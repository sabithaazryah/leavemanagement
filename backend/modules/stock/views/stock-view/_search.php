<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StockViewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-view-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'item_code') ?>

    <?= $form->field($model, 'item_name') ?>

    <?= $form->field($model, 'mrp') ?>

    <?php // echo $form->field($model, 'retail_price') ?>

    <?php // echo $form->field($model, 'ws_price') ?>

    <?php // echo $form->field($model, 'location_code') ?>

    <?php // echo $form->field($model, 'batch_no') ?>

    <?php // echo $form->field($model, 'opening_carton') ?>

    <?php // echo $form->field($model, 'opening_weight') ?>

    <?php // echo $form->field($model, 'opening_piece') ?>

    <?php // echo $form->field($model, 'weight_per_carton') ?>

    <?php // echo $form->field($model, 'piece_per_carton') ?>

    <?php // echo $form->field($model, 'available_carton') ?>

    <?php // echo $form->field($model, 'available_weight') ?>

    <?php // echo $form->field($model, 'available_pieces') ?>

    <?php // echo $form->field($model, 'average_cost') ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'error_msg') ?>

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
