<html>
    <head>
    </head>
    <body>
        <h4 style="text-align: center;">Item Wise Stock Report</h4>
        <table style="border: 1px solid; border-collapse: collapse;width: 100%;">
            <thead>
                <tr style="background-color: #649bd0;">
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Sl.No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Item_name</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Item Code</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Available Carton</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Available Weight</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Available Pieces</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($model_report as $value) {
                    $i++;
                    ?>
                    <tr>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $i ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value['item_name'] ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value['item_code'] ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value['available_carton'] ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value['available_weight'] ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value['available_pieces'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </body>
</html>