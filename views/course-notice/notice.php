<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->notice_title;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['/teacher-course/index']];
$this->params['breadcrumbs'][] = '通知详情';
?>
<div class="notice-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('更新通知', ['update-notice', 'id' => $model->notice_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除通知', ['delete-notice', 'id' => $model->notice_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认删除?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'notice_title',
            'notice_content:ntext',
            'notice_date:date',
        ],
    ]) ?>

</div>
