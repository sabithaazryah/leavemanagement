<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "business_partner".
 *
 * @property int $id
 * @property int $type 1=>Customer,2=>Supplier
 * @property string $name
 * @property string $company_name
 * @property int $location
 * @property string $billing_address
 * @property string $shipping_address
 * @property string $phone_no
 * @property string $fax_no
 * @property string $email
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class BusinessPartner extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'business_partner';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['location', 'name', 'fax_no', 'email', 'company_name', 'phone_no'], 'required'],
            [['type', 'location', 'status', 'CB', 'UB'], 'integer'],
            [['billing_address', 'shipping_address'], 'string'],
            [['DOC', 'DOU'], 'safe'],
            [['name', 'fax_no', 'email'], 'string', 'max' => 100],
            [['company_name'], 'string', 'max' => 250],
            [['phone_no'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'company_name' => 'Company Name',
            'location' => 'Location',
            'billing_address' => 'Billing Address',
            'shipping_address' => 'Shipping Address',
            'phone_no' => 'Phone No',
            'fax_no' => 'Fax No',
            'email' => 'Email',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
