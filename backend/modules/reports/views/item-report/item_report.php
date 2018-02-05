<html>
    <head>
    </head>
    <body>
        <h4 style="text-align: center;">Item Sales Report</h4>
        <table style="border: 1px solid; border-collapse: collapse;width: 100%;">
            <thead>
                <tr style="background-color: #649bd0;">
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Sl.No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Item Code</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Item_name</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">KG Sold</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Cartons Sold</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Sale Amount</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Total GST</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $kg_tot = 0;
                $carton_tot = 0;
                $order_tot = 0;
                $tax_tot = 0;
                foreach ($model_report as $value) {
                    $i++;
                    ?>
                    <tr>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $i ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->item_code ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->item_name ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->qty ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->carton ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->line_total ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->tax_amount ?></td>
                    </tr>
                    <?php
                    $kg_tot += $value->qty;
                    $carton_tot += $value->carton;
                    $order_tot += $value->line_total;
                    $tax_tot += $value->tax_amount;
                }
                ?>
                <tr>
                    <th colspan="3" style="border: 1px solid;font-size: 12px;padding: 5px 3px;text-align: center">Total</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $kg_tot; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $carton_tot; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($order_tot, 2)) . ' (S$)'; ?></th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= Yii::$app->SetValues->NumberFormat(round($tax_tot, 2)) . ' (S$)'; ?></th>
                </tr>
            </tbody>
        </table>
    </body>
</html>