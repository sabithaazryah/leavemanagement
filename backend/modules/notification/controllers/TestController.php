<?php

namespace backend\modules\notification\controllers;

use Yii;
use common\models\Test;
use common\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

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
            $msg = 'Item <span class="appno-highlite">' . $expiry_data->item_code . '</span> will expired on <span class="appno-highlite">' . $expiry_data->due_date;
            $msg1 = 'Item ' . $expiry_data->item_code . ' will expired on ' . $expiry_data->due_date;
        } elseif ($type == 2) {
            $msg = 'Item <span class="appno-highlite">' . $expiry_data->item_code . '</span> expiry date is over in <span class="appno-highlite"> ' . $expiry_data->due_date;
            $msg1 = 'Item ' . $expiry_data->item_code . ' expiry date is over in ' . $expiry_data->due_date;
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
            $model->save();
        } else {
            if ($data_exist->closed == 0) {
                $data_exist->status = 1;
                $data_exist->content = $msg;
                $data_exist->message = $msg1;
                $data_exist->date = date("Y-m-d H:i:s");
                $data_exist->save();
            }
        }
        return;
    }

    public function actionIndex1() {
        date_default_timezone_set("Asia/kolkata");
        $current_date = date("Y-m-d");
        $expiry_datas = \common\models\SalesInvoiceMaster::find()->where(['>', 'due_amount', 0])->all();
        foreach ($expiry_datas as $expiry_data) {
            if ($expiry_data->due_date > $current_date) {
                $diff = abs(strtotime($current_date) - strtotime($expiry_data->due_date));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                if ($days <= 3) {
                    $this->AddSalesNotification($expiry_data, 1);
                }
            } else {
                $diff = abs(strtotime($current_date) - strtotime($expiry_data->due_date));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                if ($days <= 10) {
                    $this->AddSalesNotification($expiry_data, 2);
                }
            }
        }
    }

    public function AddSalesNotification($expiry_data, $type) {
        $data_exist = \common\models\Notification::find()->where(['invoice_id' => $expiry_data->id, 'notification_type' => 2])->one();
        if ($type == 1) {
            $msg = 'Invoice <span class="appno-highlite">' . $expiry_data->sales_invoice_number . '</span> amount <span class="appno-highlite">' . $expiry_data->due_amount . '</span> due date is on <span class="appno-highlite">' . $expiry_data->due_date;
            $msg1 = 'Invoice ' . $expiry_data->sales_invoice_number . ' amount <span class="appno-highlite">' . $expiry_data->due_amount . '</span> due date is on ' . $expiry_data->due_date;
        } elseif ($type == 2) {
            $msg = 'Invoice <span class="appno-highlite">' . $expiry_data->sales_invoice_number . '</span> amount <span class="appno-highlite">' . $expiry_data->due_amount . '</span> due date is over in <span class="appno-highlite"> ' . $expiry_data->due_date;
            $msg1 = 'Invoice ' . $expiry_data->sales_invoice_number . ' amount <span class="appno-highlite">' . $expiry_data->due_amount . '</span> due date is over in ' . $expiry_data->due_date;
        }
        if (empty($data_exist)) {
            $model = new \common\models\Notification();
            $model->notification_type = 2;
            $model->invoice_id = $expiry_data->id;
            $model->invoice_no = $expiry_data->sales_invoice_number;
            $model->content = $msg;
            $model->message = $msg1;
            $model->status = 1;
            $model->date = date("Y-m-d H:i:s");
            $model->save();
        } else {
            if ($data_exist->closed == 0) {
                $data_exist->status = 1;
                $data_exist->content = $msg;
                $data_exist->message = $msg1;
                $data_exist->date = date("Y-m-d H:i:s");
                $data_exist->save();
            }
        }
        return;
    }

}
