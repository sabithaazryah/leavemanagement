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
        /***************Daily Entry**********************/
        $('body').on('change', '.netweight', function () {
                var ids = $(this).attr('id');
                var id = ids.split("_");
                $('#total_' + id[1]).val('');
                var netweight = $('#' + ids).val();
                var rate = $('#rate_' + id[1]).val();
                if (rate != "") {
                        var total = rate * netweight;
                        $('#total_' + id[1]).val(total);
                }
//            alert(rate);
        });
        $('body').on('change', '.rate', function () {
                var ids = $(this).attr('id');
                var id = ids.split("_");
                $('#total_' + id[1]).val('');
                var rate = $('#' + ids).val();
                var netweight = $('#netweight_' + id[1]).val();
                if (netweight != "") {
                        var total = rate * netweight;
                        $('#total_' + id[1]).val(total);
                }
//            alert(rate);
        });
//



        //-------------------Appointment ----------------------//


        $("#appointmentdetails-service_id").select2({
                allowClear: true
        }).on('select2-open', function ()
        {
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });

        $("#appointmentdetails-supplier").select2({
                allowClear: true
        }).on('select2-open', function ()
        {
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });


        $(document).on('change', '#appointment-vessel', function (e) {
//        $('#appointment-vessel').change(function () {
                var vessel = $(this).val();
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {vessel: vessel},
                        url: homeUrl + 'appointment/appointment/appointment-number',
                        success: function (data) {
                                $('#appointment-appointment_number').val(data);
                        }
                });
        });

        $('.edit_text').on('dblclick', function () {

                var val = $(this).attr('val');
                var idd = this.id;
                var res_data = idd.split("-");
                if (res_data[1] == 'description' || res_data[1] == 'rate_to_category') {
                        $(this).html('<textarea class="' + idd + '" value="' + val + '">' + val + '</textarea>');

                } else {
                        $(this).html('<input class="' + idd + '" type="text" value="' + val + '"/>');

                }

                $('.' + idd).focus();
        });

        $('.edit_text').on('focusout', 'input,textarea', function () {
                //$(document).on('focusout', '.edit_text', function (e) {
                var thiss = $(this).parent('.edit_text');
                var data_id = thiss.attr('id');
                var update = thiss.attr('update');
                var res_id = data_id.split("-");
                var res_val = $(this).val();
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {id: res_id[0], name: res_id[1], valuee: res_val},
                        url: homeUrl + 'appointment/appointment/edit-comment',
                        success: function (data) {
                                if (data == '') {
                                        data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                }
                                thiss.html(res_val);
                                $.pjax.reload({container: '#some_pjax_id', async: false});
                        }
                });

        });

        //----------------Appointment service-----------------//
        $('#appointmentdetails-service_id').change(function () {
                var service_id = $(this).val();
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {service_id: service_id},
                        url: homeUrl + 'appointment/appointment/supplier',
                        success: function (data) {
                                if (data != '') {
                                        $("#appointmentdetails-supplier").html(data);
                                        $("#appointmentdetails-unit_price").val('');

                                } else {
                                        $("#appointmentdetails-supplier").prop('disabled', true);
                                }
                        }
                });
        });

        $('#appointmentdetails-supplier').change(function () {

                var supplier = $(this).val();
                var service = $('#appointmentdetails-service_id').val();
                if (service && supplier) {

                        $.ajax({
                                type: 'POST',
                                cache: false,
                                data: {service_id: service, supplier_id: supplier},
                                url: homeUrl + 'appointment/appointment/rate',
                                success: function (data) {
                                        if (data != '') {

                                                var res = $.parseJSON(data);
                                                $("#appointmentdetails-unit_price").val(res['rate']);
                                                $("#appointmentdetails-tax").val(res['tax']);
                                                $("#appointmentdetails-tax").val(res['tax']);
                                                $("#appointmentdetails-unit").val(res['tax']);
                                                $("#unit-text").html(res['unit']);
                                                Total();
                                                Tax();
                                                SubTotal();
                                        } else {
                                                $("#appointmentdetails-supplier").prop('disabled', true);
                                        }
                                }
                        });

                } else {
                        $('#appointmentdetails-supplier').val('');
                        alert('Please select a service');
                }
        });


        $('#appointmentdetails-quantity').keyup(function () {
                Total();
                Tax();
                SubTotal();
        });
        $('#appointmentdetails-unit_price').keyup(function () {
                Total();
                SubTotal();
        });
        $('#appointmentdetails-tax').change(function () {

                Tax();
                SubTotal();
        });
        function Total() {
                var quantity = $('#appointmentdetails-quantity').val();
                var rate = $('#appointmentdetails-unit_price').val();
                if (quantity && rate) {
                        var total = quantity * rate;
                        var total = total.toFixed(2);
                        $('#appointmentdetails-total').val(total);
                }
        }

        function Tax() {

                var tax = $('#appointmentdetails-tax').val();
                var total = $('#appointmentdetails-total').val();

                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {tax: tax},
                        url: homeUrl + 'appointment/appointment/tax',
                        success: function (data) {
                                if (data != '') {
                                        var tax_amount = (total * data) / 100;
                                        var tax_amount = tax_amount.toFixed(2);
                                        $('#appointmentdetails-tax_amount').val(tax_amount);
                                        $('#tax-amount-show').html(tax_amount);
                                        SubTotal();

                                }
                        }
                });


        }
        function SubTotal() {
                var subtotal = 0;
                var total = $('#appointmentdetails-total').val();
                var tax = $('#appointmentdetails-tax_amount').val();
                if (tax == '') {
                        tax = 0;
                }
                if (total != '')
                        var subtotal = parseFloat(total) + parseFloat(tax);

                $('#appointmentdetails-sub_total').val(subtotal.toFixed(2));
        }

        /*
         * Add dropdown popup
         */

        $(document).on('click', '.add-option-dropdown', function (e) {
                e.preventDefault();
                var id_attr = $(this).attr('id');
                var type = id_attr.split('-');


                $.ajax({
                        type: 'POST',
                        url: homeUrl + 'dropdown/showform',
                        data: {type: type[1], field_id: type[0]},
                        success: function (data) {

                                $("#modal-pop-up").html(data);
                                $('#modal-6').modal('show', {backdrop: 'static'});

                        }
                });
        });


        $("#dailyentrydetails-net_weight, #dailyentrydetails-rate,#dailyentrydetails-transport_amount ").keypress(
                function (e) {
                        if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57)) {
                                alert('Digits Only');
                                return false;
                        }
                });

        $('.edit_daily').on('dblclick', function () {

                var val = $(this).attr('val');
                var idd = this.id;
                var res_data = idd.split("-");

                $(this).html('<input class="' + idd + '" type="text" value="' + val + '"/>');



                $('.' + idd).focus();
        });


        $('.edit_daily').on('focusout', 'input', function () {
                var thiss = $(this).parent('.edit_daily');
                var data_id = thiss.attr('id');
                var update = thiss.attr('update');
                var res_id = data_id.split("-");
                var res_val = $(this).val();
                $.ajax({
                        type: 'POST',
                        cache: false,
                        data: {id: res_id[0], name: res_id[1], valuee: res_val},
                        url: homeUrl + 'purchase/daily-entry/update-details',
                        success: function (data) {
                                if (data == '') {
                                        data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                }
                                thiss.html(res_val);
                                $.pjax.reload({container: '#daily_entry_id', async: false});
                        }
                });

        });


});
function showLoader() {
        $('.page-loading-overlay').removeClass('loaded');
}
function hideLoader() {
        $('.page-loading-overlay').addClass('loaded');
}


