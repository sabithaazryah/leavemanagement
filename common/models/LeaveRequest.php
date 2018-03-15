<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leave_request".
 *
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type
 * @property string $reason
 * @property string $from_date
 * @property string $to_date
 * @property int $recommender
 * @property int $approver
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 */
class LeaveRequest extends \yii\db\ActiveRecord {

        /**
         * {@inheritdoc}
         */
        public static function tableName() {
                return 'leave_request';
        }

        /**
         * {@inheritdoc}
         */
        public function rules() {
                return [
                        [['employee_id', 'leave_type', 'recommender', 'approver', 'status', 'CB', 'UB', 'recommended_by', 'approved_by'], 'integer'],
                        [['reason'], 'string'],
                        [['from_date', 'to_date', 'DOC', 'DOU'], 'safe'],
                        [['employee_id', 'leave_type', 'from_date', 'to_date', 'reason'], 'required']
                ];
        }

        /**
         * {@inheritdoc}
         */
        public function attributeLabels() {
                return [
                    'id' => 'ID',
                    'employee_id' => 'Employee',
                    'leave_type' => 'Leave Category',
                    'reason' => 'Reason',
                    'from_date' => 'From Date',
                    'to_date' => 'To Date',
                    'recommender' => 'Recommender',
                    'approver' => 'Approver',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
