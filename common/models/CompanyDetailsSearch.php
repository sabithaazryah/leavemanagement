<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CompanyDetails;

/**
 * CompanyDetailsSearch represents the model behind the search form about `common\models\CompanyDetails`.
 */
class CompanyDetailsSearch extends CompanyDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_register_no', 'gst_register_no', 'status', 'CB', 'UB'], 'integer'],
            [['company_code', 'company_name', 'company_established', 'company_type', 'no_of_employees', 'salary_day', 'logo', 'contact_no', 'email_id', 'website', 'fax_no', 'building_name', 'street_name', 'city', 'state', 'country', 'pin_code', 'about_company', 'DOC', 'DOU'], 'safe'],
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
        $query = CompanyDetails::find();

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
            'company_established' => $this->company_established,
            'company_register_no' => $this->company_register_no,
            'gst_register_no' => $this->gst_register_no,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'company_code', $this->company_code])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_type', $this->company_type])
            ->andFilterWhere(['like', 'no_of_employees', $this->no_of_employees])
            ->andFilterWhere(['like', 'salary_day', $this->salary_day])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no])
            ->andFilterWhere(['like', 'email_id', $this->email_id])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'fax_no', $this->fax_no])
            ->andFilterWhere(['like', 'building_name', $this->building_name])
            ->andFilterWhere(['like', 'street_name', $this->street_name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'pin_code', $this->pin_code])
            ->andFilterWhere(['like', 'about_company', $this->about_company]);

        return $dataProvider;
    }
}
