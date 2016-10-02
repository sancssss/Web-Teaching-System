<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Works';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Student Work', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'swork_id',
            'swork_title',
            'swork_content:ntext',
            'swork_date',
            'user_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
