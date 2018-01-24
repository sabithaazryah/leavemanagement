<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ItemMaster;
use common\models\Locations;
use common\models\BusinessPartner;
use common\models\Country;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Stock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $items = ItemMaster::find()->where(['status' => 1])->all() ?>
            <?= $form->field($model, 'item_id')->dropDownList(ArrayHelper::map($items, 'id', 'name'), ['prompt' => '--Select--']) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'item_code')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'uom')->textInput(['readonly' => true]) ?>

        </div>
    </div>

    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'batch_no')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if (!$model->isNewRecord) {
                $model->slaughter_date_from = date('d-m-Y', strtotime($model->slaughter_date_from));
            } else {
                $model->slaughter_date_from = date('d-m-Y');
            }
            echo DatePicker::widget([
                'model' => $model,
                'form' => $form,
                'type' => DatePicker::TYPE_INPUT,
                'attribute' => 'slaughter_date_from',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ]
            ]);
            ?>


        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if (!$model->isNewRecord) {
                $model->slaughter_date_to = date('d-m-Y', strtotime($model->slaughter_date_to));
            } else {
                $model->slaughter_date_to = date('d-m-Y');
            }
            echo DatePicker::widget([
                'model' => $model,
                'form' => $form,
                'type' => DatePicker::TYPE_INPUT,
                'attribute' => 'slaughter_date_to',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ]
            ]);
            ?>


        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if (!$model->isNewRecord) {
                $model->production_date = date('d-m-Y', strtotime($model->production_date));
            } else {
                $model->production_date = date('d-m-Y');
            }
            echo DatePicker::widget([
                'model' => $model,
                'form' => $form,
                'type' => DatePicker::TYPE_INPUT,
                'attribute' => 'production_date',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ]
            ]);
            ?>


        </div>
    </div>

    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if (!$model->isNewRecord) {
                $model->due_date = date('d-m-Y', strtotime($model->due_date));
            } else {
                $model->due_date = date('d-m-Y');
            }
            echo DatePicker::widget([
                'model' => $model,
                'form' => $form,
                'type' => DatePicker::TYPE_INPUT,
                'attribute' => 'due_date',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                ]
            ]);
            ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'plant')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $loactions = Locations::find()->where(['status' => 1])->all() ?>
            <?= $form->field($model, 'location')->dropDownList(ArrayHelper::map($loactions, 'id', 'location_name'), ['prompt' => '--Select--']) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'warehouse')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="row">
        <?php $supplier = BusinessPartner::find()->where(['status' => 1, 'type' => 2])->all() ?>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'supplier')->dropDownList(ArrayHelper::map($supplier, 'id', 'company_name'), ['prompt' => '--Select--']) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $country = Country::find()->where(['status' => 1])->all() ?>
            <?= $form->field($model, 'origin')->dropDownList(ArrayHelper::map($country, 'id', 'country_name'), ['prompt' => '--Select--']) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="row" style="margin-left: 0">
        <h5 style="color: black;font-weight: bold">STOCK DETAILS</h5>
        <hr style="border-top: 1px solid #195faa;margin-top: 10px;"/>

    </div>

    <div class="row">


        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'cartons')->textInput() ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'total_weight')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'pieces')->textInput() ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'stock')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div>

    </div>

    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'available_stock')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'closing_stock')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        </div><div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'remarks')->textarea(['rows' => 1]) ?>

        </div>

    </div>
    <div class="row">
        <div class='col-md-12 col-sm-12 col-xs-12'>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<script>
    $(document).ready(function () {
        $("#stock-item_id").select2({
            //   placeholder: 'Select',
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
    });
</script>