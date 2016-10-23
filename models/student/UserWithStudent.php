<?php

namespace app\models\student;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "teacher_course".
 *
 * 
 */
class UserWithStudent extends \app\models\User
{
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
    
   
    
}
