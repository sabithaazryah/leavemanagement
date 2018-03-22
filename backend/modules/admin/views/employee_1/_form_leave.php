<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\LeaveCategory;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model_leave common\models\LeaveConfiguration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-configuration-form form-inline">

        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
                <div class='col-md-2 left_padd'>
                        <?php $leave_categorys = ArrayHelper::map(LeaveCategory::findAll(['status' => 1]), 'id', 'leave_name'); ?>
                        <?= $form->field($model_leave, 'leave_type')->dropDownList($leave_categorys, ['prompt' => '-Choose a Category-']) ?>

                </div>
                <div class='col-md-2 left_padd'>
                        <?= $form->field($model_leave, 'entitlement')->textInput() ?>

                </div>
                <div class='col-md-2 left_padd'>
                        <?= $form->field($model_leave, 'carry_forward')->textInput() ?>

                </div>
                <div class='col-md-2 left_padd'>
                        <?= $form->field($model_leave, 'adjustments_type')->dropDownList(['1' => 'Add', '2' => 'Deduct']) ?>

                </div>
                <div class='col-md-2 left_padd'>
                        <?= $form->field($model_leave, 'adjustments')->textInput() ?>

                </div>

                <div class='col-md-2 left_padd'>
                        <?= $form->field($model_leave, 'no_of_days')->textInput(['readOnly' => true]) ?>

                </div>
        </div>
        <input type="hidden" name="leave_carry" id="leave_carry" value="">
        <input type="hidden" name="employee_id" id="employee_id" value="<?= $model->id ?>">

        <input type="hidden" id="leave_category_leave">

        <div class="row">
                <div class='col-md-12 col-sm-12 col-xs-12'>
                        <div class="form-group">
                                <?= Html::submitButton($model_leave->isNewRecord ? 'Create' : 'Update', ['class' => $model_leave->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;float:right;']) ?>
                        </div>
                </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div>
                <h5 style="font-weight: 600;color: #408244;font-size: 14px;text-transform: uppercase;text-decoration: underline;">Leave History</h5>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'attribute' => 'leave_type',
                            'value' => function($data) {
                                    if (isset($data->leave_type)) {
                                            return LeaveCategory::findOne($data->leave_type)->leave_name;
                                    } else {
                                            return '';
                                    }
                            },
                            'filter' => ArrayHelper::map(LeaveCategory::find()->asArray()->all(), 'id', 'leave_name'),
                        ],
                            [
                            'attribute' => 'entitlement',
                            'value' => function($data) {
                                    if (isset($data->entitlement)) {
                                            return $data->entitlement;
                                    } else {
                                            return '';
                                    }
                            },
                        ],
                            [
                            'attribute' => 'carry_forward',
                            'value' => function($data) {
                                    if (isset($data->carry_forward)) {
                                            return $data->carry_forward;
                                    } else {
                                            return '';
                                    }
                            },
                        ],
                            [
                            'attribute' => 'adjustments',
                            'value' => function($data) {
                                    if (isset($data->adjustments)) {
                                            return $data->adjustments;
                                    } else {
                                            return '';
                                    }
                            },
                        ],
//             'adjustments_type',
                        'no_of_days',
                        'available_days',
                    // 'status',
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
//                                                ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>
        </div>
</div>
<script>
        $(document).ready(function () {
                $("#leaveconfiguration-leave_type").change(function (e) {
                        var leave_type = this.value;
                        var employee_id = $("#employee_id").val();
//			var carry_date = $("#leave_carry").val();
                        $.ajax({
                                type: 'POST',
                                url: '<?= Yii::$app->homeUrl; ?>admin/employee/leave-type-days', // select product features
                                data: {leave_type: leave_type, employee_id: employee_id},
                                success: function (data) {
                                        $('#leaveconfiguration-no_of_days').val(data);
                                        $('#leave_category_leave').val(data);
                                },
                                error: function (data) {

                                }
                        });
                });
//                $("#leaveconfiguration-adjustments").keyup(function () {
//                        var adjustment_type = $("#leaveconfiguration-adjustments_type").val();
//                        if (this.value > 0 && adjustment_type == 1) {
//                                var days = parseInt($("#leaveconfiguration-no_of_days").val()) + parseInt($("#leaveconfiguration-adjustments").val());
//                                $('#leaveconfiguration-no_of_days').val(days);
//                        } else if (this.value > 0 && adjustment_type == 2) {
//                                if (this.value < parseInt($("#leaveconfiguration-no_of_days").val())) {
//                                        var days = parseInt($("#leaveconfiguration-no_of_days").val()) - parseInt($("#leaveconfiguration-adjustments").val());
//                                        $('#leaveconfiguration-no_of_days').val(days);
//                                } else {
//                                        alert('value shouls not exceed the alotted days');
//                                }
//                        }
//
//
//                });
                $("#leaveconfiguration-entitlement").keyup(function () {
                        leaveDays();
                });
                $("#leaveconfiguration-carry_forward").keyup(function () {
                        leaveDays();
                });
                $("#leaveconfiguration-adjustments").keyup(function () {
                        leaveDays();
                });
                $("#leaveconfiguration-adjustments_type").change(function () {
                        leaveDays();
                });
        });
        function leaveDays() {
                var entitlement = $("#leaveconfiguration-entitlement").val();
                var carry_forward = $("#leaveconfiguration-carry_forward").val();
                var adjustments = $("#leaveconfiguration-adjustments").val();
                var adjustments_type = $("#leaveconfiguration-adjustments_type").val();
                var leave_category_leave = $("#leave_category_leave").val();
                if (!entitlement) {
                        entitlement = 0;
                }
                if (!carry_forward) {
                        carry_forward = 0;
                }
                if (!adjustments) {
                        adjustments = 0;
                }
                if (!leave_category_leave) {
                        leave_category_leave = 0;
                }
                if (adjustments_type == 1) {
                        $res = (parseInt(entitlement) + parseInt(carry_forward)) + parseInt(adjustments) + parseInt(leave_category_leave);
                        $("#leaveconfiguration-no_of_days").val($res);
                } else if (adjustments_type == 2) {

                        $res1 = (parseInt(entitlement) + parseInt(carry_forward));
                        $res2 = +parseInt(adjustments)
                        $res3 = $res1 - parseInt(adjustments) + parseInt(leave_category_leave);

                        if ($res1 > $res2) {
                                $("#leaveconfiguration-no_of_days").val($res3);
                        } else {
                                $("#leaveconfiguration-no_of_days").val(0);
                                $("#leaveconfiguration-adjustments").val(0);
                                alert('Please enter a value smaller than ' + $res1 + '(Entitlement+Carry forward)')
                        }
                }

        }
        //);
</script>
