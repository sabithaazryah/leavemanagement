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
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl ?>css/thermal_invoice.css">
    <style type="text/css">

        @media print {
            body {-webkit-print-color-adjust: exact;}

        }
    </style>
    <!--    </head>
        <body >-->
    <table border ="0"  class="main-tabl" border="0" style="width: 95%;">
        <tbody>
            <tr>
                <td>
                    <div style="">
                        <div class="head" style="border-bottom: 1px solid #bcbcbc;">
                            <div style="text-align: center;">
                                <h3 style="margin: 0px;"><?= $company_details->name ?></h3>
                                <div style="font-size: 13px;font-weight: 600;margin-bottom: 10px;">
                                    <p style="margin: 0px;"><?= $company_details->address1 ?></p>
                                    <p style="margin: 0px;">Phone : <?= $company_details->phone ?>7</p>
                                    <p style="margin: 0px;">Email : <?= $company_details->email ?></p>
                                </div>
                            </div>
                            <table  style="font-size: 14px;margin-bottom: 6px;font-weight: 600;">
                                <tr>
                                    <td>Invoice No.</td><td>:</td>
                                    <td><?= $sales_master->sales_invoice_number ?></td>
                                </tr>
                                <tr>
                                    <td>Invoice Date</td><td>:</td>
                                    <td><?= $sales_master->sales_invoice_date ?></td>
                                </tr>
                            </table>
                        </div>
                        <table class="table" style="border-bottom: 1px solid #bcbcbc;margin-bottom: 15px;">
                            <thead>
                                <tr style="text-align: right;">
                                    <th>#</th>
                                    <th width="">Item</th>
                                    <th width="">Qty</th>
                                    <th width="">Rate</th>
                                    <th width="">GST %</th>
                                    <th width="">GST</th>
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
                                $qty_total = 0;
                                $k = 0;
                                foreach ($sales_details as $sales_detail) {
                                    ++$k;
                                    ?>
                                    <tr>
                                        <td><?= $k ?></td>
                                        <td><?= $sales_detail->item_name . '<br/>' . $sales_detail->comments ?></td>
                                        <td><?= $sales_detail->qty ?></td>
                                        <td><?= $sales_detail->rate ?></td>
                                        <td><?= $sales_detail->tax_percentage ?></td>
                                        <td><?= $sales_detail->tax_amount ?></td>
                                        <td><?= $sales_detail->net_amount ?></td>
                                    </tr>
                                    <?php
                                    $qty_total += $sales_detail->qty;
                                    $sub_total += $sales_detail->net_amount;
                                    $total_tax += $sales_detail->tax_amount;
                                    $tot = $sales_detail->net_amount + $sales_detail->tax_amount;
                                    $grand_total += $tot;
                                }
                                ?>
                                <tr style="border-top: 1px solid #bcbcbc;font-weight: 600;">
                                    <td colspan="6" style="text-align: right;">Total Qty</td>
                                    <td><?= $qty_total; ?></td>
                                </tr>
                                <tr style="font-weight: 600;">
                                    <td colspan="6" style="text-align: right;">Sub Total</td>
                                    <td><?= sprintf('%0.2f', $sub_total); ?></td>
                                </tr>
                                <tr style="font-weight: 600">
                                    <td colspan="6" style="text-align: right;">Tax</td>
                                    <td><?= sprintf('%0.2f', $total_tax); ?></td>
                                </tr>
                                <tr style="font-weight: 600;">
                                    <td colspan="6" style="text-align: right;">Total</td>
                                    <td><?= 'Rs.' . sprintf('%0.2f', $grand_total); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">

    window.print();
    setTimeout(function () {
        window.close();
    }, 2000);
</script>