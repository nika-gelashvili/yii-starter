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
        if (Yii::$app->request->isAjax) {
            $url = Yii::$app->request->post('url');
            $model->url = $url;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->pageSpeed($url);
        }
        return $this->render('index', [
            'model' => $model
        ]);
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