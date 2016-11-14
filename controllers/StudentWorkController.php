<?php

namespace app\controllers;

use Yii;
use app\models\StudentWork;
use app\models\student\CourseWithStudent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \app\models\Form\SWorkForm;
use app\models\Form\SworkUploadForm;
use yii\web\UploadedFile;
use \app\models\SworkTwork;
use app\models\TeacherWork;
use app\models\student\TworkFileWithStudent;
use app\models\SworkFile;
use app\models\student\WorkWithStudent;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
/**
 * StudentWorkController implements the CRUD actions for StudentWork model.
 */
class StudentWorkController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                //非学生无法access
                'rules' => [
                     [
                        'allow' => 'true',
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['student'],
                    ],
                ]
            ],
        ];
    }

    /**
     * 显示课程号为cid的作业
     * @throw 当请求不是当前学生所选确认了的课的作业列表时将会抛出404异常
     * @return mixed
     */
    public function actionIndex($cid)
    {
        $course = CourseWithStudent::find()
                ->innerJoinWith('studentNumbers')
                ->where(['student_course.course_id' => $cid, 'student_course.verified' => 1, 'user_number' => Yii::$app->user->getId()])
                ->one();
        if($course == null){
           throw new NotFoundHttpException('错误访问');
        }
        $query = WorkWithStudent::find()
                ->where(['course_id' => $cid]);
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'course' => $course,
        ]);
    }

    /**
     * Displays a single StudentWork model.
     * @param integer $id
     * @return mixed
     */
    public function actionWork($id)
    {
        return $this->render('work', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentWork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *@param integer $tworkid 学生将要提交的对应老师布置的作业id
     * @return mixed
     */
    public function actionCommitSwork($tworkid)
    {        
        $model = new SWorkForm();
        $course = TeacherWork::find()->where(['twork_id' => $tworkid])->one();
       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $studentWork = new StudentWork();
            $sworkTwork = new SworkTwork();
            $studentWork->swork_title = $model->title;
            $studentWork->swork_content = $model->content;
            $studentWork->swork_date = time();
            $studentWork->user_number = Yii::$app->user->getId();
            if($studentWork->checkCanCreate($tworkid, Yii::$app->user->getId())){
                //保存成功后
                $studentWork->save();
                $sworkTwork->twork_id = $tworkid;
                $sworkTwork->swork_id =  $studentWork->swork_id;
                $sworkTwork->save();
                return $this->redirect(['work', 'id' => $studentWork->swork_id]);
            }else{
                 Yii::$app->session->setFlash('error', "提交错误！");
            }
        }
        return $this->render('commit-twork', [
                'model' => $model,
                'course' => $course,
            ]);
    }

    /**
     * Updates an existing StudentWork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateSwork($id)
    {
        $model = $this->findModel($id);
        

        if ($model->checkCanUpdate($id, Yii::$app->user->getId()) && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['work', 'id' => $model->swork_id]);
        } else {
            return $this->render('update-swork', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * 显示作业号为tworkid的附件列表
     * @param integer $tworkid
     * @return mixed
     */
    public function actionCourseFiles($tworkid)
    {
        $work = WorkWithStudent::find()->where(['twork_Id' => $tworkid])->one();
        if($work == NULL){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $query = TworkFileWithStudent::find()->where(['twork_id' => $tworkid]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('work-files', [
            'dataProvider' => $dataProvider,
            'work' => $work,
        ]);
    }
    
    /**
     * 重定向到真实下载链接并且下载数量加一
     */
    public function actionDownloadTworkFile($fileid)
    {
        $file = TworkFileWithStudent::find()->where(['file_id' => $fileid])->one();
        $file->file_download_count += 1;
        $file->save();
        return $this->redirect(Url::to('@web/uploads/'.$file->file_hash.'.'.$file->file_extension));
    }
    
    /**
     * 显示某门学生提交作业的附件
     * @param integer $sworkid 作业号
     * @return mixed
     */
    public function actionSworkFiles($sworkid)
    {
        $work = $this->findModel($sworkid);
        $query = SworkFile::find()->where(['swork_id' => $sworkid]);
        $dataProvider = new ActiveDataProvider([
           'query' => $query, 
        ]);
        return $this->render('swork-files', [
            'dataProvider' => $dataProvider,
            'work' => $work, 
        ]);
    }
    
    //TODO:检查失败后不成功没有提示
    /**
     * 提交学生端的附件
     */
    public function actionUploadSworkFile($sworkid)
    {
        $fileModel = new SworkUploadForm();
        $work = $this->findModel($sworkid);     
        if(Yii::$app->request->isPost && $work->checkCanUpdate($sworkid, Yii::$app->user->getId())){
            $fileModel->mutiFiles = UploadedFile::getInstances($fileModel, 'mutiFiles');
            //upload方法内验证
            if($fileModel->upload($sworkid)){
                Yii::$app->session->setFlash('success', '文件上传成功！');
            }
        }
        return $this->render('upload-file', [
            'model' => $fileModel,
            'work' => $work,
        ]);
    }
    
     /**
     * 为课程号为sworkid的作业上传资料
     * @param integer $sworkid
     */
    public function actionUploadFile($tworkid)
    {
        $fileModel = new TworkUploadForm();
        $work = $this->findModel($tworkid);
        if(Yii::$app->request->isPost){
            $fileModel->mutiFiles = UploadedFile::getInstances($fileModel, 'mutiFiles');
            //upload方法内验证
            if($fileModel->upload($tworkid)){
                Yii::$app->session->setFlash('success', '文件上传成功！');
            }
        }
        return $this->render('upload-file', [
            'model' => $fileModel,
            'work' => $work,
        ]);
    }
    
    /**
     * 教师布置的作业详情
     * @param integer $tworkid 布置的作业id
     */
    public function actionTeacherWork($tworkid)
    {
        $model = WorkWithStudent::find()->where(['twork_id' => $tworkid])->one();
        return $this->render('teacher-work', [
                'model' => $model,
            ]);
    }
    
    
    /**
     * 显示未完成的作业
     * @return mixed
     */
    public function actionUnfinishedWorks(){
        //然首先看当前用户的课对应布置的全部作业
        //得到当前用户完成的全部作业
        //用布置作业减去完成的作业得到未提交作业
        $myWorks = SworkTwork::find()->innerJoinWith('swork')->where(['student_work.user_number' => Yii::$app->user->getId()])->all();
        $allWorks = WorkWithStudent::find()
                ->innerJoin('student_course', 'student_course.course_id = teacher_work.course_id')
                ->where(['not in', 'twork_id', $myWorks])
                ->andWhere(['student_course.student_number' => Yii::$app->user->getId(), 'student_course.verified' => 1]);
         $dataProvider = new ActiveDataProvider([
           'query' => $allWorks, 
        ]);
        return $this->render('unfinshed-works', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the StudentWork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentWork::find()->where(['swork_id' => $id, 'user_number' => Yii::$app->user->getId()])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
