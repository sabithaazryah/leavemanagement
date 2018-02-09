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

<div class="sales-invoice-master-search" style="margin-left: 5px;">
    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'post',
//                'options' => ['target' => 'print_popup'],
    ]);
    ?>
    <div class="col-md-9">
        <?php
        $items = \common\models\ItemMaster::find()->where(['status' => 1])->all();
        ?>
        <select id="SalesInvoiceDetailsSearch-id" class="form-control" name="item_id" aria-invalid="false">
            <option value="">-Select Item-</option>
            <?php foreach ($items as $item) { ?>
                <option value="<?= $item->id ?>" <?= $item_idd == $item->id ? 'selected' : '' ?>><?= $item->item_code . ' - ' . $item->item_name ?></option>
            <?php }
            ?>
        </select>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search" style="padding-right: 10px;"></i><span>Search</span>', ['class' => 'btn btn-success', 'name' => 'search']) ?>
            <?php // Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank'])  ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

