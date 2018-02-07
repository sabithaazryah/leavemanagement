<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_post".
 *
 * @property int $id
 * @property string $post_name
 * @property int $admin
 * @property int $masters
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Employee[] $employees
 */
class AdminPost extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'admin_post';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['admin', 'masters', 'status', 'CB', 'UB', 'daily_entry', 'appointement', 'stock', 'reports', 'sales_invoice', 'stock_adjustment', 'opening_stock'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['post_name'], 'string', 'max' => 100],
            [['post_name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'post_name' => 'Post Name',
            'admin' => 'Admin',
            'masters' => 'Masters',
            'daily_entry' => 'Daily Entry',
            'appointement' => 'Appointement',
            'stock' => 'Stock',
            'sales_invoice' => 'Sales Invoice',
            'stock_adjustment' => 'Stock Adjustment',
            'opening_stock' => 'Opening Stock',
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
    public function getEmployees() {
        return $this->hasMany(Employee::className(), ['post_id' => 'id']);
    }

}
