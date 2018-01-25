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
            [['sales_invoice_master_id', 'base_unit', 'qty', 'tax_id', 'status', 'CB', 'UB', 'busines_partner_code', 'item_id', 'discount_type', 'tax_type', 'type', 'inventory'], 'integer'],
            [['sales_invoice_date', 'DOC', 'DOU', 'hsn', 'CB', 'UB', 'comments'], 'safe'],
            [['rate', 'amount', 'discount_value', 'net_amount', 'tax_amount', 'line_total', 'discount_amount'], 'number'],
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
            'qty' => 'Qty',
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

    public static function getQtyTotal($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(qty) as sale_qty')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(qty) as return_qty')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_tot = $result[0]['sale_qty'] == '' ? 0 : $result[0]['sale_qty'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_tot = $result_return[0]['return_qty'] == '' ? 0 : $result_return[0]['return_qty'];
        return $sale_tot - $return_tot;
    }

    public static function getQtyAverageRate($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(qty) as sale_qty,sum(amount) as sale_amount')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(qty) as return_qty,sum(amount) as return_amount')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_qty = $result[0]['sale_qty'] == '' ? 0 : $result[0]['sale_qty'];
        $sale_amount = $result[0]['sale_amount'] == '' ? 0 : $result[0]['sale_amount'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_qty = $result_return[0]['return_qty'] == '' ? 0 : $result_return[0]['return_qty'];
        $return_amount = $result_return[0]['return_amount'] == '' ? 0 : $result_return[0]['return_amount'];
        if (($sale_qty - $return_qty) != 0) {
            return sprintf('%0.2f', ($sale_amount - $return_amount) / ($sale_qty - $return_qty));
        } else {
            return sprintf('%0.2f', 0);
        }
    }

    public static function getAmountTotal($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(amount) as sale_amount')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(amount) as return_amount')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_amount = $result[0]['sale_amount'] == '' ? 0 : $result[0]['sale_amount'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_amount = $result_return[0]['return_amount'] == '' ? 0 : $result_return[0]['return_amount'];
        return sprintf('%0.2f', ($sale_amount - $return_amount));
    }

    public static function getDiscountTotal($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(discount_amount) as sale_discount')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(discount_amount) as return_discount')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_discount = $result[0]['sale_discount'] == '' ? 0 : $result[0]['sale_discount'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_discount = $result_return[0]['return_discount'] == '' ? 0 : $result_return[0]['return_discount'];
        return sprintf('%0.2f', ($sale_discount - $return_discount));
    }

    public static function getNetTotal($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(net_amount) as sale_net_amount')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(net_amount) as return_net_amount')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_net_amount = $result[0]['sale_net_amount'] == '' ? 0 : $result[0]['sale_net_amount'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_net_amount = $result_return[0]['return_net_amount'] == '' ? 0 : $result_return[0]['return_net_amount'];
        return sprintf('%0.2f', ($sale_net_amount - $return_net_amount));
    }

    public static function getTaxTotal($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(tax_amount) as sale_tax_amount')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(tax_amount) as return_tax_amount')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_tax_amount = $result[0]['sale_tax_amount'] == '' ? 0 : $result[0]['sale_tax_amount'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_tax_amount = $result_return[0]['return_tax_amount'] == '' ? 0 : $result_return[0]['return_tax_amount'];
        return sprintf('%0.2f', ($sale_tax_amount - $return_tax_amount));
    }

    public static function getSaleTotal($item_id, $from, $to, $salesman) {
        if ($from != '') {
            $from = $from . ' 00:00:00';
        }
        if ($to != '') {
            $to = $to . ' 60:60:60';
        }
        $query = new Query();
        $query_return = new Query();
        $query->select('sum(line_total) as sale_line_total')
                ->from('sales_invoice_details')
                ->where(['item_id' => $item_id]);
        $query_return->select('sum(line_total) as return_line_total')
                ->from('sales_return_invoice_details')
                ->where(['item_id' => $item_id]);
        if ($from != '') {
            $query->andWhere(['>=', 'sales_invoice_date', $from]);
            $query_return->andWhere(['>=', 'sales_invoice_date', $from]);
        }
        if ($to != '') {
            $query->andWhere(['<=', 'sales_invoice_date', $to]);
            $query_return->andWhere(['<=', 'sales_invoice_date', $to]);
        }
        if ($salesman != '') {
            $query->andWhere(['salesman' => $salesman]);
            $query_return->andWhere(['salesman' => $salesman]);
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $sale_line_total = $result[0]['sale_line_total'] == '' ? 0 : $result[0]['sale_line_total'];
        $command_return = $query_return->createCommand();
        $result_return = $command_return->queryAll();
        $return_line_total = $result_return[0]['return_line_total'] == '' ? 0 : $result_return[0]['return_line_total'];
        return sprintf('%0.2f', ($sale_line_total - $return_line_total));
    }

}
