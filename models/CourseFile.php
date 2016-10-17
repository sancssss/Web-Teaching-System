<?php

namespace app\models;

use Yii;
use app\models\teacher\CourseWithTeacher;

/**
 * This is the model class for table "course_file".
 *
 * @property integer $file_id
 * @property string $course_id
 * @property string $file_name
 * @property string $file_extension
 * @property string $file_hash
 *
 * @property TeacherCourse $course
 */
class CourseFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'file_name', 'file_hash'], 'required'],
            [['course_id'], 'integer'],
            [['file_name', 'file_extension', 'file_hash'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseWithTeacher::className(), 'targetAttribute' => ['course_id' => 'course_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'course_id' => 'Course ID',
            'file_name' => 'File Name',
            'file_extension' => 'File Extension',
            'file_hash' => 'File Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(TeacherCourse::className(), ['course_id' => 'course_id']);
    }
}
