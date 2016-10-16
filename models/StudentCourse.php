<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "student_course".
 *
 * @property integer $student_number
 * @property integer $course_id
 * @property integer $verified
 *
 * @property User $teacherNumber
 * @property Course $courseId
 */
class StudentCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_number', 'course_id'], 'required'],
            [['student_number', 'course_id', 'verified'], 'integer'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
            [['student_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['student_number' => 'user_number']],
            //[['course_id', 'student_number'], 'unique', 'targetClass' => [Course::className(), User::className()], 'targetAttribute' => ['course_id' => 'course_id' ,'student_number' => 'user_number']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_number' => '学生学号',
            'course_id' => '课程号',
            'verifiedIt' => '操作',
        ];
    }
    
    /**
     * 老师进行对学生身份的确认链接生成
     * @return Html $link确认某个学生申请课的链接
     */
    public function getVerifiedIt()
    {
        $url = Url::to(['/teacher-course/verified', 'sid' => $this->student_number, 'cid' => $this->course_id]);
        $options = [];
        return Html::a('确认', $url, $options);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseId()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'student_number']);
    }
}
