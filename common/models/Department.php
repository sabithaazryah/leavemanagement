<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $department_code
 * @property string $department_name
 * @property int $description
 * @property int $recomender
 * @property int $approver
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class Department extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['recomender', 'approver', 'department_code', 'department_name'], 'required'],
            [['description', 'recomender', 'approver', 'status', 'CB', 'UB'], 'integer'],
            [['DOC', 'DOU'], 'safe'],
            [['department_code', 'department_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'department_code' => 'Department Code',
            'department_name' => 'Department Name',
            'description' => 'Description',
            'recomender' => 'Recomender',
            'approver' => 'Approver',
            'status' => 'Status',
            'CB' => 'Cb',
            'UB' => 'Ub',
            'DOC' => 'Doc',
            'DOU' => 'Dou',
        ];
    }

}
