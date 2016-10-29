<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
if($noticeStatus == 0){
    $title = '未读通知';
    $buttonText = '查看已读通知';
    $status = 1;
}else{
    $title = '已读通知';
    $buttonText = '查看未读通知';
    $status = 0;
}
$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => ['/student/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a($buttonText, ['/student-course/all-course-notices', 'status' => $status], ['class' => 'btn btn-info']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'noticeLink',
                'format' => 'raw'
            ],
            'notice_date:date',
            [
                'attribute' => 'noticeStatus',
                'format' => 'raw'
            ]
        
        ],
    ]); ?>
</div>
