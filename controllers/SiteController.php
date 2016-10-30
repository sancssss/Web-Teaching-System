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
use app\models\teacher\CourseWithTeacher;

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
        $courses = CourseWithTeacher::find()->all();
        return $this->render('index',[
            'courses' => $courses
        ]);
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
                 $identity = User::findOne($user->user_number);
                 Yii::$app->user->login($identity, 0);
            }else{
                 $auth = Yii::$app->authManager;
                 $userRole = $auth->getRole('student');
                 $auth->assign($userRole, $user->user_number);
                 $identity = User::findOne($user->user_number);
                 Yii::$app->user->login($identity, 0);
                 //跳转到学生信息完善
                 return $this->redirect(['/student/update-user']);
            }
            Yii::$app->session->setFlash('success', "注册成功");
            //return $this->goBack();
        }
        return $this->render('signup', [
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
}
