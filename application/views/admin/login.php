<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
        <!-- start: META -->
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="icon" href="<?= base_url() ?>assets/images/favicon.png" type="image/png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
        <!-- end: GOOGLE FONTS -->
        <!-- start: MAIN CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css">
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

        <!-- START alerify CSS -->
        <link href="<?= base_url() ?>assets/alertify/alertify.core.css" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url() ?>assets/alertify/alertify.default.css" rel="stylesheet" type="text/css"/>
        <!-- END -->

        <style type="text/css">
            .login{
                background: url('<?= base_url() ?>assets/images/background_image.jpg') no-repeat center center;
                background-size: cover;
                background-origin: content-box;
                background-attachment: fixed;
            }
            .main-login .box-login{
                border-radius: 0;
                padding: 25px 0 0;
            }
            .box-login{
                margin-top: 30% !important;
            }
            fieldset {
                background: #ffffff;
                border: 1px solid #e6e8e8;
                border-radius: 5px;
                margin: 20px 20px 20px 20px;
                padding: 25px;
                position: relative;
            }
            .btn {
                padding: 6px 25px 6px 25px;
            }

        </style>

        <script src="<?= base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <!-- end: HEAD -->
    <body id="login" class="login">
        <div class="row">
            <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
                <!-- start: LOGIN BOX -->
                <div class="box-login">
                    <form class="form-login" id="frm_login" name="frm_login" method="post" action="<?= base_url() ?>admin/alogin/authentication">
                        <div class="row">
                            <div style="text-align: center">                           
                                <img style="width:50%" src="<?= base_url() ?>front_assets/images/pce_logo.png" alt="admin" >
                            </div>
                        </div>
                        <fieldset>
                            <?php
                            echo ($this->session->flashdata('msg')) ? $this->session->flashdata('msg') : '';
                            ?> 
                            <h4 class="box-title">Sign In</h4>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Username">
                                    <i class="fa fa-user"></i> 
                                </span></span><span id="erroremail" style="color:red;"></span>
                            </div>
                            <div class="form-group form-actions">
                                <span class="input-icon">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    <i class="fa fa-lock"></i>
                                </span></span><span id="errorpassword" style="color:red;"></span>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-green form-control" id="btn_login">
                                    Log In
                                </button>
                            </div>

                        </fieldset>
                    </form>
                </div>
                <!-- end: LOGIN BOX -->
            </div>
        </div>  
        <!-- start: MAIN JAVASCRIPTS -->
        <script src="<?= base_url() ?>assets/vendor/modernizr/modernizr.js"></script>
        <script src="<?= base_url() ?>assets/vendor/jquery-cookie/jquery.cookie.js"></script>
        <script src="<?= base_url() ?>assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="<?= base_url() ?>assets/vendor/switchery/switchery.min.js"></script>
        <!-- end: MAIN JAVASCRIPTS -->

        <!-- START alerify JS -->    
        <script src="<?= base_url() ?>assets/alertify/alertify.min.js" type="text/javascript"></script>
        <!-- END -->

        <!-- start: CLIP-TWO JAVASCRIPTS -->
        <script src="<?= base_url() ?>assets/js/main.js"></script>
        <!-- start: JavaScript Event Handlers for this page -->

        <script>
            jQuery(document).ready(function () {
                Main.init();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#btn_login").on("click", function () {
                    if ($("#email").val().trim() == "") {
                        $("#erroremail").text("Please Enter Email").fadeIn('slow').fadeOut(5000);
                        return false;
                    } else if ($("#password").val() == "") {
                        $("#errorpassword").text("Please Enter Password").fadeIn('slow').fadeOut(5000);

                        return false;
                    } else {
                        return true; //submit form
                    }
                    return false; //Prevent form to submitting
                });
            });
        </script>
        <!-- end: JavaScript Event Handlers for this page -->
        <!-- end: CLIP-TWO JAVASCRIPTS -->
    </body>
</html>
