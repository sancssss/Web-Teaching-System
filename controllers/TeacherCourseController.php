<?php

namespace app\controllers;

use Yii;
use app\models\Course;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Form\CourseForm;

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
            'query' => Course::find()->where(['teacher_number' => Yii::$app->user->getId()]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionCourseUser($cid)
    {
        $query = User::find()->innerJoinWith('studentCourses')->where(['course_id' => $cid]);
        $course = Course::findOne($cid);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('course-user', [
            'dataProvider' => $dataProvider,
            'course' => $course,
        ]);
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
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cid)
    {
        if (($model = Course::findOne(['course_id' => $cid, 'teacher_number' =>  Yii::$app->user->getId()])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
