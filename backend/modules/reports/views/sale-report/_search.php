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
</style>

<div class="sales-invoice-master-search">

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
        <?=
        $form->field($model, 'createdFrom')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label('From');
        ?>
    </div>
    <div class="col-md-4">
        <?=
        $form->field($model, 'createdTo')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label('To');
        ?>
    </div>

    <div class="col-md-4" style="margin-top: 31px;">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-success', 'name' => 'search']) ?>
            <?php // Html::submitButton('<i class="fa fa-file-pdf-o" style="padding-right: 10px;"></i><span>PDF</span>', ['class' => 'btn btn-default', 'id' => 'pdf-btn', 'name' => 'pdf', 'style' => 'background-color: #337ab7;border-color: #2e6da4;color:white;', 'formtarget' => '_blank']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

