<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\components\ModalViewWidget;
use common\models\Employee;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?= Html::button('<i class="fa-th-list"></i><span> Add Department</span>', ['value' => Url::to('create'), 'class' => 'btn btn-warning  btn-icon btn-icon-standalone modalButton']) ?>
                    <?= \common\widgets\Alert::widget(); ?>
                    <?= ModalViewWidget::widget(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                            'department_code',
                            'department_name',
//                            'description',
                            [
                                'attribute' => 'recomender',
                                'value' => function($data) {
                                    if (isset($data->recomender)) {
                                        return Employee::findOne($data->recomender)->name;
                                    } else {
                                        return '';
                                    }
                                },
                                'filter' => ArrayHelper::map(Employee::find()->asArray()->all(), 'id', 'name'),
                                'filterOptions' => array('id' => "emp_recomender_search"),
                            ],
                            [
                                'attribute' => 'approver',
                                'value' => function($data) {
                                    if (isset($data->approver)) {
                                        return Employee::findOne($data->approver)->name;
                                    } else {
                                        return '';
                                    }
                                },
                                'filter' => ArrayHelper::map(Employee::find()->asArray()->all(), 'id', 'name'),
                                'filterOptions' => array('id' => "emp_approver_search"),
                            ],
                            // 'status',
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            [
                                'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
                                'header' => 'Actions',
                                'template' => '{update}{delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::button('<i class="fa fa-pencil"></i>', ['value' => Url::to(['update', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                    'title' => Yii::t('app', 'delete'),
                                                    'class' => '',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                    ],
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, $model) {
                                    if ($action === 'delete') {
                                        $url = Url::to(['del', 'id' => $model->id]);
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


