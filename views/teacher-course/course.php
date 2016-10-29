<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->course_name;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = '课程详情';
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新课程', ['update', 'cid' => $model->course_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('上传课件', ['upload-file', 'cid' => $model->course_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('管理作业', ['/teacher-work/index', 'cid' => $model->course_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('管理通知', ['/course-notice/index', 'cid' => $model->course_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除课程', ['delete', 'cid' => $model->course_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_name',
            'course_id',
            'courseUserCountLink:raw',
            'teacherNumber.user_name',
            'course_content:ntext',
            'courseWorksLink:raw',
            'courseFilesLink:raw'
        ],
    ]) ?>

</div>
