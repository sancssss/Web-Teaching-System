<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我发布的作业';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('创建新作业', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'twork_id',
            'twork_title',
            //'twork_content',
            'twork_date',
            'user_number',
            [
                'attribute' => '提交数量',
                'value' => 'submitCount',
            ],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}',
                ],
        ],
    ]); ?>
</div>
