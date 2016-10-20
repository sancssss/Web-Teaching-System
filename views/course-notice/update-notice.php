<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = '更新通知';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' =>  $model->notice_title, 'url' => ['notice', 'id' => $model->notice_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('success') ?>
    </div>
    <?php endif; ?>
    <div class="notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'notice_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notice_content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>

</div>
