<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_work".
 *
 * @property integer $swork_id
 * @property string $swork_title
 * @property string $swork_content
 * @property string $swork_date
 * @property integer $user_number
 *
 * @property User $userNumber
 * @property SworkTwork[] $sworkTworks
 * @property TeacherWork[] $tworks
 */
class StudentWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['swork_content'], 'string'],
            [['user_number'], 'required'],
            [['user_number'], 'integer'],
            [['swork_title', 'swork_date'], 'string', 'max' => 255],
            [['user_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_number' => 'user_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'swork_id' => '作业ID',
            'swork_title' => '作业题目',
            'swork_content' => '作业答案',
            'swork_date' => '提交时间',
            'user_number' => '提交者',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'user_number']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSworkTworks()
    {
        return $this->hasMany(SworkTwork::className(), ['swork_id' => 'swork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTworks()
    {
        return $this->hasMany(TeacherWork::className(), ['twork_id' => 'twork_id'])->viaTable('swork_twork', ['swork_id' => 'swork_id']);
    }
}
