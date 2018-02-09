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
        $time = strtotime(date("H:i:s"));
        $current_date = date("Y-m-d");
        $expirt_datas = \common\models\StockView::find()->all();
        foreach ($expirt_datas as $expirt_data) {
            if ($expirt_data->available_carton > 0 || $expirt_data->available_weight > 0 || $expirt_data->available_pieces > 0) {
                echo $expirt_data->due_date;
                echo $current_date;
                exit;
                if ($expirt_data->due_date > $current_date) {
                    $diff = abs(strtotime($current_date) - strtotime($expirt_data->due_date));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                } else {
                    $diff = abs(strtotime($current_date) - strtotime($expirt_data->due_date));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    if ($days <= 3) {
                        $this->AddNotification($expirt_data, 1);
                    }
                }
                exit;
            }
        }
        var_dump($expirt_datas);
        exit;
        $end_date = date("Y-m-d H:i:s", strtotime('-3 days', $time));
        $diff = abs(strtotime($end_date) - strtotime($current_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        echo $days;
        exit;
        $before_date = date('Y-m-d H:i:s', strtotime('-30 days'));
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        $arr = [0, 6, 12, 24, 48, 72];
        foreach ($arr as $val) {
            if ($val == 0) {
                $expirt_datas = \common\models\StockView::find()->where(['<', 'due_date', $current_date])->andWhere(['not', ['due_date' => null]])->andWhere(['not', ['due_date' => '0000-00-00 00:00:00']])->all();
                $due_date_datas = \common\models\SalesInvoiceMaster::find()->where(['<', 'due_date', $current_date])->andWhere(['>', 'due_date', $before_date])->andWhere(['not', ['due_date' => null]])->andWhere(['not', ['due_date' => '0000-00-00 00:00:00']])->all();
//                if (!empty($expirt_datas)) {
//                    $this->AddNotification($expirt_datas, 0);
//                }
//                if (!empty($due_date_datas)) {
//                    $this->AddCastOfNotification($due_date_datas, 0);
//                }
            } elseif ($val == 6) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +6 hour'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +6 hour'));
                $expirt_datas = \common\models\StockView::find()->where(['<=', 'due_date', $end])->andWhere(['>=', 'due_date', $begin])->all();
                $due_date_datas = \common\models\SalesInvoiceMaster::find()->where(['<=', 'due_date', $end])->andWhere(['>=', 'due_date', $begin])->all();
                if (!empty($expirt_datas)) {
                    $this->AddNotification($expirt_datas, 6);
                }
                if (!empty($due_date_datas)) {
                    $this->AddCastOfNotification($due_date_datas, 6);
                }
            } elseif ($val == 12) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +12 hour'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +12 hour'));
                $expirt_datas = \common\models\StockView::find()->where(['<=', 'due_date', $end])->andWhere(['>=', 'due_date', $begin])->all();
                $due_date_datas = \common\models\SalesInvoiceMaster::find()->where(['<=', 'due_date', $end])->andWhere(['>=', 'due_date', $begin])->all();
                if (!empty($expirt_datas)) {
                    $this->AddNotification($expirt_datas, 12);
                }
                if (!empty($due_date_datas)) {
                    $this->AddCastOfNotification($due_date_datas, 12);
                }
            } elseif ($val == 24) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +10 day'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +10 day'));
                echo $begin;
                $expirt_datas = \common\models\StockView::find()->where(['<=', 'due_date', $end])->andWhere(['>=', 'due_date', $begin])->all();
                $due_date_datas = \common\models\SalesInvoiceMaster::find()->where(['<=', 'due_date', $end])->andWhere(['>=', 'due_date', $begin])->all();
                var_dump($expirt_datas);
                var_dump($due_date_datas);
                exit;
                if (!empty($expirt_datas)) {
                    $this->AddNotification($expirt_datas, 24);
                }
                if (!empty($due_date_datas)) {
                    $this->AddCastOfNotification(v, 24);
                }
            }
        }
    }

    public function AddCastOfNotification($eta_datas, $hour) {
        foreach ($eta_datas as $value) {
            $appointment = \common\models\Appointment::find()->where(['id' => $value->appointment_id, 'status' => 0, 'stage' => 5])->one();
            if (empty($appointment)) {
                $data_exist = \common\models\Notification::find()->where(['appointment_id' => $value->appointment_id, 'notification_type' => 2])->one();
                $app_no = \common\models\Appointment::findOne(['id' => $value->appointment_id])->appointment_no;
                if ($hour == 0) {
                    $diff_in_hrs = $this->CalculateDateDiff($value->eta);
                    $msg = 'Cast off for appointment <span class="appno-highlite">' . $app_no . '</span> is over about more than almost <span class="appno-highlite">' . $diff_in_hrs . '<span>';
                    $msg1 = 'Cast off for appointment ' . $app_no . ' is over about more than almost ' . $diff_in_hrs;
                } else {
                    $msg = 'Cast off for appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour';
                    $msg1 = 'Cast off for appointment ' . $app_no . ' in ' . $hour . ' hour';
                }
                if (empty($data_exist)) {
                    $model = new \common\models\Notification();
                    $model->notification_type = 2;
                    $model->appointment_id = $value->appointment_id;
                    $model->appointment_no = $app_no;
                    $model->content = $msg;
                    $model->message = $msg1;
                    $model->status = 1;
                    $model->date = date("Y-m-d H:i:s");
                    $model->save();
                } else {
                    $data_exist->status = 1;
                    $data_exist->content = $msg;
                    $data_exist->message = $msg1;
                    $data_exist->date = date("Y-m-d H:i:s");
                    $data_exist->save();
                }
            }
        }
        return;
    }

    public function AddNotification($eta_datas, $hour) {
        foreach ($eta_datas as $value) {
            $data_exist = \common\models\Notification::find()->where(['appointment_id' => $value->appointment_id, 'notification_type' => 1])->one();
            $app_no = \common\models\Appointment::findOne(['id' => $value->appointment_id])->appointment_no;
            if ($hour == 0) {
                $diff_in_hrs = $this->CalculateDateDiff($value->eta);
                $msg = 'ETA for Appointment <span class="appno-highlite">' . $app_no . '</span> is over <span class="appno-highlite">' . $diff_in_hrs . '</span> ago';
                $msg1 = 'ETA for Appointment ' . $app_no . ' is over ' . $diff_in_hrs . ' ago';
            } else {
                $msg = 'ETA for Appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour ';
                $msg1 = 'ETA for Appointment ' . $app_no . ' in ' . $hour . ' hour ';
            }
            if (empty($data_exist)) {
                $model = new \common\models\Notification();
                $model->notification_type = 1;
                $model->appointment_id = $value->appointment_id;
                $model->appointment_no = $app_no;
                $model->content = $msg;
                $model->message = $msg1;
                $model->status = 1;
                $model->date = date("Y-m-d H:i:s");
                $model->save();
            } else {
                $data_exist->status = 1;
                $data_exist->content = $msg;
                $data_exist->message = $msg1;
                $data_exist->date = date("Y-m-d H:i:s");
                $data_exist->save();
            }
        }
        return;
    }

    public function CalculateDateDiff($eta) {
        $start_date = $eta;
        $end_date = date("Y-m-d H:i:s");
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        if ($years > 0) {
            $new_date = $years . ' Years ' . $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        } elseif ($years < 0 && $months > 0) {
            $new_date = $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        } elseif ($years < 0 && $months < 0 && $days > 0) {
            $new_date = $days . ' Days ' . $hours . ' Hours';
        } else {
            $new_date = $hours . ' Hours';
        }
        return $new_date;
    }

}
