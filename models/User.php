<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_number
 * @property string $user_name
 * @property string $user_password
 * @property string $user_authKey
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[] $itemNames
 * @property StudentCourse[] $studentCourses
 * @property TeacherCourse[] $courses
 * @property StudentWork[] $studentWorks
 * @property TeacherCourse[] $teacherCourses
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['user_number', 'user_name', 'user_password'], 'required'],
            [['user_number'], 'integer'],
            [['user_name'], 'string', 'max' => 255],
            [['user_password'], 'string', 'max' => 32],
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user_authKey = Yii::$app->security->generateRandomString();
                $this->user_password = md5($this->user_password);
            }
            return true;
        }
        return false;
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

    public function getAuthKey() {
        return $this->user_authKey;
    }

    public function getId() {
        return $this->user_number;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id) {
         return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentCourses()
    {
        return $this->hasMany(StudentCourse::className(), ['student_number' => 'user_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(TeacherCourse::className(), ['course_id' => 'course_id'])->viaTable('student_course', ['student_number' => 'user_number']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourses()
    {
        return $this->hasMany(TeacherCourse::className(), ['teacher_number' => 'user_number']);
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'user_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'user_number']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentInformation()
    {
        return $this->hasOne(StudentInformation::className(), ['student_number' => 'user_number']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherInformation()
    {
        return $this->hasOne(TeacherInformation::className(), ['teacher_number' => 'user_number']);
    }
}
