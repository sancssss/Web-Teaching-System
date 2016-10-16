<?php

namespace app\models\Form;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * 学生信息填写表格model
 *
 */
class AddStuInfoForm extends Model
{
    public $student_class;
    public $student_number;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['student_class', 'student_number'], 'required'],
            [['student_number'], 'integer'],
            [['student_class'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_number' => '学号',
            'student_class' => '班级',
        ];
    }
    
}
