<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_register".
 *
 * @property int $id
 * @property int $transaction 0- Sales, 1 - Sales Return, 2 -Purchase, 3 -Purchase Return , 4 -Stock Addition, 5 - Stock Deduction, 6 -Opening Balance
 * @property int $document_line_id
 * @property string $document_no
 * @property string $document_date
 * @property int $item_id
 * @property string $item_code
 * @property string $item_name
 * @property string $batch_no
 * @property string $location_code
 * @property string $item_cost
 * @property string $cartoon_in
 * @property string $cartoon_out
 * @property int $balance_qty
 * @property string $weight_in
 * @property string $weight_out
 * @property string $piece_in
 * @property string $piece_out
 * @property string $total_cost
 * @property int $status 1-Active, 0-Inactive
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class StockRegister extends \yii\db\ActiveRecord {

        /**
         * @inheritdoc
         */
        public static function tableName() {
                return 'stock_register';
        }

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['transaction', 'document_line_id', 'item_id', 'balance_qty', 'status', 'CB', 'UB', 'location_code'], 'integer'],
                        [['document_date', 'DOC', 'DOU'], 'safe'],
                        [['item_cost', 'cartoon_in', 'cartoon_out', 'weight_in', 'weight_out', 'piece_in', 'piece_out', 'total_cost'], 'number'],
                        [['document_no', 'item_code', 'item_name',], 'string', 'max' => 50],
                        [['batch_no'], 'string', 'max' => 100],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'transaction' => 'Transaction',
                    'document_line_id' => 'Document Line ID',
                    'document_no' => 'Document No',
                    'document_date' => 'Document Date',
                    'item_id' => 'Item ID',
                    'item_code' => 'Item Code',
                    'item_name' => 'Item Name',
                    'batch_no' => 'Batch No',
                    'location_code' => 'Location Code',
                    'item_cost' => 'Item Cost',
                    'cartoon_in' => 'Cartoon In',
                    'cartoon_out' => 'Cartoon Out',
                    'balance_qty' => 'Balance Qty',
                    'weight_in' => 'Weight In',
                    'weight_out' => 'Weight Out',
                    'piece_in' => 'Piece In',
                    'piece_out' => 'Piece Out',
                    'total_cost' => 'Total Cost',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
