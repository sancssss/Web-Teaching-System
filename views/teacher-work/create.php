<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = $model->courseName." 的作业";
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->courseName, 'url' => ['/teacher-course/course', 'cid' => $model->course_id]];
$this->params['breadcrumbs'][] = ['label' => '作业', 'url' => ['/teacher-work/index', 'cid' => $model->course_id]];
$this->params['breadcrumbs'][] = '新作业';
?>
<div class="teacher-work-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
