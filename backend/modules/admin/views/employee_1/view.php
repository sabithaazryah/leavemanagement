<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">
                                <div class="panel-body"><div class="employee-view">
                                                <?php if (!empty($model->photo)) { ?>

                                                        <div class="col-md-12 disp-image">
                                                                <img src="<?= Yii::$app->homeUrl ?>uploads/employee/<?= $model->id ?>.<?= $model->photo ?>" />
                                                        </div>
                                                <?php } ?>
                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        'employee_code',
                                                        'full_name',
                                                        'date_of_birth',
                                                            [
                                                            'attribute' => 'department',
                                                            'value' => function($data) {
                                                                    if (isset($data->department)) {
                                                                            return \common\models\Department::findOne($data->department)->department_name;
                                                                    } else {
                                                                            return '';
                                                                    }
                                                            },
                                                        ],
                                                            [
                                                            'attribute' => 'designation',
                                                            'value' => function($data) {
                                                                    if (isset($data->designation)) {
                                                                            return common\models\Designation::findOne($data->designation)->designation_name;
                                                                    } else {
                                                                            return '';
                                                                    }
                                                            },
                                                        ],
                                                        'hired_date',
                                                            [
                                                            'attribute' => 'recommender',
                                                            'value' => function($data) {
                                                                    if (isset($data->recommender)) {
                                                                            return common\models\Employee::findOne($data->recommender)->full_name;
                                                                    } else {
                                                                            return '';
                                                                    }
                                                            },
                                                        ],
                                                            [
                                                            'attribute' => 'approver',
                                                            'value' => function($data) {
                                                                    if (isset($data->approver)) {
                                                                            return common\models\Employee::findOne($data->approver)->full_name;
                                                                    } else {
                                                                            return '';
                                                                    }
                                                            },
                                                        ],
                                                        'job_grade',
                                                            [
                                                            'attribute' => 'working_hours',
                                                            'value' => function($data) {
                                                                    if (isset($data->working_hours)) {
                                                                            return common\models\WorkingHours::findOne($data->working_hours)->working_hour;
                                                                    } else {
                                                                            return '';
                                                                    }
                                                            },
                                                        ],
                                                        'user_name',
                                                        'name',
                                                        'email:email',
                                                        'phone',
                                                        'address:ntext',
                                                    ],
                                                ])
                                                ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>


<style>
        .disp-image img{
                width:100px;
                height: 100px;
                float: right;

        }
</style>