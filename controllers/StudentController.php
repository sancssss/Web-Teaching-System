<?php

namespace app\controllers;

use app\models\User;
use app\models\StudentInformation;
use Yii;
use yii\web\NotFoundHttpException;

class StudentController extends \yii\web\Controller
{
    /**
     * 显示学生资料
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findUserModel(Yii::$app->user->getId());
        
        return $this->render('index',[
            'model' => $model,
        ]);
    }
    
     /**
     * 完善学生信息
     * @return mixd
     */
    public function actionUpdateUser()
    {
        $user = $this->findUserModel(Yii::$app->user->getId());
        $model = $this->findStudentinfoModel(Yii::$app->user->getId());
        if($model == null){
           $model = new StudentInformation();
           $model->student_number = Yii::$app->user->getId();
        }
        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->setFlash('success', "资料更新成功");
        }
        return $this->render('update-user', [
            'model' => $model,
            'user' => $user,
        ]);
    }
    
    /**
     * 找到当前用户的用户表信息
     * @return $model
     * @throws NotFoundHttpException
     */
    protected function findUserModel(){
        $model= User::find()->where(['user_number' => Yii::$app->user->getId()])->one();
        if($model != null){
            return $model;
        }
        throw new NotFoundHttpException('错误操作！');
    }
    
    /**
     * 找到当前用户的学生信息表信息
     * @return $model
     * @throws NotFoundHttpException
     */
    protected function findStudentinfoModel(){
        $model= StudentInformation::find()->where(['student_number' => Yii::$app->user->getId()])->one(); 
        return $model;
    }

}
