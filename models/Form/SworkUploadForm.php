<?php

namespace app\models\Form;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\SworkFile;
use Yii;

class SworkUploadForm extends Model
{
     /**
     * @var UploadedFile[]
     */
    public $mutiFiles;

    public function rules()
    {
        return [
            [['mutiFiles'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 0],
        ];
    }
    
    public function attributeLabels() {
        return [
          'mutiFiles' => '请选择要上传的文件',
        ];
    }
    /**
     * 上传文件到服务器并且在对应数据表中创建文件索引
     * swork为对应学生作业号,上传成功返回true
     * @param integer $sworkid
     * @return boolean 
     */
    public function upload($sworkid)
    {
        if ($this->validate()) { 
            foreach ($this->mutiFiles as $file) {
                $randomKey = Yii::$app->getSecurity()->generateRandomString(32);
                $file->saveAs(Yii::getAlias('@webroot').'/uploads/' . $randomKey . '.' . $file->extension);
                $sworkFile = new SworkFile();
                $sworkFile->swork_id = $sworkid;
                $sworkFile->file_name = $file->baseName;
                $sworkFile->file_extension = $file->extension;
                $sworkFile->file_hash = $randomKey;
                $sworkFile->file_upload_time = time();
                $sworkFile->save();
            }
            return true;
        } else {
            return false;
        }
    }

}

?>