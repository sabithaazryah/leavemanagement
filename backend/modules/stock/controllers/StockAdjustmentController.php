<?php

namespace backend\modules\stock\controllers;

use Yii;
use common\models\StockAdjustment;
use common\models\StockAdjustmentSearch;
use common\models\StockView;
use common\models\Stock;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StockAdjustmentController implements the CRUD actions for StockAdjustment model.
 */
class StockAdjustmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
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
     * Lists all StockAdjustment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockAdjustmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StockAdjustment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StockAdjustment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StockAdjustment();

        if ($model->load(Yii::$app->request->post())) {
             $model->slaughter_date_from=date('Y-m-d',strtotime($model->slaughter_date_from));
                    $model->slaughter_date_to=date('Y-m-d',strtotime($model->slaughter_date_to));
                    $model->production_date=date('Y-m-d',strtotime($model->production_date));
                    $model->due_date=date('Y-m-d',strtotime($model->due_date));
                    $stock_view=StockView::findOne($model->stock_view_id);
                                $stock_view->available_carton=$model->adjust_cartons;
            $stock_view->available_weight=$model->adjust_weight;
            $stock_view->available_pieces=$model->adjust_pieces;
            $model->item_id=$stock_view->item_id;
            $stock_view->save();
            $model->save();
            return $this->redirect(['index']);
        } 
            return $this->render('create', [
                'model' => $model,
            ]);
        
    }

    /**
     * Updates an existing StockAdjustment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing StockAdjustment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StockAdjustment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StockAdjustment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StockAdjustment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionItemDetails(){
        if (Yii::$app->request->isAjax) {
         $items=StockView::find()->select('item_id')->distinct()->all();
         $list = $this->renderPartial('items', ['items' => $items, 'status' => $status]);
                        return $list;
            
        }
    }
    
    public function actionSelectedItem(){
        if (Yii::$app->request->isAjax) {
            $item=$_POST['selected'];
            $stock_view=StockView::findOne($item);
            $stock= Stock::find()->where(['item_id'=>$stock_view->item_id,'batch_no'=>$stock_view->batch_no])->one();
            $item_details=\common\models\ItemMaster::findOne($stock_view->item_id);
            $unit = \common\models\BaseUnit::findOne($item_details->base_unit_id);
            $data = ['item_name' => $stock_view->item_name, 
                     'item_code' => $stock_view->item_code,
                     'price' => $stock_view->mrp,
                     'uom' => $unit->name,
                     'batch_no' => $stock_view->batch_no,
                     'slaughter_date_from' => date('d-m-Y',strtotime($stock->slaughter_date_from)),
                     'slaughter_date_to' => date('d-m-Y',strtotime($stock->slaughter_date_to)),
                     'production_date' => date('d-m-Y',strtotime($stock->production_date)),
                     'due_date' => date('d-m-Y',strtotime($stock->due_date)),
                     'location' => $stock_view->location_code,
                     'cost' => $stock_view->average_cost,
                     'cartons' => $stock_view->available_carton,
                     'total_weight' => $stock_view->available_weight,
                     'pieces' => $stock_view->available_pieces,
                
                
                    ];
                        echo json_encode($data);
        }
    }
    
    
}
