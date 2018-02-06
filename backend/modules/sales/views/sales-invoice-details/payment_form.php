<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-details-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3'>
            <?php
            $model->invoice_number = $sale->sales_invoice_number;
            ?>
            <?= $form->field($model, 'invoice_number')->textInput(['readonly' => TRUE]) ?>
        </div>
        <div class='col-md-2'>
            <div class="form-group field-payments-amount">
                <label class="control-label" for="payments-amount">Due Amount</label>
                <input type="text" id="due-amount" value="<?= $sale->due_amount ?>" class="form-control" name="due_amount" aria-invalid="false" readonly >
            </div>

        </div>
        <div class='col-md-3'>
            <?php
            $model->payment_date = date('Y-m-d');
            ?>
            <?=
            $form->field($model, 'payment_date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])
            ?>
        </div>
        <div class='col-md-2'>
            <div style="text-align: center;padding-top: 30px;color: #484848;font-weight: bold;">
                <input type="checkbox" id="checkbox-payall" name="pay-all" value="" class="checkbox-payall" tabindex="-1">Pay Full<br>
                <input type="hidden" id="balance-amount" value="<?= $sale->due_amount ?>" class="form-control" name="balance-amount" aria-invalid="false" readonly >
            </div>
        </div>
        <div class='col-md-2'>
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="form-group" style="float: right;">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        $(document).on('change', '#checkbox-payall', function (e) {
            var due = $("#due-amount").val();
            var num = 0;
            if ($(this).is(":checked")) {
                $("#payments-amount").val(due);
                $("#due-amount").val(num.toFixed(2));
            } else {
                var bal = $("#balance-amount").val();
                $("#due-amount").val(bal);
                $("#payments-amount").val(num.toFixed(2));
            }
        });
    });
</script>
