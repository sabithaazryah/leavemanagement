<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_code') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'company_established') ?>

    <?= $form->field($model, 'company_type') ?>

    <?php // echo $form->field($model, 'company_register_no') ?>

    <?php // echo $form->field($model, 'gst_register_no') ?>

    <?php // echo $form->field($model, 'no_of_employees') ?>

    <?php // echo $form->field($model, 'salary_day') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'email_id') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'fax_no') ?>

    <?php // echo $form->field($model, 'building_name') ?>

    <?php // echo $form->field($model, 'street_name') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'pin_code') ?>

    <?php // echo $form->field($model, 'about_company') ?>

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
