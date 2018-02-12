<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
Use common\models\BaseUnit;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceDetails */

$this->title = $model->sales_invoice_number;
$this->params['breadcrumbs'][] = ['label' => 'Sales Invoice Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .appoint{
        width: 100%;
        background-color: #eeeeee;
    }
    .appoint .value{
        font-weight: bold;
        text-align: left;
    }
    .appoint .labell{
        text-align: left;
    }
    .appoint .colen{

    }
    .appoint td{
        padding: 10px;
    }
    table th{
        color:black;
    }
    table td{
        color:black;
    }
    .sales-master{
        margin-bottom: 40px;
    }
    .sales-details{
        margin-bottom: 40px;
    }
    h4{
        color: #2196F3;
    }
</style>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Invoice</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <?= Html::a('<i class="fa-print"></i><span> Print Invoice</span>', ['report', 'id' => $model->id], ['class' => 'btn btn-secondary btn-icon btn-icon-standalone', 'target' => '_blank']) ?>
                <?= Html::a('<i class="fa fa-envelope-o"></i><span> Send Invoice</span>', ['send-invoice', 'id' => $model->id], ['class' => 'btn btn-primary btn-icon btn-icon-standalone']) ?>
                <?= \common\widgets\Alert::widget(); ?>
                <div class="panel-body">
                    <div class="sales-master table-responsive">
                        <h4>Sales Invoice : <?= $model->sales_invoice_number; ?></h4>
                        <table class="appoint">
                            <tr>
                                <td class="labell">Sales Invoice Number </td><td class="colen">:</td><td class="value"> <?= $model->sales_invoice_number; ?></td>
                                <td class="labell">Sales Invoice Date</td><td class="colen">:</td><td class="value"><?= $model->sales_invoice_date; ?></td>
                                <td class="labell">Customer </td><td class="colen">:</td><td class="value"><?= \common\models\BusinessPartner::findOne(['id' => $model->busines_partner_code])->name; ?> </td>
                            </tr>
                            <tr>
                                <td class="labell">Salesman </td><td class="colen">:</td><td class="value"> <?= common\models\Employee::findOne(['id' => $model->salesman])->name; ?></td>
                                <td class="labell">Amount </td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->amount); ?></td>
                                <td class="labell">Discount</td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->discount_amount); ?></td>
                            </tr>
                            <tr>
                                <td class="labell">Round Of Amount </td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->round_of_amount); ?></td>
                                <td class="labell">GST </td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->tax_amount); ?></td>
                                <td class="labell">Total Amount </td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->order_amount); ?></td>
                            </tr>
                            <tr>
                                <td class="labell">Amount Paid </td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->amount_payed); ?></td>
                                <td class="labell">Due Amount </td><td class="colen">:</td><td class="value"> <?= sprintf('%0.2f', $model->due_amount); ?></td>
                                <td class="labell">Due Date </td><td class="colen">:</td><td class="value"> <?= $model->due_date; ?></td>
                            </tr>

                        </table>
                    </div>
                    <div class="sales-details">
                        <!--<h4>Sales Item Details</h4>-->
                        <table class="table table-bordered">
                            <tr>
                                <th>Item Name</th>
                                <th>Rate</th>
                                <th>KG Sold</th>
                                <th>Carton Sold</th>
                                <th>Pieces Sold</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>GST</th>
                                <th>Sale Amount</th>
                            </tr>
                            <?php
                            $amount_total = 0;
                            $discount_total = 0;
                            $tax_total = 0;
                            $line_total = 0;
                            foreach ($sales_details as $sales_detail) {
                                ?>
                                <tr>
                                    <td><?= $sales_detail->item_name; ?></td>
                                    <td><?= $sales_detail->rate; ?></td>
                                    <td><?= $sales_detail->qty; ?></td>
                                    <td><?= $sales_detail->carton; ?></td>
                                    <td><?= $sales_detail->pieces; ?></td>
                                    <td><?= $sales_detail->amount; ?></td>
                                    <td><?= $sales_detail->discount_amount; ?></td>
                                    <td><?= $sales_detail->tax_amount; ?></td>
                                    <td><?= $sales_detail->line_total; ?></td>
                                </tr>
                                <?php
                                $amount_total += $sales_detail->amount;
                                $discount_total += $sales_detail->discount_amount;
                                $tax_total += $sales_detail->tax_amount;
                                $line_total += $sales_detail->line_total;
                            }
                            ?>
                            <tr>
                                <td colspan="5">TOTAL</td>
                                <td><?= sprintf('%0.2f', $amount_total); ?></td>
                                <td><?= sprintf('%0.2f', $discount_total); ?></td>
                                <td><?= sprintf('%0.2f', $tax_total); ?></td>
                                <td><?= sprintf('%0.2f', $line_total); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


