<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ItemMaster;
use common\models\Tax;
use common\models\Employee;
use yii\jui\DatePicker;

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
                    <div class="sales-invoice-master-create">
                        <div class="sales-invoice-master-form form-inline">

                            <div class='col-md-6 col-sm-6 col-xs-12' style="padding-left: 0px;">
                                <div class="form-group">
                                    <label class="control-label" for="salesreturninvoicedetails-busines_partner_code">Customer</label>
                                    <div class="frmSearch auto-search" id="auto-complete" >
                                        <div class="search-drop">
                                            <span>
                                                <span class="selected-data-name partner_name" data_val="<?= $default_partner->id ?>"><?= $default_partner->name . ' - ' . $default_partner->business_partner_code ?></span>
                                                <span class="arrow-control"><i class="fa arrow" aria-hidden="true"></i></span>
                                            </span>
                                            <!--<input type="text" id="salesinvoicedetails-busines_partner_code" placeholder="Partner Name" />-->
                                        </div>
                                        <div id="" class="suggesstion-box">
                                            <div class="row suggesstion-box-sub">
                                                <div class="col-md-12 search-link-box">
                                                    <input type="text" id="" class="form-control serch-text" placeholder="Partner Name" />
                                                </div>
                                                <div class="col-md-12>">
                                                    <ul id="" class="search-resut-list">
                                                        <li style="text-align: center;height: 85px;margin-top: 9%;background-color: white;">
                                                            <img style="width: 24%;" src="<?= Yii::$app->homeUrl; ?>images/loading_dots.gif" />
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-12 new-link-box" id="" partner-type="0"><a href="" class="pop-up-link">+ Add New Partner</a></div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?= $default_partner->id ?>" placeholder="" class="form-control salesinvoicedetails-item_code hideen-value" id="salesreturninvoicedetails-busines_partner_code" name="SalesInvoiceDetails[busines_partner_code]" readonly/>
                                    </div>
                                    <div class="help-block"></div>
                                </div>

                            </div>
                            <div class='col-md-3 col-sm-6 col-xs-12'>
                                <?php
                                if (!empty($estimate_master)) {
                                    $default_salesman = Salesman::findOne(['id' => $estimate_master->salesman])->id;
                                } else {
                                    $default_salesman = Salesman::findOne(['type' => 1])->id;
                                }
                                ?>
                                <?=
                                $form->field($model_sales_master, 'salesman')->dropDownList(
                                        ArrayHelper::map(Salesman::find()->where(['status' => 1])->all(), 'id', 'name'), ['options' => [$default_salesman => ['selected' => true]]])
                                ?>
                                <?php // $form->field($model_sales_master, 'salesman')->textInput(['maxlength' => true])  ?>

                            </div>

                            <?php
                            $serial_no = \common\models\SerialNumber::find()->orderBy(['id' => SORT_DESC])->where(['transaction' => 0])->one();
                            $sales_invoice_number = $serial_no->prefix . '-' . $serial_no->sequence_no;
                            $new_invoice_number = $this->context->generateInvoice($serial_no->prefix, $serial_no->sequence_no);
                            $model_sales_master->sales_invoice_number = $new_invoice_number;
                            ?>
                            <div class='col-md-3 col-sm-6 col-xs-12'>
                                <div class="form-group field-salesreturninvoicemaster-sales_invoice_number">
                                    <label class="control-label" for="salesreturninvoicemaster-sales_invoice_number">Invoice Number</label>
                                    <input type="text" id="salesreturninvoicemaster-sales_invoice_number" class="form-control salesreturninvoicemaster-sales_invoice_number" name="SalesInvoiceMaster[sales_invoice_number]" value="<?= $model_sales_master->sales_invoice_number ?>" readonly="true" maxlength="50" aria-invalid="false">
                                    <div class="sales-invoive-no-change" id="sales-invoive-no-change" invoice-type="0" ><a href="" id="sales-invoive-no-text">Change Invoice Number</a></div>
                                    <div class="help-block"></div>
                                </div>
                            </div>
                            <input type="hidden" value="1" name="invoice_transaction_id" id="invoice_transaction_id"/>
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            $current_date = date("d-m-Y h:i");
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label class="control-label control-label1" for="formation-date" >Invoice Date</label>
                                <input type="text" id="invoice_dates" class="form-control"  data-mask="datetime"name="sales_invoice_date" value="<?= $current_date ?>"/>
                            </div>

                            <div class='col-md-4 col-sm-6 col-xs-12'>
                                <?php
                                if (!empty($estimate_master)) {
                                    if (isset($estimate_master->reference) && $estimate_master->reference != '') {
                                        $model_sales_master->reference = $estimate_master->reference;
                                    }
                                }
                                ?>
                                <?= $form->field($model_sales_master, 'reference')->textInput(['maxlength' => true]) ?>

                            </div>

                        </div>
                    </div>
                </div>

                <hr class="billing-hr">

                <div class="table-responsive form-control-new" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true" style="overflow: visible;">
                    <?php
                    $items = ArrayHelper::map(ItemMaster::find()->where(['status' => 1])->all(), 'SKU', 'SKU');
                    ?>
                    <table cellspacing="0" class="table table-small-font table-bordered table-striped" id="add-invoicee">
                        <thead>
                            <tr>
                                <th data-priority="3">Item</th>
                                <th data-priority="6" style="width: 10%;">Qty</th>
                                <!--<th data-priority="6" style="width: 5%;">UOM</th>-->
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
                                        <div class="form-group field-salesinvoicedetails-item_code has-success">

                                            <div class="frmSearch auto-search auto-complete-item" id="auto-complete<?= $i ?>" style="position: relative;" afterfunction="">
                                                <div class="search-drop" style="text-align: left;" id="salesinvoicedetails-itemss-<?= $i ?>">
                                                    <input type="text" id="salesinvoicedetails-items-<?= $i ?>" class="form-control selected-data-name salesinvoicedetails-items" placeholder="Select Item" itemid="<?= $i ?>" data_val="<?= $estimate_detail->item_id ?>" autocomplete="off"  value="<?= $estimate_detail->item_code ?> - <?= $estimate_detail->item_name ?>"/>
                                                </div>
                                                <input type="text" value="" placeholder="Description" class="form-control salesinvoicedetails-item_comment bill-comment" id="salesinvoicedetails-item-comment-<?= $i ?>" name="SalesInvoiceDetailsItemComment[<?= $i ?>]" autocomplete="off" style="display:none;"/>
                                                <div id="" class="suggesstion-box">
                                                    <div class="row suggesstion-box-sub">
                                                        <div class="col-md-12>">
                                                            <ul id="" class="search-resut-list">
                                                                <li style="text-align: center;height: 85px;margin-top: 9%;background-color: white;">
                                                                    <img style="width: 24%;" src="<?= Yii::$app->homeUrl; ?>images/loading_dots.gif" />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <a href="" class="item-pop-up-link" id="item-<?= $i ?>"><div class="col-md-12 new-link-box">+ Add New Item</div></a>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="<?= $estimate_detail->item_id ?>" placeholder="" class="form-control salesinvoicedetails-item_code hideen-value" id="salesinvoicedetails-item-code-<?= $i ?>" name="SalesInvoiceDetailsItem[<?= $i ?>]" readonly/>
                                            </div>
                                        </div>

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
                                <?php // $form->field($model, 'item_name')->textInput(['placeholder' => 'UOM'])->label(false)              ?>
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

                                    <div class="frmSearch auto-search auto-complete-item" id="auto-complete<?= $next_count ?>" style="position: relative;" afterfunction="">
                                        <div class="search-drop" style="text-align: left;" id="salesinvoicedetails-itemss-<?= $next_count ?>">
                                            <input type="text" id="salesinvoicedetails-items-<?= $next_count ?>" class="form-control selected-data-name salesinvoicedetails-items add-next" placeholder="Select Item" itemid="<?= $next_count ?>" data_val="" autocomplete="off"/>
                                        </div>
                                        <input type="text" value="" placeholder="Description" class="form-control salesinvoicedetails-item_comment bill-comment" id="salesinvoicedetails-item-comment-<?= $next_count ?>" name="SalesInvoiceDetailsItemComment[<?= $next_count ?>]" autocomplete="off" style="display:none;"/>
                                        <div id="" class="suggesstion-box">
                                            <div class="row suggesstion-box-sub">
                                                <div class="col-md-12>">
                                                    <ul id="" class="search-resut-list">
                                                        <li style="text-align: center;height: 85px;margin-top: 9%;background-color: white;">
                                                            <img style="width: 24%;" src="<?= Yii::$app->homeUrl; ?>images/loading_dots.gif" />
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="" class="item-pop-up-link" id="item-<?= $next_count ?>"><div class="col-md-12 new-link-box">+ Add New Item</div></a>
                                            </div>
                                        </div>
                                        <input type="hidden" value="" placeholder="" class="form-control salesinvoicedetails-item_code hideen-value" id="salesinvoicedetails-item-code-<?= $next_count ?>" name="SalesInvoiceDetailsItem[<?= $next_count ?>]" readonly/>
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
                        <?php // $form->field($model, 'item_name')->textInput(['placeholder' => 'UOM'])->label(false)               ?>
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
                <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Line</a>
                <hr class="billing-hr">
                <div class="panel-body">
                    <div class="sales-invoice-master-create">
                        <div class="sales-invoice-master-form form-inline">

                            <div class='col-md-4 col-sm-6 col-xs-12'>
                                <?= $form->field($model_sales_master, 'general_terms')->textarea(['rows' => '6']) ?>
                            </div>


                            <div class='col-md-4 col-sm-6 col-xs-12' style="float:right;padding-right: 0px;">
                                <table cellspacing="0" class="table table-small-font table-bordered table-striped" style="float:right;text-align: left;">
                                <!--<table style="float:right;text-align: left;">-->
                                    <tr>
                                        <td>Round off</td>
                                        <td><input type="text" id="round_of" class="amount-receipt"  name="round_of" style="width: 100%;" autocomplete="off" value="<?= sprintf('%0.2f', 0); ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Cash</td>
                                        <td><input type="text" id="cash_amount" class="amount-receipt"  name="cash_amount" style="width: 100%;" autocomplete="off" value="<?= sprintf('%0.2f', 0); ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Card</td>
                                        <td><input type="text" id="card_amount" class="amount-receipt"  name="card_amount" style="width: 100%;" autocomplete="off" value="<?= sprintf('%0.2f', 0); ?>"/></td>
                                    </tr>

                                    <tr>
                                        <td>Amount Paid</td>
                                        <td><input type="text" id="payed_amount" class="amount-receipt"  name="payed_amount" style="width: 100%;" readonly/></td></td>
                                    </tr>
                                    <tr>
                                        <td>Balance</td>
                                        <td><input type="text" id="balance" class="amount-receipt"  name="balance" style="width: 100%;" readonly/></td>
                                        <!--<td><span id="balance"></span></td>-->
                                    </tr>
                                    <tr class="due-date-row">
                                        <td>Due Date</td>
                                        <td>
                                            <?php
                                            echo DatePicker::widget([
                                                'name' => 'due_date',
                                                'id' => 'due-date',
                                                'value' => date('d-m-Y'),
                                                'dateFormat' => 'dd-MM-yyyy',
                                                'options' => ['class' => 'form-control']
                                            ]);
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div style="float:right;">
                    <?= Html::submitButton('Save & Print', ['class' => 'btn btn-secondary', 'name' => 'save-print', 'value' => 'save-print']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-secondary', 'name' => 'save', 'value' => 'save']) ?>
                </div>

                <?php ActiveForm::end(); ?>



            </div>
            <?php //Pjax::end();                        ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/sales-invoice/auto-complete.js"></script>
<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/sales-invoice/invoice.js"></script>

<script type="text/javascript" src="<?= Yii::$app->homeUrl ?>js/sales-invoice/pop-up.js"></script>
<!-- Imported scripts on this page -->
<script src="<?= Yii::$app->homeUrl ?>js/inputmask/jquery.inputmask.bundle.js"></script>
<script>
    $(document).ready(function () {
        var next_count = '<?php echo $next_count; ?>';
        $("#auto-complete").select({
            id: "auto-complete",
            method_name: "item-partner",
        });
        $("#auto-complete" + next_count).select({
            id: "auto-complete" + next_count,
            method_name: "get-autocomplte-itemss",
        });
        calculateSubtotal();
    });
</script>
