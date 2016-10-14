<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\student\CourseWithStudent;

/**
 * StudentCourseTempSearch represents the model behind the search form about `app\models\Course`.
 */
class StudentCourseSearch extends CourseWithStudent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'teacher_number'], 'integer'],
            [['course_name', 'teacherNumber.user_name'], 'safe'],
        ];
    }
    
    public function attributes()
    {
        // 添加关联字段到可搜索属性集合
        return array_merge(parent::attributes(), ['teacherNumber.user_name']);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $notIn =  new StudentCourse();
        $notIn->student_number = Yii::$app->user->getId();
        $query = CourseWithStudent::find()->where(['not in', 'course_id',  StudentCourse::find()->where(['student_number' => Yii::$app->user->getId()])->all()]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->innerJoinWith('teacherNumber'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'course_id' => $this->course_id,
        ]);

        $query->andFilterWhere(['like', 'course_name', $this->course_name])
            ->andFilterWhere(['like', 'course_content', $this->course_content])
            ->andFilterWhere(['like', 'user.user_name', $this->getAttribute('teacherNumber.user_name')]);

        return $dataProvider;
    }
    
    
}
