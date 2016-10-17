<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $work->twork_title.' 的全部附件';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' => $work->twork_title, 'url' => ['/teacher-work/view', 'id' => $work->twork_id]];
$this->params['breadcrumbs'][] = '附件列表';
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('上传附件', ['upload-file', 'tworkid' => $work->twork_id], ['class' => 'btn btn-success']) ?>
    </p>
    
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
