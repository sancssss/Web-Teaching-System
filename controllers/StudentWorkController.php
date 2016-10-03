<?php

namespace app\controllers;

use Yii;
use app\models\StudentWork;
use app\models\StudentWorkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \app\models\Form\SWorkForm;
use \app\models\SworkTwork;
use app\models\TeacherWork;
use yii\data\Pagination;
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
     * Lists all StudentWork models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentWorkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentWork model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentWork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *@param integer $tworkid 学生将要提交的对应老师布置的作业id
     * @return mixed
     */
    public function actionCreate($tworkid)
    {        
        $model = new SWorkForm();
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
                return $this->redirect(['view', 'id' => $studentWork->swork_id]);
            }else{
                 Yii::$app->session->setFlash('error', "提交错误！");
            }
        }
        return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing StudentWork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->swork_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StudentWork model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = StudentWork::find($id)->where(['user_number' => Yii::$app->user->getId()])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
