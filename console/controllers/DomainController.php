<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 13/08/2019
 * Time: 14:25
 */

namespace console\controllers;

use common\models\Domain;
use common\models\GoogleAnalytics;
use Yii;
use phpDocumentor\Reflection\Types\This;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\Console;

class DomainController extends Controller
{
    private $ip = null;
    public $key = '';

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['key']);
    }

    /* @return array
     */
    private function parseFile()
    {
        $domains = [];
        $fileLocation = Yii::getAlias('@storage') . '/web/source/top500Domains.csv';
        $csv = array_map('str_getcsv', file($fileLocation));
        foreach ($csv as $key => $value) {
            $domains [] = $value[1];
        }
        array_shift($domains);
        return $domains;
    }

    /* @return string
     * @var $domain string
     */
    private function findIpAddress($domain)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $real_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        $host = parse_url($real_url, PHP_URL_HOST);
        $ip = gethostbyname($host);
        $this->ip = $ip;
        return $ip;
    }

    /* @return array|string
     *
     */
    private function retrieveHeaders()
    {
        try {
            $ip = $this->ip;
            stream_context_set_default([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
            $url = 'http://' . $ip . '/';
            $header = get_headers($url, 1);
            return $header ? $header : 'No Header';
        } catch (\ErrorException $e) {
            return [];
        }
    }

    /* @return array|string
     * @var $domainName string
     * @var $ip string
     * @var $region array|string
     * @var $server array|string
     * @var $header array|string
     * @var $secure string
     */

    private function saveToDatabase($domainName, $ip, $region, $server, $header, $secure)
    {
        $domain = Domain::findOne(['domain_name' => $domainName]);

        if (!$domain) {
            $domain = new Domain();
        }
        $domain->domain_name = $domainName;
        $domain->ip = $ip;
        $domain->region = $region['regionName'];
        $domain->region_json = json_encode($region);
        $domain->server = is_array($server) ? $server[0] : $server;
        $domain->latest_full_headers = json_encode($header);
        $domain->secure = $secure;

        return [$domain->save(), $domain->id];
    }

    /* @return array */
    private function regionInfo()
    {
        $ip = $this->ip;
        $data = json_decode(file_get_contents("http://ip-api.com/json/" . $ip), true);
        return $data;
    }

    /* @return string
     * @var $domain string
     */
    private function isSecure($domain)
    {
        $ssl_check = @fsockopen('ssl://' . $domain, 443, $errno, $errstr, 30);
        $res = !!$ssl_check;
        if ($ssl_check) {
            fclose($ssl_check);
        }
        return strval($res);
    }

    /* @return bool|void
     * @var $domain string
     * @var $id integer
     */
    private function parseGoogleAnalyticsAPI($domain, $id)
    {
        $ch = curl_init();
        $domain = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://' . $domain . '&key=' . $this->key;
        curl_setopt($ch, CURLOPT_URL, $domain);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $content = curl_exec($ch);
        curl_close($ch);
        $real_content = json_decode($content);
        if (isset($real_content->error)) {
            return $real_content->error;
        }
        return $this->saveGoogleAnalytics($real_content, $id);
    }

    private function saveGoogleAnalytics($json, $id)
    {
        $googleAnalytics = GoogleAnalytics::findOne(['domain_id' => $id]);
        if (!$googleAnalytics) {
            $googleAnalytics = new GoogleAnalytics();
        }
        if (array_key_exists('metrics', $json->loadingExperience)) {
            $googleAnalytics->load_first_contentful_paint = $json
                ->loadingExperience
                ->metrics
                ->FIRST_CONTENTFUL_PAINT_MS
                ->category;
            $googleAnalytics->load_first_input_delay = $json
                ->loadingExperience
                ->metrics
                ->FIRST_INPUT_DELAY_MS
                ->category;
            $googleAnalytics->origin_first_contentful_paint = $json
                ->originLoadingExperience
                ->metrics
                ->FIRST_CONTENTFUL_PAINT_MS
                ->category;

        } else {
            $googleAnalytics->load_first_contentful_paint = 'No Data';
            $googleAnalytics->load_first_input_delay = 'No Data';
            $googleAnalytics->origin_first_contentful_paint = 'No Data';
        }
        $googleAnalytics->light_first_contentful_paint = $json
            ->lighthouseResult
            ->audits
            ->{'first-contentful-paint'}
            ->displayValue;
        $googleAnalytics->light_speed_index = $json
            ->lighthouseResult
            ->audits
            ->{'speed-index'}
            ->displayValue;
        $googleAnalytics->light_time_to_interactive = $json
            ->lighthouseResult
            ->audits
            ->{'interactive'}
            ->displayValue;
        $googleAnalytics->light_first_cpu_idle = $json
            ->lighthouseResult
            ->audits
            ->{'first-cpu-idle'}
            ->displayValue;
        $googleAnalytics->light_first_meaningful_paint = $json
            ->lighthouseResult
            ->audits
            ->{'first-meaningful-paint'}
            ->displayValue;
        $googleAnalytics->light_estimated_input_latency = $json
            ->lighthouseResult
            ->audits
            ->{'estimated-input-latency'}
            ->displayValue;
        $googleAnalytics->captcha = $json
            ->captchaResult;
        $googleAnalytics->kind = $json
            ->kind;
        $googleAnalytics->time = $json
            ->analysisUTCTimestamp;
        $googleAnalytics->domain_id = $id;

        return $googleAnalytics->save();
    }

    public function actionGetDomainData()
    {
        $domains = $this->parseFile();
        $counter = 0;

        foreach ($domains as $domain) {
//            if ($domain != 'networkadvertising.org') {
//                continue;
//            }
            $ip = $this->findIpAddress($domain);

            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                continue;
            }

            $header = $this->retrieveHeaders();
            $region = $this->regionInfo();
            $secure = $this->isSecure($domain);
            $server = array_key_exists('Server', $header) ? $header['Server'] : 'No Server Info';
            $id = $this->saveToDatabase($domain, $ip, $region, $server, $header, $secure)[1];
            var_dump($this->parseGoogleAnalyticsAPI($domain, $id));
            Console::output("Processed: " . $counter++);
        }
    }
}