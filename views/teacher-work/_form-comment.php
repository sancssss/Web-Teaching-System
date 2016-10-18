<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TWorkCommnet */
/* @var $form yii\widgets\ActiveForm */
/* @var $studentmodel yii\models\StudentWork */
?>

    <?= DetailView::widget([
        'model' => $studentmodel,
        'attributes' => [
            'swork_title',
            'swork_content:ntext',
            'tSworkFilesLink:raw',
            'swork_date:date',
            'userNumber.user_name',
            'sworkTwork.swork_grade',
            'sworkTwork.swork_comment:ntext',
            'sworkTwork.swork_comment_date:date'
        ],
    ]) ?>

<div class="teacher-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['btn btn-success']) ?>
    </div>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-warning alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('error') ?>
    </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
