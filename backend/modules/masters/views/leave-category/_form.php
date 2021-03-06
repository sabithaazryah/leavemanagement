<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Country;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\LeaveCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/dd.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/flags.css" />
<div class="leave-category-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">

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
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'country')->dropDownList($locations, ['options' => $flag_img, 'class' => 'form-control country-change', 'aria-invalid' => 'false', 'prompt' => '-Select Country-']) ?>

                </div>

                <?php
                if (!$model->isNewRecord) {
                        $branch = common\models\Branch::find()->where(['country' => $model->country])->all();
                } else {
                        $branch = [];
                }
                ?>

                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map($branch, 'id', 'branch_name'), ['prompt' => '--Select--']) ?>

                </div>

                <?php
                $designation = common\models\Designation::find()->where(['status' => 1])->all();
                ?>

                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'designation')->dropDownList(ArrayHelper::map($designation, 'id', 'designation_name'), ['prompt' => '--Select--']) ?>

                </div>

                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'leave_code')->textInput(['maxlength' => true]) ?>

                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'leave_name')->textInput(['maxlength' => true]) ?>

                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'no_of_days')->textInput() ?>

                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
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
<script src="<?= Yii::$app->homeUrl; ?>js/jquery.dd.js"></script>
<script>
        jQuery(document).ready(function ($) {
                $("#leavecategory-country").msDropdown({roundedBorder: false});

                $('#leavecategory-country').change(function () {
                        var country = $(this).val();
                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {country: country},
                                url: homeUrl + 'masters/leave-category/branch',
                                success: function (data) {
                                        $('#leavecategory-branch').html(data);
                                }
                        });
                });

                $("#leavecategory-designation").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });

                $("#leavecategory-branch").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });



        });
</script>
