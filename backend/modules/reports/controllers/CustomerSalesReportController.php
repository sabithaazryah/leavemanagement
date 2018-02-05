<?php

namespace backend\modules\reports\controllers;

use Yii;
use kartik\mpdf\Pdf;
use common\models\BusinessPartnerSearch;

class CustomerSalesReportController extends \yii\web\Controller {

    /**
     * Lists Customer wise sales report.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BusinessPartnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post()) {
            if (isset($_POST['BusinessPartnerSearch']['id']) && $_POST['BusinessPartnerSearch']['id'] != '') {
                $id = $_POST['BusinessPartnerSearch']['id'];
                $dataProvider->query->andWhere(['id' => $id]);
            } else {
                $id = '';
            }
            if (isset($_POST['BusinessPartnerSearch']['createdFrom']) && $_POST['BusinessPartnerSearch']['createdFrom'] != '') {
                $from = $_POST['BusinessPartnerSearch']['createdFrom'];
            } else {
                $from = '';
            }
            if (isset($_POST['BusinessPartnerSearch']['createdTo']) && $_POST['BusinessPartnerSearch']['createdTo'] != '') {
                $to = $_POST['BusinessPartnerSearch']['createdTo'];
            } else {
                $to = '';
            }
        } else {
            $from = '';
            $to = '';
            $id = '';
        }
        $dataProvider->pagination->pageSize = 10;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'from' => $from,
                    'to' => $to,
                    'id' => $id,
        ]);
    }

    /**
     * Generate Customer wise sales report pdf.
     * @return mixed
     */
    public function actionReports() {
        $query = new yii\db\Query();
        $query->select(['*'])
                ->from('business_partner')
                ->where(['type' => 1]);
        if (isset($_POST['customer_id']) && $_POST['customer_id'] != '') {
            $customer_id = $_POST['customer_id'];
            $query->andWhere(['id' => $customer_id]);
        } else {
            $from = '';
        }
        if (isset($_POST['from_date']) && $_POST['from_date'] != '') {
            $from = $_POST['from_date'];
        } else {
            $from = '';
        }
        if (isset($_POST['to_date']) && $_POST['to_date'] != '') {
            $to = $_POST['to_date'];
        } else {
            $to = '';
        }
        $command = $query->createCommand();
        $customer_model = $command->queryAll();
        $content = $this->renderPartial('customer_sales_report', [
            'customer_model' => $customer_model,
            'from' => $from,
            'to' => $to,
        ]);
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'Customer Sales Report'],
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
