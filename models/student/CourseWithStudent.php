<?php

namespace app\models\student;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Course;

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
            'courseStatusLink'=> '选课状态'
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
    
    /**
     * 获取选课的情况依据情况生成不同说明
     * @return Html
     */
    public function getCourseStatusLink()
    {
        //$url = Url::to(['/student-course/course', 'cid' => $this->course_id]);
        //$options = [];
        if($this->studentCourses->verified == 1)
        {
            return '已审核';
        }else{
             return '未审核';
        }
        
    }
    
}
