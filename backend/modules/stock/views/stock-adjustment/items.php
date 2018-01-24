<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ItemMaster;
use common\models\StockView;
use common\models\BaseUnit;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
?>


<div class="modal-content">
        <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title" id="largeModalLabel">Choose Item</h4>
        </div>
        <div class="modal-body">
                <div class="row clearfix">

<table id="example-11" class="table table-striped table-bordered staff-search-results" cellspacing="0" width="100%">
        <thead>
                <tr>
                        <th>No</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>UOM</th>
                </tr>
        </thead>
        <tbody >
<?php
foreach($items as $value){ 
    $item_details=ItemMaster::findOne($value->item_id);
    $uom=BaseUnit::findOne($item_details->base_unit_id);
    $batches=StockView::find()->where(['item_id'=>$value->item_id])->all();
    ?>
            <tr>
                <td><a href="#" id="<?=$value->item_id?>" class="parent-change">+</a></td>
                <td><?=$item_details->item_code?></td>
                <td><?=$item_details->item_name?></td>
                <td><?=$item_details->purchase_price?></td>
                <td><?=$uom->name?></td>
                
            </tr>
            
            
            <tr style="display:none" id="child-<?=$value->item_id?>">
                <td colspan="5">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Batch No</th>
                            <th>Due Date</th>
                            <th>Location</th>
                            <th >Stock On Hand</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($batches as $batch){ ?>
                        <tr>
                            <td><?=$batch->batch_no?></td>
                            <td><?=$batch->due_date?></td>
                            <td><?=$batch->location_code?></td>
                            <td>
                                <?php if($item_details->product_category==1){ ?>
		                <span style="border-right:1px solid;" class="col-xs-5"><?=$batch->available_weight?> Kg </span>  
                                <?php } else{ ?>
                                <span style="border-right:1px solid;" class="col-xs-5"><?=$batch->available_pieces?> Pieces </span>
                                <?php } ?>
		                <span class="col-xs-6 pull-right"><?=$batch->available_carton?> Cartons</span></td>
                            <td><a class="btn btn-success choose-batch" id="<?=$batch->id?>">Select</a></td>
                        </tr>
                        <?php }?>
                        
                    </table>
                </td>
            </tr>
                
<?php }
?>

               
        </tbody>
</table>
                </div>
        </div>
</div>


<script>
$(document).ready(function(){
    $('.parent-change').click(function(){
        var id=$(this).attr('id');
        $('#child-'+id).toggle();
    });
    
        $(document).on('click', '.choose-batch', function () {
        var selected=$(this).attr('id');
        $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {selected: selected},
                        url: homeUrl + 'stock/stock-adjustment/selected-item',
                        success: function (data) {
                                var res = $.parseJSON(data);
                                $("#stockadjustment-item_name").val(res['item_name']);
                                $('#stockadjustment-item_code').val(res['item_code']);
                                $('#stockadjustment-price').val(res['price']);
                                $('#stockadjustment-uom').val(res['uom']);
                                $('#stockadjustment-batch_no').val(res['batch_no']);
                                $('#stockadjustment-slaughter_date_from').val(res['slaughter_date_from']);
                                $('#stockadjustment-slaughter_date_to').val(res['slaughter_date_to']);
                                $('#stockadjustment-production_date').val(res['production_date']);
                                $('#stockadjustment-due_date').val(res['due_date']);
                                $('#stockadjustment-location').val(res['location']);
                                $('#stockadjustment-cost').val(res['cost']);
                                $('#stockadjustment-cartons').val(res['cartons']);
                                $('#stockadjustment-total_weight').val(res['total_weight']);
                                $('#stockadjustment-pieces').val(res['pieces']);
                                $('#stockadjustment-stock_view_id').val(selected);
       $('#modal-6').hide();
                        }
                });
       
    });
    
});
</script>