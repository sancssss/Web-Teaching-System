<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teacher_information".
 *
 * @property integer $teacher_number
 * @property integer $teacher_introduction
 */
class TeacherInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_introduction'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'teacher_number' => '教师号',
            'teacher_introduction' => '个人简介',
        ];
    }
}
