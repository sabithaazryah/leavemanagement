<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Expression;

/**
 * ExpensesController implements the CRUD actions for Expenses model.
 */
class CroneMailController extends Controller {

    public function actionIndex() {
        date_default_timezone_set("Asia/kolkata");
        $current_date = date("Y-m-d");
        $expiry_datas = \common\models\StockView::find()->all();
        foreach ($expiry_datas as $expiry_data) {
            if ($expiry_data->available_carton > 0 || $expiry_data->available_weight > 0 || $expiry_data->available_pieces > 0) {
                if ($expiry_data->due_date > $current_date) {
                    $diff = abs(strtotime($current_date) - strtotime($expiry_data->due_date));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    if ($days <= 3) {
                        $this->AddNotification($expiry_data, 1);
                    }
                } else {
                    $diff = abs(strtotime($current_date) - strtotime($expiry_data->due_date));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    if ($days <= 10) {
                        $this->AddNotification($expiry_data, 2);
                    }
                }
            }
        }
    }

    public function AddNotification($expiry_data, $type) {
        $data_exist = \common\models\Notification::find()->where(['invoice_id' => $expiry_data->id, 'notification_type' => 1])->one();
        if ($type == 1) {
            $msg = 'Item <span class="appno-highlite">' . $expiry_data->item_code . '</span> will expires on <span class="appno-highlite">' . $expiry_data->due_date;
            $msg1 = 'Item ' . $expiry_data->item_code . ' will expires on ' . $expiry_data->due_date;
        } elseif ($type == 2) {
            $msg = 'Item <span class="appno-highlite">' . $expiry_data->item_code . '</span> is expired. <span class="appno-highlite"> ';
            $msg1 = 'Item ' . $expiry_data->item_code . ' is expired.';
        }
        if (empty($data_exist)) {
            $model = new \common\models\Notification();
            $model->notification_type = 1;
            $model->invoice_id = $expiry_data->id;
            $model->invoice_no = '';
            $model->content = $msg;
            $model->message = $msg1;
            $model->status = 1;
            $model->date = date("Y-m-d H:i:s");
            if ($model->save()) {
                $this->SendEmail($model);
            }
        } else {
            if ($data_exist->closed == 0) {
                $data_exist->status = 1;
                $data_exist->content = $msg;
                $data_exist->message = $msg1;
                $data_exist->date = date("Y-m-d H:i:s");
                if ($data_exist->save()) {
                    $this->SendEmail($model);
                }
            }
        }
        return;
    }

    public function SendEmail($model) {
        $to = 'manu@azryah.com';
// subject
        $subject = ' Attention :';

        $message = '<html><head></head><body>';
        $message .= '<p><span style="color: #2196F3;">' . $model->message . '</span></p>';
        $message .= '</body></html>';
// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@sis.innoq.com";
        mail($to, $subject, $message, $headers);


        return true;
    }

}
