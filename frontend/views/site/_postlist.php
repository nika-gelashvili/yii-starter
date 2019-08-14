<?php
/* @var $model \common\models\PostTranslation */

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>
<div style="padding: 5px;position: relative;font-size: 30px;font-style:normal;margin-top: 30px;">
    <?= HTML::encode($model->post_title) ?>
    <div style="padding: 5px; overflow:auto; width:50%;">
        <p style="float:left; margin-right: 15px;">
            <?php
            echo Html::img('@web/source/upload/' . $model->post->post_image, ['width' => '150px', 'height' => '100px']);
            ?>
        </p>
        <p style="font-size: medium">
            <?php echo Html::encode($model->post_short_description) ?>
        </p>
    </div>
    <div style="width: 100%;height: 35px;">
        <?= Html::a('View', ['view', 'id' => $model->post->id, 'lang' => $model->locale], ['class' => 'btn btn-primary', 'style' => ['float' => 'right']]) ?>
    </div>
</div>