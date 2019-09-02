<?php

/**
 * Created by PhpStorm
 * User: nika
 * Date: 13/08/2019
 * Time: 12:40
 */

/* @var $model \common\models\Comment */

use yii\helpers\Html;

?>
<div style="min-height: 50px; padding-top: 70px; padding-left: 10px;margin-bottom: 5px">
    <p style="font-size: large">
        <?php echo Html::encode($model->message_text) ?>
    </p>
    <p style="font-size:x-small">
        <?php echo Html::encode('User: ' . $model->user->username) ?>
    </p>
</div>
