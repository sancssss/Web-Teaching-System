<?php
namespace app\controllers;

use Yii;
use app\models\teacher\NoticeWithTeacher;
use yii\data\ActiveDataProvider;
use app\models\Form\NoticeForm;
use yii\web\NotFoundHttpException;
use app\models\CourseNoticeBroadcast;
use app\models\StudentCourse;
use app\models\teacher\CourseWithTeacher;

class CourseNoticeController extends \yii\web\Controller
{
    /**
     * 显示某门课的通知
     * @return mixed
     */
     public function actionIndex($cid)
    {
        $model = $this->findModelByCid($cid);
        $dataProvider = new ActiveDataProvider([
            'query' => NoticeWithTeacher::find()
                ->where(['course_id' => $cid]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }
    /**
     * 创建某门课的通知
     * @param integer $cid 课程号
     * @return mixed
     */
    public function actionCreateNotice($cid){
        $model = $this->findModelByCid($cid);
        $formModel = new NoticeForm();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $notice = new NoticeWithTeacher();
            $notice->notice_title = $formModel->notice_title;
            $notice->notice_content = $formModel->notice_content;
            $notice->notice_date = time();
            $notice->course_id = $cid;
            $notice->save();
            return $this->redirect(['notice',
               'id' => $notice->notice_id,
            ]);
        }
        return $this->render('create-notice', [
           'model' => $model,
           'formModel' => $formModel,
        ]);
    }
    
    public function actionUpdateNotice($id){
        $model = $this->findModel($id);
        $model->notice_date = time();
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
           Yii::$app->session->setFlash('success', "更新成功!");
        }
        return $this->render('update-notice',[
           'model' => $model, 
        ]);
    }
    
    /**
     * 返回通知详情
     * @param integer $id 通知的id
     * @return mixed
     */
    public function actionNotice($id){
        $model = $this->findModel($id);
        return $this->render('notice', [
            'model' => $model,
        ]);
    }
    
    /**
     * 删除一条通知并跳转
     * @param integer $id 通知id
     * @return redirect notice list
     */
    public function actionDeleteNotice($id){
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect([
           'index',
           'cid' => $model->course_id,
        ]);
    }
    
    public function actionPushNotice($id){
        $this->pushNoticesToStudent($id);
        return $this->redirect(['notice', 'id' => $id]);
    }
    
    /**
     * 发送全部通知到选课学生
     * @param $id 通知编号
     */
    public function pushNoticesToStudent($id){
        $model = $this->findModel($id);
        $students = StudentCourse::find()->where(['course_Id' => $model->course_id])->all();
        //TODO:未解决多条插入性能问题
        //TODO:未解决发送失败的具体详情
        $countSuccess = 0;
        foreach ($students as $student){
            $addBroadcast = new CourseNoticeBroadcast();
            $addBroadcast->is_read = 0;
            $addBroadcast->notice_id = $id;
            $addBroadcast->student_number = $student->student_number;
            if($addBroadcast->save()){
                $countSuccess++;
            }
        }
        Yii::$app->session->setFlash('success', '成功为'.$countSuccess.'名选课学生推送数据');
        if($countSuccess == 0){
            Yii::$app->session->setFlash('success', '未导入有效数据');
        }
        return true;
    }


    
    /**
     * 通过课程号返回实例
     * @param 课程号 integer $cid
     * @return array
     * @throws NotFoundHttpException 当不是当前老师的课程时抛出异常
     */
    protected  function findModelByCid($cid){
        if(($course = CourseWithTeacher::find()->where(['course_id' => $cid, 'teacher_number' => Yii::$app->user->getId()])->one()) == NULL){
            throw new NotFoundHttpException('非法请求');
        }else{
            return $course;
        }  
    }


    protected function findModel($id)
    {
        if (($model = NoticeWithTeacher::find()->innerJoinWith('course')->where(['notice_id' => $id, 'teacher_number' => Yii::$app->user->getId()])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}


?>

