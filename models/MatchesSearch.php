<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Matches;

/**
 * MatchesSearch represents the model behind the search form about `app\models\Matches`.
 */
class MatchesSearch extends Matches
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'home_team_id', 'guest_team_id', 'home_team_result', 'guest_team_result', 'won_team_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
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
        $query = Matches::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'home_team_id' => $this->home_team_id,
            'guest_team_id' => $this->guest_team_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'home_team_result' => $this->home_team_result,
            'guest_team_result' => $this->guest_team_result,
            'won_team_id' => $this->won_team_id,
        ]);

        return $dataProvider;
    }
}
