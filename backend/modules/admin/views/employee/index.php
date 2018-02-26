<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Department;
use common\models\Designation;

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

                    <?= Html::a('<i class="fa fa-users"></i><span> Add Employee</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
//                                                            'id',
//            'post_id',
                            'employee_code',
                            'full_name',
                            'date_of_birth',
                            // 'branch',
                            [
                                'attribute' => 'department',
                                'value' => function($data) {
                                    if (isset($data->department)) {
                                        return Department::findOne($data->department)->department_name;
                                    } else {
                                        return '';
                                    }
                                },
                                'filter' => ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'department_name'),
                                'filterOptions' => array('id' => "employee_department_search"),
                            ],
                            [
                                'attribute' => 'designation',
                                'value' => function($data) {
                                    if (isset($data->designation)) {
                                        return Designation::findOne($data->designation)->designation_name;
                                    } else {
                                        return '';
                                    }
                                },
                                'filter' => ArrayHelper::map(Designation::find()->asArray()->all(), 'id', 'designation_name'),
                                'filterOptions' => array('id' => "employee_designation_search"),
                            ],
                            // 'hired_date',
                            // 'recommender',
                            // 'approver',
                            // 'job_grade',
                            // 'working_hours',
                            // 'user_name',
                            // 'password',
                            // 'name',
                            // 'email:email',
                            // 'phone',
                            // 'photo',
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


