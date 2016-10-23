<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
        //获取用户权限
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRolesByUser(Yii::$app->user->getId());
        //根据用户权限复制菜单中的url
        $courseUrl = '/site/error-unregister';
        $personalUrl = '/site/error-unregister';
        if(isset($userRole['teacher'])){
            $courseUrl = '/teacher-course/index';
            $personalUrl = '/teacher/index';
        }
        
        if(isset($userRole['student'])){
            $courseUrl = '/student-course/index';
            $personalUrl = '/student/index';
        }
        //echo(isset($userRole['teacher']));
    ?>
    <?php
    NavBar::begin([
        'brandLabel' => '扬大师生互动系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '首页', 'url' => ['/site/index']],
            ['label' => '关于', 'url' => ['/site/about']],
            ['label' => '反馈', 'url' => ['/site/contact']],
            ['label' => '注册', 'url' => ['/site/signup']],
            Yii::$app->user->isGuest ? (
                ['label' => '登录', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->user_name . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            ),
            [
                'label' => '菜单',
                'items' => [
                    ['label' => '个人中心', 'url' => [$personalUrl]],
                    '<li class="divider"></li>',
                    '<li class="dropdown-header">课程管理</li>',
                    ['label' => '我的课程', 'url' => [$courseUrl]],
                    ['label' => '我的作业', 'url' => ['/']],
                ]
            ],
            //Yii::$app->user->isGuest ? ['label' => '登录', 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest] 
//            : ['label' => '注销('.Yii::$app->user->identity->user_name.')', 'url' => ['/site/logout'], 'visible' => !Yii::$app->user->isGuest],
        ],
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'itemTemplate' => "<li><i>{link}</i></li>\n",
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
             'homeLink' => ['label' => '首页',
                            'url' => '/'
                ],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 扬州大学师生互动系统 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
