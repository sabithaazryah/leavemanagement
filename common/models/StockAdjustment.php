<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_adjustment".
 *
 * @property int $id
 * @property int $item_id
 * @property string $item_name
 * @property string $item_code
 * @property string $price
 * @property string $uom
 * @property string $batch_no
 * @property string $slaughter_date_from
 * @property string $slaughter_date_to
 * @property string $production_date
 * @property string $due_date
 * @property string $plant
 * @property int $location
 * @property string $warehouse
 * @property int $supplier
 * @property int $origin
 * @property string $cost
 * @property string $cartons
 * @property string $total_weight
 * @property int $pieces
 * @property string $adjust_cartons
 * @property string $adjust_weight
 * @property string $adjust_pieces
 * @property string $stock_type
 * @property string $remarks
 * @property int $stock_view_id
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class StockAdjustment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_adjustment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'location', 'supplier', 'origin', 'pieces', 'stock_view_id', 'status', 'CB', 'UB'], 'integer'],
            [['price', 'cost', 'cartons', 'total_weight', 'adjust_cartons', 'adjust_weight', 'adjust_pieces'], 'number'],
            [['slaughter_date_from', 'slaughter_date_to', 'production_date', 'due_date', 'DOC', 'DOU'], 'safe'],
            [['remarks'], 'string'],
            [['item_name', 'item_code', 'stock_type'], 'string', 'max' => 30],
            [['uom'], 'string', 'max' => 50],
            [['batch_no', 'plant', 'warehouse'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'item_name' => 'Item Name',
            'item_code' => 'Item Code',
            'price' => 'Price',
            'uom' => 'Uom',
            'batch_no' => 'Batch No',
            'slaughter_date_from' => 'Slaughter Date From',
            'slaughter_date_to' => 'Slaughter Date To',
            'production_date' => 'Production Date',
            'due_date' => 'Due Date',
            'plant' => 'Plant',
            'location' => 'Location',
            'warehouse' => 'Warehouse',
            'supplier' => 'Supplier',
            'origin' => 'Origin',
            'cost' => 'Cost',
            'cartons' => 'Cartons',
            'total_weight' => 'Total Weight',
            'pieces' => 'Pieces',
            'adjust_cartons' => 'Adjust Cartons',
            'adjust_weight' => 'Adjust Weight',
            'adjust_pieces' => 'Adjust Pieces',
            'stock_type' => 'Stock Type',
            'remarks' => 'Remarks',
            'stock_view_id' => 'Stock View ID',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
