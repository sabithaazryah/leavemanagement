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

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
                <?php
                $employees = Employee::find()->where(['status' => 1])->orWhere(['recommender' => Yii::$app->user->identity->id])->orWhere(['approver' => Yii::$app->user->identity->id])->all();
                $employees1 = Employee::find()->where(['id' => Yii::$app->user->identity->id])->all();
                $employees_list = array_merge($employees, $employees1);
                ?>
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'employee_id')->dropDownList(ArrayHelper::map($employees_list, 'id', 'full_name'), ['prompt' => 'Select']) ?>

                </div>


                <div class='col-md-8 col-sm-6 col-xs-12 left_padd'>
                        <div class="table-responsive employee-leaves-list" style="border:none">
<!--                                <table class="table table-bordered table-striped">
                                        <tr>
                                                <th>Leave Name</th>
                                                <th>Available Days</th>
                                        </tr>


                                        <tr>
                                                <td>Annual Leave</td>
                                                <td>20</td>
                                        </tr>

                                        <tr>
                                                <td>Sick Leave</td>
                                                <td>10</td>
                                        </tr>
                                </table>-->
                        </div>


                </div>
        </div>

        <div class="row">
                <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'leave_type')->dropDownList([], ['prompt' => 'Select']) ?>

                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
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

                </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>

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

                </div><div class='col-md-12 col-sm-12 col-xs-12 left_padd'>    <?= $form->field($model, 'reason')->textarea(['rows' => 4]) ?>

                </div>
        </div>   </div>
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
                $('#leaverequest-employee_id').change(function () {
                        var employee = $(this).val();
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
        });
</script>