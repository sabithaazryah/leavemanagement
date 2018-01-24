<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\components\ModalViewWidget;
use common\models\Locations;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BusinessPartnerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-partner-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?= Html::button('<i class="fa-th-list"></i><span> Add New</span>', ['value' => Url::to('create'), 'class' => 'btn btn-warning  btn-icon btn-icon-standalone modalButton']) ?>
                    <?= \common\widgets\Alert::widget(); ?>
                    <?php
                    echo ModalViewWidget::widget();
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                            'id',
//                            'type',
                            'name',
                            'company_name',
                            [
                                'attribute' => 'location',
                                'format' => 'raw',
                                'filter' => Html::activeDropDownList($searchModel, 'location', ArrayHelper::map(Locations::find()->all(), 'id', 'location_name'), ['class' => 'form-control', 'id' => 'name', 'prompt' => '']),
                                'value' => function ($data) {
                                    return Locations::findOne($data->location)->location_name;
                                },
                            ],
                            // 'billing_address:ntext',
                            // 'shipping_address:ntext',
                            // 'phone_no',
                            // 'fax_no',
                            // 'email:email',
                            [
                                'attribute' => 'status',
                                'filter' => ['1' => 'Enable', '0' => 'Disable'],
                                'value' => function($data) {
                                    return $data->status == 1 ? 'Enable' : 'Disable';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
//                                    'contentOptions' => ['style' => 'width:100px;'],
                                'header' => 'Actions',
                                'template' => '{update}{view}{delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::button('<i class="fa fa-pencil"></i>', ['value' => Url::to(['update', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
                                    },
                                    'view' => function ($url, $model) {
                                        return Html::button('<i class="fa fa-eye"></i>', ['value' => Url::to(['view', 'id' => $model->id]), 'class' => 'modalButton edit-btn']);
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


