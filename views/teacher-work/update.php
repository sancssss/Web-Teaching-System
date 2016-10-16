<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = '更新作业: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->course_name, 'url' => ['/teacher-work/index', 'cid' => $model->course_id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->twork_id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="teacher-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lastupdate' => $lastupdate,
    ]) ?>

</div>
