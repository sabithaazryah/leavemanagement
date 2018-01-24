<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Locations;

/* @var $this yii\web\View */
/* @var $model common\models\BusinessPartner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Business Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <div class="panel-body"><div class="business-partner-view">

                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
//                                'id',
//                                'type',
                                'name',
                                'company_name',
                                [
                                    'attribute' => 'location',
                                    'value' => function ($data) {
                                        return Locations::findOne($data->location)->location_name;
                                    },
                                ],
                                'billing_address:ntext',
                                'shipping_address:ntext',
                                'phone_no',
                                'fax_no',
                                'email:email',
                                [
                                    'attribute' => 'status',
                                    'value' => function($data) {
                                        return $data->status == 1 ? 'Enable' : 'Disable';
                                    }
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


