<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockView;

/**
 * StockViewSearch represents the model behind the search form about `common\models\StockView`.
 */
class StockViewSearch extends StockView
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'status', 'CB', 'UB'], 'integer'],
            [['item_code', 'item_name', 'location_code', 'due_date', 'error_msg', 'DOC', 'DOU'], 'safe'],
            [['mrp', 'retail_price', 'ws_price', 'available_carton', 'available_weight', 'available_pieces', 'average_cost'], 'number'],
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
        $query = StockView::find();

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
            'item_id' => $this->item_id,
            'mrp' => $this->mrp,
            'retail_price' => $this->retail_price,
            'ws_price' => $this->ws_price,
            'available_carton' => $this->available_carton,
            'available_weight' => $this->available_weight,
            'available_pieces' => $this->available_pieces,
            'average_cost' => $this->average_cost,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'location_code', $this->location_code])
            ->andFilterWhere(['like', 'error_msg', $this->error_msg]);

        return $dataProvider;
    }
}
