<?php

namespace app\models;

use yii\helpers\Url;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "twork_file".
 *
 * @property integer $file_id
 * @property integer $twork_id
 * @property string $file_name
 * @property string $file_extension
 * @property integer $file_upload_time
 * @property string $file_hash
 * @property integer $file_download_count
 *
 * @property TeacherWork $twork
 */
class TworkFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'twork_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['twork_id', 'file_name', 'file_extension', 'file_upload_time', 'file_hash'], 'required'],
            [['twork_id', 'file_upload_time', 'file_download_count'], 'integer'],
            [['file_name', 'file_extension', 'file_hash'], 'string', 'max' => 255],
            [['twork_id'], 'exist', 'skipOnError' => true, 'targetClass' => TeacherWork::className(), 'targetAttribute' => ['twork_id' => 'twork_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'twork_id' => 'Twork ID',
            'file_name' => '文件名',
            'file_extension' => '文件类型',
            'file_upload_time' => '上传时间',
            'file_hash' => 'File Hash',
            'file_download_count' => '下载次数',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTwork()
    {
        return $this->hasOne(TeacherWork::className(), ['twork_id' => 'twork_id']);
    }
    
     //TODO:未进行下载安全加密
    /**
     * 生成当前文件的action下载链接
     * @return string
     */
    public function getFileDownloadLink()
    {
        $url = Url::to(['student-work/download-twork-file', 'tworkid' => $this->twork_id]);
        $options =  [];
        return Html::a('下载', $url, $options);
    }
    
}
