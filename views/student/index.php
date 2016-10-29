<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */

$this->title = $model->user_name.'的个人中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-center-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新资料', ['update-user'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('我的课程', ['/student-course/index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('未交作业', ['/student-work/unfinished-works'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('未读通知', ['/student-course/all-course-notices', 'status' => 0], ['class' => 'btn btn-info']) ?>
    </p>
    <div class="grid-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_number',
            'user_name',
            'studentInformation.student_class',
        ],
    ]) ?>
    </div>
</div>
