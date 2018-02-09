<?php

namespace backend\modules\reports\controllers;

use yii;
use kartik\mpdf\Pdf;
use common\models\StockViewSearch;
use common\models\ItemMaster;
use yii\db\Query;
use yii\data\ArrayDataProvider;

class ItemWiseStockController extends \yii\web\Controller {

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
     * Lists Item wise stock report.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new StockViewSearch();
        $query = new Query();
        $query->select('item_name,item_code,SUM(available_carton) as available_carton,SUM(available_weight) as available_weight,SUM(available_pieces) as available_pieces')
                ->from('stock_view')
                ->groupBy('item_id');
        if (Yii::$app->request->post()) {
            if (isset($_POST['item_id']) && $_POST['item_id'] != '') {
                $item = $_POST['item_id'];
                $query->andWhere(['item_id' => $item]);
            } else {
                $item = '';
            }
        } else {
            $item = '';
        }
        $command = $query->createCommand();
        $result = $command->queryAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'item' => $item,
        ]);
    }

    /**
     * Generate Item wise stock report pdf.
     * @return mixed
     */
    public function actionReports() {
        $query = new Query();
        $query->select('item_name,item_code,SUM(available_carton) as available_carton,SUM(available_weight) as available_weight,SUM(available_pieces) as available_pieces')
                ->from('stock_view')
                ->groupBy('item_id');
        if (Yii::$app->request->post()) {
            if (isset($_POST['item_idd']) && $_POST['item_idd'] != '') {
                $item = $_POST['item_idd'];
                $query->andWhere(['item_id' => $item]);
            } else {
                $item = '';
            }
        } else {
            $item = '';
        }
        $command = $query->createCommand();
        $model_report = $command->queryAll();
        $content = $this->renderPartial('item_wise_report', [
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
            'options' => ['title' => 'Item Wise Stock Report'],
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
