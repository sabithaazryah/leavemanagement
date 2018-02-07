<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?= yii::$app->homeUrl; ?>images/fav.png" type="image/png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Xenon Boostrap Admin Panel" />
        <meta name="author" content="" />
        <title>Sales Invoice System</title>
        <script src="<?= Yii::$app->homeUrl; ?>js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
            var homeUrl = '<?= Yii::$app->homeUrl; ?>';
        </script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="page-body">
        <?php $this->beginBody() ?>


        <div class="page-container">
            <div class="sidebar-menu toggle-others fixed collapsed">

                <div class="sidebar-menu-inner">
                    <header class="logo-env">
                        <!-- logo -->
                        <div class="logo">
                            <a href="" class="logo-expanded">
                                <img width="45" height="" src="<?= Yii::$app->homeUrl ?>images/logo.png"/>
                            </a>

                            <a href="" class="logo-collapsed">
                                <img width="40" height="" src="<?= Yii::$app->homeUrl ?>images/fav.png"/>
                            </a>
                        </div>
                        <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                        <div class="mobile-menu-toggle visible-xs">
                            <a href="" data-toggle="user-info-menu">
                                <i class="fa-bell-o"></i>
                                <span class="badge badge-success">7</span>
                            </a>

                            <a href="" data-toggle="mobile-menu">
                                <i class="fa-bars"></i>
                            </a>
                        </div>
                        <!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->



                    </header>

                    <ul id="main-menu" class="main-menu">
                        <?php
                        if (Yii::$app->session['post']['admin'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-tachometer"></i>
                                    <span class="title">Administration</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Access Powers', ['/admin/admin-post/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Employees', ['/admin/employee/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['sales_invoice'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Sales Invoice</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Invoice Details', ['/sales/sales-invoice-details/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Create Invoice', ['/sales/sales-invoice-details/add'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['stock'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-cart-plus"></i>
                                    <span class="title">Stock</span>
                                </a>
                                <ul>
                                    <?php
                                    if (Yii::$app->session['post']['opening_stock'] == 1) {
                                        ?>
                                        <li>
                                            <?= Html::a('Opening Stock', ['/stock/stock/index'], ['class' => 'title']) ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (Yii::$app->session['post']['stock_adjustment'] == 1) {
                                        ?>
                                        <li>
                                            <?= Html::a('Stock Adjustment', ['/stock/stock/update'], ['class' => 'title']) ?>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li>
                                        <?= Html::a('Avilable Stock', ['/stock/stock-view/index'], ['class' => 'title']) ?>
                                    </li>

                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['reports'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-file"></i>
                                    <span class="title">Reports</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('Sale Report', ['/reports/sale-report/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Item Wise Sale Report', ['/reports/item-report/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Customer Sales Report', ['/reports/customer-sales-report/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Batch Wise Stock', ['/reports/batch-wise-stock/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Item Wise Stock', ['/reports/item-wise-stock/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Stock Register', ['/reports/stock-report/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->session['post']['masters'] == 1) {
                            ?>
                            <li>
                                <a href="">
                                    <i class="fa fa-building"></i>
                                    <span class="title">Masters</span>
                                </a>
                                <ul>
                                    <li>
                                        <?= Html::a('UOM', ['/masters/base-unit/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Item', ['/masters/item-master/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Locations', ['/masters/locations/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Customer', ['/masters/customer/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Supplier', ['/masters/supplier/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Tax', ['/masters/tax/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('Warehouse', ['/masters/warehouse/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                </div>

            </div>

            <div class="main-content">

                <nav class="navbar user-info-navbar"  role="navigation"><!-- User Info, Notifications and Menu Bar -->

                    <!-- Left links for user info navbar -->
                    <ul class="user-info-menu left-links list-inline list-unstyled">

                        <li class="hidden-sm hidden-xs">
                            <a href="" data-toggle="sidebar">
                                <i class="fa-bars"></i>
                            </a>
                        </li>
                        <li class="dropdown hover-line hover-line-notify" style="min-height: 48px;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                <i class="fa-bell-o"></i>
                                <!--<span class="badge badge-purple" id="notify-count"></span>-->
                                <span class="badge badge-purple" id="notify-count">6</span>
                            </a>
                            <ul class="dropdown-menu notifications">
                                <li class="top">
                                    <p class="small">
                                        <!--                                        <a href="#" class="pull-right">Mark all Read</a>-->
                                        You have <strong id="notify-counts"></strong> new notifications.
                                    </p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="user-info-menu left-links list-inline list-unstyled sit-title-ul">
                        <li class="sit-title-li">
                            <h5 class="sit-title">Sales Invoice System</h5>
                        </li>
                    </ul>
                    <!-- Right links for user info navbar -->
                    <ul class="user-info-menu right-links list-inline list-unstyled">

                        <li>
                            <a href="<?= Yii::$app->homeUrl; ?>site/home"><i class="fa-home"></i> Home</a>
                        </li>

                        <li class="dropdown user-profile">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                                <span>
                                    <?= Yii::$app->user->identity->user_name ?>
                                    <i class="fa-angle-down"></i>
                                </span>
                            </a>

                            <ul class="dropdown-menu user-profile-menu list-unstyled">
                                <li class="user-header">
                                    <img src="<?= yii::$app->homeUrl; ?>images/user-4.png" alt="user-image" class="img-circle" />
                                    <p>
                                        <?= Yii::$app->user->identity->name ?>
                                        <!--<small>Member since Nov. 2012</small>-->
                                    </p>
                                </li>
                                <li class="user-footer" style="background: #eeeeee;">
                                    <div class="row">
                                        <div class="pull-left">
                                            <?= Html::a('Profile', ['/admin/employee/update?id=' . Yii::$app->user->identity->id], ['class' => 'btn btn-white', 'style' => 'padding: 9px 20px;border: 1px solid #a09f9f;']) ?>
                                        </div>
                                        <div class="pull-right">
                                            <?php
                                            echo ''
                                            . Html::beginForm(['/site/logout'], 'post', ['style' => 'margin-bottom: 0px;']) . '<a>'
                                            . Html::submitButton(
                                                    'Sign out', ['class' => 'btn btn-white', 'style' => 'border: 1px solid #a09f9f;']
                                            ) . '</a>'
                                            . Html::endForm()
                                            . '';
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <!--                                <li>
                                <?php // Html::a('<i class="fa-wrench"></i>Change Password', ['/admin/admin-users/change-password'], ['class' => 'title'])  ?>
                                                                </li>
                                                                <li>
                                <?php // Html::a('<i class="fa-pencil"></i>Edit Profile', ['/admin/admin-users/update?id=' . Yii::$app->user->identity->id], ['class' => 'title'])  ?>
                                                                </li>-->

                                <?php
//                                echo '<li class="last">'
//                                . Html::beginForm(['/site/logout'], 'post') . '<a>'
//                                . Html::submitButton(
//                                        '<i class="fa-lock"></i> Logout', ['class' => 'btn logout_btn']
//                                ) . '</a>'
//                                . Html::endForm()
//                                . '</li>';
                                ?>


                            </ul>
                        </li>

                    </ul>

                </nav>
                <div class="row">


                    <?= $content; ?>


                </div>
                <footer class="main-footer sticky footer-type-1">

                    <div class="footer-inner">

                        <!-- Add your copyright text here -->
                        <div class="footer-text">
                            &copy; <?= Html::encode(date('Y')) ?>
                            <strong>Azryah</strong>
                            All rights reserved.
                        </div>


                        <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                        <div class="go-up">

                            <a href="#" rel="go-top">
                                <i class="fa-angle-up"></i>
                            </a>

                        </div>

                    </div>

                </footer>
            </div>




        </div>

        <div class="footer-sticked-chat"><!-- Start: Footer Sticked Chat -->

            <script type="text/javascript">
                function toggleSampleChatWindow()
                {
                    var $chat_win = jQuery("#sample-chat-window");

                    $chat_win.toggleClass('open');

                    if ($chat_win.hasClass('open'))
                    {
                        var $messages = $chat_win.find('.ps-scrollbar');

                        if ($.isFunction($.fn.perfectScrollbar))
                        {
                            $messages.perfectScrollbar('destroy');

                            setTimeout(function () {
                                $messages.perfectScrollbar();
                                $chat_win.find('.form-control').focus();
                            }, 300);
                        }
                    }

                    jQuery("#sample-chat-window form").on('submit', function (ev)
                    {
                        ev.preventDefault();
                    });
                }
            </script>



            <a href="#" class="mobile-chat-toggle">
                <i class="linecons-comment"></i>
                <span class="num">6</span>
                <span class="badge badge-purple">4</span>
            </a>

            <!-- End: Footer Sticked Chat -->
        </div>






        <!-- Imported styles on this page -->
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/fonts/meteocons/css/meteocons.css">

        <!-- Bottom Scripts -->



        <!-- JavaScripts initializations and stuff -->
        <script src="<?= Yii::$app->homeUrl; ?>js/xenon-custom.js"></script>
        <?php $this->endBody() ?>
    </body>

    <!------------------------------------------------------ popup---------------------------------------------------->
    <div class="modal fade" id="modal-6">
        <div class="modal-dialog" id="modal-pop-up" style="width:60%">

        </div>
    </div>


</html>
<?php $this->endPage() ?>