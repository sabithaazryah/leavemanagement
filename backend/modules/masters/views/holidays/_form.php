<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Holidays */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holidays-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'holiday_name')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?=
            $form->field($model, 'date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <?php $branches = ArrayHelper::map(common\models\Branch::findAll(['status' => 1]), 'id', 'branch_name'); ?>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'country')->dropDownList($branches, ['prompt' => '-Choose a Branch-']) ?>

        </div>
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

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
