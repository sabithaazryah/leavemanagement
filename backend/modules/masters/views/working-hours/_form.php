<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WorkingHours */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="working-hours-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'working_hour')->textInput(['type' => 'number', 'min' => 1, 'step' => "0.01"]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 25px; height: 36px; width:100px;float:left;']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
