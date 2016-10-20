<?php

namespace app\models\Form;

use yii\base\Model;

/**
 *TWorkCommentForm 教师批改作业的表单
 *
 */
class NoticeForm extends Model
{
    public $notice_title;
    public $notice_content;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['notice_title', 'notice_content'], 'required'],
            [['notice_title'], 'string', 'min' => 0, 'max' => 255],
            [['notice_content'], 'string', 'min' => 0, 'max' => 5000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_title' => '标题',
            'notice_content' => '内容',
        ];
    }
    
}
