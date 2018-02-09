<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Access Powers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-post-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Access Powers</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            'post_name',
                            [
                                'attribute' => 'admin',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->admin == 1 ? 'Yes' : 'No';
                                },
                                'filter' => [1 => 'Yes', 0 => 'No'],
                            ],
                            [
                                'attribute' => 'masters',
                                'format' => 'raw',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->masters == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'stock',
                                'format' => 'raw',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->stock == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'sales_invoice',
                                'format' => 'raw',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->sales_invoice == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'stock_adjustment',
                                'format' => 'raw',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->stock_adjustment == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'opening_stock',
                                'format' => 'raw',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->opening_stock == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'reports',
                                'format' => 'raw',
                                'filter' => [1 => 'Yes', 0 => 'No'],
                                'value' => function ($model) {
                                    return $model->reports == 1 ? 'Yes' : 'No';
                                },
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'filter' => [1 => 'Enabled', 0 => 'disabled'],
                                'value' => function ($model) {
                                    return $model->status == 1 ? 'Enabled' : 'disabled';
                                },
                            ],
                            // 'CB',
                            // 'UB',
                            // 'DOC',
                            // 'DOU',
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


