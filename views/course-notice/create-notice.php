<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = '创建通知';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' =>  $model->course_name, 'url' => ['/teacher-course/course', 'cid' => $model->course_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($formModel, 'notice_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'notice_content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('创建', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>

</div>
