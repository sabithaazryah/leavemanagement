<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sales Invoice Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">
                                <?=  Html::a('<i class="fa-th-list"></i><span> Manage Sales Invoice Master</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                <div class="panel-body"><div class="sales-invoice-master-view">
                                                <p>
                                                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                                                        'class' => 'btn btn-danger',
                                                        'data' => [
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                        'method' => 'post',
                                                        ],
                                                        ]) ?>
                                                </p>

                                                <?= DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                            'id',
            'sales_invoice_number',
            'sales_invoice_date',
            'order_type',
            'busines_partner_code',
            'salesman',
            'payment_terms',
            'delivery_terms',
            'general_terms:ntext',
            'amount',
            'tax_amount',
            'order_amount',
            'ship_to_adress',
            'discount_amount',
            'cash_amount',
            'card_amount',
            'round_of_amount',
            'amount_payed',
            'due_amount',
            'due_date',
            'payment_status',
            'reference',
            'receipt_id',
            'receipt_no',
            'goods_total',
            'service_total',
            'error_message',
            'status',
            'CB',
            'UB',
            'DOC',
            'DOU',
                                                ],
                                                ]) ?>
</div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>


