<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-master-form form-inline">

        <?php $form = ActiveForm::begin(); ?>

        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'sales_invoice_number')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?php
                echo '<label class="control-label control-label1" for="formation-date">Sales Invoice Date</label>';
                if (!$model->isNewRecord) {
                        $model->sales_invoice_date = date('d-m-Y h:i', strtotime($model->sales_invoice_date));
                } else {
                        $model->sales_invoice_date = date('d-m-Y h:i');
                }
                echo DateTimePicker::widget([
                    'name' => 'sales_invoice_date',
                    'type' => DateTimePicker::TYPE_INPUT,
                    'value' => $model->sales_invoice_date,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-M-yyyy hh:ii'
                    ]
                ]);
                ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'order_type')->textInput() ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'busines_partner_code')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'salesman')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'payment_terms')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'delivery_terms')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'tax_amount')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'ship_to_adress')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'amount_payed')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'due_amount')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'payment_status')->dropDownList(['0' => 'Free', '1' => 'Open', '2' => 'Paid']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'error_message')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
                <?= $form->field($model, 'status')->dropDownList(['0' => 'Free', '1' => 'Open']) ?>

        </div>
        <div class="form-group" style="float: right;">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
