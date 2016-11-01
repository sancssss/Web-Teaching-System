<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->user_name.'的个人中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-center-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新资料', ['update-user'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('我的课程', ['/teacher-course/index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('未读留言', ['/teacher-course/unread-message'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('未批准申请', ['/teacher-course/unread-application'], ['class' => 'btn btn-info']) ?>
    </p>
    <div class="grid-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_number',
            'user_name',
            'teacherInformation.teacher_introduction',
        ],
    ]) ?>
    </div>
</div>
