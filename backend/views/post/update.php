<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $postTranslation common\models\PostTranslation */
/* @var $post \common\models\Post */
/* @var $upload \common\models\Image */

$this->title = 'Update Post: ' . $postTranslation['en-US']['post_title'];
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $postTranslation['en-US']['post_title'], 'url' => ['view', 'id' => $postTranslation['en-US']['id']]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('create', [
        'postTranslation' => $postTranslation,
        'post' => $post,
        'upload' => $upload
    ]) ?>

</div>