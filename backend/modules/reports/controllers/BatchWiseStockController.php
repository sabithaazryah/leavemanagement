<?php

namespace backend\modules\reports\controllers;

use yii;
use kartik\mpdf\Pdf;
use common\models\StockViewSearch;

class BatchWiseStockController extends \yii\web\Controller {

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
     * Lists Batch wise stock report.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new StockViewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post()) {
            if (isset($_POST['batch_no']) && $_POST['batch_no'] != '') {
                $batch = $_POST['batch_no'];
                $dataProvider->query->andWhere(['batch_no' => $batch]);
            } else {
                $batch = '';
            }
        } else {
            $batch = '';
        }
        $dataProvider->pagination->pageSize = 20;
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'batch' => $batch,
        ]);
    }

    /**
     * Generate Batch wise stock report pdf.
     * @return mixed
     */
    public function actionReports() {
        $searchModel = new StockViewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (isset($_POST['batch']) && $_POST['batch'] != '') {
            $batch = $_POST['batch'];
            $dataProvider->query->andWhere(['batch_no' => $batch]);
        }
        $model_report = $dataProvider->models;
        $content = $this->renderPartial('batch_report', [
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
            'options' => ['title' => 'Batch Wise Stock Report'],
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
