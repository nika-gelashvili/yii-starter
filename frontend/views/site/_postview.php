<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 09/08/2019
 * Time: 13:34
 */

/* @var $model \common\models\PostTranslation */

use yii\helpers\Html; ?>
<div style="margin-top: 50px;margin-bottom: 30px;">
    <div>
        <h1 style="height: "><?= \yii\helpers\Html::encode($model->post_title) ?></h1>

        <?php
        //        var_dump($model->post->post_image);
        //        exit;
        echo Html::img('@storageUrl/source/upload/' . $model->post->post_image, ['width' => '150px', 'height' => '100px']) ?>
        <p>
            <?= $model->post_description ?>
        </p>
        <div style="width:350px;height: 150px">
            <?php
            $images = [];
            $url = Yii::getAlias('@storageUrl');
            foreach ($model->post->images as $imageItem) {
                $images[] = '<img src="' .
                    $url .
                    '/source/upload/' .
                    $imageItem->image .
                    '" class="img-responsive" style="height: 200px; width: 350px"/>';
            }
            echo \yii\bootstrap\Carousel::widget([
                'items' => $images,
                'options' => [
                    'style' =>
                        [
                            'width' => '350px',
                            'height' => '200px',
                        ]
                ]
            ]); ?>
        </div>
    </div>
</div>