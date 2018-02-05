<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

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
        ?>
        <div class="col-md-10">
            <?php
            $batches = \common\models\StockView::find()->select('batch_no')->distinct()->all();
            ?>
            <select id="StockViewSearch-id" class="form-control" name="batch_no" aria-invalid="false">
                <option value="">-Select Batch-</option>
                <?php foreach ($batches as $val) { ?>
                    <option value="<?= $val->batch_no ?>" <?= $batch == $val->batch_no ? 'selected' : '' ?>><?= $val->batch_no ?></option>
                <?php }
                ?>
            </select>
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

