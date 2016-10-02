<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWorkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'swork_id') ?>

    <?= $form->field($model, 'swork_title') ?>

    <?= $form->field($model, 'swork_content') ?>

    <?= $form->field($model, 'swork_date') ?>

    <?= $form->field($model, 'user_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
