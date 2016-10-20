<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Login Page - Smarthub by HDFC Bank</title>

        <base href="<?= HTTP_ROOT; ?>" target="">

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.css" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.css" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <style>
            /*******Succes & Error Message Start*******/
            div.message::before {
                background-color: #fff;
                border-radius: 15px;
                color: #1AAF65;
                content: "i";
                display: inline-block;
                font-size: 16px;
                left: -11px;
                padding: 2px 11px 2px 5px;
                position: relative;
                text-align: center;
                vertical-align: middle;
                width: 12px;
            }
            div.message {
                background-color: #1AAF65;
                color: #FFF;
                cursor: pointer;
                display: block;
                font-size: 13px;
                font-weight: normal;
                overflow: hidden;
                padding: 5px 15px;
                /*                position: fixed;
                                right: 15px;
                                top: 40px;*/
                transition: height 300ms ease-out 0s;
                z-index: 999;
            }
            div.message.error {
                background-color: #C3232D;
                color: #FFF;
            }
            div.message.error:before {   
                color: #C3232D;
                content: "x";
            }
            .logo-row-1 {
                background: #e5e6e8;
                width: 100%;
                float: left;
                padding: 10px;
            }
        </style>
    </head>

    <body class="login-layout light-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">

                            <div class="center">
                                <h4 class="blue" id="id-company-text">&copy; <img src="img/logo/web-info-mart-logo.png" /></h4>                              
                            </div>

                            <div class="space-6"></div>                           

                            <div class="position-relative" style="margin-top: 60px;">




                                <div id="signup-box" class="signup-box widget-box  visible no-border" style="display: block; margin-bottom: 40px;">
                                    <div class="widget-body">

                                        <div class="logo-row-1">
                                            <img src="img/logo/smarthub-logo.png" />
                                            <img style="float:right;" src="img/logo/hdfc-logo.png" />
                                        </div>

                                        <div class="widget-main">
                                            <h4 class="header green lighter bigger">
                                                <i class="ace-icon fa fa-users blue"></i>
                                                New User Registration
                                            </h4>

                                            <?= $this->Flash->render() ?>

                                            <div class="space-6"></div>
                                            <p> Enter your details to begin: </p>


                                            <?php echo $this->Form->create($user, ['type' => 'post']); ?>

                                            <fieldset>

                                                <!--<input type="hidden" name="id" class="form-control" value="Email" />-->

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <?php echo $this->Form->input('email', ['class' => "form-control", 'div' => FALSE, 'label' => FALSE, 'readonly' => TRUE]); ?>
                                                        <!--<input type="email" name="email" class="form-control" placeholder="Email" readonly="" />-->
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>

                                                <!--
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" class="form-control" placeholder="Username" />
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>
                                                
                                                -->

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" class="form-control" name="confirm_password" placeholder="Repeat password" required=""  />
                                                        <i class="ace-icon fa fa-retweet"></i>
                                                    </span>
                                                </label>

                                                <label class="block">
                                                    <input type="checkbox" class="ace" required="" />
                                                    <span class="lbl">
                                                        I accept the
                                                        <a href="#">User Agreement</a>
                                                    </span>
                                                </label>

                                                <div class="space-24"></div>

                                                <div class="clearfix">
                                                    <button type="reset" class="width-30 pull-left btn btn-sm">
                                                        <i class="ace-icon fa fa-refresh"></i>
                                                        <span class="bigger-110">Reset</span>
                                                    </button>

                                                    <button type="submit" class="width-65 pull-right btn btn-sm btn-success">
                                                        <span class="bigger-110">Register</span>
                                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                    </button>
                                                </div>
                                            </fieldset>

                                            <?php echo $this->Form->end(); ?>

                                        </div>

                                        <div class="toolbar center">
                                            <!--<a href="<?= HTTP_ROOT ?>" data-target="#login-box" class="back-to-login-link">-->
                                            <a href="<?= HTTP_ROOT ?>" class="back-to-login-link">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                Back to login
                                            </a>
                                        </div>
                                    </div><!-- /.widget-body -->
                                </div>

                                <!-- /.signup-box -->
                            </div><!-- /.position-relative -->

                            <!--<div class="navbar-fixed-top align-right">
                                    <br />
                                    &nbsp;
                                    <a id="btn-login-dark" href="#">Dark</a>
                                    &nbsp;
                                    <span class="blue">/</span>
                                    &nbsp;
                                    <a id="btn-login-blur" href="#">Blur</a>
                                    &nbsp;
                                    <span class="blue">/</span>
                                    &nbsp;
                                    <a id="btn-login-light" href="#">Light</a>
                                    &nbsp; &nbsp; &nbsp;
                            </div>-->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="components/jquery/dist/jquery.js"></script>

        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='components/_mod/jquery.mobile.custom/jquery.mobile.custom.js'>" + "<" + "/script>");
        </script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function ($) {
                $(document).on('click', '.toolbar a[data-target]', function (e) {
                    e.preventDefault();
                    var target = $(this).data('target');
                    $('.widget-box.visible').removeClass('visible');//hide others
                    $(target).addClass('visible');//show target
                });
            });

            //you don't need this, just used for changing background
            jQuery(function ($) {
                $('#btn-login-dark').on('click', function (e) {
                    $('body').attr('class', 'login-layout');
                    $('#id-text2').attr('class', 'white');
                    $('#id-company-text').attr('class', 'blue');

                    e.preventDefault();
                });
                $('#btn-login-light').on('click', function (e) {
                    $('body').attr('class', 'login-layout light-login');
                    $('#id-text2').attr('class', 'grey');
                    $('#id-company-text').attr('class', 'blue');

                    e.preventDefault();
                });
                $('#btn-login-blur').on('click', function (e) {
                    $('body').attr('class', 'login-layout blur-login');
                    $('#id-text2').attr('class', 'white');
                    $('#id-company-text').attr('class', 'light-blue');

                    e.preventDefault();
                });

            });
        </script>
    </body>
</html>
