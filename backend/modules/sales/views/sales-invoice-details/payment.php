<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceDetails */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = ['label' => 'Sales Invoice Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <?php if (!empty($payment_details)) { ?>
                    <h4 class="control-label">Payment History</h4>
                    <div class="paym-history">
                        <table class="table table-bordered">
                            <tr>
                                <th>Invoice Number</th>
                                <th>Payment Date</th>
                                <th>Amount</th>
                            </tr>
                            <?php
                            foreach ($payment_details as $payment_detail) {
                                ?>
                                <tr>
                                    <td><?= $payment_detail->invoice_number ?></td>
                                    <td><?= $payment_detail->payment_date ?></td>
                                    <td><?= $payment_detail->amount ?></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </div>
                <?php }
                ?>
                <div class="panel-body">
                    <div class="sales-invoice-details-create">
                        <?=
                        $this->render('payment_form', [
                            'model' => $model,
                            'sale' => $sale,
                        ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

