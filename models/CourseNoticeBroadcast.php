<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course_notice_broadcast".
 *
 * @property integer $notice_id
 * @property integer $student_number
 * @property integer $is_read
 *
 * @property User $studentNumber
 */
class CourseNoticeBroadcast extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_notice_broadcast';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_id', 'student_number', 'is_read'], 'required'],
            [['notice_id', 'student_number', 'is_read'], 'integer'],
            [['student_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['student_number' => 'user_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_id' => 'Notice ID',
            'student_number' => 'Student Number',
            'is_read' => 'Is Read',
        ];
    }
    


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'student_number']);
    }
    
}
