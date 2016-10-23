<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        扬大师生互助系统是基于yii2.0的开源系统，有任何问题可以联系管理员，其联系方式为:
    </p>
    <p>
        <b>email:admin@example.com</b>
    </p>
    <p>
        <b>phone:12345678910</b>
    </p>

    <!-- <code><?= __FILE__ ?></code> -->
</div>