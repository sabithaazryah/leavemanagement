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
        
        $(document).on('keyup', '#stock-pieces', function () {
              var total_weight=$(this).val();
              $("#stock-stock").val(total_weight);
              $("#stock-available_stock").val(total_weight);
              $("#stock-closing_stock").val(total_weight);
        });


});
function showLoader() {
        $('.page-loading-overlay').removeClass('loaded');
}
function hideLoader() {
        $('.page-loading-overlay').addClass('loaded');
}


