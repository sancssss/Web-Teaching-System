<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '未处理的申请';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => '暂无数据',
        'columns' => [
            [
               'attribute'=>'teacherCourseLink', 'format'=>'raw' 
            ],
            [
               'attribute'=>'courseWaitingLink', 'format'=>'raw' 
            ], 
        ],
    ]); ?>
</div>
