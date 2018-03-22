<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\LeaveConfiguration;
use common\models\Employee;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\LeaveRequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-request-form form-inline">

        <?= common\widgets\Alert::widget() ?>
        <?php $form = ActiveForm::begin(); ?>

        <?php
        $recommender_exists = common\models\Employee::find()->where(['recommender' => Yii::$app->user->identity->id])->exists();
        if ($recommender_exists) {
                ?>
                <div class="row">
                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                <input type="checkbox" name="apply_for_me" id='apply-leave-for-me' value=""> Apply leave for me
                        </div>
                </div>
        <?php } ?>

        <div class="row">
                <?php
                if ($recommender_exists) {
                        $employees = Employee::find()->where(['status' => 1])->andWhere(['recommender' => Yii::$app->user->identity->id])->all();
                        ?>
                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd' id='leave-employee'>    <?= $form->field($model, 'employee_id')->dropDownList(ArrayHelper::map($employees, 'id', 'empname'), ['prompt' => 'Select']) ?>

                        </div>
                        <?php
                } else {
                        $model->employee_id = Yii::$app->user->identity->id;
                        ?>
                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd' id='leave-employee' style="display:none">    <?= $form->field($model, 'employee_id')->textInput() ?>

                        </div>

                <?php } ?>


                <div class='col-md-8 col-sm-6 col-xs-12 left_padd'>
                        <div class="table-responsive employee-leaves-list" style="border:none">

                        </div>
                </div>
        </div>

        <div class="row">
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?=
                        $form->field($model, 'from_date')->widget(DatePicker::classname(), [
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                        ?>

                </div>

                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                        <?=
                        $form->field($model, 'to_date')->widget(DatePicker::classname(), [
                            'type' => DatePicker::TYPE_INPUT,
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                        ?>

                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd' id="leave-from-type">
                        <?= $form->field($model, 'from_leave_type')->dropDownList(['' => '--Select--', '1' => 'Full Day', '2' => 'Half Day']) ?>
                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd' id="leave-to-type">
                        <?= $form->field($model, 'to_leave_type')->dropDownList(['' => '--Select--', '1' => 'Full Day', '2' => 'Half Day']) ?>
                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd' id="single-leave-type">
                        <?= $form->field($model, 'apply_leave_type')->dropDownList(['' => '--Select--', '1' => 'Full Day', '2' => 'Half Day']) ?>
                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd' id="laeve-count">
                        <?= $form->field($model, 'no_of_days')->textInput(['readonly' => true])->label('Leave Applied') ?>
                </div>

                <input type="hidden" id="appied-leave-dates" value="0">

                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'leave_type')->dropDownList([], ['prompt' => 'Select']) ?>

                </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>    <?= $form->field($model, 'reason')->textarea(['rows' => 4]) ?>

                </div>
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


<script>
        $(document).ready(function () {


                $('#apply-leave-for-me').change(function () {
                        if ($(this).is(":checked")) {
                                var checked = 1;
                        } else {
                                var checked = 0;
                        }
                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {checked: checked},
                                url: homeUrl + 'leave/leave-request/employee-list-change',
                                success: function (data) {
                                        if (checked == 1) {
                                                $("#leave-employee").empty();
                                                $(".employee-leaves-list").empty();
                                                var appenddata = "<div class='form-group field-leaverequest-employee_id required'><label class='control-label' for='leaverequest-employee_id'>Employee</label>\n\
                                                <input typ='text' id='leaverequest-employee_id' class='form-control' name='LeaveRequest[employee_id]' value='<?= Yii::$app->user->identity->id ?>' readonly='true'><div class='help-block'></div></div>";
                                                $(appenddata).appendTo('#leave-employee');
                                                $("#leave-employee").hide();
                                                var employee = $('#leaverequest-employee_id').val();
                                                $.ajax({
                                                        type: 'POST',
                                                        cache: false,
                                                        data: {employee: employee},
                                                        url: homeUrl + 'leave/leave-request/employee-leave',
                                                        success: function (data) {
                                                                var res = $.parseJSON(data);
                                                                $(".employee-leaves-list").empty();
                                                                $(".employee-leaves-list").append(res['list']);
                                                                $("#leaverequest-leave_type").html(res['options']);
                                                        }
                                                });
                                        } else {
                                                $("#leave-employee").empty();
                                                $("#leave-employee").show();
                                                $(".employee-leaves-list").empty();
                                                $(data).appendTo('#leave-employee');
                                        }
                                }
                        });
                });

                /*
                 * On choosing employee list employee leaves
                 */
                $(document).on('change', '#leaverequest-employee_id', function (e) {
                        var employee = $('#leaverequest-employee_id').val();
                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {employee: employee},
                                url: homeUrl + 'leave/leave-request/employee-leave',
                                success: function (data) {
                                        var res = $.parseJSON(data);
                                        $(".employee-leaves-list").empty();
                                        $(".employee-leaves-list").append(res['list']);
                                        $("#leaverequest-leave_type").html(res['options']);
                                }
                        });
                });
                /*
                 * calculate leave
                 */
                $('#leaverequest-to_date').change(function () {
                        var flag = 0;
                        var to_date = $(this).val();
                        var from_date = $('#leaverequest-from_date').val();
                        var employee = $('#leaverequest-employee_id').val();
                        if (!employee) {
                                var flag = 1;
                        } else if (!from_date) {
                                var flag = 2;
                        }
                        if (flag == 0) {
                                ShowLeaveType();
                                CalculateLeave();
//                                LeaveTypeValidation(from_date, to_date);

                        } else if (flag == 1) {
                                $('#leaverequest-from_date').val('');
                                $('#leaverequest-to_date').val('');
                                alert('Please select an employee');
                        } else if (flag == 2) {
                                $('#leaverequest-from_date').val('');
                                $('#leaverequest-to_date').val('');
                                alert('Please select a from date');
                        }
                });


                $('#leaverequest-apply_leave_type').change(function (e) {
                        CalculateLeave();
                });

                $('#leaverequest-from_leave_type').change(function (e) {
                        CalculateLeave();
                });

                $('#leaverequest-to_leave_type').change(function (e) {
                        CalculateLeave();
                });




                $('#leave-from-type').hide();
                $('#leave-to-type').hide();
                $('#single-leave-type').hide();
                $('#laeve-count').hide();

                function ShowLeaveType() {
                        var from_date = $('#leaverequest-from_date').val();
                        var to_date = $('#leaverequest-to_date').val();
                        if (from_date == to_date) {
                                $('#single-leave-type').show();
                                $('#leave-from-type').hide();
                                $('#leave-to-type').hide();
                                $('#appied-leave-dates').val('1');
                        } else {
                                $('#single-leave-type').hide();
                                $('#leave-from-type').show();
                                $('#leave-to-type').show();
                                $('#appied-leave-dates').val('2');
                        }
                }
                function LeaveTypeValidation(from_date, to_date) {
                        if (from_date == to_date) {
                                var single_date_type = $('#leaverequest-apply_leave_type').val();
                                if (!single_date_type) {
                                        var flag = 3;
                                }
                        } else {
                                var from_leave_type = $('#leaverequest-from_leave_type').val();
                                var to_leave_type = $('#leaverequest-to_leave_type').val();
                                if (!from_leave_type) {
                                        var flag = 4;
                                }
                                if (!to_leave_type) {
                                        var flag = 5;
                                }
                        }
                        if (flag == 0) {
                                CalculateLeave();
                        } else if (flag == 3) {
                                alert('Half day/full day cannot be blank');
                        } else if (flag == 4) {
                                alert('From date half day/full day cannot be blank');
                        } else if (flag == 5) {
                                alert('To date half day/full day cannot be blank');
                        }
                }

                function CalculateLeave() {
                        var valid = 0;
                        var to_date = $('#leaverequest-to_date').val();
                        var from_date = $('#leaverequest-from_date').val();
                        var employee = $('#leaverequest-employee_id').val();
                        if (from_date && to_date && employee) {
                                if (from_date == to_date) {
                                        var single_date_type = $('#leaverequest-apply_leave_type').val();
                                        if (!single_date_type) {
                                                var valid = 3;
                                        }
                                } else {
                                        var from_leave_type = $('#leaverequest-from_leave_type').val();
                                        var to_leave_type = $('#leaverequest-to_leave_type').val();
                                        if (!from_leave_type) {
                                                var valid = 4;
                                        }
                                        if (!to_leave_type) {
                                                var valid = 5;
                                        }
                                }
                                if (valid == 0) {
                                        $.ajax({
                                                type: 'POST',
                                                cache: false,
                                                data: {from_date: from_date, to_date: to_date, employee: employee, single_date_type: single_date_type, from_leave_type: from_leave_type, to_leave_type: to_leave_type},
                                                url: homeUrl + 'leave/leave-request/leaves',
                                                success: function (data) {
                                                        if (data <= 0) {
                                                                data = 0;
                                                                alert('Your requested date is a holiday');
                                                        }
                                                        $('#laeve-count').show();
                                                        $('#leaverequest-no_of_days').val(data);
                                                }
                                        });
                                }
                        }
                }


        });
</script>