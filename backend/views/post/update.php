<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $postTranslation common\models\PostTranslation */

$this->title = 'Update Post: ' . $postTranslation->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Post', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $postTranslation->post_title, 'url' => ['view', 'id' => $postTranslation->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'postTranslation' => $postTranslation,
    ]) ?>

</div>