<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<span>
    <div class="row">
        <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class = "form-group field-staffperviousemployer-hospital_address">
                <label class = "control-label">Document</label>
                <input type = "file" name = "creates[file][]" id="document-file-<?= $next ?>">

            </div>
        </div>
        <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group field-staffperviousemployer-designation">
                <label class="control-label" for="">Document Title</label>
                <input class="form-control" type = "text" name = "creates[file_name][]" id="document-title-<?= $next ?>">
            </div>
        </div>
        <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group field-staffperviousemployer-designation">
                <label class="control-label" for="">Expiry Date</label>
                <input type="date" class="form-control" name="creates[expiry_date][]" id="document-expiry-<?= $next ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-11 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group field-staffperviousemployer-designation">
                <label class="control-label" for="">Description</label>
                <textarea rows="3" class="form-control" name="creates[description][]" id="document-desc-<?= $next ?>"></textarea>
            </div>
        </div>
    </div>


    <div style="clear:both"></div>
</span>

