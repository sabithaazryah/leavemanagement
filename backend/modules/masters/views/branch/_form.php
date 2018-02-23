<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/dd.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/flags.css" />
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    #branch-country_child{
        height: auto !important;
    }
</style>

<div class="branch-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $locations = ArrayHelper::map(Country::find()->where(['status' => 1])->orderBy(['country_name' => SORT_ASC])->all(), 'id', function($model) {
                return $model['country_name'];
            }
    );
    $flags = Country::find()->where(['status' => 1])->all();
    $flag_img = array();
    foreach ($flags as $flag) {
        $flag_img[$flag->id] = ['data-image' => Yii::$app->homeUrl . 'uploads/flags/' . $flag->id . '.' . $flag->country_flag];
    }
    ?>
    <div class="row">
        <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'country')->dropDownList($locations, ['options' => $flag_img, 'class' => 'form-control country-change', 'aria-invalid' => 'false', 'prompt' => '-Select Country-']) ?>

        </div><div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
            <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>

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
<script src="<?= Yii::$app->homeUrl; ?>js/jquery.dd.js"></script>
<script>
    jQuery(document).ready(function ($) {
        $("#branch-country").msDropdown({roundedBorder: false});
    });
</script>

