<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $pageSpeed \PHPUnit\Util\Json */
/* @var $model \yii\base\DynamicModel */
$this->title = 'Page Speed';
?>
<div style="margin-top: 100px">
    <?php $form = ActiveForm::begin(['id' => 'page-speed-form']) ?>
    <?= $form->field($model, 'url')->textInput(['autofocus' => true])->label('Url') ?>
    <div class="form-group">
        <?= Html::submitButton('Check', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
<div style="margin-top: 100px;margin-bottom: 100px;display: flex;">
    <div style="flex: 50%">
        <div style="margin-top: 5px">
            <h3>First Contentful Paint</h3>
            <?php echo Html::encode($pageSpeed
                ->loadingExperience
                ->metrics
                ->FIRST_CONTENTFUL_PAINT_MS
                ->category);
            ?>
        </div>
        <div>
            <h3>First Input Delay</h3>
            <?php echo Html::encode($pageSpeed
                ->loadingExperience
                ->metrics
                ->FIRST_INPUT_DELAY_MS
                ->category);
            ?>
        </div>
        <div>
            <h3>First Contentful Paint</h3>
            <?php echo Html::encode($pageSpeed
                ->originLoadingExperience
                ->metrics
                ->FIRST_CONTENTFUL_PAINT_MS
                ->category);
            ?>
        </div>
        <div>
            <h3>First Contentful Paint</h3>
            <?php echo Html::encode($pageSpeed
                ->lighthouseResult
                ->audits
                ->{'first-contentful-paint'}
                ->displayValue);
            ?>
        </div>
        <div>
            <h3>Speed Index</h3>
            <?php echo Html::encode($pageSpeed
                ->lighthouseResult
                ->audits
                ->{'speed-index'}
                ->displayValue);
            ?>
        </div>
        <div>
            <h3>Time To Interactive</h3>
            <?= Html::encode($pageSpeed
                ->lighthouseResult
                ->audits
                ->{'interactive'}
                ->displayValue);
            ?>
        </div>
        <div>
            <h3>First CPU Idle</h3>
            <?= Html::encode($pageSpeed
                ->lighthouseResult
                ->audits
                ->{'first-cpu-idle'}
                ->displayValue);
            ?>
        </div>
        <div>
            <h3>First Meaningful Paint</h3>
            <?= Html::encode($pageSpeed
                ->lighthouseResult
                ->audits
                ->{'first-meaningful-paint'}
                ->displayValue);
            ?>
        </div>
        <div>
            <h3>Estimated Input Latency</h3>
            <?= Html::encode($pageSpeed
                ->lighthouseResult
                ->audits
                ->{'estimated-input-latency'}
                ->displayValue);
            ?>
        </div>
    </div>
    <div style="flex: 50%">
        <div>
            <h3>Captcha</h3>
            <?= Html::encode($pageSpeed
                ->captchaResult);
            ?>
        </div>
        <div>
            <h3>Kind</h3>
            <?= Html::encode($pageSpeed
                ->kind);
            ?>
        </div>
        <div>
            <h3>Web Page</h3>
            <?= Html::encode($pageSpeed
                ->id)
            ?>
        </div>
        <div>
            <h3>Time</h3>
            <?= Html::encode($pageSpeed
                ->analysisUTCTimestamp);
            ?>
        </div>
    </div>
</div>
