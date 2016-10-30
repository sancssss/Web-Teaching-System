<?php

namespace app\models\student;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Course;
use app\models\StudentCourse;

/**
 * This is the model class for table "teacher_course".
 *
 * 
 */
class CourseWithStudent extends Course
{
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'studentCourseLink' => '课程名',
            'courseStatusLink'=> '选课状态',
            'teacherNumber.user_name' => '授课教师',
            'registerLink' => '操作',
            'courseWorkLink' => '作业',
            'courseFilesLink' => '课程课件',
            'noticeLink' => '通知'
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
    /**
     * 得到每个课程的详情链接
     * @return Html 
     */
    public function getStudentCourseLink()
    {
        $url = Url::to(['/student-course/course', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a($this->course_name, $url, $options);
    }
    
    //TODO:待优化的结构：不应该在model出现session操作
    /**
     * 获取选课的情况依据情况生成不同说明
     * @return Html
     */
    public function getCourseStatusLink()
    {
        $url = Url::to(['/student-course/cancel-course', 'cid' => $this->course_id]);
        $options = [];
        if(StudentCourse::find()->where(['course_id' => $this->course_id, 'student_number' => Yii::$app->user->getId()])->one()->verified == 1)
        {
            return '已审核';
        }else{
             return '未审核 | '.Html::a('取消申请', $url, $options);
        }
        
    }
    
    /**
     * 作业查看链接
     * @return Html
     */
    public function getCourseWorkLink()
    {
        $url = Url::to(['/student-work/index', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a('查看', $url, $options);
    }


    /**
     * 选课申请链接：显示确认或取消
     */
    public function getRegisterLink()
    {
        $url = Url::to(['/student-course/register-course', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a('申请课程', $url, $options);
    }
    
    /**
     * 得到当前课程的文件列表链接
     * @return Html
     */
    public function getCourseFilesLink()
    {
        $url = Url::to(['/student-course/course-files', 'cid' => $this->course_id]);
        $option = [];
        return Html::a('查看课件', $url, $option);
    }
    
    /**
     * 得到通知查看链接
     * @return Html
     */
    public function getNoticeLink()
    {
        $url = Url::to(['/student-course/course-notices', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a('查看', $url, $options);
    }
    
}
