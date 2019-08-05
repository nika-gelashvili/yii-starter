<?php
/* @var $this yii\web\View */
/* @var $form \yii\widgets\ActiveForm */
/* @var $code string */

/* @var $postTranslation \common\models\PostTranslation */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<?= $form->field($postTranslation, '[' . $code . ']post_title')->textInput(['autofocus' => true])->label(Yii::t('backend', 'Title')) ?>

<?= $form->field($postTranslation, '[' . $code . ']post_description')->textInput()->label(Yii::t('backend', 'Description')) ?>

<?= $form->field($postTranslation, '[' . $code . ']post_short_description')->textInput()->label(Yii::t('backend', 'Short Description')) ?>

<?= $form->field($postTranslation, '[' . $code . ']locale')->hiddenInput(['value' => $code])->label(false) ?>
