<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

          $user = $auth->createRole('nochecked_teacher');
          $auth->add($user);
          /*$teacher = $auth->createRole('teacher');
          $auth->add($teacher);
          $studentMonitor = $auth->createRole('studentmonitor');
          $auth->add($studentMonitor);
          $admin = $auth->createRole('admin');
          $auth->add($admin);
          $auth->addChild($studentMonitor, $user);*/
    }
}