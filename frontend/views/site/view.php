<?php
/**
 * Created by PhpStorm
 * User: nika
 * Date: 09/08/2019
 * Time: 13:32
 */

use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model \common\models\PostTranslation */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $postDataProvider ActiveDataProvider */
/* @var $comment \common\models\Comment */

$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">
    <?php echo ListView::widget([
        'dataProvider' => $postDataProvider,
        'itemView' => '_postview',
        'summary' => ''
    ]) ?>

    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_commentlist',
        'summary' => ''
    ]) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'comment-form',
    ]); ?>
    <?= $form->field($comment, 'message_text')->textInput(['autofocus' => true])->label('Comment') ?>
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php else: ?>
        <div class="form-group">
            <?= Html::a('Sign in', ['login'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
</div>