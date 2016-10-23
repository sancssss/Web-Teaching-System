<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

$this->title = $model->notice_title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' =>  $model->course->course_name.'的通知', 'url' => ['/student-course/course-notices', 'cid' => $model->course->course_id]];
$this->params['breadcrumbs'][] = '通知详情';
?>
<div class="notice-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'notice_title',
            'notice_content:ntext',
            'notice_date:date',
        ],
    ]) ?>

</div>
