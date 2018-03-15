<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_details".
 *
 * @property int $id
 * @property string $company_code
 * @property string $company_name
 * @property string $company_established
 * @property string $company_type
 * @property int $company_register_no
 * @property int $gst_register_no
 * @property string $no_of_employees
 * @property string $salary_day
 * @property string $logo
 * @property string $contact_no
 * @property string $email_id
 * @property string $website
 * @property string $fax_no
 * @property string $building_name
 * @property string $street_name
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $pin_code
 * @property string $about_company
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class CompanyDetails extends \yii\db\ActiveRecord {

        /**
         * {@inheritdoc}
         */
        public static function tableName() {
                return 'company_details';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
                return [
                        [['company_established', 'DOC', 'DOU'], 'safe'],
                        [['company_register_no', 'gst_register_no', 'status', 'CB', 'UB'], 'integer'],
                        [['about_company'], 'string'],
                        [['company_code', 'company_name', 'company_type', 'no_of_employees', 'salary_day', 'logo', 'email_id', 'website', 'fax_no', 'building_name', 'street_name', 'city', 'state', 'country', 'pin_code'], 'string', 'max' => 200],
                        [['email_id'], 'email'],
                        [['contact_no'], 'number'],
                ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'company_code' => 'Company Code',
                    'company_name' => 'Company Name',
                    'company_established' => 'Company Established',
                    'company_type' => 'Company Type',
                    'company_register_no' => 'Company Register No.',
                    'gst_register_no' => 'GST Register No.',
                    'no_of_employees' => 'Number Of Employees',
                    'salary_day' => 'Salary Day',
                    'logo' => 'Logo',
                    'contact_no' => 'Contact No.',
                    'email_id' => 'Email ID',
                    'website' => 'Website',
                    'fax_no' => 'Fax No.',
                    'building_name' => 'Building Name/No.',
                    'street_name' => 'Street Name',
                    'city' => 'City',
                    'state' => 'State',
                    'country' => 'Country',
                    'pin_code' => 'Pin Code',
                    'about_company' => 'About the Company',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
