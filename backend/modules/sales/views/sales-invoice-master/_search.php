<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-invoice-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sales_invoice_number') ?>

    <?= $form->field($model, 'sales_invoice_date') ?>

    <?= $form->field($model, 'order_type') ?>

    <?= $form->field($model, 'busines_partner_code') ?>

    <?php // echo $form->field($model, 'salesman') ?>

    <?php // echo $form->field($model, 'payment_terms') ?>

    <?php // echo $form->field($model, 'delivery_terms') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'tax_amount') ?>

    <?php // echo $form->field($model, 'order_amount') ?>

    <?php // echo $form->field($model, 'ship_to_adress') ?>

    <?php // echo $form->field($model, 'amount_payed') ?>

    <?php // echo $form->field($model, 'due_amount') ?>

    <?php // echo $form->field($model, 'payment_status') ?>

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
