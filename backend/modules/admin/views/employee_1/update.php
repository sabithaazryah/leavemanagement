<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = 'Update Employee: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa fa-users"></i><span> Manage Employee</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <div class="col-md-12">
					
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#home" data-toggle="tab" aria-expanded="false">
								<span class="visible-xs"><i class="fa-home"></i></span>
								<span class="hidden-xs">Basic</span>
							</a>
						</li>
						<li class="">
							<a href="#profile" data-toggle="tab" aria-expanded="false">
								<span class="visible-xs"><i class="fa-user"></i></span>
								<span class="hidden-xs">Leave</span>
							</a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div class="tab-pane active" id="home">
							<div class="panel-body">
                    <div class="employee-create">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                        ])
                        ?>
                        
                    </div>
                </div>
						</div>
						<div class="tab-pane" id="profile">
                                                    <div class="panel-body">
                    <div class="employee-create">
                            <?=
                            $this->render('_form_leave', [
                              'model' => $model,
                              'searchModel' => $searchModel,
                              'dataProvider' => $dataProvider,
                              'model_leave' => $model_leave,
                            ])
                            ?>
                    </div>
                                                    </div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
