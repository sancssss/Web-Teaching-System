<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->course->course_name.'的通知';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = ['label' =>  $model->course->course_name, 'url' => ['/student-course/course', 'cid' => $model->course->course_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'noticeLink',
                'format' => 'raw'
            ],
            'notice_date:date',
        
        ],
    ]); ?>
</div>
