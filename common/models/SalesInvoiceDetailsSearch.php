<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SalesInvoiceDetails;

/**
 * SalesInvoiceDetailsSearch represents the model behind the search form about `common\models\SalesInvoiceDetails`.
 */
class SalesInvoiceDetailsSearch extends SalesInvoiceDetails {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'sales_invoice_master_id', 'base_unit', 'qty', 'tax_id', 'status', 'CB', 'UB', 'busines_partner_code', 'item_id'], 'integer'],
                [['sales_invoice_number', 'sales_invoice_date', 'item_code', 'item_name', 'discount_type', 'tax_percentage', 'reference', 'error_message', 'DOC', 'DOU', 'hsn'], 'safe'],
                [['rate', 'amount', 'discount_value', 'net_amount', 'tax_amount', 'line_total', 'discount_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = SalesInvoiceDetails::find();

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
            'sales_invoice_master_id' => $this->sales_invoice_master_id,
            'sales_invoice_date' => $this->sales_invoice_date,
            'base_unit' => $this->base_unit,
            'qty' => $this->qty,
            'rate' => $this->rate,
            'amount' => $this->amount,
            'discount_value' => $this->discount_value,
            'net_amount' => $this->net_amount,
            'tax_id' => $this->tax_id,
            'tax_amount' => $this->tax_amount,
            'line_total' => $this->line_total,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'sales_invoice_number', $this->sales_invoice_number])
                ->andFilterWhere(['like', 'busines_partner_code', $this->busines_partner_code])
                ->andFilterWhere(['like', 'item_code', $this->item_code])
                ->andFilterWhere(['like', 'item_name', $this->item_name])
                ->andFilterWhere(['like', 'discount_type', $this->discount_type])
                ->andFilterWhere(['like', 'tax_percentage', $this->tax_percentage])
                ->andFilterWhere(['like', 'reference', $this->reference])
                ->andFilterWhere(['like', 'error_message', $this->error_message]);

        return $dataProvider;
    }

}
