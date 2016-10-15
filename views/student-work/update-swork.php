<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */

$this->title = '更新作业: ' . $model->swork_title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = ['label' => $model->swork_title, 'url' => ['/student-work/work', 'id' => $model->swork_id]];
$this->params['breadcrumbs'][] = '更新作业';
?>
<div class="student-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update_work', [
        'model' => $model,
    ]) ?>

</div>
