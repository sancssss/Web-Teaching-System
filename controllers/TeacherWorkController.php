<?php

namespace app\controllers;

use Yii;
use app\models\TeacherWork;
use app\models\TeacherWorkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \app\models\Form\TWorkForm;

/**
 * TeacherWorkController implements the CRUD actions for TeacherWork model.
 */
class TeacherWorkController extends Controller
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
                //非登陆用户无法进入个人中心
                'rules' => [
                     [
                        'allow' => 'true',
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['teacher'],
                    ],
                ]
            ],
        ];
    }

    /**
     * Lists all TeacherWork models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeacherWorkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeacherWork model.
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
     * Creates a new TeacherWork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TWorkForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $teacherWork = new TeacherWork();
            $teacherWork->twork_title = $model->title;
            $teacherWork->twork_content = $model->content;
            $teacherWork->twork_date = time();
            $teacherWork->user_number = Yii::$app->user->getId();
            $teacherWork->save();
            return $this->redirect(['view', 'id' => $teacherWork->twork_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TeacherWork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->twork_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TeacherWork model.
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
     * Finds the TeacherWork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TeacherWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TeacherWork::find($id)->where(['user_number' => Yii::$app->user->getId()])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
