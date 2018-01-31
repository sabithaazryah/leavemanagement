<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Opening Stocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">
                                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                        <?= Html::a('<i class="fa-th-list"></i><span> Add Opening Stock</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn'],
                                                //  'id',
//                                                'item_id',
                                                [
                                                    'attribute' => 'item_id',
                                                    'filter' => Html::activeDropDownList($searchModel, 'item_id', ArrayHelper::map(common\models\ItemMaster::find()->all(), 'id', 'item_name'), ['class' => 'form-control', 'id' => 'item-name', 'prompt' => '']),
                                                    'value' => function ($data) {
                                                            $item = common\models\ItemMaster::findOne($data->item_id);
                                                            if (isset($item))
                                                                    return $item->item_name;
                                                    },
                                                ],
                                                'item_code',
//                                                'price',
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
//                                                'cost',
                                                'cartons',
                                                'total_weight',
                                                'pieces',
                                                // 'stock',
                                                // 'available_stock',
                                                // 'closing_stock',
                                                // 'remarks:ntext',
                                                // 'status',
                                                // 'CB',
                                                // 'UB',
                                                // 'DOC',
                                                // 'DOU',
                                                ['class' => 'yii\grid\ActionColumn',
                                                    'template' => '{view}{update}',
                                                    'buttons' => [
                                                        //view button
                                                        'update' => function ($url, $model) {
                                                                return Html::a('<span class="fa fa-adjust" style="padding-top: 0px;font-size: 15px;"></span>', $url, [
                                                                            'title' => Yii::t('app', 'Stock Adjustment'),
                                                                ]);
                                                        },
                                                        'view' => function ($url, $model) {
                                                                return Html::a('<span class="fa fa-eye" style="padding-top: 0px;font-size: 15px;"></span>', $url, [
                                                                            'title' => Yii::t('app', 'View'),
                                                                ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model) {
                                                            if ($action === 'update') {
                                                                    $url = Url::to(['update', 'id' => $model->id]);
                                                                    return $url;
                                                            }
                                                            if ($action === 'view') {
                                                                    $url = Url::to(['view', 'id' => $model->id]);
                                                                    return $url;
                                                            }
                                                    }
                                                ],
                                            ],
                                        ]);
                                        ?>
                                </div>
                        </div>
                </div>
        </div>
</div>


<script>
        $(document).ready(function () {
                $("#item-name").select2({
                        //   placeholder: 'Select',
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
        });
</script>