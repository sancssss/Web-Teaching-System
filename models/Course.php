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
 * @property CourseFile[] $courseFiles
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
        ];
    }
    
        /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseFiles()
    {
        return $this->hasMany(CourseFile::className(), ['course_id' => 'course_id']);
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
