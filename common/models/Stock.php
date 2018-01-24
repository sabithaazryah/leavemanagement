<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property int $item_id
 * @property string $item_name
 * @property string $item_code
 * @property string $price
 * @property int $uom
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
 * @property int $cartons
 * @property string $total_weight
 * @property int $pieces
 * @property string $stock
 * @property string $available_stock
 * @property string $closing_stock
 * @property string $remarks
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Stock extends \yii\db\ActiveRecord {

        /**
         * @inheritdoc
         */
        public static function tableName() {
                return 'stock';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['item_id', 'location', 'supplier', 'origin', 'cartons', 'pieces', 'status', 'CB', 'UB'], 'integer'],
                        [['price', 'cost', 'total_weight', 'stock', 'available_stock', 'closing_stock'], 'number'],
                        [['slaughter_date_from', 'slaughter_date_to', 'production_date', 'due_date', 'DOC', 'DOU'], 'safe'],
                        [['remarks'], 'string'],
                        [['item_name', 'item_code', 'uom',], 'string', 'max' => 30],
                        [['batch_no', 'plant', 'warehouse'], 'string', 'max' => 100],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'item_id' => 'Item Name',
                    'item_name' => 'Item Name',
                    'item_code' => 'Item Code',
                    'price' => 'Price',
                    'uom' => 'UOM',
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
                    'stock' => 'Stock',
                    'available_stock' => 'Available Stock',
                    'closing_stock' => 'Closing Stock',
                    'remarks' => 'Remarks',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
