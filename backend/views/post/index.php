<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Translations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-translation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post Translation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'post_id',
            'post_title',
            'post_description',
            'post_short_description',
            'locale',
            'post.post_image',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>