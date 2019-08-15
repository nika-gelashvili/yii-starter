<?php

namespace frontend\controllers;

use frontend\models\PostForm;
use Yii;
use yii\base\DynamicModel;

class PageSpeedController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new DynamicModel([
            'url'
        ]);
        $model->addRule(['url'], 'required')
            ->addRule(['url'], 'string', ['max' => 30]);
        if ($model->load(Yii::$app->request->post())) {
            $pageSpeed = $this->pageSpeed($model->url);
            return $this->render('index', ['pageSpeed' => $pageSpeed, 'model' => $model]);
        }
        $pageSpeed = $this->pageSpeed('developers.google.com');
        return $this->render('index', ['pageSpeed' => $pageSpeed, 'model' => $model]);
    }

    /* @return mixed
     * @var $url string
     */
    public function pageSpeed($url)
    {
        $ch = curl_init();
        $domain = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=https://' . $url . '&key=AIzaSyC-9bIcGNbAbiqEwg2e_YHCtUlQAhi7IiI';
        curl_setopt($ch, CURLOPT_URL, $domain);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $content = curl_exec($ch);
        curl_close($ch);
        $real_content = json_decode($content);
        if (isset($real_content->error)) {
            var_dump($real_content->error);
            exit;
        }

        return $real_content;
    }

}