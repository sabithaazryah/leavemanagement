<tr class="filter" id="item-row-<?= $next ?>">
    <td>
        <?php $item_datas = common\models\ItemMaster::findAll(['status' => 1]); ?>
        <select id="salesinvoicedetails-item_id-<?= $next ?>" class="form-control salesinvoicedetails-item_id add-next" name="create[item_id][]">
            <option value="">-Choose a Item-</option>
            <?php foreach ($item_datas as $item_data) {
                ?>
                <option value="<?= $item_data->id ?>"><?= $item_data->item_name ?></option>
            <?php }
            ?>
        </select>
        <input type="text" value="" placeholder="Description" class="form-control salesinvoicedetails-item_comment bill-comment" id="salesinvoicedetails-item-comment-<?= $next ?>" name="create[comment][]" autocomplete="off" style="display: none;">
    </td>
    <td>
        <div class="form-group field-salesinvoicedetails-discount_percentage has-success">
            <div class="row" style="margin:0px;">
                <div class="col-md-6" style="padding:0px;">
                    <input type="number" id="salesinvoicedetails-qty-<?= $next ?>" value="" class="form-control salesinvoicedetails-qty" name="create[qty][]" placeholder="Qty" min="1" aria-invalid="false" autocomplete="off"  style="display:inline-block;">
                </div>
                <div class="col-md-6" style="padding:0px;">
                    <select id="salesinvoicedetails-type-<?= $next ?>" class="form-control salesinvoicedetails-type" name="create[type][]">
                        <option value="1">Carton</option>
                        <option value="2">Kg</option>
                        <option value="1">Pieces</option>
                    </select>
                </div>
            </div>
            <div id="stock-table-1">

            </div>
        </div>
    </td>
    <td>
        <div class="form-group field-salesinvoicedetails-rate has-success">
            <input type="number" id="salesinvoicedetails-rate-<?= $next ?>" class="form-control salesinvoicedetails-rate" name="create[rate][]" placeholder="RATE" step="0.01" aria-invalid="false" autocomplete="off" value="<?= $estimate_detail->rate ?>" >
        </div>
    </td>
    <td>
        <div class="form-group field-salesinvoicedetails-discount_percentage has-success">
            <div class="row" style="margin:0px;">
                <div class="col-md-6" style="padding:0px;">
                    <input type="number" id="salesinvoicedetails-discount_value-<?= $next ?>" value="" class="form-control salesinvoicedetails-discount_value" name="create[discount_value][]" placeholder="Discount" min="1" aria-invalid="false" autocomplete="off"  style="display:inline-block;">
                </div>
                <div class="col-md-6" style="padding:0px;">
                    <select id="salesinvoicedetails-discount_type-<?= $next ?>" class="form-control salesinvoicedetails-discount_type" name="create[discount_type][]">
                        <option value="1">Rs.</option>
                        <option value="2">%</option>
                    </select>
                </div>
            </div>
        </div>
    </td>
    <?php
    $taxes = common\models\Tax::findAll(['status' => 1]);
    ?>
    <td>
        <div class="form-group field-salesinvoicedetails-tax has-success">

            <select id="salesinvoicedetails-tax-<?= $next ?>" class="form-control salesinvoicedetails-tax" name="create[tax_id][]" aria-invalid="false">
                <option value="">Slelect a Tax</option>
                <?php
                foreach ($taxes as $tax) {
                    if ($tax->type == 0) {
                        $type = '%';
                    } else {
                        $type = 'Rs';
                    }
                    ?>
                    <option value="<?= $tax->id ?>" <?= $estimate_detail->tax_id == $tax->id ? "selected" : "" ?> ><?= $tax->name . ' - ' . $tax->value . ' ' . $type ?></option>
                <?php }
                ?>
            </select>
            <input type="hidden" id="salesinvoicedetails-tax_value-<?= $next ?>" value="" class="form-control salesinvoicedetails-tax_value" name="create[tax_value][]" >
            <input type="hidden" id="salesinvoicedetails-tax_type-<?= $next ?>" value="" class="form-control salesinvoicedetails-tax_type" name="create[tax_type][]" >
        </div>
    </td>
    <td>
        <div class="form-group field-salesinvoicedetails-line_total has-success">
            <input type="text" id="salesinvoicedetails-line_total-<?= $next ?>" value="" class="form-control salesinvoicedetails-line_total" name="create[line_total][]" placeholder="Amount" aria-invalid="false" autocomplete="off">
        </div>
    </td>
    <td>
        <div class="form-group field-salesinvoicedetails-line_total has-success" style="text-align: center;margin-top: 6px;">
            <input type="checkbox" id="salesinvoicedetails-inventory-1" name="check" value="1" checked="checked" uncheckValue="0">
        </div>
    </td>
    <td>
        <a id="del" class="" ><i class="fa fa-times sales-invoice-delete"></i></a>
    </td>
</tr>