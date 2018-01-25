<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_view".
 *
 * @property int $id
 * @property int $item_id
 * @property string $item_code
 * @property string $item_name
 * @property string $mrp
 * @property string $retail_price
 * @property string $ws_price
 * @property string $location_code
 * @property string $batch_no
 * @property string $opening_carton
 * @property string $opening_weight
 * @property string $opening_piece
 * @property string $weight_per_carton
 * @property string $piece_per_carton
 * @property string $available_carton
 * @property string $available_weight
 * @property string $available_pieces
 * @property string $average_cost
 * @property string $due_date
 * @property string $error_msg
 * @property int $status 0-Free,1-Open, 2-Ready, 3-Finilized, 4 -Error
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class StockView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'status', 'CB', 'UB'], 'integer'],
            [['mrp', 'retail_price', 'ws_price', 'opening_carton', 'opening_weight', 'opening_piece', 'weight_per_carton', 'piece_per_carton', 'available_carton', 'available_weight', 'available_pieces', 'average_cost'], 'number'],
            [['due_date', 'DOC', 'DOU'], 'safe'],
            [['DOC'], 'required'],
            [['item_code'], 'string', 'max' => 250],
            [['item_name', 'batch_no'], 'string', 'max' => 100],
            [['location_code'], 'string', 'max' => 15],
            [['error_msg'], 'string', 'max' => 50],
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
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'mrp' => 'Mrp',
            'retail_price' => 'Retail Price',
            'ws_price' => 'Ws Price',
            'location_code' => 'Location Code',
            'batch_no' => 'Batch No',
            'opening_carton' => 'Opening Carton',
            'opening_weight' => 'Opening Weight',
            'opening_piece' => 'Opening Piece',
            'weight_per_carton' => 'Weight Per Carton',
            'piece_per_carton' => 'Piece Per Carton',
            'available_carton' => 'Available Carton',
            'available_weight' => 'Available Weight',
            'available_pieces' => 'Available Pieces',
            'average_cost' => 'Average Cost',
            'due_date' => 'Due Date',
            'error_msg' => 'Error Msg',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
}
