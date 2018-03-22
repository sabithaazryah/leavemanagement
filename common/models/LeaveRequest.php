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
        public $leave_count;

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
                        [['from_date', 'to_date', 'DOC', 'DOU', 'from_leave_type', 'to_leave_type', 'apply_leave_type', 'no_of_days'], 'safe'],
//                        [['employee_id', 'leave_type', 'from_date', 'to_date', 'reason'], 'required'],
                    [['employee_id', 'leave_type', 'from_date', 'to_date', 'reason', 'apply_leave_type'], 'required', 'when' => function ($model) {

                        }, 'whenClient' => "function (attribute, value) {
               return $('#appied-leave-dates').val() == '1';
            }"],
                        [['employee_id', 'leave_type', 'from_date', 'to_date', 'reason', 'from_leave_type', 'to_leave_type'], 'required', 'when' => function ($model) {

                        }, 'whenClient' => "function (attribute, value) {
               return $('#appied-leave-dates').val() == '2';
            }"],
                        [['employee_id', 'leave_type', 'from_date', 'to_date', 'reason'], 'required', 'when' => function ($model) {

                        }, 'whenClient' => "function (attribute, value) {
               return $('#appied-leave-dates').val() == '0';
            }"],
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
                    'from_leave_type' => 'Half Day/Full Day (On the from date you are requesting for a half day/full day)',
                    'to_leave_type' => 'Half Day/Full Day  (On the to date you are requesting for a half day/full day)',
                    'apply_leave_type' => 'Half Day/Full Day',
                    'no_of_days' => 'Leave Applied (days)',
                    'status' => 'Status',
                    'CB' => 'Cb',
                    'UB' => 'Ub',
                    'DOC' => 'Doc',
                    'DOU' => 'Dou',
                ];
        }

}
