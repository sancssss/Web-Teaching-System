<?php

namespace app\models\Form;

use yii\base\Model;
use yii\web\UploadedFile;
use app\models\CourseFile;
use Yii;

class CourseUploadForm extends Model
{
     /**
     * @var UploadedFile[]
     */
    public $mutiFiles;

    public function rules()
    {
        return [
            [['mutiFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt', 'maxFiles' => 4],
        ];
    }
    //TODO::上传path未解决
    public function upload($cid)
    {
        if ($this->validate()) { 
            foreach ($this->mutiFiles as $file) {
                $randomKey = Yii::$app->getSecurity()->generateRandomKey(32);
                $file->saveAs(Yii::getAlias('@webroot').'/uploads/' . $randomKey . '.' . $file->extension);
                $courseFile = new CourseFile();
                $courseFile->course_id = $cid;
                $courseFile->file_name = time() . $file->baseName;
                $courseFile->file_extension = $file->extension;
                $courseFile->file_hash = $randomKey;
                $courseFile->save();
            }
            return true;
        } else {
            return false;
        }
    }

}

?>