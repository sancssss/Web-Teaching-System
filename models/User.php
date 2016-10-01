<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_number
 * @property string $user_name
 * @property string $user_password
 * @property string $user_authKey
 *
 * @property StudentWork[] $studentWorks
 * @property TeacherWork[] $teacherWorks
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_number', 'user_name', 'user_password', 'user_authKey'], 'required'],
            [['user_number'], 'integer'],
            [['user_name'], 'string', 'max' => 255],
            [['user_password', 'user_authKey'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_number' => '用户ID',
            'user_name' => '姓名',
            'user_password' => '密码',
            'user_authKey' => 'User Auth Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentWorks()
    {
        return $this->hasMany(StudentWork::className(), ['user_number' => 'user_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherWorks()
    {
        return $this->hasMany(TeacherWork::className(), ['user_number' => 'user_number']);
    }
}
