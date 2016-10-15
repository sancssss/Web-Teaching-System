<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $course->course_name.'的作业列表';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' => $course->course_name, 'url' => ['teacher-course/course', 'cid' => $course->course_id]];
$this->params['breadcrumbs'][] = '全部作业';
?>
<div class="teacher-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('创建新作业', ['create', 'cid' => $course->course_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'twork_title',
            //'twork_content',
            'twork_date:date',
            [
               'attribute'=>'usersLink', 'format'=>'raw' 
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}',
                ],
        ],
    ]); ?>
    
</div>
