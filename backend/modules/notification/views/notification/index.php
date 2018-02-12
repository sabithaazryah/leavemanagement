<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Notification</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            'notification_type',
                            //  'invoice_id',
                            //   'invoice_no',
//                            'content:ntext',
                            'message:ntext',
                            // 'status',
                            // 'closed',
                            // 'date',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'contentOptions' => [],
                                'header' => 'Actions',
                                'template' => '{disable}',
//                                    'template' => '{print}',
                                'buttons' => [
                                    //view button
                                    'disable' => function ($url, $model) {
                                        return Html::a('<span class="fa fa-ban" style="padding-top: 0px;font-size: 16px;color:red;"></span>', $url, [
                                                    'title' => Yii::t('app', 'Disable'),
                                                    'class' => 'actions',
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, $model) {
                                    if ($action === 'disable') {
                                        $url = Url::to(['notification/disable-notification', 'id' => $model->id]);
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


