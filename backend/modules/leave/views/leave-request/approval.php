<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\LeaveConfiguration;
use common\models\LeaveCategory;
use common\models\Employee;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LeaveRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Approvals';
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
                                        <?= common\widgets\Alert::widget() ?>
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
                                                            } else if ($model->status == 2) {
                                                                    return 'Recommended';
                                                            }
                                                    },
                                                ],
                                                    [
                                                    'attribute' => 'recommended_by',
                                                    'value' => function($model) {
                                                            $recommender = Employee::findOne($model->recommended_by);
                                                            return $recommender->full_name;
                                                    },
                                                ],
                                                    [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'contentOptions' => ['style' => 'width:100px;'],
                                                    'header' => 'Actions',
                                                    'template' => '{approve}{reject}',
                                                    'buttons' => [
                                                        'approve' => function ($url, $model) {
                                                                return Html::a('Apprpve', $url, [
                                                                            'title' => Yii::t('app', 'Approve this leave'),
                                                                            'class' => 'btn btn-secondary',
                                                                            'style' => 'padding: 4px 4px;border-radius: 5px;',
                                                                ]);
                                                        },
                                                        'reject' => function ($url, $model) {
                                                                return Html::a('Reject', $url, [
                                                                            'title' => Yii::t('app', 'Reject this leave'),
                                                                            'class' => 'btn btn-red',
                                                                            'style' => 'border-radius: 5px;padding: 4px 4px;',
                                                                ]);
                                                        },
                                                    ],
                                                    'urlCreator' => function ($action, $model) {
                                                            if ($action === 'approve') {
                                                                    $url = Url::to(['approveleave', 'id' => $model->id]);
                                                                    return $url;
                                                            }
                                                            if ($action === 'reject') {
                                                                    $url = Url::to(['rejectleave', 'id' => $model->id]);
                                                                    return $url;
                                                            }
                                                    }
                                                ],
                                            ],
                                        ]);
                                        ?>
                                </div>
                        </div>
                </div>
        </div>
</div>


