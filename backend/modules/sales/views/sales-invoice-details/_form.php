<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-details-form form-inline">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'sales_invoice_master_id')->textInput() ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'sales_invoice_number')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'sales_invoice_date')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'busines_partner_code')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'item_code')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'base_unit')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'qty')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'discount_percentage')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'discount_amount')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'net_amount')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'tax_id')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'tax_percentage')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'tax_amount')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'line_total')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'reference')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'error_message')->textInput(['maxlength' => true]) ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'status')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'CB')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'UB')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'DOC')->textInput() ?>

    </div><div class='col-md-4 col-sm-6 col-xs-12'>    <?= $form->field($model, 'DOU')->textInput() ?>

    </div>        <div class="form-group" style="float: right;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
