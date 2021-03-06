<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LeaveCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-category-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">
                                        <?= Html::button('<i class="fa-th-list"></i><span> Add Leave Category</span>', ['value' => Url::to('create'), 'class' => 'btn btn-warning  btn-icon btn-icon-standalone modalButton']) ?>
                                        <?= \common\widgets\Alert::widget(); ?>
                                        <?= ModalViewWidget::widget(); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                                                // 'country',
                                                [
                                                    'attribute' => 'country',
                                                    'value' => function($model) {
                                                            $country = common\models\Country::findOne($model->country);
                                                            if (!empty($country)) {
                                                                    return $country->country_name;
                                                            } else {
                                                                    return '';
                                                            }
                                                    },
                                                    'filter' => \yii\helpers\ArrayHelper::map(common\models\Country::find()->where(['status' => 1])->orderBy(['country_name' => SORT_ASC])->all(), 'id', 'country_name'),
                                                ],
                                                    [
                                                    'attribute' => 'branch',
                                                    'value' => function($model) {
                                                            $branch = common\models\Branch::findOne($model->branch);
                                                            if (!empty($branch)) {
                                                                    return $branch->branch_name;
                                                            } else {
                                                                    return '';
                                                            }
                                                    },
                                                    'filter' => \yii\helpers\ArrayHelper::map(common\models\Branch::find()->where(['status' => 1])->orderBy(['branch_name' => SORT_ASC])->all(), 'id', 'branch_name'),
                                                ],
                                                    [
                                                    'attribute' => 'designation',
                                                    'value' => function($model) {
                                                            $designation = common\models\Designation::findOne($model->designation);
                                                            if (!empty($designation)) {
                                                                    return $designation->designation_name;
                                                            } else {
                                                                    return '';
                                                            }
                                                    },
                                                    'filter' => \yii\helpers\ArrayHelper::map(common\models\Designation::find()->where(['status' => 1])->orderBy(['designation_name' => SORT_ASC])->all(), 'id', 'designation_name'),
                                                ],
                                                'leave_code',
                                                'leave_name',
                                                'no_of_days',
//                            'include_docs',
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


