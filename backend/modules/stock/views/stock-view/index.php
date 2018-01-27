<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockViewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-view-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                          //  'item_id',
                            [
                                                    'attribute' => 'item_id',
                                                    'filter' => Html::activeDropDownList($searchModel, 'item_id', ArrayHelper::map(common\models\ItemMaster::find()->all(), 'id', 'item_name'), ['class' => 'form-control', 'id' => 'item-name', 'prompt' => '']),
                                                    'value' => function ($data) {
                                                           $item= common\models\ItemMaster::findOne($data->item_id);
                                                           if(isset($item))
                                                               return $item->item_name;
                                                    },
                                                ],
                            'item_code',
//                            'item_name',
//                            'mrp',
                            // 'retail_price',
                            // 'ws_price',
                            // 'location_code',
                             'batch_no',
                            // 'opening_carton',
                            // 'opening_weight',
                            // 'opening_piece',
                            // 'weight_per_carton',
                            // 'piece_per_carton',
                             'available_carton',
                             'available_weight',
                             'available_pieces',
                            // 'average_cost',
                            // 'due_date',
                            // 'error_msg',
                            // 'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                           // ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


