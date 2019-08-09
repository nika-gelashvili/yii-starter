<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post';
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
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = Url::to(['post/view', 'id' => $model['id']]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                        ]);
                    },
                    'update' => function ($url, $model) {
                        $url = Url::to(['post/update', 'id' => $model['post_id']]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $url = Url::to(['post/delete', 'id' => $model['id']]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>
</div>