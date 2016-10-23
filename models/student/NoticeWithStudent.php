<?php

namespace app\models\student;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * This is the model class for table "course_notice".
 */
class NoticeWithStudent extends \app\models\CourseNotice
{
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
           'noticeLink' => '标题'
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
    
    /**
     * 返回通知详情链接
     * @return Html
     */
    public function getNoticeLink(){
        $url = Url::to(['/student-course/notice', 'id' => $this->notice_id]);
        $option = [];
        return Html::a($this->notice_title, $url, $option);
    }
}
