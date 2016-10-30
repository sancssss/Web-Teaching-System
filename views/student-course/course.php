<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = $model->course_name;
$this->params['breadcrumbs'][] = ['label' => '我的课程', 'url' => ['index']];
$this->params['breadcrumbs'][] = '课程详情';
?>
<div class="course-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'course_name',
            'course_id',
            'teacherNumber.user_name',
            'course_content:html',
            'courseFilesLink:raw',
             [
               'attribute'=>'courseStatusLink', 'format'=>'raw' 
            ],
        ],
    ]) ?>

</div>
