<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockAdjustmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Adjustments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-adjustment-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">
                                                                                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                                        
                                        <?=  Html::a('<i class="fa-th-list"></i><span> Create Stock Adjustment</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                                                                                                                                        <?= GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                'filterModel' => $searchModel,
        'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],

                                                            //'id',
           // 'item_id',
            'item_name',
            'item_code',
            'price',
            // 'uom',
            // 'batch_no',
            // 'slaughter_date_from',
            // 'slaughter_date_to',
            // 'production_date',
            // 'due_date',
            // 'plant',
            // 'location',
            // 'warehouse',
            // 'supplier',
            // 'origin',
            // 'cost',
            // 'cartons',
            // 'total_weight',
            // 'pieces',
             'adjust_cartons',
             'adjust_weight',
             'adjust_pieces',
            // 'remarks:ntext',
            // 'stock_view_id',
            // 'status',
            // 'CB',
            // 'UB',
            // 'DOC',
            // 'DOU',

                                                ['class' => 'yii\grid\ActionColumn'],
                                                ],
                                                ]); ?>
                                                                                                                </div>
                        </div>
                </div>
        </div>
</div>


