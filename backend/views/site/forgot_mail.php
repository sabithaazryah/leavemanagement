<?php

use yii\helpers\Html;
?>

<html>
        <head>
                <title>Forgot Password</title>
        </head>
        <body style="font-family: sans-serif !important;">

                <div style="/* margin: 20px 200px 0px 300px; */border: 1px solid #9E9E9E;">
                        <table border ="0"  class="main-tabl" border="0" style="width:100%;">
                                <thead>
                                        <tr>
                                                <th style="width:100%">
                                                        <div class="header" style="padding-bottom: 0px;">
                                                                <div class="main-header">
                                                                        <div class="" style=";padding-left: 40px;text-align: center;">
                                                                                <?php echo Html::img('http://' . Yii::$app->request->serverName . '/leave/images/logo.png', $options = ['width' => '100px', 'height' => '100px']) ?>
                                                                                <?php //echo Html::img('@web/admin/images/logos/logo-1.png', $options = ['width' => '200px']) ?>
                                                                        </div>
                                                                </div>
                                                                <br/>

                                                        </div>
                                                </th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                                <td style="width:100%">
                                                        <div class="content" style="margin-left: 40px;">
                                                                <h2 style="text-align: center;margin-bottom: 0px">FORGOT</h2>
                                                                <h3 style="text-align: center;margin-top: 0px;">YOUR PASSWORD ?</h3>
                                                                <p style="text-align: center;padding-bottom: 20px;">Not to worry, we got you! Let's get you a new password.</p>
                                                                <p style="text-align: center;"><a href="http://<?= Yii::$app->request->serverName ?>/leave/site/new-password?token=<?= $val ?>" style="display: inline-block;cursor: pointer;padding: 6px 12px;font-size: 13px;line-height: 1.42857143;text-decoration: none;color: #fff;border-color: #80b636;background-color: #8dc63f;border: 1px solid transparent;">Reset Password</a></p>
                                                        </div>

                                                </td>
                                        </tr>
                                </tbody>
                        </table>
                </div>

        </body>
</html>