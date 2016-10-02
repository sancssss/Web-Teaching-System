<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TeacherWork */

$this->title = $model->twork_title;
$this->params['breadcrumbs'][] = ['label' => 'Teacher Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->twork_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->twork_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'twork_id',
            'twork_title',
            'twork_content:ntext',
            'twork_date:datetime',
            [
                'label' => '发布者',
                'value' => $model->userNumber->user_name
            ]
        ],
    ]) ?>

</div>
