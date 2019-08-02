<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PostTranslation */
/* @var $form ActiveForm */
?>
<div class="post">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id') ?>
    <?= $form->field($model, 'post_title') ?>
    <?= $form->field($model, 'locale') ?>
    <?= $form->field($model, 'post_description') ?>
    <?= $form->field($model, 'post_short_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- post -->