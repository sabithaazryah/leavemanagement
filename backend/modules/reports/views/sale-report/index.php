<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

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
                    <div class="row" style="margin-left: 0px;margin-right: 0px;background-color: #eae9e9;">
                        <div class="col-md-8">

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>
                        <div class="col-md-4">
                            <div class="sales-invoice-master-search" style="margin-right: 15px;float: right;">

                                <?= Html::beginForm(['sale-report/reports'], 'post', ['target' => 'print_popup', 'id' => "epda-form", 'style' => 'padding-top: 12px;margin-bottom: 0px;']) ?>
                                <input type="hidden" value="<?= $from ?>" name="from_date"/>
                                <input type="hidden" value="<?= $to ?>" name="to_date"/>
                                <?= Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank']) ?>

                                <?= Html::endForm() ?>

                            </div>
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
                            'tax_amount',
                            'order_amount',
//                            'ship_to_adress',
                        // 'amount_payed',
                        // 'due_amount',
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


