<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Holidays;

/**
 * HolidaysSearch represents the model behind the search form about `common\models\Holidays`.
 */
class HolidaysSearch extends Holidays
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country', 'status', 'CB', 'UB'], 'integer'],
            [['holiday_name', 'date', 'description', 'DOC', 'DOU'], 'safe'],
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
        $query = Holidays::find();

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
            'date' => $this->date,
            'country' => $this->country,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'holiday_name', $this->holiday_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
