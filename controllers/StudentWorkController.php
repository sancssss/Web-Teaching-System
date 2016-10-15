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
use \app\models\SworkTwork;
use app\models\TeacherWork;
use app\models\student\WorkWithStudent;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['work', 'id' => $model->swork_id]);
        } else {
            return $this->render('update-swork', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 教师布置的作业详情
     * @param type $tworkid 布置的作业id
     */
    public function actionTeacherWork($tworkid)
    {
        $model = WorkWithStudent::find()->where(['twork_id' => $tworkid])->one();
        return $this->render('teacher-work', [
                'model' => $model,
            ]);
    }
    
    /**
     * 显示学生所选老师的作业,为0时显示全部选课老师作业
     * @param integer $teacherid为老师的id
     * @return mixed
     */
    public function actionShowWorks($teacherid=0)
    {
        if($teacherid == 0){
            //得到当前学生授权老师的全部作业
            $model = TeacherWork::find()
                    ->join('INNER JOIN', 'student_teacher', 'student_teacher.teacher_number = teacher_work.user_number')
                    ->where(['student_number' => Yii::$app->user->getId(), 'verified' => 1]);
        }else{
            //得到当前学生指定的授权老师的全部作业
            $model = TeacherWork::find()
                    ->join('INNER JOIN', 'student_teacher', 'student_teacher.teacher_number = teacher_work.user_number')
                    ->where(['student_number' => Yii::$app->user->getId(), 'teacher_number' => $teacherid, 'verified' => 1]);
        }
        
        $pagination = new Pagination([
            'defaultPageSize' => 8,
            'totalCount' => $model->count(),
        ]);
        
        $works = $model->orderBy('twork_id')
                       ->offset($pagination->offset)
                       ->limit($pagination->limit)
                       ->all();
        return $this->render('show-works',[
            'works' => $works,
            'pagination' => $pagination,
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
