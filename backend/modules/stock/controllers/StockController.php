<?php

namespace backend\modules\stock\controllers;

use Yii;
use common\models\Stock;
use common\models\StockSearch;
use common\models\StockView;
use common\models\ItemMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller {

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

        /**
         * Lists all Stock models.
         * @return mixed
         */
        public function actionIndex() {
                $searchModel = new StockSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single Stock model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
                return $this->render('view', [
                            'model' => $this->findModel($id),
                ]);
        }

        /**
         * Creates a new Stock model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
                $model = new Stock();
                $stock_view = new StockView();

                if ($model->load(Yii::$app->request->post())) {
                        $item_deatils = ItemMaster::findOne($model->item_id);
                        $model->item_name = $item_deatils->item_name;
                        $model->slaughter_date_from = date('Y-m-d', strtotime($model->slaughter_date_from));
                        $model->slaughter_date_to = date('Y-m-d', strtotime($model->slaughter_date_to));
                        $model->production_date = date('Y-m-d', strtotime($model->production_date));
                        $model->due_date = date('Y-m-d', strtotime($model->due_date));
                        Yii::$app->SetValues->Attributes($model);
                        $model->save();
                        $this->StockView($stock_view, $model);

//                        $transaction = Yii::$app->db->beginTransaction();
//                        if (Yii::$app->SetValues->Attributes($model) && $model->save() && $this->StockView($stock_view, $model)) {
//                                $transaction->commit();
//                        } else {
//                                $transaction->rollBack();
//                        }



                        return $this->redirect(['index']);
                }
                return $this->render('create', [
                            'model' => $model,
                ]);
        }

        public function StockView($stock_view, $model) {

                $stock_view->item_id = $model->item_id;
                $stock_view->item_code = $model->item_code;
                $stock_view->item_name = $model->item_name;
                $stock_view->batch_no = $model->batch_no;
                $stock_view->location_code = $model->location;
                $stock_view->available_carton = $model->cartons;
                $stock_view->available_weight = $model->total_weight;
                $stock_view->available_pieces = $model->pieces;
                $stock_view->average_cost = $model->cost;
                $stock_view->due_date = $model->due_date;
                if ($stock_view->save()) {

                } else {
                        print_r($stock_view->getErrors());
                        exit;
                }
        }

        /**
         * Updates an existing Stock model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
                $model = $this->findModel($id);

                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                } else {
                        return $this->render('update', [
                                    'model' => $model,
                        ]);
                }
        }

        /**
         * Deletes an existing Stock model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Finds the Stock model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Stock the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
                if (($model = Stock::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        public function actionItemDetails() {
                if (Yii::$app->request->isAjax) {
                        $item = $_POST['item'];
                        $item_details = \common\models\ItemMaster::findOne($item);
                        $unit = \common\models\BaseUnit::findOne($item_details->base_unit_id);
                        $data = ['item_code' => $item_details->item_code, 'price' => $item_details->purchase_price, 'UOM' => $unit->name];
                        echo json_encode($data);
                }
        }

}
