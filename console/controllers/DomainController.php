<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 13/08/2019
 * Time: 14:25
 */

namespace console\controllers;

use common\models\Domain;
use Yii;
use phpDocumentor\Reflection\Types\This;
use yii\console\Controller;
use yii\db\Exception;

class DomainController extends Controller
{
    private $ip = null;

    /* @return array
     */
    public function parseFile()
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
    public function findIpAddress($domain)
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
    public function retrieveHeaders()
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
     * @var $s Domain
     * @var $ip string
     * @var $region array|string
     * @var $server array|string
     * @var $header array|string
     * @var $secure string
     */

    public function saveToDatabase($s, $ip, $region, $server, $header, $secure)
    {
        $s->ip = $ip;
        $s->region = $region['regionName'];
        $s->region_json = $region;
        $s->server = $server;
        $s->latest_full_headers = $header;
        $s->secure = $secure;
        if ($s->save()) {
            return 'Done';
        } else {
            return $s->errors;
        }
    }

    /* @return array */
    public function regionInfo()
    {
//        $ip = $this->findIpAddress();
        $ip = $this->ip;
        $data = json_decode(file_get_contents("http://ip-api.com/json/" . $ip), true);
        return $data;
    }

    /* @return string
     * @var $domain string
     */
    public function isSecure($domain)
    {
        $ssl_check = @fsockopen('ssl://' . $domain, 443, $errno, $errstr, 30);
        $res = !!$ssl_check;
        if ($ssl_check) {
            fclose($ssl_check);
        }
        return strval($res);
    }

    public function actionGetDomainData()
    {
        $domains = $this->parseFile();
        $n = 0;
        foreach ($domains as $domain) {
            var_dump($domain);
            if (filter_var($this->findIpAddress($domain), FILTER_VALIDATE_IP)) {
                $ip = $this->findIpAddress($domain);
                var_dump($ip);
            } else {
                continue;
            }
            $header = $this->retrieveHeaders();
            var_dump($header);
            $region = $this->regionInfo();
            var_dump($region);
            $secure = $this->isSecure($domain);
            var_dump($secure);
            $server = array_key_exists('Server', $header) ? $header['Server'][0] : 'No Server Info';
            $domainModel = new Domain();
            $findDomain = Domain::findOne(['domain_name' => $domain]);
            if (empty($findDomain)) {
                $updateResponse = $this->saveToDatabase($findDomain, $ip, $region, $server, $header, $secure);
                var_dump($updateResponse);
                $n++;
            } else {
                $createResponse = $this->saveToDatabase($domainModel, $ip, $region, $server, $header, $secure);
                var_dump($createResponse);
                $n++;
            }
            var_dump($n);
        }
    }
}