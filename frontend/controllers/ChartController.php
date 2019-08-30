<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 16/08/2019
 * Time: 18:01
 */

namespace frontend\controllers;


use common\models\Domain;
use common\models\GoogleAnalytics;
use yii\web\Controller;

class ChartController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'viewajax' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionData()
    {
        if (\Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return Domain::find()
                ->select([
                    'region', 'count(*) as amount'
                ])
                ->groupBy('region')
                ->createCommand()
                ->queryAll();

        }
        return $this->actionIndex();
    }

    public function actionDelay()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return GoogleAnalytics::find()
                ->select(['concat(0.5*floor(light_first_contentful_paint/0.5), \'-\' ,0.5*floor(light_first_contentful_paint/0.5)+0.5) as delay , count(*) as domains'])
                ->groupBy('delay')
                ->createCommand()
                ->queryAll();
        }
        return $this->actionIndex();
    }

    public function actionResponse()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \Yii::$app->db->createCommand('select concat(20*floor(light_estimated_input_latency/20), \'-\' ,20*floor(light_estimated_input_latency/20)+20) as `response delay`, count(*) as domains
from google_analytics
where light_estimated_input_latency <100
group by 1
union
select \'100-500\',count(light_estimated_input_latency) from google_analytics where light_estimated_input_latency between 100 and 1000
group by 1
union
select \'500 +\',count(light_estimated_input_latency) from google_analytics where replace(light_estimated_input_latency,\',\',\'\') >=500;')
                ->queryAll();
        }
        return $this->actionIndex();
    }

    public function actionServer()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return Domain::find()->select(['server', 'count(*) as amount'])->groupBy('server')->createCommand()->queryAll();
        }
        return $this->actionIndex();
    }

}