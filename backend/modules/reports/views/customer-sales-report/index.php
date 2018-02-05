<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use common\models\SalesInvoiceMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalesInvoiceMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customer Sales Report';
$this->params['breadcrumbs'][] = $this->title;
$grand_total = 0;
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

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to, 'id' => $id]) ?>

                        </div>
                        <div class="col-md-6">
                            <div class="col-md-2">
                                <div class="sales-invoice-master-search" style="margin-right: 15px;float: left;">

                                    <?= Html::beginForm(['customer-sales-report/reports'], 'post', ['target' => 'print_popup', 'id' => "epda-form", 'style' => 'margin-bottom: 0px;']) ?>
                                    <input type="hidden" value="<?= $from ?>" name="from_date"/>
                                    <input type="hidden" value="<?= $to ?>" name="to_date"/>
                                    <input type="hidden" value="<?= $id ?>" name="customer_id"/>
                                    <?= Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank']) ?>

                                    <?= Html::endForm() ?>

                                </div>
                            </div>
                            <div class="col-md-10">
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="3">Report Summary</th>
                                    </tr>
                                    <tr>
                                        <th>Total Sale</th>
                                        <th>Total Amount</th>
                                        <th>Total Tax Amount</th>
                                    </tr>
                                    <?php
                                    $sale_total = SalesInvoiceMaster::getTotalCount($from, $to, $id);
                                    $amount_total = SalesInvoiceMaster::getSaleTotal($from, $to, $id, 'order_amount');
                                    $tax_total = SalesInvoiceMaster::getSaleTotal($from, $to, $id, 'tax_amount');
                                    ?>
                                    <tr>
                                        <th><?= $sale_total ?></th>
                                        <th><?= Yii::$app->SetValues->NumberFormat(round($amount_total, 2)) . ' (S$)'; ?></th>
                                        <th><?= Yii::$app->SetValues->NumberFormat(round($tax_total, 2)) . ' (S$)'; ?></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>Po.No.</th>
                                <th>Po.Date</th>
                                <th>Total Amount</th>
                                <th>Total GST</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?=
                            ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemView' => '_view2',
                                'viewParams' => ['from' => $from, 'to' => $to],
                            ]);
                            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


