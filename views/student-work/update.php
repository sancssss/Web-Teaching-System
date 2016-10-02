<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */

$this->title = 'Update Student Work: ' . $model->swork_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->swork_id, 'url' => ['view', 'id' => $model->swork_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
