<?php

namespace app\models\Form;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Course;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class TWorkForm extends Model
{
    public $title;
    public $content;
    public $cid;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title'], 'string', 'min' => '2', 'max' => '255'],
            [['content'], 'string', 'min' => '10', 'max' => '20000']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '作业题目',
            'content' => '作业要求',
        ];
    }
    
    /**
     * 获取cid对应作业的名字
     * @param type $cid
     */
    public function getCourseName()
    {
        return Course::find($this->cid)->one()->course_name;
        
    }
    
    public function setCourseName($cid)
    {
        $this->cid = $cid;
    }
    
}
