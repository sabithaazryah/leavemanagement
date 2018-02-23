<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LeaveCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-category-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'leave_code')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'leave_name')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'no_of_days')->textInput() ?>

        </div><div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'include_docs')->textInput() ?>

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
