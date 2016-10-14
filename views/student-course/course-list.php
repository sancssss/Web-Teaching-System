<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程申请情况';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('选择新课程', ['/student-course/find-course'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php if (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('info') ?>
    </div>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'course_id',
            [
               'attribute'=>'studentCourseLink', 'format'=>'raw'
            ],
            [
               'attribute'=>'courseStatusLink', 'format'=>'raw' 
            ],
        
        ],
    ]); ?>
</div>
