<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-work-form">

     <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'swork_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'swork_content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => 'btn btn-success']) ?> <?= Html::a('管理附件', ['swork-files', 'sworkid' => $model->swork_id], ['class' => 'btn btn-primary']) ?>
    </div>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-warning alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('error') ?>
    </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>

</div>
