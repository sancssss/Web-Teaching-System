<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = '扬大师生互动系统';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
               <div class="jumbotron">
		<h1>
                   扬州大学师生互动系统
                </h1>
                <p>
                   欢迎使用扬州大学师生互动系统！
		</p>
                <p>
                    <a class="btn btn-primary btn-large" href="#">了解更多</a>
                </p>
		</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">最新添加课程</h3>
                    </div>
                    <div class="list-group">
                <?php $i = 0;?>
                <?php foreach ($courses as $course): ?>
                        <a href="<?= Url::to(['/teacher-course/course', 'cid' => $course->course_id]) ?>" class="list-group-item ">
                        <p class="list-group-item-text"><?= Html::encode("{$course->course_name}"); ?></p>
                        </a>
                <?php
                    $i++;
                    if($i == 5){
                        break;
                    }
                        endforeach; ?>
               </div>
            </div>
        </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">寻物启事 <span class="badge">3</span></h3>
                    </div>
                    <div class="list-group">

                        <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">一则寻物启事</h4>
                        <p class="list-group-item-text">寻物启事okokok.</p>
                        </a>
                        <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">二则寻物启事</h4>
                        <p class="list-group-item-text">寻物其实内容.</p>
                        </a>
                        <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">三则寻物启事</h4>
                        <p class="list-group-item-text">寻物启事内容.</p>
                        </a>
                    </div>
            </div>
        </div>
        </div>
        <div class="row">
                      <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">热门课程</h3>
                    </div>
                    <div class="list-group">
                       <?php $i = 0;?>
                       <?php foreach ($courses as $course): ?>
                        <a href="<?= Url::to(['/teacher-course/course', 'cid' => $course->course_id]) ?>" class="list-group-item ">
                        <p class="list-group-item-text"><?= Html::encode("{$course->course_name}"); ?></p>
                        </a>
                       <?php
                        $i++;
                        if($i == 5)
                        break;
                        endforeach; ?>
                    </div>
            </div>
        </div>
        </div>
</div>
</div>