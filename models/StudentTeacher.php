<?php

namespace app\models;

use Yii;
use \yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "student_teacher".
 *
 * @property integer $student_number
 * @property integer $teacher_number
 * @property integer $verified
 *
 * @property User $teacherNumber
 * @property User $studentNumber
 */
class StudentTeacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_number', 'teacher_number'], 'required'],
            [['student_number', 'teacher_number', 'verified'], 'integer'],
            [['teacher_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['teacher_number' => 'user_number']],
            [['student_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['student_number' => 'user_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_number' => '学生学号',
            'teacher_number' => '老师工号',
            'verifiedIt' => '确认学生',
        ];
    }
    
    /**
     * 老师进行对学生身份的确认链接生成
     * @return Html $link确认某个学生的链接
     */
    public function getVerifiedIt()
    {
        $url = Url::to(['/user/verified', 'id' => $this->student_number]);
        $options = [];
        return Html::a('确认', $url, $options);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'teacher_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'student_number']);
    }
}
