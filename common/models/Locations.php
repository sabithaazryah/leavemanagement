<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property string $location_code
 * @property string $location_name
 * @property string $description
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Locations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'locations';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['location_code', 'location_name'], 'required'],
            [['description'], 'string'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['location_code', 'location_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'location_code' => 'Location Code',
            'location_name' => 'Location Name',
            'description' => 'Description',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }
    
    
        public function getLocation() {
                return $this->location_name . " (" . $this->location_code . ") ";
        }

}
