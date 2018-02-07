<html>
    <head>
    </head>
    <body>
        <h4 style="text-align: center;">Sale Report</h4>
        <table style="border: 1px solid; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #649bd0;">
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Sl.No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Invoice No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Invoice Date</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Company Name</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">PO No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Invoice Address</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Amount</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Discount</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">GST</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Net Amount</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Paid</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $amount_tot = 0;
                $discount_tot = 0;
                $order_tot = 0;
                $tax_tot = 0;
                $paid_tot = 0;
                $balance_tot = 0;
                foreach ($model_report as $value) {
                    $i++;
                    ?>
                    <tr>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $i ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->sales_invoice_number ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->sales_invoice_date ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;">
                            <?php
                            if (isset($value->busines_partner_code)) {
                                $add = common\models\BusinessPartner::find()->where(['id' => $value->busines_partner_code])->one();
                                if (!empty($add)) {
                                    echo $add->company_name;
                                } else {
                                    echo '';
                                }
                            }
                            ?>
                        </td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->po_no ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->ship_to_adress ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->amount ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->discount_amount ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->tax_amount ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->order_amount ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->amount_payed ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->due_amount ?></td>
                    </tr>
                    <?php
                    $discount_tot += $value->discount_amount;
                    $amount_tot += $value->amount;
                    $order_tot += $value->order_amount;
                    $tax_tot += $value->tax_amount;
                    $paid_tot += $value->amount_payed;
                    $balance_tot += $value->due_amount;
                }
                ?>
                <tr>
                    <th colspan="6" style="border: 1px solid;font-size: 12px;padding: 5px 3px;text-align: center">Total</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($amount_tot, 2)) . ' (S$)'; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($discount_tot, 2)) . ' (S$)'; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($tax_tot, 2)) . ' (S$)'; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($order_tot, 2)) . ' (S$)'; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($paid_tot, 2)) . ' (S$)'; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($balance_tot, 2)) . ' (S$)'; ?></th>
                </tr>
            </tbody>
        </table>
    </body>
</html>