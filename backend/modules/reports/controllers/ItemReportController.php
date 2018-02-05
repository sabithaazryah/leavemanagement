<?php

namespace backend\modules\reports\controllers;

use yii;
use kartik\mpdf\Pdf;
use common\models\SalesInvoiceDetailsSearch;

class ItemReportController extends \yii\web\Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        return true;
    }

    /**
     * Lists Item wise sales report.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SalesInvoiceDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post()) {
            if (isset($_POST['SalesInvoiceDetailsSearch']['item_id']) && $_POST['SalesInvoiceDetailsSearch']['item_id'] != '') {
                $item_code = $_POST['SalesInvoiceDetailsSearch']['item_id'];
                $dataProvider->query->andWhere(['item_id' => $item_code]);
            } else {
                $item_code = '';
            }
            if (isset($_POST['SalesInvoiceDetailsSearch']['createdFrom']) && $_POST['SalesInvoiceDetailsSearch']['createdFrom'] != '') {
                $from = $_POST['SalesInvoiceDetailsSearch']['createdFrom'];
                $dataProvider->query->andWhere(['>=', 'sales_invoice_date', $from . '00:00:00']);
            } else {
                $from = '';
            }
            if (isset($_POST['SalesInvoiceDetailsSearch']['createdTo']) && $_POST['SalesInvoiceDetailsSearch']['createdTo'] != '') {
                $to = $_POST['SalesInvoiceDetailsSearch']['createdTo'];
                $dataProvider->query->andWhere(['<=', 'sales_invoice_date', $to . '60:60:60']);
            } else {
                $to = '';
            }
        } else {
            $from = '';
            $to = '';
            $item_code = '';
        }
        $dataProvider->pagination->pageSize = 20;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'from' => $from,
                    'to' => $to,
                    'item_code' => $item_code,
        ]);
    }

    /**
     * Generate Item wise sales report pdf.
     * @return mixed
     */
    public function actionReports() {
        $searchModel = new SalesInvoiceDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($_POST['item_code']) && $_POST['item_code'] != '') {
            $id = $_POST['item_code'];
            $dataProvider->query->andWhere(['item_id' => $id]);
        } else {
            $id = '';
        }
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
        $content = $this->renderPartial('item_report', [
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
            'options' => ['title' => 'Item Sales Report'],
            'methods' => [
                'SetHeader' => ['Sale Invoice System'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        return $pdf->render();
    }

}
