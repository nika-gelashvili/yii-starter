<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $this yii\web\View */
/* @var $model common\models\PostTranslation */

$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Post Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-translation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_postview'
    ]) ?>
    <!--
        --><? /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'post_id',
            'post_title',
            'post_description',
            'post_short_description',
            'locale',
        ],
    ]) */ ?>

</div>