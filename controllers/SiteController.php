<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Form\LoginForm;
use app\models\ContactForm;
use app\models\Form\SignupForm;
use app\models\User;
use app\models\StudentInformation;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
            //return $this->renderPartial('//user/index');//登陆成功后，重定向到user试图文件夹下的index，参数问题
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        //重复注册问题的代码设计暂缺
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->user_number = $model->userid;
            $user->user_name = $model->username;
            $user->user_password = $model->password;
            $user->save();
            //设置角色
            if($model->isteacher == TRUE){
                 $auth = Yii::$app->authManager;
                 $userRole = $auth->getRole('nochecked_teacher');
                 $auth->assign($userRole, $user->user_number);
            }else{
                 $auth = Yii::$app->authManager;
                 $userRole = $auth->getRole('student');
                 $auth->assign($userRole, $user->user_number);
                 //跳转到学生信息完善
                 return $this->redirect('update-student-information');
            }
            $identity = User::findOne($user->user_number);
            Yii::$app->user->login($identity, 0);
            Yii::$app->session->setFlash('success', "注册成功");
            //return $this->goBack();
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    /**
     * 完善学生信息
     * @return mixd
     */
    public function actionUpdateStudentInformation()
    {
        $model = StudentInformation::find(Yii::$app->user->getId())->one();
        if($model == null){
           $model = new StudentInformation();
           $model->student_number = Yii::$app->user->getId();
        }
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', "资料更新成功");
        }
        return $this->render('udpate-student-information', [
            'model' => $model,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionForgotPassword()
    {
        return $this->render('forgot-password');
    }
}
