<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ItemMaster;
use common\models\StockView;
use common\models\BaseUnit;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
?>


<div class="modal-dialog">
        <div class="modal-content">

                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Choose a batch for stock adjustment</h4>
                </div>

                <div class="modal-body">
                        <?php if (!empty($batches)) { ?>
                                <table id="example-11" class="table table-striped table-bordered staff-search-results" cellspacing="0" width="100%">
                                        <tr>
                                                <th>Batch</th>
                                                <th>Cartons</th>
                                                <th>Weight</th>
                                                <th>Pieces</th>
                                                <th></th>
                                        </tr>
                                        <?php foreach ($batches as $value) { ?>
                                                <tr>
                                                        <td><?= $value->batch_no ?></td>
                                                        <td><?php
                                                                if (isset($value->available_carton)) {
                                                                        echo $value->available_carton;
                                                                } else {
                                                                        echo '-';
                                                                }
                                                                ?></td>
                                                        <td><?php
                                                                if (isset($value->available_weight)) {
                                                                        echo $value->available_weight;
                                                                } else {
                                                                        echo '-';
                                                                }
                                                                ?></td>
                                                        <td><?php
                                                                if (isset($value->available_pieces)) {
                                                                        echo $value->available_pieces;
                                                                } else {
                                                                        echo '-';
                                                                }
                                                                ?></td>
                                                        <td><button type="submit" class="btn btn-success choose-stock-batch" id="<?= $value->id ?>">Select</button></td>
                                                </tr>
                                        <?php }
                                        ?>
                                </table>
                        <?php } else { ?>
                                <p>No batches found !!</p>
                        <?php } ?>

                </div>


        </div>
</div>

