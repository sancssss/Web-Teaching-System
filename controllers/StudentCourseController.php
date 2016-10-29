<?php

namespace app\controllers;
use app\models\student\CourseWithStudent;
use app\models\Course;
use app\models\StudentCourse;
use app\models\StudentCourseSearch;
use yii\data\ActiveDataProvider;
use app\models\student\CourseFileWithStudent;
use app\models\student\NoticeWithStudent;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use Yii;
use app\models\CourseNoticeBroadcast;

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
         $dataProvider = new ActiveDataProvider([
            'query' => CourseWithStudent::find()
                ->innerJoinWith('studentCourses')
                ->where(['student_number' => Yii::$app->user->getId()]),
        ]);

        return $this->render('course-list', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * 申请课程号为cid的课程
     * @param type $cid
     */
    public function actionRegisterCourse($cid)
    {
        $model = new StudentCourse();
        $model->student_number = Yii::$app->user->getId();
        $model->course_id = $cid;
        $model->verified = 0;
        if($model->save()){
            Yii::$app->session->setFlash('info', '申请成功!请等待批准.');
        }else{
             Yii::$app->session->setFlash('info', '申请失败.');
        }
        
        $this->redirect(['/student-course/find-course']);
    }
    
    /**
     * 取消申请课程号为cid的-待同意-课程
     * @param type $cid
     */
    public function actionCancelCourse($cid)
    {
        $model = StudentCourse::find()->where(['course_id' => $cid, 'verified' => 0, 'student_number' => Yii::$app->user->getId()])->one();
        if(!$model->delete()){
             Yii::$app->session->setFlash('info', '取消失败.');
        }
        Yii::$app->session->setFlash('info', '取消成功.');
         $this->redirect(['/student-course/courses-list']);
    }

    /**
     * 查找课程
     */
    public function actionFindCourse()
    {
        $searchModel = new StudentCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('find-course', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     /**
     * 显示课程号为cid的课件列表
     * @param integer $cid
     * @return mixed
     */
    public function actionCourseFiles($cid)
    {
        $course = $this->findModel($cid);
        $query = CourseFileWithStudent::find()->where(['course_id' => $cid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('course-files', [
            'dataProvider' => $dataProvider,
            'course' => $course,
        ]);
    }
    
    
     /*
     * 显示全部课程的未读通知
     */
    public function actionAllCourseNotices($status)
    {
        /*if(($status != 1 || $status != 0)){
            throw new NotFoundHttpException('非法访问');
        }*/
        $notices = NoticeWithStudent::find()
                ->innerJoinWith('courseNoticeBroadcasts')
                ->where(['course_notice_broadcast.student_number' => Yii::$app->user->getId(), 'course_notice_broadcast.is_read' => $status]);
        $dataProvider = new ActiveDataProvider([
            'query' => $notices,
        ]);
        return $this->render('all-course-notices', [
            'dataProvider' => $dataProvider,
            'noticeStatus' => $status,
        ]);
    }
    
    
    /**
     * 重定向到真实下载链接并且下载数量加一
     */
    public function actionDownloadCourseFile($fileid)
    {
        $file = CourseFileWithStudent::find()->where(['file_id' => $fileid])->one();
        $file->file_download_count += 1 ;
        $file->save();
        return $this->redirect(Url::to('@web/uploads/'.$file->file_hash.'.'.$file->file_extension));
    }
    
    /**
     * 显示学生所选的某门课的通知列表
     * @param integer $cid 课程号
     * @return mixed
     */
    public function actionCourseNotices($cid){
        //检验是否为当前登录用户选课
        $model = NoticeWithStudent::find()
                ->innerJoin('student_course', 'student_course.course_id = course_notice.course_id')
                ->where(['course_notice.course_id' => $cid, 'student_course.student_number' => Yii::$app->user->getId(), ])->one();
        //return print_r($model);
        if($model == null){
            throw new NotFoundHttpException('非法请求');
        }
        //当有推送记录时才会得到数据
        $dataProvider = new ActiveDataProvider([
            'query' => NoticeWithStudent::find()->innerJoin('course_notice_broadcast', 'course_notice.notice_id = course_notice_broadcast.notice_id')
                ->where(['course_notice.course_id' => $cid, 'course_notice_broadcast.student_number' => Yii::$app->user->getId(),]),
        ]);

        return $this->render('course-notices', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    
    /**
     * 显示每个选择课的通知详情
     * @param integer $id 通知id
     * @return mixed
     * @throws NotFoundHttpException 非选择课的通知详情时抛出异常
     */
    public function actionNotice($id){
        $model = NoticeWithStudent::find()
                ->innerJoin('student_course', 'student_course.course_id = course_notice.course_id')
                ->where(['course_notice.notice_id' => $id, 'student_course.student_number' => Yii::$app->user->getId(),])->one();
        if($model == null){
             throw new NotFoundHttpException('非法请求');
        }
        //通知查看状态修改
        $noticeStatus = CourseNoticeBroadcast::find()->where(['notice_id' => $model->notice_id])->one();
        if($noticeStatus->is_read == 0){
            $noticeStatus->is_read = 1;
            $noticeStatus->save();
        }
        return $this->render('notice', [
            'model' => $model,
        ]);
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
        //查询时候用where实现条件就会使find中的条件失效
        if (($model = CourseWithStudent::find()->innerJoinWith('studentNumbers')->where(['student_number' => Yii::$app->user->getId(), 'teacher_course.course_id' => $cid])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    
}
