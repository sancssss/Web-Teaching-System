<?php

namespace app\controllers;

use Yii;
use app\models\Course;
use app\models\teacher\CourseWithTeacher;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Form\CourseForm;
use app\models\StudentCourse;
use  yii\helpers\ArrayHelper;

/**
 * TeacherCourseController implements the CRUD actions for Course model.
 */
class TeacherCourseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 课程管理首页，显示当前登录用户的课程
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CourseWithTeacher::find()->where(['teacher_number' => Yii::$app->user->getId()]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 显示某门课的选课确认了的用户
     * @param type $cid
     * @return mixed
     */
    public function actionCourseUser($cid)
    {
        $query = User::find()->innerJoinWith('studentCourses')->where(['course_id' => $cid, 'verified' => 1]);
        $course = CourseWithTeacher::findOne($cid);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('course-user', [
            'dataProvider' => $dataProvider,
            'course' => $course,
        ]);
    }
    
     /**
     * 当前登录老师对应的未批准的学生列表
     * @return $mixed
     */
    public function actionWaitingList($cid)
    {
        $selectionData = Yii::$app->request->post('selection');
        if($selectionData != NULL)
        {
           // Yii::trace($selectionData);
           // Yii::trace(ArrayHelper::toArray(json_decode($selectionData[0])));
            for($i = 0; $i < sizeof($selectionData); $i++){
                $this->verifiedItem(ArrayHelper::toArray(json_decode($selectionData[$i]))['student_number'], ArrayHelper::toArray(json_decode($selectionData[$i]))['course_id']);
            }
        }
        $query = StudentCourse::find(['course_id' => $cid])->where([ 'verified' => '0' ]);
        $model = Course::findOne($cid);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $this->render('waiting-list', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
    /**
     * 老师确认某个id的学生为自己的学生
     * @param integer $id 学生的学号
     * @return mixed 返回列表页
     */ 
    public function actionVerified($sid, $cid)
    {
        $this->verifiedItem($sid, $cid);
        $this->redirect(['teacher-course/waiting-list', 'cid' => $cid]);
    }

    /**
     * 课程详细信息页面
     * @param type $cid 课程号
     * @return mixed
     */
    public function actionCourse($cid)
    {
        return $this->render('course', [
            'model' => $this->findModel($cid),
        ]);
    }


    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $course = new Course();
            $course->course_name = $model->title;
            $course->course_content = $model->content;
            $course->teacher_number = Yii::$app->user->getId();
            $course->save();
            return $this->redirect(['course', 'cid' => $course->course_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($cid)
    {
        $model = new CourseForm();
        $model->cid = $cid;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $course = $this->findModel($cid);
            $course->course_name = $model->title;
            $course->course_content = $model->content;
            $course->teacher_number = Yii::$app->user->getId();
            $course->save();
            return $this->redirect(['course', 'cid' => $course->course_id]);
        } else {
            $model->title = $this->findModel($cid)->course_name;
            $model->content = $this->findModel($cid)->course_content;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
     /**
     * 老师确认某个id的学生的课程申请
     * @param integer $id 学生的学号 $cid 课程号
     * @return boolean 如果更新成功返回true反之false
     */
    protected function verifiedItem($sid, $cid)
    {
        $studentCourse = StudentCourse::find()->innerJoinWith('courseId')
                ->where([ 'verified' => '0', 'teacher_course.course_id' => $cid, 'student_number' => $sid, 'teacher_number' => Yii::$app->user->getId()])
                ->one();
        $studentCourse->verified = 1;
        if($studentCourse->save()){
             Yii::$app->session->setFlash('info', '批准成功！');
            return TRUE;
        }else{
             throw new NotFoundHttpException(json_encode($studentCourse->getErrors()));
             return FALSE;
        }
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
        if (($model = CourseWithTeacher::findOne(['course_id' => $cid, 'teacher_number' =>  Yii::$app->user->getId()])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
