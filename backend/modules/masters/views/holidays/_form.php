<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\Holidays */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/dd.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/flags.css" />
<style>
        #holidays-country_child{
                height: 100px !important;
        }
</style>

<div class="holidays-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'holiday_name')->textInput(['maxlength' => true]) ?>

                </div>

                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?php
                        if ($model->isNewRecord) {
                                $date_label = 'Date (You can choose multiple dates, selected dates will be shown in the next textbox)';
                        } else {
                                $date_label = 'Date';
                        }
                        ?>
                        <?=
                        $form->field($model, 'date')->widget(DatePicker::classname(), [
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy',
                                'multiple' => true
                            ]
                        ])->label($date_label);
                        ?>
                </div>
                <?php if ($model->isNewRecord) { ?>
                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <label>Selected Dates</label>
                                <input type="text" class="form-control" id='multiple-selcted-dates' placeholder="Dates" name="selecteddates">
                        </div>
                <?php } ?>

        </div>

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
                if (isset($model->country) && $model->country != '')
                        $model->country = explode(',', $model->country);
                ?>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'country')->dropDownList($locations, ['options' => $flag_img, 'class' => 'form-control country-change', 'aria-invalid' => 'false', 'prompt' => '-Select Country-', 'multiple' => true]) ?>

                </div>



                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?php
                        if (!$model->isNewRecord) {
                                $branches = common\models\Branch::find()->where(['country' => $model->country])->all();
                        } else {
                                $branches = [];
                        }
                        if (isset($model->branch) && $model->branch != '')
                                $model->branch = explode(',', $model->branch);
                        ?>

                        <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map($branches, 'id', 'branch_name'), ['prompt' => '-Choose a Branch-', 'class' => 'form-control']) ?>

                </div>


                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

                </div>



        </div>
        <?php if ($model->isNewRecord) { ?>
                <div class="row">
                        <div class='col-md-2 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'recurring_leave')->checkbox() ?>

                        </div>

                        <div class='col-md-2 col-sm-6 col-xs-12 left_padd' id='show-recurring-years'>
                                <label>How many years?</label>
                                <select name="recurring_years" id="recurring-years" class="form-control">
                                        <option>--Select--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                </select>

                        </div>
                </div>
        <?php } ?>
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

                $("#holidays-country").msDropdown({roundedBorder: false});

                $('#holidays-country').change(function () {
                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {country: $(this).val()},
                                url: homeUrl + 'masters/holidays/branch',
                                success: function (data) {
                                        $('#holidays-branch').html(data);
                                }
                        });
                });
                $('#holidays-date').change(function () {
                        var date = $(this).val();
                        var selected = $('#multiple-selcted-dates').val();
                        if (selected) {
                                var set_date = selected + ' , ' + date;
                                $('#multiple-selcted-dates').val(set_date);
                        } else {
                                $('#multiple-selcted-dates').val(date);
                        }
                });


                $('#show-recurring-years').hide();
                $('#holidays-recurring_leave').change(function () {
                        if ($(this).is(":checked")) {
                                $('#show-recurring-years').show();
                        } else {
                                $('#show-recurring-years').hide();
                        }
                });


        });
</script>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script type="text/javascript">
        jQuery(document).ready(function ($)
        {
                $("#holidays-branch").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
        });
</script>
