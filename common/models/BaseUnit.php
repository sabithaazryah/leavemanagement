<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "base_unit".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class BaseUnit extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'base_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'value'], 'required'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['value'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Unit Name',
            'value' => 'Unit Code',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
