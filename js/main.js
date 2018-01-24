/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(function () {

        $(document).on('click', '.modalButton', function () {

                $('#modal').modal('show')
                        .find('#modalContent')
                        .load($(this).attr("value"));
        });


        //*********************Opening Stock *******************//

        $(document).on('change', '#stock-item_id', function () {
                var item = $(this).val();
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {item: item},
                        url: homeUrl + 'stock/stock/item-details',
                        success: function (data) {
                                var res = $.parseJSON(data);
                                $("#stock-item_code").val(res['item_code']);
                                $("#stock-price").val(res['price']);
                                $("#stock-uom").val(res['UOM']);
                        }
                });
        });
        
        $(document).on('keyup', '#stock-total_weight', function () {
              var total_weight=$(this).val();
              $("#stock-stock").val(total_weight);
              $("#stock-available_stock").val(total_weight);
              $("#stock-closing_stock").val(total_weight);
        });
        
  $(document).on('click', '.select-stock-item', function () {
            var id = 1;
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {id: id},
                        url: homeUrl + 'stock/stock-adjustment/item-details',
                        success: function (data) {
                                $("#modal-pop-up").html(data);
                                $('#modal-6').modal('show', {backdrop: 'static'});
                        }
                });
            });
            
            $(document).on('keyup', '#stockadjustment-adjust_weight', function () {
                var adjust_weight=$(this).val();  
                var stock_weight=$('#stockadjustment-total_weight').val();
                
                if(parseFloat(adjust_weight)>parseFloat(stock_weight)){
                    $('#stockadjustment-stock_type').val('Stock In');
                } else{
                    $('#stockadjustment-stock_type').val('Stock Out');
                }
            });
            


});
function showLoader() {
        $('.page-loading-overlay').removeClass('loaded');
}
function hideLoader() {
        $('.page-loading-overlay').addClass('loaded');
}


