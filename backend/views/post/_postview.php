<?php
/* @var $model \common\models\PostTranslation */

use yii\helpers\Html; ?>
<div style="margin-top: 20px;margin-bottom: 30px;">
    <div>
        <h1><?= \yii\helpers\Html::encode($model->post_title) ?></h1>

        <?php echo Html::img(Yii::getAlias('@storageUrl') . '/web/source/upload/' . $model->post->post_image, ['width' => '150px', 'height' => '100px']) ?>
        <p>
            <?= $model->post_description ?>
        </p>
        <div style="width:350px;height: 150px">
            <?php
            $images = [];

            foreach ($model->post->images as $imageItem) {
                $images[] = Html::img(Yii::getAlias('@storageUrl') . '/web/source/upload/' . $imageItem->image);
            }
            echo \yii\bootstrap\Carousel::widget([
                'items' => $images,
                'options' => [
                    'style' =>
                        [
                            'width' => '350px',
                            'height' => '150px',
                        ]
                ]
            ]) ?>
        </div>
    </div>
</div>