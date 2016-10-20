<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "swork_file".
 *
 * @property integer $file_id
 * @property integer $swork_id
 * @property string $file_name
 * @property string $file_extension
 * @property integer $file_upload_time
 * @property string $file_hash
 * @property integer $file_download_count
 *
 * @property StudentWork $swork
 */
class SworkFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'swork_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['swork_id', 'file_name', 'file_extension', 'file_upload_time', 'file_hash'], 'required'],
            [['swork_id', 'file_upload_time', 'file_download_count'], 'integer'],
            [['file_name', 'file_extension', 'file_hash'], 'string', 'max' => 255],
            [['swork_id'], 'exist', 'skipOnError' => true, 'targetClass' => StudentWork::className(), 'targetAttribute' => ['swork_id' => 'swork_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'swork_id' => 'Swork ID',
            'file_name' => '文件名',
            'file_extension' => '文件类型',
            'file_upload_time' => '上传时间',
            'file_hash' => 'File Hash',
            'file_download_count' => '下载次数',
            'fileDownloadLink' => '下载'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSwork()
    {
        return $this->hasOne(StudentWork::className(), ['swork_id' => 'swork_id']);
    }
    
     //TODO::未进行下载安全加密
    /**
     * 生成当前文件的下载链接
     * @return string
     */
    public function getFileDownloadLink()
    {
        $url = Url::to('@web/uploads/'.$this->file_hash.'.'.$this->file_extension);
        $option = [];
        return Html::a('下载', $url, $option);
    }
}
