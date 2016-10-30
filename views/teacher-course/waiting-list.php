<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TeacherWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
$this->title = '《'.$model->course_name.'》学生申请列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('info')): ?>
    <div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <?= Yii::$app->session->getFlash('info') ?>
    </div>
    <?php endif; ?>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php $form = ActiveForm::begin([
        'id' => 'list-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'studentNumber.user_name',
            //'twork_content',
            'studentNumber.user_number',
            [
               'attribute'=>'verifiedIt', 'format'=>'raw' 
            ],
        ],
    ]); ?>
    <?=Html::submitButton('确认选中项', ['class' => 'btn btn-info',]);?>
     <?php ActiveForm::end(); ?>
</div>