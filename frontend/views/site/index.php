<?php
/* @var $this yii\web\View */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\widgets\ListView;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <?php echo \common\widgets\DbCarousel::widget([
        'key' => 'index',
        'assetManager' => Yii::$app->getAssetManager(),
        'options' => [
            'class' => 'slide', // enables slide effect
        ],
    ]) ?>

    <div class="jumbotron">
        <?php echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_postlist',
            'summary' => ''
        ])
        ?>
    </div>

</div>
