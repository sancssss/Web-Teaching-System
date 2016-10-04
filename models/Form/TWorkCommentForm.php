<?php

namespace app\models\Form;

use yii\base\Model;

/**
 *TWorkCommentForm 教师批改作业的表单
 *
 */
class TWorkCommentForm extends Model
{
    public $grade;
    public $comment;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['grade', 'comment'], 'required'],
            [['grade'], 'number', 'min' => 0.0, 'max' => 100],
            [['comment'], 'string', 'min' => 0, 'max' => 10000], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grade' => '成绩',
            'comment' => '评语',
        ];
    }
    
}
