<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\LeaveConfiguration;
use common\models\LeaveCategory;
use common\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LeaveRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-request-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">
                                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                                        <?= Html::a('<i class="fa-th-list"></i><span> Apply Leave </span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn'],
//                                                'id',
                                                [
                                                    'attribute' => 'employee_id',
                                                    'value' => function($model) {
                                                            $employee = Employee::findOne($model->employee_id);
                                                            return $employee->full_name;
                                                    },
                                                    'filter' => \yii\helpers\ArrayHelper::map(Employee::find()->where(['status' => 1])->all(), 'id', 'full_name')
                                                ],
                                                    [
                                                    'attribute' => 'leave_type',
                                                    'value' => function($data) {
                                                            $employee_leave = LeaveConfiguration::findOne($data->leave_type);
                                                            $leave_name = LeaveCategory::findOne($employee_leave->leave_type);
                                                            if (!empty($leave_name))
                                                                    return $leave_name->leave_name;
                                                    }
                                                ],
                                                'from_date',
                                                'to_date',
                                                    [
                                                    'attribute' => 'status',
                                                    'value' => function($model) {
                                                            if ($model->status == 1) {
                                                                    return 'Leave Applied';
                                                            }
                                                    },
                                                ],
                                            // 'CB',
                                            // 'UB',
                                            // 'DOC',
                                            // 'DOU',
                                            //['class' => 'yii\grid\ActionColumn'],
                                            ],
                                        ]);
                                        ?>
                                </div>
                        </div>
                </div>
        </div>
</div>


