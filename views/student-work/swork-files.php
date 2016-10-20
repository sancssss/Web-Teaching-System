<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $work->swork_title.' 的全部附件';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = ['label' => $work->swork_title, 'url' => ['/student-work/work', 'id' => $work->swork_id]];
$this->params['breadcrumbs'][] = '附件列表';
?>

<div class="course-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('上传附件', ['upload-swork-file', 'sworkid' => $work->swork_id], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'file_name',
            'file_extension',
            'file_upload_time:date',
            [
               'attribute'=>'fileDownloadLink', 'format'=>'raw' 
            ],
        ],
    ]); ?>
</div>
