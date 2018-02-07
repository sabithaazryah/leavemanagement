<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\SalesInvoiceDetails;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalesInvoiceMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Register';
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

                            <?= $this->render('_search', ['model' => $searchModel, 'from' => $from, 'to' => $to]) ?>

                        </div>
                        <div class="col-md-7">
                            <div class="col-md-2">
                                <div class="sales-invoice-master-search" style="margin-right: 15px;float: left;">

                                    <?= Html::beginForm(['stock-report/reports'], 'post', ['target' => 'print_popup', 'id' => "epda-form", 'style' => 'margin-bottom: 0px;']) ?>
                                    <input type="hidden" value="<?= $from ?>" name="from_date"/>
                                    <input type="hidden" value="<?= $to ?>" name="to_date"/>
                                    <?= Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank']) ?>

                                    <?= Html::endForm() ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'document_date',
                            'item_code',
                            'item_name',
                            [
                                'attribute' => 'transaction',
                                'attribute' => 'Type',
                                'value' => function ($model) {
                                    if ($model->transaction == 1) {
                                        return 'Opening Stock';
                                    } elseif ($model->transaction == 2) {
                                        return 'Stock Adjustment';
                                    } elseif ($model->transaction == 3) {
                                        return 'Stock Sale';
                                    } else {
                                        return '';
                                    }
                                },
                            ],
                            [
                                'attribute' => 'price',
                                'value' => function ($model) {
                                    $info = \common\models\ItemMaster::findOne(['id' => $model->item_id]);

                                    return isset($info->MRP) ? $info->MRP : '';
                                },
                            ],
                            [
                                'attribute' => 'batch_no',
                                'value' => function ($model) {
                                    return isset($model->batch_no) ? $model->batch_no : '';
                                },
                            ],
                            [
                                'attribute' => 'weight_in',
                                'value' => function ($model) {
                                    return isset($model->weight_in) ? $model->weight_in : '';
                                },
                            ],
                            [
                                'attribute' => 'weight_out',
                                'value' => function ($model) {
                                    return isset($model->weight_out) ? $model->weight_out : '';
                                },
                            ],
                            [
                                'attribute' => 'cartoon_in',
                                'label' => 'Cartons In',
                                'value' => function ($model) {
                                    return isset($model->cartoon_in) ? $model->cartoon_in : '';
                                },
                            ],
                            [
                                'attribute' => 'cartoon_out',
                                'label' => 'Cartons Out',
                                'value' => function ($model) {
                                    return isset($model->cartoon_out) ? $model->cartoon_out : '';
                                },
                            ],
                            [
                                'attribute' => 'piece_in',
                                'value' => function ($model) {
                                    return isset($model->piece_in) ? $model->piece_in : '';
                                },
                            ],
                            [
                                'attribute' => 'piece_out',
                                'value' => function ($model) {
                                    return isset($model->piece_out) ? $model->piece_out : '';
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


