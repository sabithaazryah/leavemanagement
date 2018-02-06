<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $invoice_type '1'=>'Sales'
 * @property int $invoice_id
 * @property string $invoice_number
 * @property string $amount
 * @property string $payment_date
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_type', 'invoice_id', 'status', 'CB', 'UB'], 'integer'],
            [['amount'], 'number'],
            [['payment_date', 'DOC', 'DOU'], 'safe'],
            [['invoice_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_type' => 'Invoice Type',
            'invoice_id' => 'Invoice ID',
            'invoice_number' => 'Invoice Number',
            'amount' => 'Amount',
            'payment_date' => 'Payment Date',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
