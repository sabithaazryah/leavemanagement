<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockAdjustment;

/**
 * StockAdjustmentSearch represents the model behind the search form about `common\models\StockAdjustment`.
 */
class StockAdjustmentSearch extends StockAdjustment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'location', 'supplier', 'origin', 'cartons', 'pieces', 'stock_view_id', 'status', 'CB', 'UB'], 'integer'],
            [['item_name', 'item_code', 'uom', 'batch_no', 'slaughter_date_from', 'slaughter_date_to', 'production_date', 'due_date', 'plant', 'warehouse', 'remarks', 'DOC', 'DOU'], 'safe'],
            [['price', 'cost', 'total_weight', 'adjust_cartons', 'adjust_weight', 'adjust_pieces'], 'number'],
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
        $query = StockAdjustment::find();

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
            'price' => $this->price,
            'slaughter_date_from' => $this->slaughter_date_from,
            'slaughter_date_to' => $this->slaughter_date_to,
            'production_date' => $this->production_date,
            'due_date' => $this->due_date,
            'location' => $this->location,
            'supplier' => $this->supplier,
            'origin' => $this->origin,
            'cost' => $this->cost,
            'cartons' => $this->cartons,
            'total_weight' => $this->total_weight,
            'pieces' => $this->pieces,
            'adjust_cartons' => $this->adjust_cartons,
            'adjust_weight' => $this->adjust_weight,
            'adjust_pieces' => $this->adjust_pieces,
            'stock_view_id' => $this->stock_view_id,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name])
            ->andFilterWhere(['like', 'item_code', $this->item_code])
            ->andFilterWhere(['like', 'uom', $this->uom])
            ->andFilterWhere(['like', 'batch_no', $this->batch_no])
            ->andFilterWhere(['like', 'plant', $this->plant])
            ->andFilterWhere(['like', 'warehouse', $this->warehouse])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
