<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "designation".
 *
 * @property int $id
 * @property string $designation_code
 * @property string $designation_name
 * @property int $designation_rank
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Designation extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'designation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['designation_rank', 'designation_code', 'designation_name'], 'required'],
            [['designation_rank', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['designation_code', 'designation_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'designation_code' => 'Designation Code',
            'designation_name' => 'Designation Name',
            'designation_rank' => 'Designation Rank',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
