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

    <?= \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'English',
                'content' => $this->render('/post/view/_posteng', ['postTranslation' => $postTranslation, 'form' => $form]),
                'active' => true,
                'id'
            ],
            [
                'label' => 'ქართული',
                'content' => $this->render('/post/view/_postgeo', ['postTranslation' => $postTranslation, 'form' => $form]),
            ],
            [
                'label' => 'Русский',
                'content' => $this->render('/post/view/_postrus', ['postTranslation' => $postTranslation, 'form' => $form]),
            ]
        ]
    ]) ?>


    <?= $form->field($post, 'post_image')->fileInput(['accept' => 'image/*'])->label('Thumbnail') ?>

    <?= $form->field($upload, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Post Images') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>