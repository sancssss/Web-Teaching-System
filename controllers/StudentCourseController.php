<?php

namespace app\controllers;
use app\models\student\CourseWithStudent;
use app\models\Course;
use yii\data\ActiveDataProvider;
use Yii;

class StudentCourseController extends \yii\web\Controller
{
    /**
     * 首页显示已经选中的课程
     * @return type
     */
   public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CourseWithStudent::find()
                ->innerJoinWith('studentCourses')
                ->where(['student_number' => Yii::$app->user->getId(), 'verified' => 1]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 显示课程详情：作业/教师/课程
     */
    public function actionCourse($cid)
    {
        return $this->render('course', [
            'model' => $this->findModel($cid),
        ]);
    }
    
    /**
     * 申请课程页面：显示未被批准的申请列表和已被同意的课程
     */
    public function actionCoursesList()
    {
        
    }
    
    /**
     * 申请课程号为cid的课程
     * @param type $cid
     */
    public function actionRegisterCourse($cid)
    {
        
    }

    /**
     * 查找课程
     */
    public function actionFindCourse()
    {
        
    }
    
     /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cid)
    {
        if (($model = Course::find()->innerJoinWith('studentNumbers')->where(['student_number' => Yii::$app->user->getId()])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
