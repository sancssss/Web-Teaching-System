<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '上传'.$course->course_name.'的课件';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $course->course_name, 'url' => ['/teacher-course/course', 'cid' => $course->course_id]];
$this->params['breadcrumbs'][] = '上传课件';
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
<p>
    文件可多选一次性上传多个
</p>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'mutiFiles[]')->fileInput(['multiple' => true]) ?>

    <?= Html::submitButton('上传课件', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end() ?>
