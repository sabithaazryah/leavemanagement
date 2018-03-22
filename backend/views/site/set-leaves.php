<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Set Leaves';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
        <div class="col-md-12">

                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

                        </div>
                        <div class="panel-body">
                                <div class="panel-body"><div class="leave-request-create">
                                                <?php $form = ActiveForm::begin(); ?>
                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                        <p>This button is to transfer all employees current year leaves to next year.</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                        <?= Html::submitButton('Transfer Leaves', ['class' => 'btn btn-success transfer', 'name' => 'transfer-leaves', 'id' => 1, 'style' => 'width:150px']) ?>
                                                                </div>

                                                        </div>
                                                </div>

                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="col-md-6">
                                                                        <p>This button is to carry forward all employees current year leaves to next year.</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                        <?= Html::submitButton('Carry forward Leaves', ['class' => 'btn btn-success transfer', 'name' => 'carry-forward', 'id' => 2]) ?>
                                                                </div>

                                                        </div>
                                                </div>
                                                <?php ActiveForm::end(); ?>

                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>

<script>

        $(document).ready(function () {

                $('.transfer').click(function (e) {
                        if ($(this).attr('id') == 1) {
                                var btn_cnt = 'Are you sure want to transfer all employees leave?';
                        } else {
                                var btn_cnt = 'Are you sure want to carry forward all employees leave to next year?';
                        }
                        if (confirm(btn_cnt)) {
                                return TRUE;
                        } else {
                                e.preventDefault();
                                return FALSE;
                        }
                });
        });
</script>


