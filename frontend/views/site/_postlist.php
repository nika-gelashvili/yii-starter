<?php
/* @var $model \common\models\PostTranslation */

use app\models\Post;
use yii\helpers\Html;
use yii\helpers\StringHelper;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5 ">
                    <h2><?= HTML::encode($model->post_title) ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= Html::img('@storage/web/source/upload/' . $model->post->post_image, ['class' => 'img-responsive']); ?>
                </div>
                <div class="col-md-9">
                    <p>
                        <?php echo Html::encode($model->post_short_description) ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-8">
                    <p>
                        <?= Html::a('View', ['view', 'id' => $model->post->id, 'lang' => $model->locale], ['class' => 'btn btn-primary btn-md']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>