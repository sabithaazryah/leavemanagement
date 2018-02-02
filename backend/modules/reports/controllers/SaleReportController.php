<?php

namespace backend\modules\reports\controllers;

use yii;
use kartik\mpdf\Pdf;
use common\models\SalesInvoiceMaster;
use common\models\SalesInvoiceMasterSearch;

class SaleReportController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new SalesInvoiceMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post()) {
            if (isset($_POST['SalesInvoiceMasterSearch']['createdFrom']) && $_POST['SalesInvoiceMasterSearch']['createdFrom'] != '') {
                $from = $_POST['SalesInvoiceMasterSearch']['createdFrom'];
                $dataProvider->query->andWhere(['>=', 'sales_invoice_date', $from . '00:00:00']);
            } else {
                $from = '';
            }
            if (isset($_POST['SalesInvoiceMasterSearch']['createdTo']) && $_POST['SalesInvoiceMasterSearch']['createdTo'] != '') {
                $to = $_POST['SalesInvoiceMasterSearch']['createdTo'];
                $dataProvider->query->andWhere(['<=', 'sales_invoice_date', $to . '60:60:60']);
            } else {
                $to = '';
            }
        } else {
            $from = '';
            $to = '';
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'from' => $from,
                    'to' => $to,
        ]);
    }

    public function actionReports() {
        $searchModel = new SalesInvoiceMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {
            $from = $_POST['from_date'];
            $dataProvider->query->andWhere(['>=', 'sales_invoice_date', $from . '00:00:00']);
        } else {
            $from = '';
        }
        if (isset($_POST['to_date']) && $_POST['to_date'] != '') {
            $to = $_POST['to_date'];
            $dataProvider->query->andWhere(['<=', 'sales_invoice_date', $to . '60:60:60']);
        } else {
            $to = '';
        }
        $model_report = $dataProvider->models;
        if (isset($_POST['from_date'])) {

        }
        $content = $this->renderPartial('sale_report', [
            'model_report' => $model_report,
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'Krajee Report Title'],
            'methods' => [
                'SetHeader' => ['Sale Report'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        return $pdf->render();
    }

}
