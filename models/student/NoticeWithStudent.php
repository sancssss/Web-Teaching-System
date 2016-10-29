<?php

namespace app\models\student;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\CourseNoticeBroadcast;

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
           'noticeLink' => '标题',
            'noticeStatus' => '状态'
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
    
        /**
     * 根据读取状态返回字符串
     */
    public function getNoticeStatus()
    {
        return CourseNoticeBroadcast::find()->where(['notice_id' => $this->notice_id])->one()->is_read == 1 ? '已读' : '未读';
    }
}
