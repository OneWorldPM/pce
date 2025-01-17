<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<?php
$uri_segment = $this->uri->segment(2);
$uri_segment1 = $this->uri->segment(3);

$user_role = $this->session->userdata('role');
$user_name = ucfirst($this->session->userdata('uname'));
?>
<html lang="en">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <meta charset="UTF-8">
        <title>PCE | Admin</title>
        <!-- start: META -->
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- end: META -->
        <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/png">  
        <!-- start: GOOGLE FONTS -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/googlefonts.css">
        <!--<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />-->
        <!-- end: GOOGLE FONTS -->
        <!-- start: MAIN CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/themify-icons/themify-icons.min.css">
        <link href="<?= base_url() ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
        <!-- end: MAIN CSS -->
        <!-- start: CLIP-TWO CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/styles.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/plugins.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/themes/theme-1.css" id="skin_color" />
        <!-- end: CLIP-TWO CSS -->
        <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>front_assets/css/custom.css" media="screen" />

        <link href="<?= base_url() ?>assets/vendor/select2/select2.min.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/vendor/DataTables/css/DT_bootstrap.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">

        <link href="<?= base_url() ?>assets/vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
        <link href="<?= base_url() ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/iCheck/all.css"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/vendor/iCheck/minimal/blue.css"  />

        <link href="<?= base_url() ?>assets/css/myset.css" rel="stylesheet" type="text/css"/>
        <!-- <link rel="stylesheet" type="text/css" href="assets/toggel/css/on-off-switch.css"/> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

        <!-- <script type="text/javascript" src="assets/toggel/js/on-off-switch.js"></script> -->
        <!-- <script type="text/javascript" src="assets/toggel/js/on-off-switch-onload.js"></script> -->
        <script src="<?= base_url() ?>front_assets/js/custom.js?v=4"></script>
        <?= getSocketScript()?>


        <!--****** PubNub Stuff *****-->
        <!-- DO NOT use production keys on the localhost-->
        <?=pubnub_keys()?>
        <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.14.0.min.js"></script>

        <style type="text/css">
            .action-row{
                margin: 10px 0;
            }
            table thead tr th,
            table tbody tr td{
                text-align: center
            }
        </style>

    </head>

    <!-- end: HEAD -->
    <body>
        <div id="app">
            <!-- sidebar -->
            <div class="sidebar app-aside" id="sidebar">
                <div class="sidebar-container perfect-scrollbar">
                    <nav>

                        <ul class="main-navigation-menu">
                            <li class="<?= ($uri_segment == 'dashboard') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/dashboard" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="ti-home"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Dashboard </span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li class="<?= ($uri_segment == 'live_support_chat') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/live_support_chat" id="live_support_chat">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-life-ring" aria-hidden="true"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Live Support Chat</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php if ($user_role == 'super_admin') { ?>
                                <li class="<?= ($uri_segment == 'user') ? 'active' : ''; ?>" >
                                    <a href="<?= site_url() ?>admin/admins" id="dash">
                                        <div class="item-content">
                                            <div class="item-media">
                                                <i class="fa fa-user-circle"></i>
                                            </div>
                                            <div class="item-inner">
                                                <span class="title">Admin Users</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>

                                <li class="<?= ($uri_segment == 'user') ? 'active' : ''; ?>" >
                                    <a href="<?= site_url() ?>admin/user" id="dash">
                                        <div class="item-content">
                                            <div class="item-media">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <div class="item-inner">
                                                <span class="title">Users</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            <li class="<?= ($uri_segment == 'presenters') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/presenters" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Presenters</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li class="<?= ($uri_segment == 'sessions') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/sessions" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-tv"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Sessions</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li class="<?= ($uri_segment == 'chat_with_attendee') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/chat_with_attendee" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-commenting"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Attendee Chat</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php if ($user_role == 'super_admin') { ?>
							<li class="<?= ($uri_segment == 'eposters') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/eposters" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-tv"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">ePosters</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if ($user_role == 'super_admin') { ?>
                            <li class="<?= ($uri_segment == 'sponsors') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/sponsors " id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Sponsors</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if ($user_role == 'super_admin') { ?>
                            <li class="<?= ($uri_segment == 'plan_pricing') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/plan_pricing" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-money"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Plan & Pricing </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if ($user_role == 'super_admin') { ?>
                            <li class="<?= ($uri_segment == 'promo_code') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/promo_code" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-gift"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Promo Code </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if ($user_role == 'super_admin') { ?>
                            <li class="<?= ($uri_segment == 'cms_setting') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/cms_setting" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-file-text"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Cms Setting </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

                            <li class="<?= ($uri_segment == 'tracking') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/tracking" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-tv"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Tracking</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php if ($user_role == 'super_admin') { ?>
                            <li class="<?= ($uri_segment == 'sessions_configurations') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/sessions_configurations" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-cogs"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Configurations </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

                            <?php if ($user_role == 'super_admin') { ?>
							 <li class="<?= ($uri_segment == 'graphics') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/graphics" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-photo"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Graphics</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>

							 <li class="<?= ($uri_segment == 'push_notifications') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/push_notifications" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-send"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Push Notifications</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

							 <li class="<?= ($uri_segment == 'dummy_user') ? 'active' : ''; ?>">
                                <a href="<?= site_url() ?>admin/dummy_user" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Guest User</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <?php if ($user_role == 'super_admin') { ?>
                            <li class="<?= ($uri_segment == 'music_setting') ? 'active' : ''; ?>" >
                                <a href="<?= site_url() ?>admin/music_setting" id="dash">
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i class="fa fa-cog"></i>
                                        </div>
                                        <div class="item-inner">
                                            <span class="title">Music Setting </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php } ?>
							
                        </ul>
                    </nav>
                </div>
            </div>


            <!-- / sidebar -->
            <div class="app-content">
                <!-- start: TOP NAVBAR -->
                <header class="navbar navbar-default navbar-static-top">

                    <!-- start: NAVBAR HEADER -->
                    <div class="navbar-header">
                        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
                            <i class="ti-align-justify"></i>
                        </a>
                        <a class="navbar-brand" href="<?= base_url() ?>admin/dashboard">
                            <img src="<?= base_url() ?>front_assets/images/pce_logo.png" class="kent_logo" alt="PCE Logo" style="max-width: 150px"/>
                        </a>
                        <a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
                            <i class="ti-align-justify"></i>
                        </a>
                        <a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="ti-view-grid"></i>
                        </a>
                    </div>
                    <!-- end: NAVBAR HEADER -->
                    <!-- start: NAVBAR COLLAPSE -->
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-right">

                            <li style="margin-top: 20px;margin-right: 15px;">
                                <span style="color: green;font-weight: bold;">Total Users Online: <span id="online-users-count">--</span></span>
                            </li>

                            <li class="dropdown current-user">
                                <a href class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= base_url() ?>assets/images/Avatar.png" alt="admin"> <span class="username"><?=$user_name?> <i class="ti-angle-down"></i></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-dark">
                                    <li>
                                        <a href="<?= base_url() ?>admin/stripe_key_setting">
                                            Stripe Key Setting
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>admin/changepassword">
                                            Change Password
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() ?>admin/alogin/logout">
                                            Log Out
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                    </div>

                </header>
                <!-- end: TOP NAVBAR -->

                <!-- end: TOP NAVBAR -->
                <script>
                    //function extract(variable) {
                    //    for (var key in variable) {
                    //        window[key] = variable[key];
                    //    }
                    //}
                    //
                    //$.get("<?//=base_url()?>//socket_config.php", function (data) {
                    //    var config = JSON.parse(data);
                    //    extract(config);
                    //
                    //    socket.emit("getSessionViewUsers", socket_app_name, function (resp) {
                    //        if (resp) {
                    //            var totalUsers = resp.users ? resp.users.length : 0;
                    //            var sessionId = resp.sessionId;
                    //            //$(".totalAttende" + sessionId + " b").html(totalUsers);
                    //            $('#online-users-count').html(totalUsers);
                    //        }
                    //    });
                    //
                    //    socket.on('activeUserListPerApp', function(data) {
                    //        if (data == null)
                    //            return;
                    //
                    //        var result = [];
                    //        var keys = Object.keys(data);
                    //        keys.forEach(function(key){
                    //            result.push(data[key]);
                    //        });
                    //        const mySet = new Set(result);
                    //        const uniqValuesArray = [...mySet];
                    //
                    //        $('#online-users-count').html(uniqValuesArray.length);
                    //    });
                    //
                    //    socket.emit('getActiveUserListPerApp', socket_app_name);
                    //
                    //    socket.on('userActiveChangeInApp', function() {
                    //        socket.emit('getActiveUserListPerApp', socket_app_name);
                    //
                    //        // socket.emit("getSessionViewUsers", socket_app_name, function (resp) {
                    //        //     if (resp) {
                    //        //         var totalUsers = resp.users ? resp.users.length : 0;
                    //        //         var sessionId = resp.sessionId;
                    //        //         //$(".totalAttende" + sessionId + " b").html(totalUsers);
                    //        //         $('#online-users-count').html(totalUsers);
                    //        //     }
                    //        // });
                    //    });
                    //
                    //    socket.on("newViewUsers",function(resp){
                    //        if(resp){
                    //            var totalUsers=resp.users?resp.users.length:0;
                    //            var sessionId=resp.sessionId;
                    //            $(".totalAttende"+sessionId+" b").html(totalUsers);
                    //        }
                    //    });
                    //
                    //});
                </script>
