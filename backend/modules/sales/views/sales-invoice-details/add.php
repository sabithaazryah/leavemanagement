<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ItemMaster;
use common\models\Tax;
use common\models\Employee;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\EstimatedProforma */

$this->title = 'Sales Invoice';
$this->params['breadcrumbs'][] = ['label' => ' Pre-Funding', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if (isset($estimate)) {
    $estimate_master = common\models\SalesEstimateMaster::find()->where(['id' => $estimate])->one();
    $estimate_details = common\models\SalesEstimateDetails::find()->where(['sales_invoice_master_id' => $estimate])->all();
}
?>
<style>
    form .form-group.has-success .form-control:focus {
        border-color: #ffffff;
    }
    .form-group {
        margin-bottom: 0px;
    }
</style>
<script>
    $(document).ready(function () {
        var report_id = '<?php echo $report_id ?>';
        if (report_id != '') {
            window.open('<?= Yii::$app->homeUrl ?>sales/sales-estimate-details/report?id=' + report_id, 'print_popup', 'width=1200,height=500');
        }
    });
</script>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2  class="appoint-title panel-title"><?= Html::encode($this->title) . '</b>' ?></h2>
                <div class="diplay-amount"><i class="fa fa-inr" aria-hidden="true"></i> <span id="total-order-amount">00.00</span></div>
            </div>
            <?php //Pjax::begin();        ?>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Invoice</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="modal fade" id="modal-6">
                    <div class="modal-dialog modal-pop-up" id="modal-pop-up">

                    </div>
                </div>
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="fa fa-check" aria-hidden="true"></i><span style="padding-left:10px;"><?= Yii::$app->session->getFlash('success') ?>!</span></h4>
                    </div>
                <?php endif; ?>
                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><span style="padding-left:10px;"><?= Yii::$app->session->getFlash('error') ?>!</span></h4>
                    </div>
                <?php endif; ?>
                <?php $form = ActiveForm::begin(); ?>
                <div class="panel-body">
                    <input type="hidden" id="salesreturninvoicemaster-amount" class="form-control" name="SalesReturnInvoiceMaster[amount]" readonly="" aria-invalid="false">
                    <div class="row">
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?php
                            if ($model_sales_master->isNewRecord) {
                                $invoice_no = $this->context->generateInvoiceNo();
                                $model_sales_master->sales_invoice_number = $invoice_no;
                            }
                            ?>
                            <?= $form->field($model_sales_master, 'sales_invoice_number')->textInput(['maxlength' => true, 'readonly' => TRUE])->label('Invoice Number') ?>
                        </div>
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?php $customers = ArrayHelper::map(\common\models\BusinessPartner::findAll(['status' => 1, 'type' => 1]), 'id', 'name'); ?>
                            <?= $form->field($model_sales_master, 'busines_partner_code')->dropDownList($customers, ['prompt' => '-Choose a Customer-'])->label('Customer') ?>
                        </div>
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?= $form->field($model_sales_master, 'ship_to_adress')->textarea(['rows' => '1'])->label('Billing Address') ?>
                        </div>
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?= $form->field($model_sales_master, 'delivery_address')->textarea(['rows' => '1']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?= $form->field($model_sales_master, 'contact_number')->textInput(['maxlength' => true])->label('Contact Number') ?>
                        </div>
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?= $form->field($model_sales_master, 'po_no')->textInput(['maxlength' => true])->label('PO NO.') ?>
                        </div>
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?php
                            $model_sales_master->po_date = date('d-M-Y');
                            ?>
                            <?=
                            $form->field($model_sales_master, 'po_date')->widget(DatePicker::classname(), [
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-M-yyyy'
                                ]
                            ])->label('PO Date');
                            ?>
                        </div>
                        <div class='col-md-3 col-sm-6 col-xs-12'>
                            <?= $form->field($model_sales_master, 'email')->textInput(['maxlength' => true])->label('Email') ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="billing-hr">

            <div class="table-responsive form-control-new" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true" style="overflow: visible;">
                <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
                    <thead>
                        <tr>
                            <th data-priority="3">Item</th>
                            <th data-priority="6" style="width: 18%;">Qty</th>
                            <th data-priority="6" style="width: 8%;">RATE</th>
                            <th data-priority="6" style="width: 14%;">Discount</th>
                            <th data-priority="6" style="width: 14%;">Tax</th>
                            <th data-priority="6" style="width: 8%;">Amount</th>
                            <th data-priority="1" style="width: 1%;"></th>
                        </tr>
                        <tr>
                    </thead>
                    <tbody>
                    <input type="hidden" value="1" name="next_item_id" id="next_item_id"/>
                    <tr class="filter" id="item-row-1">
                        <td>
                            <?php $item_datas = ItemMaster::findAll(['status' => 1]); ?>
                            <select id="salesinvoicedetails-item_id-1" class="form-control salesinvoicedetails-item_id add-next" name="create[item_id][]">
                                <option value="">-Choose a Item-</option>
                                <?php foreach ($item_datas as $item_data) {
                                    ?>
                                    <option value="<?= $item_data->id ?>"><?= $item_data->item_name ?></option>
                                <?php }
                                ?>
                            </select>
                        </td>
                        <td>
                            <div class="form-group field-salesinvoicedetails-discount_percentage has-success">
                                <div class="row">
                                    <div class="col-md-6" style="padding-right:0px;">
                                        <input type="number" id="salesinvoicedetails-qty-1" value="" class="form-control salesinvoicedetails-qty" name="create[qty][]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  style="display:inline-block;width:75% ! important;">
                                    </div>
                                    <div class="col-md-6" style="padding-left:0px;">
                                        <select id="salesinvoicedetails-type-1" class="form-control salesinvoicedetails-type" name="create[type][]">
                                            <option value="1">Carton</option>
                                            <option value="2">Kg</option>
                                            <option value="1">Pieces</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group field-salesinvoicedetails-rate has-success">
                                <input type="number" id="salesinvoicedetails-rate-1" class="form-control salesinvoicedetails-rate" name="create[rate][]" placeholder="RATE" step="0.01" aria-invalid="false" autocomplete="off" value="<?= $estimate_detail->rate ?>" >
                            </div>
                        </td>
                        <td>
                            <div class="form-group field-salesinvoicedetails-discount_percentage has-success">
                                <div class="row">
                                    <div class="col-md-6" style="padding-right:0px;">
                                        <input type="number" id="salesinvoicedetails-discount_value-1" value="" class="form-control salesinvoicedetails-discount_value" name="create[discount_value][]" placeholder="Discount" min="1" aria-invalid="false" autocomplete="off"  style="display:inline-block;width:75% ! important;">
                                    </div>
                                    <div class="col-md-6" style="padding-left:0px;">
                                        <select id="salesinvoicedetails-discount_type-1" class="form-control salesinvoicedetails-discount_type" name="create[discount_type][]">
                                            <option value="1">Rs.</option>
                                            <option value="2">%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php
                        $taxes = Tax::findAll(['status' => 1]);
                        ?>
                        <td>
                            <div class="form-group field-salesinvoicedetails-tax has-success">

                                <select id="salesinvoicedetails-tax-1" class="form-control salesinvoicedetails-tax" name="create[tax_id][]" aria-invalid="false">
                                    <option value="">Slelect a Tax</option>
                                    <?php
                                    foreach ($taxes as $tax) {
                                        if ($tax->type == 0) {
                                            $type = '%';
                                        } else {
                                            $type = 'Rs';
                                        }
                                        ?>
                                        <option value="<?= $tax->id ?>" <?= $estimate_detail->tax_id == $tax->id ? "selected" : "" ?> ><?= $tax->name . ' - ' . $tax->value . ' ' . $type ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <input type="hidden" id="salesinvoicedetails-tax_value-1" value="" class="form-control salesinvoicedetails-tax_value" name="create[tax_value][]" >
                                <input type="hidden" id="salesinvoicedetails-tax_type-1" value="" class="form-control salesinvoicedetails-tax_type" name="create[tax_type][]" >
                            </div>
                        </td>
                        <td>
                            <div class="form-group field-salesinvoicedetails-line_total has-success">
                                <input type="text" id="salesinvoicedetails-line_total-1" value="" class="form-control salesinvoicedetails-line_total" name="create[line_total][]" placeholder="Amount" aria-invalid="false" autocomplete="off">
                            </div>
                        </td>
                        <td>
                            <a id="del" class="" ><i class="fa fa-times sales-invoice-delete"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
                    <thead>
                        <tr>
                            <th data-priority="3">Item Total</th>
                            <th data-priority="6" style="width: 18%;"><input type="text" id="qty_total" class="amount-receipt-1" name="qty_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 8%;"><input type="hidden" id="sub_total" class="amount-receipt-1" name="sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 14%;"><input type="text" id="discount_sub_total" class="amount-receipt-1"  name="discount_sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 14%;"><input type="text" id="tax_sub_total" class="amount-receipt-1"  name="tax_sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 8%;"><input type="text" id="order_sub_total" class="amount-receipt-1"  name="order_sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="1" style="width: 4%;"></th>
                        </tr>
                    <input type="hidden" id="amount_without_tax" class="amount-receipt-1" name="amount_without_tax" style="width: 100%;" readonly/>
                    </thead>
                </table>
            </div>
            <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Line</a>
            <div class="row">
                <div class="col-md-12">
                    <?php // Html::submitButton('Save & Print', ['class' => 'btn btn-secondary', 'name' => 'save-print', 'value' => 'save-print'])  ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-secondary', 'name' => 'save', 'value' => 'save', 'style' => 'float:right;']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>



        </div>
        <?php //Pjax::end();                          ?>
    </div>
</div>
<script>
    $(document).ready(function () {

        $(document).on('change', '#salesinvoicemaster-busines_partner_code', function () {
            $.ajax({
                type: 'POST',
                cache: false,
                data: {id: $(this).val()},
                url: '<?= Yii::$app->homeUrl; ?>sales/sales-invoice-details/customer-details',
                success: function (data) {
                    var res = $.parseJSON(data);
                    $("#salesinvoicemaster-ship_to_adress").val(res.result['billing_address']);
                    $("#salesinvoicemaster-delivery_address").val(res.result['delivery_address']);
                    $("#salesinvoicemaster-contact_number").val(res.result['contact_number']);
                    $("#salesinvoicemaster-email").val(res.result['email']);
                }
            });
        });

        $('#salesinvoicedetails-item_id-1').select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        $(document).on('change', '.salesinvoicedetails-item_id', function (e) {
            var current_row_id = $(this).attr('id').match(/\d+/); // 123456
            var next_row_id = $('#next_item_id').val();
            var item_id = $(this).val();
            itemChange(item_id, current_row_id, next_row_id);
        });

    });
    function itemChange(item_id, current_row_id, next_row_id) {
        var next = parseInt(next_row_id) + 1;
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {item_id: item_id, next_row_id: next_row_id},
            url: '<?= Yii::$app->homeUrl; ?>sales/sales-invoice-details/get-items',
            success: function (data) {
                var res = $.parseJSON(data);
                if (data != 0) {
                    if ($('#salesinvoicedetails-item_id-' + current_row_id).hasClass('add-next')) {
                        $('#add-invoicee tr:last').after(res.result['next_row_html']);
                        $("#next_item_id").val(next);
                        $('.salesinvoicedetails-qty').attr('type', 'number');
                        $('.salesinvoicedetails-qty').attr('min', 1);
                        $("#salesinvoicedetails-rate-" + current_row_id).val(res.result['item_rate']);
                        var iddd = '#salesinvoicedetails-tax-' + current_row_id;
                        $("" + iddd + " option[value='" + res.result['tax_id'] + "']").prop('selected', true);
                        $('#salesinvoicedetails-item_id-' + current_row_id).removeClass("add-next");
                        $('#salesinvoicedetails-item_id-' + next).select2({
                            allowClear: true
                        }).on('select2-open', function ()
                        {
                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        });
                        if ($('#salesinvoicedetails-qty-' + current_row_id).val() != "" && $("#salesinvoicedetails-rate-" + current_row_id).val() != "") {
                            lineTotalAmount(current_row_id);
                        }
                    }
                }
//                calculateSubtotal();
            }
        });
        return true;
    }
    function lineTotalAmount(current_row_id) {

        var tax_amount = 0;
        var discount_amount = 0;
        var qty = $('#salesinvoicedetails-qty-' + current_row_id).val();
        var tax_type = $('#salesinvoicedetails-tax-type-' + current_row_id).val();
        var rate = $('#salesinvoicedetails-rate-' + current_row_id).val();
        var tax = $('#salesinvoicedetails-tax-value-' + current_row_id).val();
        var discount = $('#salesinvoicedetails-discount_value-' + current_row_id).val();
        var discount_type = $('#salesinvoicedetails-discount_type-' + current_row_id).val();

        var amount = qty * rate;

        if (discount != "") {

            if (discount_type == 0) {
                var discount_amount = discount;
            } else {
                var discount_amount = (amount * discount) / 100;
            }
        }
        if (qty != "" && rate != "") {
            if (tax_type == 1) {
                var tax_amount = tax;
            } else {
                var total = (qty * rate) - discount_amount;
                var tax_amount = (total * tax) / 100;
            }

        }

        var grand_total = (parseFloat(amount) + parseFloat(tax_amount)) - parseFloat(discount_amount);
        $('#salesinvoicedetails-line_total-' + current_row_id).val(grand_total.toFixed(2));
//        calculateSubtotal();
    }
</script>
