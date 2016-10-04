<?php

namespace app\models;
use yii\helpers\Url;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "teacher_work".
 *
 * @property integer $twork_id
 * @property string $twork_title
 * @property string $twork_content
 * @property string $twork_date
 * @property string $twork_update
 * @property integer $user_number
 *
 * @property SworkTwork[] $sworkTworks
 * @property StudentWork[] $sworks
 * @property User $userNumber
 */
class TeacherWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['twork_title', 'twork_content', 'twork_date', 'user_number'], 'required'],
            [['twork_content'], 'string'],
            [['twork_title'], 'string', 'max' => 255],
            [['user_number'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_number' => 'user_number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'twork_id' => '作业ID',
            'twork_title' => '作业题目',
            'twork_content' => '作业要求',
            'twork_date' => ' 发布时间',
            'user_update' => '更新时间',
            'user_number' => '发布者ID',
            'usersLink' => '提交数量'
        ];
    }
    
    /**
     * 得到每个作业的提交学生列表的链接
     * 
     * @return Html $link
     * 
     */
    public function getUsersLink()
    {
        $url = Url::to(['/teacher-work/submit-users', 'id' => $this->twork_id]);
        $options = [];
        return Html::a($this->getSubmitCount(), $url, $options);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSworkTworks()
    {
        return $this->hasMany(SworkTwork::className(), ['twork_id' => 'twork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSworks()
    {
        return $this->hasMany(StudentWork::className(), ['swork_id' => 'swork_id'])->viaTable('swork_twork', ['twork_id' => 'twork_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserNumber()
    {
        return $this->hasOne(User::className(), ['user_number' => 'user_number']);
    }
    
    /**
     * @return integer 每个作业对应的提交学生数量
     */
    public function getSubmitCount()
    {
        return $this->getSworkTworks()->count();
    }
}
