<?php

namespace app\models;

use Yii;
use app\models\teacher\CourseWithTeacher;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "course_file".
 *
 * @property integer $file_id
 * @property string $course_id
 * @property string $file_name
 * @property string $file_extension
 * @property string $file_hash
 * @property string $file_upload_time 
 * @property integer $file_download_count
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
            'file_name' => '文件名',
            'file_extension' => '文件类型',
            'file_download_count' => '下载次数',
            'file_hash' => 'File Hash',
            'file_upload_time' => '上传时间',
            'fileDownloadLink' => '下载链接'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(TeacherCourse::className(), ['course_id' => 'course_id']);
    }
    
    //TODO:未进行下载安全加密
    /**
     * 生成当前文件的下载链接
     * @return string
     */
    public function getFileDownloadLink()
    {
        $url = Url::to(['student-course/download-course-file', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a('下载', $url, $options);
    }
    
}
