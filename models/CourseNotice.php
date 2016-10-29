<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course_notice".
 *
 * @property integer $notice_id
 * @property string $notice_title
 * @property string $notice_content
 * @property string $notice_date
 * @property string $course_id
 *
 * @property TeacherCourse $course
 */
class CourseNotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_title', 'notice_content', 'course_id'], 'required'],
            [['notice_content'], 'string'],
            [['course_id'], 'integer'],
            [['notice_title'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'course_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_id' => 'Notice ID',
            'notice_title' => '标题',
            'notice_content' => '内容',
            'notice_date' => '时间',
            'course_id' => 'Course ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['course_id' => 'course_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseNoticeBroadcasts()
    {
        return $this->hasMany(CourseNoticeBroadcast::className(), ['notice_id' => 'notice_id']);
    }
}
