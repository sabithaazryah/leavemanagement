<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tax".
 *
 * @property int $id
 * @property string $name
 * @property int $type 1=>percentage,2=>flat
 * @property string $value
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Tax extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tax';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'value', 'type'], 'required'],
            [['type', 'status', 'CB', 'UB'], 'integer'],
            [['value'], 'number'],
            [['DOC', 'DOU'], 'safe'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'value' => 'Value',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
