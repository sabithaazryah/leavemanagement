<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BusinessPartner;

/**
 * BusinessPartnerSearch represents the model behind the search form about `common\models\BusinessPartner`.
 */
class BusinessPartnerSearch extends BusinessPartner {

    /**
     * @var string
     */
    public $createdFrom;

    /**
     * @var string
     */
    public $createdTo;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'type', 'location', 'status', 'CB', 'UB'], 'integer'],
            [['name', 'company_name', 'billing_address', 'shipping_address', 'phone_no', 'fax_no', 'email', 'DOC', 'DOU'], 'safe'],
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
        $query = BusinessPartner::find();

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
            'type' => $this->type,
            'location' => $this->location,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'company_name', $this->company_name])
                ->andFilterWhere(['like', 'billing_address', $this->billing_address])
                ->andFilterWhere(['like', 'shipping_address', $this->shipping_address])
                ->andFilterWhere(['like', 'phone_no', $this->phone_no])
                ->andFilterWhere(['like', 'fax_no', $this->fax_no])
                ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }

}
