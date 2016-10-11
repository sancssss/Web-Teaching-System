<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "teacher_course".
 *
 * @property string $course_id
 * @property string $course_name
 * @property string $course_content
 * @property integer $teacher_number
 *
 * @property StudentCourse[] $studentCourses
 * @property User[] $studentNumbers
 * @property TeacherWork[] $teacherWorks
 * @property User $teacherNumber
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_name', 'teacher_number'], 'required'],
            [['course_content'], 'string'],
            [['teacher_number'], 'integer'],
            [['course_name'], 'string', 'max' => 255],
            [['teacher_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['teacher_number' => 'user_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => '课程号',
            'course_name' => '课程名',
            'course_content' => '课程介绍',
            'teacher_number' => '教师号',
            'teacherCourseLink' => '课程详情',
            'courseUserCountLink' => '选课人数',
            'courseWorksLink' => '作业详情',
        ];
    }
    
    /**
     * 得到每一个教师课程的详情链接
     * @return Html
     */
    public function getTeacherCourseLink()
    {
        $url = Url::to(['/teacher-course/course', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a($this->course_name, $url, $options);
    }
    
    /**
     * 得到每一个课程选课用户列表的链接
     * @return Html
     */    
    public function getCourseUserCountLink()
    {
        $url = Url::to(['/teacher-course/course-user', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a($this->getCourseUserCount(), $url, $options);
    }
    
    /**
     * 得到每一个课程的作业列表链接
     * @return Html
     */
    public function getCourseWorksLink()
    {
        $url = Url::to(['/teacher-work/index', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a('查看('.$this->getTeacherWorks()->where(['course_id' => $this->course_id])->count().')', $url, $options);
    }
    
    /**
     * 得到当前课程选课已经确认了的人数
     * @return integer
     */
    public function getCourseUserCount()
    {
        return $this->getStudentCourses()->where(['course_id' => $this->course_id, 'verified' => 1])->count();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourses()
    {
        return $this->hasMany(StudentCourse::className(), ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNumbers()
    {
        return $this->hasMany(User::className(), ['user_number' => 'student_number'])->viaTable('student_course', ['course_id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'teacher_number']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherWorks()
    {
        return $this->hasMany(TeacherWork::className(), ['course_id' => 'course_id']);
    }
}
