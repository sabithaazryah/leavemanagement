<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use common\models\Designation;
use common\models\Department;
use common\models\Branch;
use common\models\Employee;
use common\models\WorkingHours;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/dd.css" />
<link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl; ?>css/flags.css" />
<style>
        #employee-country_child{
                height: auto !important;
        }
        #employee-country_msdd{
                height: 36px !important;
        }
        #employee-country_msdd .divider{
                height: 36px !important;
        }
</style>
<div class="employee-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'post_id')->dropDownList(ArrayHelper::map(common\models\AdminPost::find()->where(['status' => 1])->all(), 'id', 'post_name'), ['prompt' => 'Select'])->label('Post') ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'employee_code')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?=
                        $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>

                </div>


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
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'country')->dropDownList($locations, ['options' => $flag_img, 'class' => 'form-control country-change', 'aria-invalid' => 'false', 'prompt' => '-Select Country-']) ?>

                </div>




                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php
                        if (!$model->isNewRecord) {
                                $branches = ArrayHelper::map(Branch::find()->where(['country' => $model->country, 'status' => 1])->all(), 'id', 'branch_name');
                        } else {
                                $branches = [];
                        }
                        ?>
                        <?= $form->field($model, 'branch')->dropDownList($branches, ['prompt' => '-Choose a Branch-']) ?>
                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

                </div>
                <?php if ($model->isNewRecord) { ?>
                        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                        </div>
                <?php }
                ?>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $departments = ArrayHelper::map(Department::findAll(['status' => 1]), 'id', 'department_name'); ?>
                        <?= $form->field($model, 'department')->dropDownList($departments, ['prompt' => '-Choose a Department-']) ?>
                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $designations = ArrayHelper::map(Designation::findAll(['status' => 1]), 'id', 'designation_name'); ?>
                        <?= $form->field($model, 'designation')->dropDownList($designations, ['prompt' => '-Choose a Designation-']) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?=
                        $form->field($model, 'hired_date')->widget(DatePicker::classname(), [
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $employees = ArrayHelper::map(Employee::findAll(['status' => 1]), 'id', 'name'); ?>
                        <?= $form->field($model, 'recommender')->dropDownList($employees, ['prompt' => '-Choose a Recommender-']) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'approver')->dropDownList($employees, ['prompt' => '-Choose a Approver-']) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'job_grade')->textInput(['maxlength' => true]) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php $working_hours = ArrayHelper::map(WorkingHours::findAll(['status' => 1]), 'id', 'working_hour'); ?>
                        <?= $form->field($model, 'working_hours')->dropDownList($working_hours, ['prompt' => '- Working Hour -']) ?>

                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'photo')->fileInput() ?>
                </div>
                <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
                        <?php
                        if ($model->isNewRecord)
                                echo "";
                        else {
                                if (!empty($model->photo)) {
                                        ?>

                                        <img src="<?= Yii::$app->homeUrl ?>uploads/employee/<?= $model->id ?>.<?= $model->photo ?>" width="125" height="100"/>
                                        <?php
                                }
                        }
                        ?>
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
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
<script type="text/javascript">
        jQuery(document).ready(function ($)
        {
                $("#employee-branch").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
                $("#employee-department").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
                $("#employee-designation").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
                $("#employee-recommender").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
                $("#employee-approver").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
                $("#employee-working_hours").select2({
                        allowClear: true
                }).on('select2-open', function ()
                {
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                });
        });
</script>
<script src="<?= Yii::$app->homeUrl; ?>js/jquery.dd.js"></script>
<script>
        jQuery(document).ready(function ($) {

                $("#employee-country").msDropdown({roundedBorder: false});

                jQuery('#employee-country').change(function () {
                        jQuery.ajax({
                                type: 'POST',
                                cache: false,
                                data: {country: $(this).val()},
                                url: homeUrl + 'admin/employee/branch',
                                success: function (data) {
                                        jQuery('#employee-branch').html(data);
                                }
                        });
                });
        });
</script>