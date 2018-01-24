<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\BaseUnit;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!--<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title></title>-->
<div id="print">
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/invoice.css">
    <style type="text/css">

        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group}
            /*tfoot {position: absolute;bottom: 0px;}*/
            .main-tabl{width: 100%}
            .footer {position: fixed ; left: 0px; bottom: 20px; right: 0px; font-size:10px; }
            body h6,h1,h2,h3,h4,h5,p,b,tr,td,span,th,div{
                color:#525252 !important;
            }
            .header{
                font-size: 12.5px;
                display: inline-block;
                width: 100%;
            }
            .main-left{
                padding-top: 12px;
                float: left;
            }
            .main-right{
                float: right;
            }
            table.table{
                border-collapse: collapse;
                width:100%;
            }
            body {-webkit-print-color-adjust: exact;}

        }
        @media screen{
            .main-tabl{
                width: 60%;
            }
        }
        .print{
            margin-top: 18px;
            margin-left: 315px;
        }
        footer {
            width: 100%;
            position: absolute;
            bottom: 0px;
        }
        .tax-declarations p{
            font-size: 12px;
            line-height: 18px;
        }
    </style>
    <!--    </head>
        <body >-->
    <table border ="0"  class="main-tabl" border="0">
        <thead>
            <tr>
                <th style="width:100%">
                    <div class="header">
                        <div class="main-left">
                            <div style="min-height: 150px;">
                                <img src="<?= Yii::$app->homeUrl ?>images/companyImages/<?= $company_details->id ?>.<?= $company_details->logo ?>"/>
                            </div>
                            <div style="">
                                <table>
                                    <tr><td class="invoice-tbl-sub">Bill To</td></tr>
                                    <tr><td><?php
                                            if (isset($sales_master->salesman)) {
                                                echo common\models\BusinessPartner::findOne(['id' => $sales_master->busines_partner_code])->name;
                                            }
                                            ?></td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="main-right">
                            <div style="">
                                <table class="invoice-tbl">
                                    <tr><td><span style="font-size: 37px;">Invoice</span></td></tr>
                                    <tr><td><span style="font-size: 20px;color: #b6aeae !important"><?= $sales_master->sales_invoice_number ?></span></td></tr>
                                    <?php if ($sales_master->due_amount > 0) { ?>
                                        <tr><td style="font-size: 13px;">Balance Due</td></tr>
                                        <tr><td style="font-size: 20px;">Rs.<?= $sales_master->due_amount ?></td></tr>
                                    <?php }
                                    ?>
                                </table>
                            </div>
                            <div style="">
                                <table class="invoice-tbl">
                                    <tr>
                                        <td class="invoice-tbl-sub">Invoice Date : &nbsp;&nbsp;&nbsp;</td>
                                        <td><?= $sales_master->sales_invoice_date ?></td>
                                    </tr>
                                    <?php if ($sales_master->due_amount > 0) { ?>
                                        <tr>
                                            <td class="invoice-tbl-sub">Due Date : &nbsp;&nbsp;&nbsp;</td>
                                            <td><?= $sales_master->due_date ?></td>
                                        </tr>
                                    <?php }
                                    ?>
                                    <tr>
                                        <td class="invoice-tbl-sub">Sale Person : &nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <?php
                                            if (isset($sales_master->salesman)) {
                                                echo common\models\Salesman::findOne(['id' => $sales_master->salesman])->name;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <br/>
                    </div>

                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="">
                        <table class="table" style="border-bottom: 3px solid #bcbcbc;margin-bottom: 15px;">
                            <thead>
                                <tr style="text-align: center;background-color: #bcbcbc !important;">
                                    <th>#</th>
                                    <th width="">Item $ Description</th>
                                    <th width="">Qty</th>
                                    <th width="">Rate</th>
                                    <th width="">Discount</th>
                                    <th width="">Tax %</th>
                                    <th width="">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $discount_amount = 0;
                                $net_total = 0;
                                $sub_total = 0;
                                $total_tax = 0;
                                $grand_total = 0;
                                $k = 0;
                                foreach ($sales_details as $sales_detail) {
                                    ++$k;
                                    ?>
                                    <tr>
                                        <td><?= $k ?></td>
                                        <td><?= $sales_detail->item_name . '<br/>' . $sales_detail->comments ?></td>
                                        <td><?= $sales_detail->qty ?></td>
                                        <td><?= $sales_detail->rate ?></td>
                                        <td><?= $sales_detail->discount_amount ?></td>
                                        <td><?= $sales_detail->tax_percentage ?></td>
                                        <td><?= $sales_detail->net_amount ?></td>
                                    </tr>
                                    <?php
                                    $sub_total += $sales_detail->net_amount;
                                    $total_tax += $sales_detail->tax_amount;
                                    $tot = $sales_detail->net_amount + $sales_detail->tax_amount;
                                    $grand_total += $tot;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="main-right">
                        <div style="">
                            <table class="invoice-tb2">
                                <tr>
                                    <td class="invoice-tb2-sub">Sub Total</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="invoice-tb2-sub"><?= sprintf('%0.2f', $sub_total); ?></td>
                                </tr>
                                <tr>
                                    <td class="invoice-tb2-sub">Tax</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="invoice-tb2-sub"><?= sprintf('%0.2f', $total_tax); ?></td>
                                </tr>
                                <tr>
                                    <td class="invoice-tb2-sub sub-tot">Total</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="invoice-tb2-sub sub-tot"><?= sprintf('%0.2f', $grand_total); ?></td>
                                </tr>
                                <tr>
                                    <td class="invoice-tb2-sub sub-tot">Due Amount</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="invoice-tb2-sub sub-tot"><?= $sales_master->due_amount ?></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php if (!empty($company_details->tax_declaration)) { ?>
                        <div class="tax-declarations">
                            <h4>Tax Declaration</h4>
                            <?= $company_details->tax_declaration ?>
                        </div>

                    <?php }
                    ?>
                    <?php if (!empty($company_details->terms_conditions)) { ?>
                        <div class="tax-declarations">
                            <h4>Terms & Conditions</h4>
                            <?= $company_details->terms_conditions ?>
                        </div>

                    <?php }
                    ?>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="width:100%">
                    <div class="footer">
                        <?= $company_details->name . ', ' . $company_details->city . ', ' . $company_details->state . ', ' . common\models\Country::findOne(['id' => $company_details->country])->country_name . ', ' . $company_details->postal_code ?><br/>
                        Tel: <?= $company_details->phone . ', ' . $company_details->mobile ?> Email- <?= $company_details->email ?> Web- <?= $company_details->web ?><br/>
                        TIN: <?= $company_details->tin ?> CST: <?= $company_details->cst ?>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
<div class="print">
    <div class="print" style="float:left;">
        <?php
        if ($print) {
            ?>
            <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
            <?php
        }
        ?>
        <button onclick="window.close();" style="font-weight: bold !important;">Close</button>

    </div>
</div>
<!--</body>

</html>-->