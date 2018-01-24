<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalesInvoiceMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Invoice Masters';
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
                                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                        <?= Html::a('<i class="fa-th-list"></i><span> Create Sales Invoice Master</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn'],
//                                                'id',
                                                'sales_invoice_number',
                                                'sales_invoice_date',
                                                'order_type',
//                                                'busines_partner_code',
                                                // 'salesman',
                                                // 'payment_terms',
                                                // 'delivery_terms',
                                                // 'amount',
                                                // 'tax_amount',
                                                // 'order_amount',
                                                // 'ship_to_adress',
                                                // 'amount_payed',
                                                // 'due_amount',
                                                [
                                                    'attribute' => 'payment_status',
                                                    'format' => 'raw',
                                                    'filter' => [0 => 'Free', 1 => 'Open', 2 => 'Paid'],
                                                    'value' => function ($data) {
                                                            if ($data->payment_status == 0) {
                                                                    return 'Free';
                                                            } elseif ($data->payment_status == 1) {
                                                                    return 'Open';
                                                            } elseif ($data->payment_status == 2) {
                                                                    return 'Paid';
                                                            }
                                                    },
                                                ],
//                                                'payment_status',
                                                // 'reference',
                                                // 'error_message',
                                                // 'status',
                                                // 'CB',
                                                // 'UB',
                                                // 'DOC',
                                                // 'DOU',
                                                ['class' => 'yii\grid\ActionColumn'],
                                            ],
                                        ]);
                                        ?>
                                </div>
                        </div>
                </div>
        </div>
</div>


