<?php
if (count($leaves) > 0) {
        ?>
        <table class="table table-bordered table-striped">
                <tr>
                        <th>Leave Name</th>
                        <th>Available Days</th>
                </tr>


                <?php
                foreach ($leaves as $value) {
                        $leave_type = \common\models\LeaveCategory::findOne($value->leave_type);
                        ?>
                        <tr>
                                <td><?= $leave_type->leave_name ?></td>
                                <td><?= $value->available_days ?></td>
                        </tr>
                <?php }
                ?>
        </table>

<?php } ?>
