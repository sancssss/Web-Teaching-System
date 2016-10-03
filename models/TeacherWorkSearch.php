<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TeacherWork;

/**
 * TeacherWorkSearch represents the model behind the search form about `app\models\TeacherWork`.
 */
class TeacherWorkSearch extends TeacherWork
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['twork_id', 'user_number'], 'integer'],
            [['twork_title', 'twork_content', 'twork_date'], 'safe'],
        ];
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
        $query = TeacherWork::find()->where(['user_number' => Yii::$app->user->getId()]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
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
            'twork_id' => $this->twork_id,
            'user_number' => $this->user_number,
        ]);

        $query->andFilterWhere(['like', 'twork_title', $this->twork_title])
            ->andFilterWhere(['like', 'twork_content', $this->twork_content])
            ->andFilterWhere(['like', 'twork_date', $this->twork_date]);

        return $dataProvider;
    }
}
