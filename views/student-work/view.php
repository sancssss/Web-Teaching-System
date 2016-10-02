<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */

$this->title = $model->swork_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->swork_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->swork_id], [
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
            'swork_id',
            'swork_title',
            'swork_content:ntext',
            'swork_date',
            'user_number',
        ],
    ]) ?>

</div>
