<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "working_hours".
 *
 * @property int $id
 * @property double $working_hour
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class WorkingHours extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'working_hours';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['working_hour'], 'required'],
            [['working_hour'], 'number'],
            [['status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'working_hour' => 'Working Hour',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
