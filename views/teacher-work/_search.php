<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWorkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'twork_id') ?>

    <?= $form->field($model, 'twork_title') ?>

    <?= $form->field($model, 'twork_content') ?>

    <?= $form->field($model, 'twork_date') ?>

    <?= $form->field($model, 'user_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
