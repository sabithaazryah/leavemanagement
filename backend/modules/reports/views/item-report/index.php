<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\SalesInvoiceDetails;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalesInvoiceMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Sales Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-invoice-master-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                </div>
                <div class="panel-body">
                    <div class="row" style="margin-left: 0px;">
                        <div class="col-md-5">

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to, 'item_code' => $item_code]) ?>

                        </div>
                        <div class="col-md-7">
                            <div class="col-md-2">
                                <div class="sales-invoice-master-search" style="margin-right: 15px;float: left;">

                                    <?= Html::beginForm(['item-report/reports'], 'post', ['target' => 'print_popup', 'id' => "epda-form", 'style' => 'margin-bottom: 0px;']) ?>
                                    <input type="hidden" value="<?= $from ?>" name="from_date"/>
                                    <input type="hidden" value="<?= $to ?>" name="to_date"/>
                                    <input type="hidden" value="<?= $item_code ?>" name="item_code"/>
                                    <?= Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank']) ?>

                                    <?= Html::endForm() ?>

                                </div>
                            </div>
                            <div class="col-md-10">
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="5">Report Summary</th>
                                    </tr>
                                    <tr>
                                        <th>Total Sale</th>
                                        <th>Total KG</th>
                                        <th>Total Cartons</th>
                                        <th>Tax Amount</th>
                                        <th>Sale Amount</th>
                                    </tr>
                                    <?php
                                    $sale_total = SalesInvoiceDetails::getTotalCount($from, $to, $item_code);
                                    $total_kg = SalesInvoiceDetails::getSaleTotal($from, $to, $item_code, 'qty');
                                    $total_carton = SalesInvoiceDetails::getSaleTotal($from, $to, $item_code, 'carton');
                                    $amount_total = SalesInvoiceDetails::getSaleTotal($from, $to, $item_code, 'line_total');
                                    $tax_total = SalesInvoiceDetails::getSaleTotal($from, $to, $item_code, 'tax_amount');
                                    ?>
                                    <tr>
                                        <th><?= $sale_total ?></th>
                                        <th><?= $total_kg ?></th>
                                        <th><?= $total_carton ?></th>
                                        <th><?= Yii::$app->SetValues->NumberFormat(round($tax_total, 2)) . ' (S$)'; ?></th>
                                        <th><?= Yii::$app->SetValues->NumberFormat(round($amount_total, 2)) . ' (S$)'; ?></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'item_code',
                            'item_name',
                            [
                                'attribute' => 'qty',
                                'label' => 'KG Sold',
                                'value' => function ($data) {
                                    return $data->qty;
                                },
                            ],
                            [
                                'attribute' => 'carton',
                                'label' => 'Cartons Sold',
                                'value' => function ($data) {
                                    return $data->carton;
                                },
                            ],
                            'tax_amount',
                            [
                                'attribute' => 'line_total',
                                'label' => 'Sale Amount',
                                'value' => function ($data) {
                                    return $data->line_total;
                                },
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


