<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Designation;

/**
 * DesignationSearch represents the model behind the search form about `common\models\Designation`.
 */
class DesignationSearch extends Designation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'designation_rank', 'status', 'CB', 'UB'], 'integer'],
            [['designation_code', 'designation_name', 'DOC', 'DOU'], 'safe'],
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
        $query = Designation::find();

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
            'designation_rank' => $this->designation_rank,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'designation_code', $this->designation_code])
            ->andFilterWhere(['like', 'designation_name', $this->designation_name]);

        return $dataProvider;
    }
}
