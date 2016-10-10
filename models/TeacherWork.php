<?php

namespace app\models;
use yii\helpers\Url;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "teacher_work".
 *
 * @property integer $twork_id
 * @property string $twork_title
 * @property string $twork_content
 * @property string $twork_date
 * @property string $twork_update
 * @property integer $course_id
 *
 * @property SworkTwork[] $sworkTworks
 * @property StudentWork[] $sworks
 *  @property TeacherCourse $course
 */
class TeacherWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['twork_title', 'twork_content', 'twork_date', 'course_id'], 'required'],
            [['twork_content'], 'string'],
            [['course_id'], 'integer'],
            [['twork_title', 'twork_update'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'twork_id' => '作业ID',
            'twork_title' => '作业题目',
            'twork_content' => '作业要求',
            'twork_date' => ' 发布时间',
            'user_update' => '更新时间',
            'course_id' => '课程号',
            'usersLink' => '提交数量'
        ];
    }
    /**
     * 判断当前课程是否属于当前身份 是返回true
     * @param type $tid
     * @return boolean
     */
    public function isBelongToTeacher($tid)
    {
        $check = $this->getCourse()->where(['course_id' => $this->course_id, 'teacher_number' => $tid]);
        if($check == NULL){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    /**
     * 得到每个作业的提交学生列表的链接
     * 
     * @return Html $link
     * 
     */
    public function getUsersLink()
    {
        $url = Url::to(['/teacher-work/submit-users', 'id' => $this->twork_id]);
        $options =  ['class'=>'btn btn-success'];
        return Html::a($this->getSubmitCount(), $url, $options);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSworkTworks()
    {
        return $this->hasMany(SworkTwork::className(), ['twork_id' => 'twork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSworks()
    {
        return $this->hasMany(StudentWork::className(), ['swork_id' => 'swork_id'])->viaTable('swork_twork', ['twork_id' => 'twork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }
    
    /**
     * @return integer 每个作业对应的提交学生数量
     */
    public function getSubmitCount()
    {
        return $this->getSworkTworks()->count();
    }
}
