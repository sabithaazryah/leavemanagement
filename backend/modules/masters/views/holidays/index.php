<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\HolidaysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Holidays';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holidays-index">

        <div class="row">
                <div class="col-md-12">

                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                                </div>
                                <div class="panel-body">
                                        <?= Html::a('<i class="fa-th-list"></i><span> Add Holidays</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                        <?= \common\widgets\Alert::widget(); ?>
                                        <?= ModalViewWidget::widget(); ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                                                'holiday_name',
                                                'date',
                                                //   'country',
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
                                                    // 'filter'=> \yii\helpers\ArrayHelper::map(common\models\Country::find()->where(['status'=>1])->all)
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
                                                    // 'filter'=> \yii\helpers\ArrayHelper::map(common\models\Country::find()->where(['status'=>1])->all)
                                                    'filter' => \yii\helpers\ArrayHelper::map(common\models\Branch::find()->where(['status' => 1])->orderBy(['branch_name' => SORT_ASC])->all(), 'id', 'branch_name'),
                                                ],
                                                'description',
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
                                                ],
                                            ],
                                        ]);
                                        ?>
                                </div>
                        </div>
                </div>
        </div>
</div>


