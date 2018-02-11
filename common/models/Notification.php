<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $notification_type '1'=>'Expiry Date','2'=>'Due Date'
 * @property int $invoice_id
 * @property string $invoice_no
 * @property string $content
 * @property string $message
 * @property int $status '1=>'Open','2'=>'Ignore','3'=>'close'
 * @property int $closed
 * @property string $date
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_type', 'invoice_id', 'status', 'closed'], 'integer'],
            [['content', 'message'], 'string'],
            [['date'], 'safe'],
            [['invoice_no'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_type' => 'Notification Type',
            'invoice_id' => 'Invoice ID',
            'invoice_no' => 'Invoice No',
            'content' => 'Content',
            'message' => 'Message',
            'status' => 'Status',
            'closed' => 'Closed',
            'date' => 'Date',
        ];
    }
}
