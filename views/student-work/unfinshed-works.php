<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = '未完成作业';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-view">

    <h1><?= Html::encode($this->title) ?></h1>


     <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'tWorkLink', 'format' => 'raw'
            ],
            //'twork_content',
            'twork_date:date',
             [
               'attribute'=>'commitWorkLink', 'format'=>'raw' 
            ],
        ],
    ]); ?>

</div>
