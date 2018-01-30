<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sales_invoice_master_id') ?>

    <?= $form->field($model, 'sales_invoice_number') ?>

    <?= $form->field($model, 'sales_invoice_date') ?>

    <?= $form->field($model, 'busines_partner_code') ?>

    <?php // echo $form->field($model, 'item_code') ?>

    <?php // echo $form->field($model, 'item_name') ?>

    <?php // echo $form->field($model, 'base_unit') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'discount_percentage') ?>

    <?php // echo $form->field($model, 'discount_amount') ?>

    <?php // echo $form->field($model, 'net_amount') ?>

    <?php // echo $form->field($model, 'tax_id') ?>

    <?php // echo $form->field($model, 'tax_percentage') ?>

    <?php // echo $form->field($model, 'tax_amount') ?>

    <?php // echo $form->field($model, 'line_total') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'error_message') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
