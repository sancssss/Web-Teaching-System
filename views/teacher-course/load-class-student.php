<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = '导入课程';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
?>
 <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('success') ?>
    </div>
    <?php endif; ?>
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_class')->textInput(['maxlength' => true]) ?>

    <?=   $form->field($model, 'course_id')->dropDownList(
                                $myCourseList,
                                ['prompt'=>'选择课程']) 
                                ?>

    <div class="form-group">
        <?= Html::submitButton( '一键导入', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>