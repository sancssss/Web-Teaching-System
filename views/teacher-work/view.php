<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = $model->twork_title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->course->course_name.'的作业', 'url' => ['teacher-work/index', 'cid' => $model->course_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新作业', ['update', 'id' => $model->twork_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传附件', ['upload-file', 'tworkid' => $model->twork_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('删除作业', ['delete', 'id' => $model->twork_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'twork_id',
            'twork_title',
            'twork_content:ntext',
            'twork_date:datetime',
            [
                'label' => '发布者',
                'value' => $model->course->teacherNumber->user_name,
            ],
             'tworkFilesLink:raw'
        ],
    ]) ?>

</div>
