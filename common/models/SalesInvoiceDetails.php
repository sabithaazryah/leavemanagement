<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "sales_invoice_details".
 *
 * @property integer $id
 * @property integer $sales_invoice_master_id
 * @property string $sales_invoice_number
 * @property string $sales_invoice_date
 * @property string $busines_partner_code
 * @property string $item_code
 * @property string $item_name
 * @property integer $base_unit
 * @property integer $qty
 * @property string $rate
 * @property string $amount
 * @property string $discount_percentage
 * @property string $discount_amount
 * @property string $net_amount
 * @property integer $tax_id
 * @property string $tax_percentage
 * @property string $tax_amount
 * @property string $line_total
 * @property string $reference
 * @property string $error_message
 * @property integer $status
 * @property integer $CB
 * @property integer $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property SalesInvoiceMaster $salesInvoiceMaster
 */
class SalesInvoiceDetails extends \yii\db\ActiveRecord {

    public $qty_total;
    public $average_rate;
    public $amount_total;
    public $discount_total;
    public $net_total;
    public $tax_total;
    public $sale_total;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'sales_invoice_details';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sales_invoice_master_id'], 'required'],
            [['sales_invoice_master_id', 'base_unit', 'tax_id', 'status', 'CB', 'UB', 'busines_partner_code', 'item_id', 'discount_type', 'tax_type', 'type', 'inventory', 'carton'], 'integer'],
            [['sales_invoice_date', 'DOC', 'DOU', 'hsn', 'CB', 'UB', 'comments'], 'safe'],
            [['rate', 'amount', 'discount_value', 'net_amount', 'tax_amount', 'line_total', 'discount_amount', 'qty', 'pieces'], 'number'],
            [['sales_invoice_number', 'reference', 'error_message'], 'string', 'max' => 50],
            [['item_code', 'item_name', 'tax_percentage'], 'string', 'max' => 30],
            [['sales_invoice_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesInvoiceMaster::className(), 'targetAttribute' => ['sales_invoice_master_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sales_invoice_master_id' => 'Sales Invoice Master ID',
            'sales_invoice_number' => 'Sales Invoice Number',
            'sales_invoice_date' => 'Date',
            'busines_partner_code' => 'Customer',
            'item_id' => 'Item ID',
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'base_unit' => 'Base Unit',
            'comments' => 'Comments',
            'qty' => 'KG Sold',
            'carton' => 'Carton Sold',
            'pieces' => 'Pieces Sold',
            'rate' => 'Rate',
            'amount' => 'Amount',
            'discount_type' => 'Discount Type',
            'discount_value' => 'Discount Value',
            'discount_amount' => 'Discount Amount',
            'net_amount' => 'Net Amount',
            'tax_id' => 'Tax ID',
            'tax_percentage' => 'Tax Percentage',
            'tax_type' => 'Tax Type',
            'tax_amount' => 'Tax Amount',
            'line_total' => 'Line Total',
            'inventory' => 'Inventory',
            'reference' => 'Reference',
            'error_message' => 'Error Message',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesInvoiceMaster() {
        return $this->hasOne(SalesInvoiceMaster::className(), ['id' => 'sales_invoice_master_id']);
    }

    public static function getSaleTotal($from_date, $to, $id, $field_name) {
        if ($from_date != '') {
            $from = $from_date . ' 00:00:00';
        } else {
            $from = '';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        } else {
            $to = '';
        }
        $query = new Query();
        $query->select('sum(' . $field_name . ') as amt_tot')
                ->from('sales_invoice_details');
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($id != '') {
            $query->andWhere(['item_id' => $id]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $amt_tot = $result[0]['amt_tot'] == '' ? 0 : $result[0]['amt_tot'];
        return $amt_tot;
    }

    public static function getTotalCount($from_date, $to, $id) {
        if ($from_date != '') {
            $from = $from_date . ' 00:00:00';
        } else {
            $from = '';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        } else {
            $to = '';
        }
        $query = new Query();
        $query->select('*')
                ->from('sales_invoice_details');
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($id != '') {
            $query->andWhere(['item_id' => $id]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        return count($result);
    }

}
