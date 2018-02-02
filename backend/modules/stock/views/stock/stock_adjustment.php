<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ItemMaster;
use common\models\Locations;
use common\models\BusinessPartner;
use common\models\Country;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use common\models\Warehouse;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
$uom = '';
$show = 1;
$available_carton = 0;
$availabel_weight = 0;
$available_piece = 0;
if (isset($id) && $id != '') {
        $item = ItemMaster::findOne($model->item_id);
        if ($item->item_type == 1) {
                $uom = 'Kg';
                $show = 1;
        } else if ($item->item_type == 2) {
                $uom = 'Pieces';
                $show = 0;
        }
        $stock_view = common\models\StockView::find()->where(['batch_no' => $model->batch_no, 'item_id' => $model->item_id])->one();
        if (!empty($stock_view)) {
                $available_carton = $stock_view->available_carton;
                $availabel_weight = $stock_view->available_weight;
                $available_piece = $stock_view->available_pieces;
        }
}
?>




<div class="stock-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php if (isset($id) && $id != '') { ?>

                                <?= $form->field($model, 'item_name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                                <?= $form->field($model, 'item_id')->hiddenInput()->label(FALSE) ?>

                        <?php } else { ?>
                                <?php $items = ItemMaster::find()->where(['status' => 1])->all() ?>
                                <?= $form->field($model, 'item_id')->dropDownList(ArrayHelper::map($items, 'id', 'name'), ['prompt' => '--Select--', 'id' => 'stock-adjusted-item_id']) ?>

                        <?php } ?>
                        <input type="hidden" id="stock-adjustment-item-type" value="<?= $show ?>">
                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'item_code')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'uom')->textInput(['readonly' => true]) ?>

                </div>

                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'batch_no')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                </div>

                <?php if ($show == 1) { ?>
                        <div class='col-md-3 col-sm-6 col-xs-12 left_padd slaughter_date_from'>
                                <?php
                                if (!$model->isNewRecord) {
                                        $model->slaughter_date_from = date('d-m-Y', strtotime($model->slaughter_date_from));
                                } else {
                                        $model->slaughter_date_from = date('d-m-Y');
                                }
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'type' => DatePicker::TYPE_INPUT,
                                    'attribute' => 'slaughter_date_from',
                                    'readonly' => TRUE,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd-mm-yyyy',
                                    ]
                                ]);
                                ?>


                        </div>

                        <div class='col-md-3 col-sm-6 col-xs-12 left_padd slaughter_date_to'>
                                <?php
                                if (!$model->isNewRecord) {
                                        $model->slaughter_date_to = date('d-m-Y', strtotime($model->slaughter_date_to));
                                } else {
                                        $model->slaughter_date_to = date('d-m-Y');
                                }
                                echo DatePicker::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'type' => DatePicker::TYPE_INPUT,
                                    'readonly' => TRUE,
                                    'attribute' => 'slaughter_date_to',
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd-mm-yyyy',
                                    ]
                                ]);
                                ?>


                        </div>
                <?php } ?>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd '>
                        <?php
                        if (!$model->isNewRecord) {
                                $model->production_date = date('d-m-Y', strtotime($model->production_date));
                        } else {
                                $model->production_date = date('d-m-Y');
                        }
                        echo DatePicker::widget([
                            'model' => $model,
                            'form' => $form,
                            'type' => DatePicker::TYPE_INPUT,
                            'attribute' => 'production_date',
                            'readonly' => TRUE,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                            ]
                        ]);
                        ?>


                </div>

                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php
                        if (!$model->isNewRecord) {
                                $model->due_date = date('d-m-Y', strtotime($model->due_date));
                        } else {
                                $model->due_date = date('d-m-Y');
                        }
                        echo DatePicker::widget([
                            'model' => $model,
                            'form' => $form,
                            'type' => DatePicker::TYPE_INPUT,
                            'attribute' => 'due_date',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                            ]
                        ]);
                        ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'plant')->textInput(['maxlength' => true, 'readonly' => TRUE,]) ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $loactions = Locations::find()->where(['status' => 1])->all() ?>
                        <?= $form->field($model, 'location')->dropDownList(ArrayHelper::map($loactions, 'id', 'location_name'), ['prompt' => '--Select--', 'readonly' => TRUE,]) ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $warehouse = Warehouse::find()->where(['status' => 1])->all() ?>
                        <?= $form->field($model, 'warehouse')->dropDownList(ArrayHelper::map($warehouse, 'id', 'name'), ['prompt' => '--Select--', 'readonly' => TRUE,]) ?>

                </div>

                <?php $supplier = BusinessPartner::find()->where(['status' => 1, 'type' => 2])->all() ?>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'supplier')->dropDownList(ArrayHelper::map($supplier, 'id', 'company_name'), ['prompt' => '--Select--', 'readonly' => TRUE,]) ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $country = Country::find()->where(['status' => 1])->all() ?>
                        <?= $form->field($model, 'origin')->dropDownList(ArrayHelper::map($country, 'id', 'country_name'), ['prompt' => '--Select--', 'readonly' => TRUE,]) ?>

                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

                </div>
        </div>

        <div class="row" style="margin-left: 0">
                <h5 style="color: black;font-weight: bold">STOCK DETAILS</h5>
                <hr style="border-top: 1px solid #195faa;margin-top: 10px;"/>

        </div>

        <div class="row">

                <?php
                $model->pieces = $available_piece;
                if ($show == 1) {
                        $model->cartons = $available_carton;
                        $model->total_weight = $availabel_weight;
                        ?>
                        <div class='col-md-3 col-sm-6 col-xs-12 left_padd cartoons'>    <div class='col-md-9 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'cartons')->textInput(['readonly' => true]) ?>

                                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'><label class="labels">No's</label></div>

                        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd weight'> <div class='col-md-9 col-sm-6 col-xs-12 left_padd'>   <?= $form->field($model, 'total_weight')->textInput(['maxlength' => true, 'class' => 'form-control', 'readonly' => true]) ?>

                                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'><label class="labels">Kg</label></div>

                        </div>

                <?php } ?>

                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>   <div class='col-md-9 col-sm-6 col-xs-12 left_padd'> <?= $form->field($model, 'pieces')->textInput(['class' => 'form-control', 'readonly' => true]) ?>

                        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'><label class="labels">Pieces</label></div>

                </div>

                <?php if ($show == 1) { ?>

                        <div class='col-md-3 col-sm-6 col-xs-12 left_padd cartoons'>  <div class='col-md-9 col-sm-6 col-xs-12 left_padd'>   <?= $form->field($model, 'adjust_cartons')->textInput(['maxlength' => true]) ?>

                                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'><label class="labels stock">No's</label></div>

                        </div>


                        <div class='col-md-3 col-sm-6 col-xs-12 left_padd weight'>   <div class='col-md-9 col-sm-6 col-xs-12 left_padd'>   <?= $form->field($model, 'adjust_weight')->textInput(['maxlength' => true]) ?>

                                </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'><label class="labels available-stock"><?= $uom ?></label></div>

                        </div>

                <?php } ?>

                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>  <div class='col-md-9 col-sm-6 col-xs-12 left_padd'>   <?= $form->field($model, 'adjust_pieces')->textInput(['maxlength' => true]) ?>

                        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'><label class="labels closing-stock"><?= $uom ?></label></div>

                </div><div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'remarks')->textarea(['rows' => 1]) ?>

                </div>

        </div>
        <div class="row">
                <div class='col-md-12 col-sm-12 col-xs-12'>
                        <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
                        </div>
                </div>
        </div>
        <?php ActiveForm::end(); ?>

</div>

<script>
        $(document).ready(function () {
                $("#stock-item_id").select2({
                        //   placeholder: 'Select',
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });

                $('#stock-adjusted-item_id').change(function () {
                        var selected = $(this).val();
                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {selected: selected},
                                url: homeUrl + 'stock/stock/batches',
                                success: function (data) {
                                        $("#modal-pop-up").html(data);
                                        $('#modal-6').modal('show', {backdrop: 'static'});
                                }
                        });

                });

                $(document).on('click', '.choose-stock-batch', function () {
                        var stock_view_id = $(this).attr('id');
                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {stock_view_id: stock_view_id},
                                url: homeUrl + 'stock/stock/stock-view-details',
                                success: function (data) {
                                        var res = $.parseJSON(data);
                                        $("#stock-item_code").val(res['item_code']);
                                        $("#stock-price").val(res['price']);
                                        $("#stock-uom").val(res['UOM']);
                                        $("#stock-available_stock").val(res['available_stock']);
                                        $(".available-stock").html(res['unit_label']);
                                        $(".closing-stock").html(res['unit_label']);
                                        $(".stock").html(res['unit_label']);
                                        $("#stock-item-type").val(res['category']);
                                        $("#stock-batch_no").val(res['batch']);
                                        $("#stock-slaughter_date_from").val(res['slaughter_date_from']);
                                        $("#stock-slaughter_date_to").val(res['slaughter_date_to']);
                                        $("#stock-production_date").val(res['production_date']);
                                        $("#stock-due_date").val(res['due_date']);
                                        $("#stock-plant").val(res['plant']);
                                        $("#stock-location").val(res['location']);
                                        $("#stock-warehouse").val(res['warehouse']);
                                        $("#stock-supplier").val(res['supplier']);
                                        $("#stock-origin").val(res['origin']);
                                        $("#stock-cartons").val(res['cartoons']);
                                        $("#stock-total_weight").val(res['weight']);
                                        $("#stock-pieces").val(res['piecse']);
                                        if (res['category'] != 1) {
                                                $('.slaughter_date_from').hide();
                                                $('.slaughter_date_to').hide();
                                                $('.cartoons').hide();
                                                $('.weight').hide();
                                        } else {
                                                $('.slaughter_date_from').show();
                                                $('.slaughter_date_to').show();
                                                $('.cartoons').show();
                                                $('.weight').show();
                                        }
                                        $('#modal-6').hide();
                                }
                        });

                });

        });
</script>

<style>
        .labels{
                margin-top: 30px;
                font-weight: bold;
                color: #000;
        }
        .left_padd {
                height: 100px;
        }
</style>