<?php

namespace app\models\student;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\TeacherWork;
use app\models\SworkTwork;

/**
 * This is the model class for table "teacher_course".
 *
 * 
 */
class WorkWithStudent extends TeacherWork
{
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'commitWorkLink' => '操作',
            'tWorkLink' => '作业',
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
    
    /**
     * 得到提交作业的链接,根据提交情况显示不同,链接也不同
     */
    //TODO::Yii::$app->user->getId()是否写在model中
    public function getCommitWorkLink()
    {
        $url = Url::to(['/student-work/commit-swork' , 'tworkid' => $this->twork_id]);
        $option = [];
        if(SworkTwork::find()
                ->innerJoinWith('swork')
                ->where(['user_number' => Yii::$app->user->getId(), 'twork_id' => $this->twork_id])
                ->one() == NULL){
            $displayText = '未提交';
        }else{
             $sworkId = SworkTwork::find()->where(['twork_id' => $this->twork_id])->one()->swork_id;
             $url = Url::to(['/student-work/work' , 'id' => $sworkId]);
             $displayText = '已提交';
        }
        return Html::a($displayText, $url, $option);
    }
    
    /**
     * 获取教师发布的作业详情的链接
     */
    public function getTWorkLink()
    {
         $url = Url::to(['/student-work/teacher-work' , 'tworkid' => $this->twork_id]);
         $option = [];
         return Html::a($this->twork_title, $url, $option);
    }
  
    public function getTworkFilesLink() {
        $url = Url::to(['/student-work/course-files', 'tworkid' => $this->twork_id]);
        $option = [];
        return Html::a('作业附件', $url, $option);
    }
    
}
