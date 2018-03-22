<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeaveConfiguration;

/**
 * LeaveConfigurationSearch represents the model behind the search form about `common\models\LeaveConfiguration`.
 */
class LeaveConfigurationSearch extends LeaveConfiguration {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id', 'employee_id', 'leave_type', 'entitlement', 'carry_forward', 'adjustments', 'adjustments_type', 'no_of_days', 'status', 'CB', 'UB'], 'integer'],
			[['DOC', 'DOU', 'available_days', 'year'], 'safe'],
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
		$query = LeaveConfiguration::find()->orderBy(['id' => SORT_DESC]);

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
		    'employee_id' => $this->employee_id,
		    'leave_type' => $this->leave_type,
		    'entitlement' => $this->entitlement,
		    'carry_forward' => $this->carry_forward,
		    'adjustments' => $this->adjustments,
		    'adjustments_type' => $this->adjustments_type,
		    'no_of_days' => $this->no_of_days,
		    'available_days' => $this->available_days,
		    'year' => $this->year,
		    'status' => $this->status,
		    'CB' => $this->CB,
		    'UB' => $this->UB,
		    'DOC' => $this->DOC,
		    'DOU' => $this->DOU,
		]);

		return $dataProvider;
	}

}
