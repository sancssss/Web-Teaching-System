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
use app\models\Form\LoadStudentForm;
use app\models\StudentInformation;
use app\models\Form\CourseUploadForm;
use app\models\teacher\CourseFileWithTeacher;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


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
        $query = StudentCourse::find()->where(['course_id' => $cid, 'verified' => '0']);
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
     * 一键导入某个班级学生到某个课程
     */
    public function actionLoadClassStudent()
    {
        $model = new LoadStudentForm();
        $courses = Course::findAll(['teacher_number' => Yii::$app->user->getId()]);
        $myCourseList = ArrayHelper::map($courses, 'course_id', 'course_name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $students = StudentInformation::find(['student_class' => $model->student_class])->asArray()->all();
            $courseid = $model->course_id;
            $this->loadStudent($students, $courseid);
        }
         return $this->render('load-class-student', [
              'myCourseList' => $myCourseList,
              'model' => $model,
           ]);
    }
    /**
     * 
     * @param type $students
     * @param type $courseid
     */
    protected function loadStudent($students, $courseid)
    {
        $countSuccess = 0;
        for($i = 0; $i < count($students); $i++){
            $model = new StudentCourse();
            $model->student_number = $students[$i]['student_number'];
            $model->course_id = $courseid;
            $model->verified = 1;
            //检查重复
            $check = StudentCourse::find()->where(['student_number' => $students[$i]['student_number'], 'course_id' => $courseid])->one();
            if($model->validate() && $check == null){
                $model->save();
                $countSuccess++;
            } 
        }
        Yii::$app->session->setFlash('success', '导入成功！共'.$countSuccess.'条数据');
        if($countSuccess == 0){
            Yii::$app->session->setFlash('success', '未导入有效数据');
        }
        return true;
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
     * 为课程号为cid的课程上传资料
     * @param integer $cid
     */
    public function actionUploadFile($cid)
    {
        $fileModel = new CourseUploadForm();
        $course = $this->findModel($cid);     
        if(Yii::$app->request->isPost){
            $fileModel->mutiFiles = UploadedFile::getInstances($fileModel, 'mutiFiles');
            //upload方法内验证
            if($fileModel->upload($cid)){
                Yii::$app->session->setFlash('success', '文件上传成功！');
            }
        }
        return $this->render('upload-file', [
            'model' => $fileModel,
            'course' => $course,
        ]);
    }
    
    /**
     * 显示课程号为cid的课程列表
     * @param integer $cid
     * @return mixed
     */
    public function actionCourseFiles($cid)
    {
        $course = $this->findModel($cid);
        $query = CourseFileWithTeacher::find()->where(['course_id' => $cid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('course-files', [
            'dataProvider' => $dataProvider,
            'course' => $course,
        ]);
    }
    
     /**
     * 重定向到真实下载链接
     */
    public function actionDownloadCourseFile($fileid)
    {
        $file = CourseFileWithTeacher::find()->where(['file_id' => $fileid])->one();
        return $this->redirect(Url::to('@web/uploads/'.$file->file_hash.'.'.$file->file_extension));
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
