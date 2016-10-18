<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */

$this->title = $model->swork_title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/student-course/index']];
$this->params['breadcrumbs'][] = ['label' =>  $model->tworks->course->course_name, 'url' => ['/student-course/course', 'cid' => $model->tworks->course_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新作业', ['update-swork', 'id' => $model->swork_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'swork_title',
            'swork_date:date',
            'userNumber.user_name',
            'swork_content:ntext',
            'sworkFilesLink:raw',
            'sworkTwork.swork_grade',
            'sworkTwork.swork_comment',
            'sworkTwork.swork_comment_date:date',
        ],
    ]) ?>

</div>
