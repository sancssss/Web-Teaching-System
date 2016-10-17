<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $course->course_name.' 的全部课件';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' => $course->course_name, 'url' => ['/teacher-course/course', 'cid' => $course->course_id]];
$this->params['breadcrumbs'][] = '课件列表';
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Html::a('上传课件', ['upload-file', 'cid' => $course->course_id], ['class' => 'btn btn-success']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'file_name',
            'file_extension',
            'file_upload_time:date',
            [
               'attribute'=>'fileDownloadLink', 'format'=>'raw' 
            ],
            'file_download_count'
        ],
    ]); ?>
</div>
