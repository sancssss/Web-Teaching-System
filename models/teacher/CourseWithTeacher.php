<?php

namespace app\models\teacher;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Course;

/**
 * This is the model class for table "teacher_course".
 *
 * 
 */
class CourseWithTeacher extends Course
{
   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'teacherCourseLink' => '课程名',
            'courseUserCountLink' => '选课人数',
            'courseWorksLink' => '作业详情',
            'courseWaitingLink' => '未审核',
            'courseFilesLink' => '课件',
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
    
     /**
     * 得到每一个教师课程的详情链接
     * @return Html
     */
    public function getTeacherCourseLink()
    {
        $url = Url::to(['/teacher-course/course', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a($this->course_name, $url, $options);
    }
    
    /**
     * 得到每一个课程选课用户列表的链接
     * @return Html
     */    
    public function getCourseUserCountLink()
    {
        $url = Url::to(['/teacher-course/course-user', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a($this->getCourseUserCount(), $url, $options);
    }
    
    /**
     * 得到每一个课程的作业列表链接
     * @return Html
     */
    public function getCourseWorksLink()
    {
        $url = Url::to(['/teacher-work/index', 'cid' => $this->course_id]);
        $options =  [];
        return Html::a($this->getTeacherWorks()->where(['course_id' => $this->course_id])->count().'次', $url, $options);
    }
    
    /**
     * 得到每门课程的选课批准链接
     * @return Html
     */
    public function getCourseWaitingLink()
    {
        $url = Url::to(['/teacher-course/waiting-list', 'cid' => $this->course_id]);
        $option = [];
        if($this->getCourseWaitingCount() == 0){
            return '无';
        }
        return Html::a($this->getCourseWaitingCount(), $url, $option);
    }
    
    /**
     * 得到当前课程选课已经确认了的人数
     * @return integer
     */
    public function getCourseUserCount()
    {
        return $this->getStudentCourses()->where(['course_id' => $this->course_id, 'verified' => 1])->count();
    }
    
    /**
     * 返回选课申请未确认的人数
     * @return integer 
     */
    public function getCourseWaitingCount()
    {
        return $this->getStudentCourses()->where(['course_id' => $this->course_id, 'verified' => 0])->count();
    }
    
    /**
     * 得到当前课程的文件列表链接
     * @return Html
     */
    public function getCourseFilesLink()
    {
        $url = Url::to(['/teacher-course/course-files', 'cid' => $this->course_id]);
        $option = [];
        return Html::a('查看课件', $url, $option);
    }
    
}
