<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdminPost */

$this->title = $model->post_name;
$this->params['breadcrumbs'][] = ['label' => 'Admin Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                        </div>
                        <div class="panel-body">
                                <?= Html::a('<i class="fa-th-list"></i><span> Manage Admin Post</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                                <div class="panel-body"><div class="admin-post-view">
                                                <p>
                                                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                                        <?=
                                                        Html::a('Delete', ['delete', 'id' => $model->id], [
                                                            'class' => 'btn btn-danger',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                'method' => 'post',
                                                            ],
                                                        ])
                                                        ?>
                                                </p>

                                                <?=
                                                DetailView::widget([
                                                    'model' => $model,
                                                    'attributes' => [
                                                        'post_name',
                                                            [
                                                            'attribute' => 'admin',
                                                            'value' => function ($model) {
                                                                    return $model->admin == 1 ? 'Yes' : 'No';
                                                            },
                                                        ],
                                                            [
                                                            'attribute' => 'masters',
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                                    return $model->masters == 1 ? 'Yes' : 'No';
                                                            },
                                                        ],
                                                            [
                                                            'attribute' => 'daily_entry',
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                                    return $model->daily_entry == 1 ? 'Yes' : 'No';
                                                            },
                                                        ],
                                                            [
                                                            'attribute' => 'appointement',
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                                    return $model->appointement == 1 ? 'Yes' : 'No';
                                                            },
                                                        ],
                                                            [
                                                            'attribute' => 'status',
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                                    return $model->status == 1 ? 'Enabled' : 'disabled';
                                                            },
                                                        ],
                                                    ],
                                                ])
                                                ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>


