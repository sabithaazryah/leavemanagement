<html>
    <head>
    </head>
    <body>
        <h4 style="text-align: center;">Stock Report</h4>
        <table style="border: 1px solid; border-collapse: collapse;width: 100%;">
            <thead>
                <tr style="background-color: #649bd0;">
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Sl.No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Document Date</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Item Code</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Item_name</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Price</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Batch No.</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Weight In</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Weight Out</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Cartons In</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Cartons Out</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Piece In</th>
                    <th style="border: 1px solid;font-size: 12px;padding: 5px 3px;color: white;">Piece Out</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($model_report as $value) {
                    $i++;
                    ?>
                    <tr>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $i ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->document_date ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->item_code ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= $value->item_name ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->item_id) ? \common\models\ItemMaster::findOne($value->item_id)->MRP : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->batch_no) ? $value->batch_no : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->weight_in) ? $value->weight_in : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->weight_out) ? $value->weight_out : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->cartoon_in) ? $value->cartoon_in : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->cartoon_out) ? $value->cartoon_out : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->piece_in) ? $value->piece_in : ''; ?></td>
                        <td style="border: 1px solid;font-size: 12px;padding: 5px 3px;"><?= isset($value->piece_out) ? $value->piece_out : ''; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </body>
</html>