<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StudentWork */

$this->title = $model->user_name.'的个人中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-center-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新个人资料', ['update-user'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_number',
            'user_name',
            'studentInformation.student_class',
        ],
    ]) ?>

</div>
