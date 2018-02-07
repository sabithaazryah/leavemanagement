<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\SalesInvoiceMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalesInvoiceMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Report';
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
                        <div class="col-md-6">

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>
                        <div class="col-md-6">
                            <div class="col-md-2">
                                <div class="sales-invoice-master-search" style="margin-right: 15px;float: left;">

                                    <?= Html::beginForm(['sale-report/reports'], 'post', ['target' => 'print_popup', 'id' => "epda-form", 'style' => 'margin-bottom: 0px;']) ?>
                                    <input type="hidden" value="<?= $from ?>" name="from_date"/>
                                    <input type="hidden" value="<?= $to ?>" name="to_date"/>
                                    <?= Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;padding: 6px 20px;', 'formtarget' => '_blank']) ?>

                                    <?= Html::endForm() ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="">
                        <div class="col-md-10" style="padding: 5px 20px;">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="7">Report Summary</th>
                                </tr>
                                <tr>
                                    <th>No. Of Sale</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>GST</th>
                                    <th>Sale Amount</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                </tr>
                                <?php
                                $sale_total = SalesInvoiceMaster::getTotalCount($from, $to, '');
                                $amount_total = SalesInvoiceMaster::getSaleTotal($from, $to, '', 'amount');
                                $discount_total = SalesInvoiceMaster::getSaleTotal($from, $to, '', 'discount_amount');
                                $tax_total = SalesInvoiceMaster::getSaleTotal($from, $to, '', 'tax_amount');
                                $nettotal = SalesInvoiceMaster::getSaleTotal($from, $to, '', 'order_amount');
                                $paid_total = SalesInvoiceMaster::getSaleTotal($from, $to, '', 'amount_payed');
                                $balance_total = SalesInvoiceMaster::getSaleTotal($from, $to, '', 'due_amount');
                                ?>
                                <tr>
                                    <th><?= $sale_total ?></th>
                                    <th><?= Yii::$app->SetValues->NumberFormat(round($amount_total, 2)) . ' (S$)'; ?></th>
                                    <th><?= Yii::$app->SetValues->NumberFormat(round($discount_total, 2)) . ' (S$)'; ?></th>
                                    <th><?= Yii::$app->SetValues->NumberFormat(round($tax_total, 2)) . ' (S$)'; ?></th>
                                    <th><?= Yii::$app->SetValues->NumberFormat(round($nettotal, 2)) . ' (S$)'; ?></th>
                                    <th><?= Yii::$app->SetValues->NumberFormat(round($paid_total, 2)) . ' (S$)'; ?></th>
                                    <th><?= Yii::$app->SetValues->NumberFormat(round($balance_total, 2)) . ' (S$)'; ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
//                       'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                'id',
                            'sales_invoice_number',
                            'sales_invoice_date',
//                            'order_type',
//                                                'busines_partner_code',
                            'po_no',
                            'po_date',
                            // 'delivery_terms',
                            'amount',
                            [
                                'attribute' => 'discount_amount',
                                'label' => 'Discount',
                                'value' => function ($data) {
                                    return $data->discount_amount;
                                },
                            ],
                            'tax_amount',
                            'order_amount',
//                            'ship_to_adress',
                            [
                                'attribute' => 'amount_payed',
                                'label' => 'Paid',
                                'value' => function ($data) {
                                    if ($data->amount_payed != '') {
                                        return $data->amount_payed;
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'due_amount',
                                'label' => 'Balance',
                                'value' => function ($data) {
                                    return $data->due_amount;
                                },
                            ],
//                            [
//                                'attribute' => 'payment_status',
//                                'format' => 'raw',
//                                'filter' => [0 => 'Free', 1 => 'Open', 2 => 'Paid'],
//                                'value' => function ($data) {
//                                    if ($data->payment_status == 0) {
//                                        return 'Free';
//                                    } elseif ($data->payment_status == 1) {
//                                        return 'Open';
//                                    } elseif ($data->payment_status == 2) {
//                                        return 'Paid';
//                                    }
//                                },
//                            ],
//                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


