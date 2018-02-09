<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa-th-list"></i><span> Manage Employee</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="panel-body"><div class="employee-view">
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
                                'id',
                                [
                                    'attribute' => 'photo',
                                    'format' => 'raw',
                                    'value' => call_user_func(function($model) {
                                                if ($model->photo != '') {
                                                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/employee/' . $model->id . '.' . $model->photo;
                                                    if (file_exists($dirPath)) {
                                                        $img = '<img width="100px" height="100" src="' . Yii::$app->homeUrl . 'uploads/employee/' . $model->id . '.' . $model->photo . '"/>';
                                                    } else {
                                                        $img = '<img width="100px" height="100" src="' . Yii::$app->homeUrl . 'images/user-4.png"/>';
                                                    }
                                                } else {
                                                    $img = '<img width="100px" height="100" src="' . Yii::$app->homeUrl . 'images/user-4.png"/>';
                                                }
                                                return $img;
                                            }, $model),
                                ],
                                [
                                    'attribute' => 'post_id',
                                    'value' => $model->post->post_name,
                                ],
                                'user_name',
                                'password',
                                'name',
                                'email:email',
                                'phone',
                                'address:ntext',
                                [
                                    'attribute' => 'status',
                                    'value' => $model->status == 1 ? 'Enabled' : 'Disabled',
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


