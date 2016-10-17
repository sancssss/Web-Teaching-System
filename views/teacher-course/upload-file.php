<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

//$this->title = $model->course_name;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'mutiFiles[]')->fileInput(['multiple' => true]) ?>

    <?= Html::submitButton('上传', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>
