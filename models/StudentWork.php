<?php

namespace app\models;

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\StudentCourse;
use app\models\SworkTwork;

/**
 * This is the model class for table "student_work".
 *
 * @property integer $swork_id
 * @property string $swork_title
 * @property string $swork_content
 * @property string $swork_date
 * @property integer $user_number
 *
 * @property User $userNumber
 * @property SworkTwork[] $sworkTworks
 * @property TeacherWork $tworks
 */
class StudentWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['swork_content'], 'string'],
            [['swork_title'], 'string', 'max' => 255],
            [['user_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_number' => 'user_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'swork_id' => '作业ID',
            'swork_title' => '作业题目',
            'swork_content' => '作业答案',
            'swork_date' => '提交时间',
            'user_number' => '提交者ID',
            'commentLink' => '批改链接',
            'sworkFilesLink' => '附件',
            'tSworkFilesLink' => '附件'
        ];
    }
    //TODO sql优化
    /**
     * @return boolean 
     * 检查新提交作业时是否重复提交
     */
    public function checkCanCreate($tworkid, $usernumber)
    {
        //tworkid存在返回true
        $isTworkidExist = TeacherWork::find()->where(['twork_id' => $tworkid])->one() != NULL;
        //重复提交返回true
        $isRepeatSubmit = SworkTwork::find()->innerJoinWith('swork')->where(['twork_id' => $tworkid, 'user_number' => $usernumber])->count() > 0;
        //课程与学生归属正确返回true且必须为确认了的学生
        $isBelong = StudentCourse::find()->innerJoin('teacher_work', 'teacher_work.course_id = student_course.course_id')
                ->where(['student_course.student_number' => $usernumber, 'student_course.verified' => 1, 'teacher_work.twork_id' => $tworkid]);
        //提交没有超时
        $isNotDeadline = (TeacherWork::find()->where(['twork_id' => $tworkid])->one()->twork_deadline < time());
        if(!$isTworkidExist || $isRepeatSubmit || !$isBelong || $isNotDeadline){
            return FALSE; 
        }else{
            return TRUE;
        }
    }
    
    
    /**
     * 检查作业是否可以更新提交
     * @param $id 学生作业id
     * @param $usernumber 学生学号
     */
    public function checkCanUpdate($id, $usernumber){
        $tworkDeadline = SworkTwork::find()->where(['swork_id' => $id])->one()->twork->twork_deadline;
        if(time() > $tworkDeadline){
            return false;
        }else{
            return true;
        }
    }
    
    /**
     * 返回某个作业的批改链接
     * @return Html $links
     */
    public function getCommentLink()
    {
        $tworkid = $this->getSworkTwork()->where(['swork_id' => $this->swork_id])->one();
        $url = Url::to(['/teacher-work/comment-swork' , 'sworkid' => $this->swork_id, 'tworkid' => $tworkid->twork_id]);
        $option = [];
        return Html::a('查看', $url, $option);
    }
    
    /**
     * 获取学生作业的附件链接(学生端)
     * @return Html
     */
    public function getSworkFilesLink()
    {
        $url = Url::to(['/student-work/swork-files' , 'sworkid' => $this->swork_id]);
        $option = [];
        return Html::a('附件列表', $url, $option);
    }
    
     /**
     * 获取学生作业的附件链接(教师端)
     * @return Html
     */
    public function getTSworkFilesLink()
    {
        $url = Url::to(['/teacher-work/swork-files' , 'sworkid' => $this->swork_id]);
        $option = [];
        return Html::a('附件列表', $url, $option);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'user_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSworkTwork()
    {
        return $this->hasOne(SworkTwork::className(), ['swork_id' => 'swork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTworks()
    {
        return $this->hasOne(TeacherWork::className(), ['twork_id' => 'twork_id'])->viaTable('swork_twork', ['swork_id' => 'swork_id']);
    }
}
