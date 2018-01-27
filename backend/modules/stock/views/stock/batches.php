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

            <table id="example-11" class="table table-striped table-bordered staff-search-results" cellspacing="0" width="100%">
                <tr>
                    <th>Batch</th>
                    <th>Cartons</th>
                    <th>Weight</th>
                    <th>Pieces</th>
                </tr>
            </table>


        </div>

        
    </div>
</div>

