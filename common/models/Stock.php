<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property int $type 1=Opening Stock,2=Stock Adjustment
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
 * @property string $pieces
 * @property string $stock
 * @property string $available_stock
 * @property string $closing_stock
 * @property string $adjust_cartons
 * @property string $adjust_weight
 * @property string $adjust_pieces
 * @property int $stock_type
 * @property int $stock_view_id
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
                        [['type', 'item_id', 'location', 'supplier', 'origin', 'stock_type', 'stock_view_id', 'status', 'CB', 'UB'], 'integer'],
                        [['price', 'cost', 'cartons', 'total_weight', 'pieces', 'stock', 'available_stock', 'closing_stock', 'adjust_cartons', 'adjust_weight', 'adjust_pieces'], 'number'],
                        [['slaughter_date_from', 'slaughter_date_to', 'production_date', 'due_date', 'DOC', 'DOU'], 'safe'],
                        [['remarks'], 'string'],
                        [['item_name', 'item_code'], 'string', 'max' => 30],
                        [['uom'], 'string', 'max' => 50],
                        [['batch_no', 'plant', 'warehouse'], 'string', 'max' => 100],
                        [['batch_no', 'item_id'], 'required'],
                        [['batch_no'], 'unique', 'on' => 'create',],
                        [['total_weight', 'cartons', 'pieces'], 'required', 'when' => function ($model) {

                        }, 'whenClient' => "function (attribute, value) {
               return $('#stock-item-type').val() == '1';
            }"],
                        [['pieces'], 'required', 'when' => function ($model) {

                        }, 'whenClient' => "function (attribute, value) {
               return $('#stock-item-type').val() == '2';
            }"],
                        [['batch_no'], 'unique', 'on' => 'update', 'when' => function($model) {
                                return static::getOldUsername($model->id) !== $model->batch_no;
                        }
                    ],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'type' => 'Type',
                    'item_id' => 'Item Name',
                    'item_name' => 'Item Name',
                    'item_code' => 'Item Code',
                    'price' => 'Price',
                    'uom' => 'Uom',
                    'batch_no' => 'Batch No',
                    'slaughter_date_from' => 'Slaughter Date From',
                    'slaughter_date_to' => 'Slaughter Date To',
                    'production_date' => 'Production Date',
                    'due_date' => 'Due Date (Expiry Date)',
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
                    'adjust_cartons' => 'Adjust Cartons',
                    'adjust_weight' => 'Adjust Weight',
                    'adjust_pieces' => 'Adjust Pieces',
                    'stock_type' => 'Stock Type',
                    'stock_view_id' => 'Stock View ID',
                    'remarks' => 'Remarks',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

        public static function getOldUsername($id) {

                return Stock::findOne($id)->batch_no;
        }

        public static function findIdentity($id) {

                return static::findOne(['id' => $id, 'status' => 1]);
        }

}
