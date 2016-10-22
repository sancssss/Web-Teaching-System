<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的课程';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
 <p>
        <?= Html::a('查看选课情况', ['courses-list'], ['class' => 'btn btn-primary']) ?> <?= Html::a('查看全校课程', ['find-course'], ['class' => 'btn btn-primary']) ?>
    </p>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'course_id',
            [
               'attribute'=>'studentCourseLink', 'format'=>'raw' 
            ],
            'teacherNumber.user_name',
            [
               'attribute'=>'courseWorkLink', 'format'=>'raw' 
            ],
            [
               'attribute'=>'noticeLink', 'format'=>'raw' 
            ],
            
        ],
    ]); ?>
</div>
