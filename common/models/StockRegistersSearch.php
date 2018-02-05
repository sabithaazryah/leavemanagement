<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockRegister;

/**
 * StockRegistersSearch represents the model behind the search form of `common\models\StockRegister`.
 */
class StockRegistersSearch extends StockRegister {

    /**
     * @var string
     */
    public $createdFrom;

    /**
     * @var string
     */
    public $createdTo;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'transaction', 'document_line_id', 'item_id', 'balance_qty', 'status', 'CB', 'UB'], 'integer'],
            [['document_no', 'document_date', 'item_code', 'item_name', 'batch_no', 'location_code', 'DOC', 'DOU'], 'safe'],
            [['item_cost', 'cartoon_in', 'cartoon_out', 'weight_in', 'weight_out', 'piece_in', 'piece_out', 'total_cost'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = StockRegister::find();

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
            'transaction' => $this->transaction,
            'document_line_id' => $this->document_line_id,
            'document_date' => $this->document_date,
            'item_id' => $this->item_id,
            'item_cost' => $this->item_cost,
            'cartoon_in' => $this->cartoon_in,
            'cartoon_out' => $this->cartoon_out,
            'balance_qty' => $this->balance_qty,
            'weight_in' => $this->weight_in,
            'weight_out' => $this->weight_out,
            'piece_in' => $this->piece_in,
            'piece_out' => $this->piece_out,
            'total_cost' => $this->total_cost,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'document_no', $this->document_no])
                ->andFilterWhere(['like', 'item_code', $this->item_code])
                ->andFilterWhere(['like', 'item_name', $this->item_name])
                ->andFilterWhere(['like', 'batch_no', $this->batch_no])
                ->andFilterWhere(['like', 'location_code', $this->location_code]);

        return $dataProvider;
    }

}
