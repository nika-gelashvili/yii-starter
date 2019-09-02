<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/* @var $pageSpeed \PHPUnit\Util\Json */
/* @var $model \yii\base\DynamicModel */
$this->title = 'Page Speed';
?>
<div style="margin-top: 100px">
    <?php $form = ActiveForm::begin([
        'id' => 'page-speed-form'
    ]) ?>
    <?= $form->field($model, 'url')->textInput(['autofocus' => true, 'id' => 'url'])->label('Url') ?>
    <?= Html::Button('Check', ['class' => 'btn btn-primary check-button']) ?>
    <?php ActiveForm::end() ?>
</div>
<div id="ajaxSpinner" hidden>
    <?= Html::img('@web/img/Spinner-1s-200px.gif', ['style' => ['width' => '100px', 'height' => '100px']]) ?>
</div>
<div id="main" style="margin-top: 100px;margin-bottom: 100px;display: none;">
    <div style="flex: 50%">
        <div id="load-fcp" style="margin-top: 5px">
            <h3>First Contentful Paint</h3>
        </div>
        <div id="load-fid">
            <h3>First Input Delay</h3>
        </div>
        <div id="origin-fcp">
            <h3>First Contentful Paint</h3>
        </div>
        <div id="light-fcp">
            <h3>First Contentful Paint</h3>
        </div>
        <div id="light-si">
            <h3>Speed Index</h3>
        </div>
        <div id="light-tti">
            <h3>Time To Interactive</h3>
        </div>
        <div id="light-fci">
            <h3>First CPU Idle</h3>
        </div>
        <div id="light-fmp">
            <h3>First Meaningful Paint</h3>
        </div>
        <div id="light-eil">
            <h3>Estimated Input Latency</h3>
        </div>
    </div>
    <div style="flex: 50%">
        <div id="captcha">
            <h3>Captcha</h3>
        </div>
        <div id="kind">
            <h3>Kind</h3>
        </div>
        <div id="web-page">
            <h3>Web Page</h3>
        </div>
        <div id="time">
            <h3>Time</h3>
        </div>
    </div>
</div>
<p id="errorMessage" hidden>Unable to retrieve data</p>
<?php
$this->registerJSFile('@web/js/page-speed/app.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
