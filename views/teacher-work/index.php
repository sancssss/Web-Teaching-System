<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teacher Works';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    //<?php echo Yii::$app->user->getId() ?>
    <p>
        <?= Html::a('Create Teacher Work', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'twork_id',
            'twork_title',
            'twork_content:ntext',
            'twork_date',
            'user_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
