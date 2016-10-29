<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $course->course_name.'的作业列表';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = ['label' => $course->course_name, 'url' => ['student-course/course', 'cid' => $course->course_id]];
$this->params['breadcrumbs'][] = '全部作业';
?>
<div class="student-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'tWorkLink', 'format' => 'raw'
            ],
            //'twork_content',
            'twork_date:date',
            'twork_deadline:date',
             [
               'attribute'=>'commitWorkLink', 'format'=>'raw' 
            ],
        ],
    ]); ?>
    
</div>
