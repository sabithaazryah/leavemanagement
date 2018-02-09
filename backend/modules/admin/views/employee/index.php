<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\AdminPost;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


                </div>
                <div class="panel-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= Html::a('<i class="fa-th-list"></i><span> Create Employee</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?= \common\widgets\Alert::widget(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
                            [
                                'attribute' => 'photo',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->photo != '') {
                                        $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/employee/' . $data->id . '.' . $data->photo;
                                        if (file_exists($dirPath)) {
                                            $img = '<img width="120px" src="' . Yii::$app->homeUrl . 'uploads/employee/' . $data->id . '.' . $data->photo . '"/>';
                                        } else {
                                            $img = 'No Image';
                                        }
                                    } else {
                                        $img = 'No Image';
                                    }
                                    return $img;
                                },
                            ],
                            [
                                'attribute' => 'post_id',
                                'value' => 'post.post_name',
                                'filter' => ArrayHelper::map(AdminPost::find()->asArray()->all(), 'id', 'post_name'),
                            ],
//                            'user_name',
//                            'password',
                            'name',
                            'email:email',
                            'phone',
                            // 'address:ntext',
                            // 'status',
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


