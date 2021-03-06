<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $post \common\models\Post */
/* @var $postTranslation \common\models\PostTranslation */

/* @var $upload \common\models\Image */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'post-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
    ]); ?>

    <?php
    $items = [];
    foreach (Yii::$app->params['availableLocales'] as $code => $lang) {
        $items = [
            'label' => $lang,
            'content' => $this->render('_posteng', ['postTranslation' => $postTranslation, 'form' => $form, 'code' => $code])
        ];
    }

    echo \yii\bootstrap\Tabs::widget([
        $items
    ]) ?>


    <?= $form->field($post, 'post_image')->fileInput(['accept' => 'image/*'])->label('Thumbnail') ?>

    <?= $form->field($upload, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Post Images') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>