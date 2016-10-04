<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = '批改作业';
$this->params['breadcrumbs'][] = ['label' => '我发布的作业', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-comment', [
        'model' => $model,
        'studentmodel' => $studentmodel,
    ]) ?>

</div>
