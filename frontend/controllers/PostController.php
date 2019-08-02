<?php

namespace frontend\controllers;

use frontend\models\PostForm;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $post = new PostForm();
        return $this->render('post', ['post' => $post]);
    }

}