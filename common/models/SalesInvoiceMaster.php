<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sales_invoice_master".
 *
 * @property int $id
 * @property string $sales_invoice_number
 * @property string $sales_invoice_date
 * @property int $order_type
 * @property int $busines_partner_code
 * @property int $salesman
 * @property string $payment_terms
 * @property string $delivery_terms
 * @property string $general_terms
 * @property string $amount
 * @property string $tax_amount
 * @property string $order_amount
 * @property string $ship_to_adress
 * @property string $delivery_address
 * @property string $contact_number
 * @property int $terms
 * @property string $po_no
 * @property string $po_date
 * @property string $email
 * @property string $discount_amount
 * @property string $cash_amount
 * @property string $card_amount
 * @property string $round_of_amount
 * @property string $amount_payed
 * @property string $due_amount
 * @property string $due_date
 * @property int $payment_status
 * @property string $reference
 * @property int $receipt_id
 * @property string $receipt_no
 * @property string $goods_total
 * @property string $service_total
 * @property string $error_message
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class SalesInvoiceMaster extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'sales_invoice_master';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sales_invoice_number', 'ship_to_adress', 'delivery_address', 'busines_partner_code', 'contact_number', 'email'], 'required'],
            [['sales_invoice_date', 'po_date', 'due_date', 'DOC', 'DOU'], 'safe'],
            [['order_type', 'busines_partner_code', 'salesman', 'terms', 'payment_status', 'receipt_id', 'status', 'CB', 'UB'], 'integer'],
            [['general_terms', 'delivery_address'], 'string'],
            [['amount', 'tax_amount', 'order_amount', 'discount_amount', 'cash_amount', 'card_amount', 'round_of_amount', 'amount_payed', 'due_amount', 'goods_total', 'service_total'], 'number'],
            [['sales_invoice_number', 'ship_to_adress', 'reference', 'error_message'], 'string', 'max' => 50],
            [['payment_terms', 'delivery_terms', 'contact_number'], 'string', 'max' => 30],
            [['po_no', 'email', 'receipt_no'], 'string', 'max' => 100],
            [['sales_invoice_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sales_invoice_number' => 'Sales Invoice Number',
            'sales_invoice_date' => 'Sales Invoice Date',
            'order_type' => 'Order Type',
            'busines_partner_code' => 'Customer',
            'salesman' => 'Salesman',
            'payment_terms' => 'Payment Terms',
            'delivery_terms' => 'Delivery Terms',
            'general_terms' => 'General Terms',
            'amount' => 'Amount',
            'tax_amount' => 'Tax Amount',
            'order_amount' => 'Order Amount',
            'ship_to_adress' => 'Ship To Adress',
            'delivery_address' => 'Delivery Address',
            'contact_number' => 'Contact Number',
            'terms' => 'Terms',
            'po_no' => 'Po No',
            'po_date' => 'Po Date',
            'email' => 'Email',
            'discount_amount' => 'Discount Amount',
            'cash_amount' => 'Cash Amount',
            'card_amount' => 'Card Amount',
            'round_of_amount' => 'Round Of Amount',
            'amount_payed' => 'Amount Payed',
            'due_amount' => 'Due Amount',
            'due_date' => 'Due Date',
            'payment_status' => 'Payment Status',
            'reference' => 'Reference',
            'receipt_id' => 'Receipt ID',
            'receipt_no' => 'Receipt No',
            'goods_total' => 'Goods Total',
            'service_total' => 'Service Total',
            'error_message' => 'Error Message',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
