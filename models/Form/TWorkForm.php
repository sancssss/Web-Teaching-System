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
    public $course_id;
    public $course_name;
    public $twork_id;
    public $deadline_day;
    public $deadline_mon;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'content', 'deadline_mon', 'deadline_day'], 'required'],
            [['deadline_day'], 'number', 'min' => '1', 'max' => '31'],
            [['deadline_mon'], 'number', 'min' => '1', 'max' => '12'],
            [['title'], 'string', 'min' => '2', 'max' => '255'],
            [['content'], 'string', 'min' => '1', 'max' => '20000']
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
            'deadline_day' => '截止日',
            'deadline_mon' => '截止月'
        ];
    }
    
    /**
     * 获取cid对应作业的名字
     * @param type $cid
     */
    public function getCourseName()
    {
        return Course::find()->where(['course_id' => $this->course_id,])->one()->course_name;
        
}
    
    public function setCourseId($cid)
    {
        $this->course_id = $cid;
    }
    
    
}
