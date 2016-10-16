<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_information".
 *
 * @property integer $student_number
 * @property string $student_class
 *
 * @property User $studentNumber
 */
class StudentInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_number', 'student_class'], 'required'],
            [['student_number'], 'integer'],
            [['student_class'], 'string', 'max' => 50],
            [['student_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['student_number' => 'user_number']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'student_number']);
    }
}
