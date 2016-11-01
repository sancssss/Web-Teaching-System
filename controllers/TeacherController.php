<?php

namespace app\controllers;
use app\models\User;
use app\models\TeacherInformation;
use Yii;

class TeacherController extends \yii\web\Controller
{
    /**
     * 显示教师资料
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
     * 完善教师信息
     * @return mixd
     */
    public function actionUpdateUser()
    {
        $user = $this->findUserModel(Yii::$app->user->getId());
        $model = $this->findTeacherinfoModel(Yii::$app->user->getId());
        if($model == null){
           $model = new TeacherInformation();
           $model->teacher_number = Yii::$app->user->getId();
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
     * 找到当前用户的教师信息表信息
     * @return $model
     * @throws NotFoundHttpException
     */
    protected function findTeacherinfoModel(){
        $model= TeacherInformation::find()->where(['teacher_number' => Yii::$app->user->getId()])->one(); 
        return $model;
    }

}
