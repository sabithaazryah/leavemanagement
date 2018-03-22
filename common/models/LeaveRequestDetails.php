<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leave_request_details".
 *
 * @property int $id
 * @property int $leave_request_id
 * @property int $employee_id
 * @property string $date
 * @property int $leave_type
 * @property int $year
 * @property int $leave_day_mode 1=full day,2=half day
 * @property int $leave_status 1=leave,2=off
 * @property string $leave_off_reason
 * @property int $status
 */
class LeaveRequestDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_request_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leave_request_id', 'employee_id', 'leave_type', 'year', 'leave_day_mode', 'leave_status', 'status'], 'integer'],
            [['date'], 'safe'],
            [['leave_off_reason'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leave_request_id' => 'Leave Request ID',
            'employee_id' => 'Employee ID',
            'date' => 'Date',
            'leave_type' => 'Leave Type',
            'year' => 'Year',
            'leave_day_mode' => 'Leave Day Mode',
            'leave_status' => 'Leave Status',
            'leave_off_reason' => 'Leave Off Reason',
            'status' => 'Status',
        ];
    }
}
