<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\\StudentCourseTempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学校课程列表';
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('info') ?>
    </div>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'course_id',
            'course_name',
            'teacherNumber.user_name',
            [
               'attribute'=>'registerLink', 'format'=>'raw' 
            ],

        ],
    ]); ?>
</div>
