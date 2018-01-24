<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ItemMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'item_code') ?>

    <?= $form->field($model, 'item_name') ?>

    <?= $form->field($model, 'item_type') ?>

    <?= $form->field($model, 'tax_id') ?>

    <?php // echo $form->field($model, 'base_unit_id') ?>

    <?php // echo $form->field($model, 'MRP') ?>

    <?php // echo $form->field($model, 'retail_price') ?>

    <?php // echo $form->field($model, 'purchase_price') ?>

    <?php // echo $form->field($model, 'item_cost') ?>

    <?php // echo $form->field($model, 'whole_sale_price') ?>

    <?php // echo $form->field($model, 'hsn') ?>

    <?php // echo $form->field($model, 'location') ?>

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
