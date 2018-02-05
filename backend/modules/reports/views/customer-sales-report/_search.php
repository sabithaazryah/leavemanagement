<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SalesInvoiceMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-group {
        margin-bottom: 0px;
    }
    form .form-group .form-control {
        color: #464646;
        font-size: 15px;
        padding: 16px 10px;
        background-color: #f9f9f9;
    }
</style>

<div class="sales-invoice-master-search">
    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'post',
//                'options' => ['target' => 'print_popup'],
        ]);
        $model->createdFrom = $from;
        $model->createdTo = $to;
        ?>

        <div class="col-md-4">
            <?php
            $customers = \common\models\BusinessPartner::find()->where(['status' => 1, 'type' => 1])->all();
            ?>
            <select id="businesspartnersearch-id" class="form-control" name="BusinessPartnerSearch[id]" aria-invalid="false">
                <option value="">-Choose a Customer-</option>
                <?php foreach ($customers as $customer) { ?>
                    <option value="<?= $customer->id ?>" <?= $id == $customer->id ? 'selected' : '' ?>><?= $customer->name . ' ( ' . $customer->company_name . ' )' ?></option>
                <?php }
                ?>
            </select>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'createdFrom')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'From'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])->label(FALSE);
            ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'createdTo')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'To'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ])->label(FALSE);
            ?>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-search" style="padding-right: 10px;"></i><span>Search</span>', ['class' => 'btn btn-success', 'name' => 'search']) ?>
                <?php // Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank'])  ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

