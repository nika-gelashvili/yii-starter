<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 16/08/2019
 * Time: 18:01
 */

namespace frontend\controllers;


use common\models\Domain;
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
            return $this->renderAjax('data');
        }
        return $this->actionIndex();
    }

    public function actionDelay()
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('delay');
        }
        return $this->actionIndex();
    }

    public function actionResponse()
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('response');
        }
        return $this->actionIndex();
    }

    public function actionServer()
    {
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('server');
        }
        return $this->actionIndex();
    }

}