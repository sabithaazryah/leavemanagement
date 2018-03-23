<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeaveRequest;

/**
 * LeaveRequestSearch represents the model behind the search form about `common\models\LeaveRequest`.
 */
class LeaveRequestSearch extends LeaveRequest {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'employee_id', 'leave_type', 'recommender', 'approver', 'status', 'CB', 'UB'], 'integer'],
                        [['reason', 'from_date', 'to_date', 'DOC', 'DOU', 'recommended_by'], 'safe'],
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
                $query = LeaveRequest::find();

                // add conditions that should always apply here

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC,
                        ]]
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
                    'employee_id' => $this->employee_id,
                    'recommended_by' => $this->recommended_by,
                    'leave_type' => $this->leave_type,
                    'from_date' => $this->from_date,
                    'to_date' => $this->to_date,
                    'recommender' => $this->recommender,
                    'approver' => $this->approver,
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'reason', $this->reason]);

                return $dataProvider;
        }

}
