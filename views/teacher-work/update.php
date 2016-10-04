<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = 'Update Teacher Work: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Teacher Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->title]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="teacher-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lastupdate' => $lastupdate,
    ]) ?>

</div>
