<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\StudentTeacher;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * 当前登录老师对应的未批准的学生列表
     * @return $mixed
     */
    public function actionWaitingList()
    {
        $selectionData = Yii::$app->request->post('selection');
        if($selectionData != NULL)
        {
           // Yii::trace($selectionData);
           // Yii::trace(ArrayHelper::toArray(json_decode($selectionData[0])));
            for($i = 0; $i < sizeof($selectionData); $i++){
                $this->verifiedItem(ArrayHelper::toArray(json_decode($selectionData[$i]))['student_number']);
            }
        }
        $query = StudentTeacher::find(['teacher_number' => Yii::$app->user->getId()])->where([ 'verified' => '0' ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $this->render('/user/teacher/waiting-list', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * 老师确认某个id的学生为自己的学生
     * @param integer $id 学生的学号
     * @return mixed 返回列表页
     */ 
    public function actionVerified($id)
    {
        $this->verifiedItem($id);
        $this->redirect(['user/waiting-list']);
    }
    
    /**
     * 老师确认某个id的学生为自己的学生
     * @param integer $id 学生的学号
     * @return boolean 如果更新成功返回true反之false
     */
    protected function verifiedItem($id)
    {
        $studentTeacher = StudentTeacher::find(['student_number' => $id])->where([ 'verified' => '0', 'teacher_number' => Yii::$app->user->getId()])->one();
        $studentTeacher->verified = 1;
        if($studentTeacher->save()){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_number]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_number]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
