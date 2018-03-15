<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leave_configuration".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type
 * @property int $entitlement
 * @property int $carry_forward
 * @property int $adjustments
 * @property int $adjustments_type 1->add,2->Deduct
 * @property int $no_of_days
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Employee $id0
 */
class LeaveConfiguration extends \yii\db\ActiveRecord {

        /**
         * {@inheritdoc}
         */
        public static function tableName() {
                return 'leave_configuration';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
                return [
                        [['leave_type'], 'required'],
                        [['employee_id', 'leave_type', 'entitlement', 'carry_forward', 'adjustments', 'adjustments_type', 'no_of_days', 'status', 'CB', 'UB'], 'integer'],
                        [['DOC', 'DOU', 'available_days'], 'safe'],
                        [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id' => 'id']],
                ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'employee_id' => 'Employee ID',
                    'leave_type' => 'Leave Category',
                    'entitlement' => 'Entitlement',
                    'carry_forward' => 'Carry Forward',
                    'adjustments' => 'Adjustments',
                    'adjustments_type' => 'Adjustments Type',
                    'no_of_days' => 'No Of Days',
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
        public function getId0() {
                return $this->hasOne(Employee::className(), ['id' => 'id']);
        }

        public function getLeave() {
                return $this->hasOne(LeaveCategory::className(), ['id' => 'leave_type']);
        }

        public function getName() {
                return $this->leave->leave_name;
        }

}
