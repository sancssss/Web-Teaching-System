<?php

namespace app\models\Form;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CourseForm extends Model
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
            'title' => '课程名',
            'content' => '课程简介',
        ];
    }
    
}
