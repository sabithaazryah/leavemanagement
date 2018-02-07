<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminPost;

/**
 * AdminPostSearch represents the model behind the search form about `common\models\AdminPost`.
 */
class AdminPostSearch extends AdminPost {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'admin', 'masters', 'status', 'CB', 'UB'], 'integer'],
            [['post_name', 'DOC', 'DOU', 'daily_entry', 'appointement', 'stock', 'reports', 'sales_invoice', 'stock_adjustment', 'opening_stock'], 'safe'],
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
        $query = AdminPost::find();

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
            'admin' => $this->admin,
            'masters' => $this->masters,
            'daily_entry' => $this->daily_entry,
            'appointement' => $this->appointement,
            'sales_invoice' => $this->sales_invoice,
            'stock_adjustment' => $this->stock_adjustment,
            'opening_stock' => $this->opening_stock,
            'stock' => $this->stock,
            'reports' => $this->reports,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'post_name', $this->post_name]);

        return $dataProvider;
    }

}
