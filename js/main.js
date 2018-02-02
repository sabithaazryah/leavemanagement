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
                                $("#stock-available_stock").val(res['available_stock']);
                                $(".available-stock").html(res['unit_label']);
                                $(".closing-stock").html(res['unit_label']);
                                $(".stock").html(res['unit_label']);
                                $("#stock-item-type").val(res['category']);
                                if (res['category'] != 1) {
                                        $('.slaughter_date_from').hide();
                                        $('.slaughter_date_to').hide();
                                        $('.cartoons').hide();
                                        $('.weight').hide();
                                } else {
                                        $('.slaughter_date_from').show();
                                        $('.slaughter_date_to').show();
                                        $('.cartoons').show();
                                        $('.weight').show();
                                }
                        }
                });
        });



//        $(document).on('click', '.select-stock-item', function () {
//                var id = 1;
//                $.ajax({
//                        type: 'POST',
//                        cache: false,
//                        data: {id: id},
//                        url: homeUrl + 'stock/stock-adjustment/item-details',
//                        success: function (data) {
//                                $("#modal-pop-up").html(data);
//                                $('#modal-6').modal('show', {backdrop: 'static'});
//                        }
//                });
//        });

//        $(document).on('keyup', '#stockadjustment-adjust_weight', function () {
//                var adjust_weight = $(this).val();
//                var stock_weight = $('#stockadjustment-total_weight').val();
//
//                if (parseFloat(adjust_weight) > parseFloat(stock_weight)) {
//                        $('#stockadjustment-stock_type').val('Stock In');
//                } else {
//                        $('#stockadjustment-stock_type').val('Stock Out');
//                }
//        });


        $(document).on('keyup', '.add-open-stock', function () {
                var item = $('#stock-item_id').val();
                var total_weight = $('#stock-total_weight').val();
                var available_stock = $("#stock-available_stock").val();
                var total_pieces = $('#stock-pieces').val();

                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {item: item},
                        url: homeUrl + 'stock/stock/item-category',
                        success: function (data) {
                                if (data == 1) {
                                        $("#stock-stock").val(total_weight);
                                        var closing = parseFloat(total_weight) + parseFloat(available_stock);
                                } else if (data == 2) {
                                        $("#stock-stock").val(total_pieces);
                                        var closing = parseFloat(total_pieces) + parseFloat(available_stock);
                                }
                                $("#stock-closing_stock").val(closing);
                        }
                });
        });

        $("#stock-cartons, #stock-total_weight,#stock-pieces").keypress(
                function (e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57)) {
                                alert('Digits Only');
                                return false;
                        }
                });



});
function showLoader() {
        $('.page-loading-overlay').removeClass('loaded');
}
function hideLoader() {
        $('.page-loading-overlay').addClass('loaded');
}


