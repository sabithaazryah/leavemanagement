<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeaveCategory;

/**
 * LeaveCategorySearch represents the model behind the search form about `common\models\LeaveCategory`.
 */
class LeaveCategorySearch extends LeaveCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'no_of_days', 'include_docs', 'status', 'CB', 'UB'], 'integer'],
            [['leave_code', 'leave_name', 'DOC', 'DOU'], 'safe'],
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
        $query = LeaveCategory::find();

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
            'no_of_days' => $this->no_of_days,
            'include_docs' => $this->include_docs,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'leave_code', $this->leave_code])
            ->andFilterWhere(['like', 'leave_name', $this->leave_name]);

        return $dataProvider;
    }
}
