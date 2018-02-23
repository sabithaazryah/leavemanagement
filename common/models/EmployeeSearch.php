<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employee;

/**
 * EmployeeSearch represents the model behind the search form about `common\models\Employee`.
 */
class EmployeeSearch extends Employee {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'post_id', 'branch', 'department', 'designation', 'recommender', 'approver', 'working_hours', 'status', 'CB', 'UB'], 'integer'],
            [['employee_code', 'full_name', 'date_of_birth', 'hired_date', 'job_grade', 'user_name', 'password', 'name', 'email', 'phone', 'photo', 'address', 'DOC', 'DOU'], 'safe'],
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
        $query = Employee::find();

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
            'post_id' => $this->post_id,
            'date_of_birth' => $this->date_of_birth,
            'branch' => $this->branch,
            'department' => $this->department,
            'designation' => $this->designation,
            'hired_date' => $this->hired_date,
            'recommender' => $this->recommender,
            'approver' => $this->approver,
            'working_hours' => $this->working_hours,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'employee_code', $this->employee_code])
                ->andFilterWhere(['like', 'full_name', $this->full_name])
                ->andFilterWhere(['like', 'job_grade', $this->job_grade])
                ->andFilterWhere(['like', 'user_name', $this->user_name])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'photo', $this->photo])
                ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }

}
