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
                            <?= $form->field($model, 'busines_partner_code')->dropDownList($customers, ['prompt' => '-Choose a Customer-'])->label('Customer') ?>
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
                <?php
                $items = ArrayHelper::map(ItemMaster::find()->where(['status' => 1])->all(), 'id', 'item_name');
                ?>
                <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
                    <thead>
                        <tr>
                            <th data-priority="3">Item</th>
                            <th data-priority="6" style="width: 10%;">Qty</th>
                            <th data-priority="6" style="width: 8%;">RATE</th>
                            <th data-priority="6" style="width: 12%;">Discount</th>
                            <th data-priority="6" style="width: 14%;">Tax</th>
                            <th data-priority="6" style="width: 8%;">Amount</th>
                            <th data-priority="1" style="width: 1%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($estimate_details)) {
                            $next_count = count($estimate_details) + 1;
                        } else {
                            $next_count = 1;
                        }
                        ?>
                    <input type="hidden" value="<?= $next_count ?>" name="next_item_id" id="next_item_id"/>
                    <input type="hidden" value="1" name="bill-type" id="bill_type"/>
                    <?php
                    if (!empty($estimate_details)) {
                        $i = 1;
                        foreach ($estimate_details as $estimate_detail) {
                            ?>
                            <tr class="filter" id="item-row-<?= $i ?>">

                                <td>
                                    <?= $form->field($model, 'item_id')->dropDownList($items, ['prompt' => '-Choose a Item-'])->label(FALSE) ?>
                                </td>
                                <td>
                                    <div class="form-group field-salesinvoicedetails-qty has-success">
                                        <?php
                                        $avail_qty = $this->context->calculateQty($estimate_detail->item_id);
                                        ?>
                                        <input type="number" id="salesinvoicedetails-qty-<?= $i ?>" value="<?= $avail_qty > $estimate_detail->qty ? $estimate_detail->qty : $avail_qty ?>" class="form-control salesinvoicedetails-qty" name="SalesInvoiceDetailsQty[<?= $i ?>]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  style="display:inline-block;width:75% ! important;">
                                        <span id="sale-uom-<?= $i ?>" style="float:right;padding: 8px 10px 0px 0px;"><?= common\models\BaseUnit::findOne($estimate_detail->base_unit)->value ?></span>
                                        <?php if ($avail_qty < $estimate_detail->qty) { ?>
                                            <div style="padding: 0px 10px;color: red;">Insufficient qty,</div>
                                            <div style="padding: 0px 10px;color: red;">qty adjusted,</div>
                                        <?php }
                                        ?>
                                        <div class="help-block"></div>
                                    </div>
                                    <div class="stock-check" id="stock-check-<?= $i ?>" style="display:none;">
                                        <p style="text-align: center;font-weight: bold;color: black;">Stock :<span class="stock-exist" id="stock-exist-<?= $i ?>"></span></p>
                                    </div>
                                    <input type="hidden" value="<?= common\models\BaseUnit::findOne($estimate_detail->base_unit)->value ?>" placeholder="UOM" class="form-control" id="sales-uom-<?= $i ?>" name="sales-uom[<?= $i ?>]" readonly/>
                                    <input type="hidden" value="<?= $avail_qty ?>"  class="form-control" id="sales-qty-count-<?= $i ?>" name="sales_qty_count[<?= $i ?>]" readonly/>
                                </td>
                            <input type="hidden" value="" placeholder="" class="form-control" id="tax-type-<?= $i ?>" name="tax-type[<?= $i ?>]" readonly/>
        <!--                        <td>
                                <span id="sale-uom-1"></span>
                                <input type="hidden" value="" placeholder="UOM" class="form-control" id="sales-uom-1" name="sales-uom[1]" readonly/>
                            <?php // $form->field($model, 'item_name')->textInput(['placeholder' => 'UOM'])->label(false)               ?>
                            </td>-->
                            <td>
                                <div class="form-group field-salesinvoicedetails-rate has-success">
                                    <input type="number" id="salesinvoicedetails-rate-<?= $i ?>" class="form-control salesinvoicedetails-rate" name="SalesInvoiceDetailsRate[<?= $i ?>]" placeholder="RATE" step="0.01" aria-invalid="false" autocomplete="off" value="<?= $estimate_detail->rate ?>" >
                                                                    <!--<input type="text" id="salesinvoicedetails-rate-1" class="form-control salesinvoicedetails-rate" name="SalesInvoiceDetailsRate[1]" placeholder="RATE" aria-invalid="false" autocomplete="off">-->

                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group field-salesinvoicedetails-discount_percentage has-success">
                                    <div class="row">
                                        <div class="col-md-6" style="padding-right:0px;">
                                            <input type="text" id="salesinvoicedetails-discount-<?= $i ?>" class="form-control salesinvoicedetails-discount" name="SalesInvoiceDetailsDiscountValue[<?= $i ?>]" value="<?= $estimate_detail->discount_value ?>" aria-invalid="false" autocomplete="off">
                                        </div>
                                        <div class="col-md-6" style="padding-left:0px;">
                                            <select id="salesinvoicedetails-discount-type-<?= $i ?>" class="form-control salesinvoicedetails-discount-type" name="SalesInvoiceDetailsDiscountType[<?= $i ?>]">
                                                <option value="0" <?= $estimate_detail->discount_type == 0 ? "selected" : "" ?> > Rs </option>
                                                <option value="1"<?= $estimate_detail->discount_type == 1 ? "selected" : "" ?> > % </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <?php
                            $taxes = Tax::findAll(['status' => 1]);
                            ?>
                            <td>
                                <div class="form-group field-salesinvoicedetails-tax has-success">

                                    <select id="salesinvoicedetails-tax-<?= $i ?>" class="form-control salesinvoicedetails-tax" name="SalesInvoiceDetailsTax[<?= $i ?>]" aria-invalid="false">
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

                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <input type="hidden" value="<?= $estimate_detail->tax_type ?>" placeholder="" class="form-control" id="salesinvoicedetails-tax-type-<?= $i ?>" name="salesinvoicedetails-tax-type[<?= $i ?>]" readonly/>
                            <input type="hidden" value="<?= $estimate_detail->tax_percentage ?>" placeholder="" class="form-control" id="salesinvoicedetails-tax-value-<?= $i ?>" name="salesinvoicedetails-tax-value[<?= $i ?>]" readonly/>
                            <td>
                                <div class="form-group field-salesinvoicedetails-line_total has-success">

                                    <input type="text" id="salesinvoicedetails-line_total-<?= $i ?>" value="<?= $estimate_detail->line_total ?>" class="form-control salesinvoicedetails-line_total" name="SalesInvoiceDetailsLineTotal[<?= $i ?>]" placeholder="Amount" aria-invalid="false" autocomplete="off">

                                    <div class="help-block"></div>
                                </div>
                            </td>
                            <td>
                                <a id="del" class="" ><i class="fa fa-times sales-invoice-delete"></i></a>
                            </td>


                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                    <tr class="filter" id="item-row-<?= $next_count ?>">

                        <td>
                            <div class="form-group field-salesinvoicedetails-item_code has-success">
                                <div class="form-group field-stockadjdtl-item_code has-success">
                                    <select id="stockadjdtl-item_code-1" class="form-control stockadjdtl-item_code add-next" name="StockAdjDtlItemId[1]" aria-invalid="false">
                                        <option value="">-Choose a Item-</option>
                                        <?php foreach ($items as $value) { ?>
                                            <option value="<?= $value->id ?>"><?= $value->item_name ?></option>
                                        <?php }
                                        ?>
                                    </select>

                                    <div class="help-block"></div>
                                </div>
                            </div>

                        </td>
                        <td>
                            <div class="form-group field-salesinvoicedetails-qty has-success">

                                <input type="number" id="salesinvoicedetails-qty-<?= $next_count ?>" class="form-control salesinvoicedetails-qty" name="SalesInvoiceDetailsQty[<?= $next_count ?>]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  style="display:inline-block;width:75% ! important;">
                                <span id="sale-uom-<?= $next_count ?>" style="float:right;padding: 8px 10px 0px 0px;"></span>
                                <div class="help-block"></div>
                            </div>
                            <div class="stock-check" id="stock-check-1" style="display:none;">
                                <p style="text-align: center;font-weight: bold;color: black;">Stock :<span class="stock-exist" id="stock-exist-1"></span></p>
                            </div>
                            <input type="hidden" value="" placeholder="UOM" class="form-control" id="sales-uom-<?= $next_count ?>" name="sales-uom[<?= $next_count ?>]" readonly/>
                            <input type="hidden" value=""  class="form-control" id="sales-qty-count-<?= $next_count ?>" name="sales_qty_count[<?= $next_count ?>]" readonly/>
                        </td>
                    <input type="hidden" value="" placeholder="" class="form-control" id="tax-type-<?= $next_count ?>" name="tax-type[<?= $next_count ?>]" readonly/>
<!--                        <td>
                        <span id="sale-uom-1"></span>
                        <input type="hidden" value="" placeholder="UOM" class="form-control" id="sales-uom-1" name="sales-uom[1]" readonly/>
                    <?php // $form->field($model, 'item_name')->textInput(['placeholder' => 'UOM'])->label(false)                ?>
                    </td>-->
                    <td>
                        <div class="form-group field-salesinvoicedetails-rate has-success">
                            <input type="number" id="salesinvoicedetails-rate-<?= $next_count ?>" class="form-control salesinvoicedetails-rate" name="SalesInvoiceDetailsRate[<?= $next_count ?>]" placeholder="RATE" step="0.01" aria-invalid="false" autocomplete="off" >
                                                            <!--<input type="text" id="salesinvoicedetails-rate-1" class="form-control salesinvoicedetails-rate" name="SalesInvoiceDetailsRate[1]" placeholder="RATE" aria-invalid="false" autocomplete="off">-->

                            <div class="help-block"></div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group field-salesinvoicedetails-discount_percentage has-success">
                            <div class="row">
                                <div class="col-md-6" style="padding-right:0px;">
                                    <input type="text" id="salesinvoicedetails-discount-<?= $next_count ?>" class="form-control salesinvoicedetails-discount" name="SalesInvoiceDetailsDiscountValue[<?= $next_count ?>]" value="0" aria-invalid="false" autocomplete="off">
                                </div>
                                <div class="col-md-6" style="padding-left:0px;">
                                    <select id="salesinvoicedetails-discount-type-<?= $next_count ?>" class="form-control salesinvoicedetails-discount-type" name="SalesInvoiceDetailsDiscountType[<?= $next_count ?>]">
                                        <option value="0"> Rs </option>
                                        <option value="1"> % </option>
                                    </select>
                                </div>
                            </div>
                            <div class="help-block"></div>
                        </div>
                    </td>
                    <?php
                    $taxes = Tax::findAll(['status' => 1]);
                    ?>
                    <td>
                        <div class="form-group field-salesinvoicedetails-tax has-success">

                            <select id="salesinvoicedetails-tax-<?= $next_count ?>" class="form-control salesinvoicedetails-tax" name="SalesInvoiceDetailsTax[<?= $next_count ?>]" aria-invalid="false">
                                <option value="">Slelect a Tax</option>
                                <?php
                                foreach ($taxes as $tax) {
                                    if ($tax->type == 0) {
                                        $type = '%';
                                    } else {
                                        $type = 'Rs';
                                    }
                                    ?>
                                    <option value="<?= $tax->id ?>"><?= $tax->name . ' - ' . $tax->value . ' ' . $type ?></option>
                                <?php }
                                ?>
                            </select>

                            <div class="help-block"></div>
                        </div>
                    </td>
                    <input type="hidden" value="" placeholder="" class="form-control" id="salesinvoicedetails-tax-type-<?= $next_count ?>" name="salesinvoicedetails-tax-type[<?= $next_count ?>]" readonly/>
                    <input type="hidden" value="" placeholder="" class="form-control" id="salesinvoicedetails-tax-value-<?= $next_count ?>" name="salesinvoicedetails-tax-value[<?= $next_count ?>]" readonly/>
                    <td>
                        <div class="form-group field-salesinvoicedetails-line_total has-success">

                            <input type="text" id="salesinvoicedetails-line_total-<?= $next_count ?>" class="form-control salesinvoicedetails-line_total" name="SalesInvoiceDetailsLineTotal[<?= $next_count ?>]" placeholder="Amount" aria-invalid="false" autocomplete="off">

                            <div class="help-block"></div>
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
                            <th data-priority="6" style="width: 10%;"><input type="text" id="qty_total" class="amount-receipt-1" name="qty_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 8%;"><input type="hidden" id="sub_total" class="amount-receipt-1" name="sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 12%;"><input type="text" id="discount_sub_total" class="amount-receipt-1"  name="discount_sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 14%;"><input type="text" id="tax_sub_total" class="amount-receipt-1"  name="tax_sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="6" style="width: 8%;"><input type="text" id="order_sub_total" class="amount-receipt-1"  name="order_sub_total" style="width: 100%;" readonly/></th>
                            <th data-priority="1" style="width: 1%;"></th>
                        </tr>
                    <input type="hidden" id="amount_without_tax" class="amount-receipt-1" name="amount_without_tax" style="width: 100%;" readonly/>
                    </thead>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php // Html::submitButton('Save & Print', ['class' => 'btn btn-secondary', 'name' => 'save-print', 'value' => 'save-print']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-secondary', 'name' => 'save', 'value' => 'save', 'style' => 'float:right;']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>



        </div>
        <?php //Pjax::end();                         ?>
    </div>
</div>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/sales-invoice/auto-complete.js"></script>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/sales-invoice/invoice.js"></script>

<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/sales-invoice/pop-up.js"></script>
<!-- Imported scripts on this page -->
<script src="<?= Yii::$app->homeUrl ?>js/inputmask/jquery.inputmask.bundle.js"></script>
<script>
    $(document).ready(function () {

        $(document).on('change', '#salesinvoicedetails-busines_partner_code', function () {
            $.ajax({
                type: 'POST',
                cache: false,
                data: {id: $(this).val()},
                url: '<?= Yii::$app->homeUrl; ?>sales/sales-invoice-details/customer-details',
                success: function (data) {
                    $('#purchaseordermst-address').val(data);
                }
            });
        });
    });
</script>
