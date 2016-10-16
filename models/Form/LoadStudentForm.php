<?php

namespace app\models\Form;

use Yii;
use yii\base\Model;
use app\models\Course;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoadStudentForm extends Model
{
    public $course_id;
    public $student_class;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['student_class', 'course_id'], 'required'],
           // [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' =>Course::className(), 'targetAttribute' => ['course_id' => 'course_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => '课程名',
            'student_class' => '导入班级',
        ];
    }
    
}
