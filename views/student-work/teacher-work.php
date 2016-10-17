<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = $model->twork_title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->course->course_name.'的作业', 'url' => ['/student-work/index', 'cid' => $model->course_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'twork_id',
            'twork_title',
            'twork_content:ntext',
            'twork_date:datetime',
            [
                'label' => '发布者',
                'value' => $model->course->teacherNumber->user_name,
            ],
            [
               'attribute' => 'commitWorkLink',
               'format' => 'raw'
            ],
            [
              'attribute' => 'tworkFilesLink',
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
