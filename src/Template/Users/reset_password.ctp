<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Reset Password</title>

        <base href="<?= HTTP_ROOT; ?>" target="_self">

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
                position: relative !important;
                left: 0;
                top: -10px;              
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

                width: 100%;
                float: left;
                padding: 10px;
            }
        </style>
    </head>

    <body class="login-layout light-login loginbg-1">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">                           

                            <div class="space-24"></div>                           
                            <div class="space-32"></div>                           

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="logo-row-1">
                                            <img src="img/logo/smarthub-logo.png" />
                                            <img style="float:right;" src="img/logo/hdfc-logo.png" />
                                        </div>
                                        <div class="widget-main">

                                            <h4 class="header red lighter bigger" style="text-align: left;">
                                                <i class="ace-icon fa fa-key"></i>
                                                Reset Password 
                                            </h4>

                                            <?= $this->Flash->render() ?>

                                            <div class="space-6"></div>

                                            <?php echo $this->Form->create(NULL, ['type' => 'post', 'onsubmit' => 'return validatePwd()']); ?>
                                            <fieldset>

                                                <div class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <?php echo $this->Form->input('password', ['type' => 'password', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Password', 'maxlength' => 20, 'required' => FALSE]); ?>
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                    <p id="password_error" style="color: red; float: left; text-align: left;"></p>
                                                </div>

                                                <div class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <?php echo $this->Form->input('conf_password', ['type' => 'password', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Confrim Password', 'required' => FALSE]); ?>
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                    <p id="conf_password_error" style="color: red; float: left; text-align: left;"></p>
                                                </div>

                                                <div class="space"></div>

                                                <div class="clearfix">                                                    

                                                    <button type="submit" name="login" class="width-35 pull-right btn btn-sm btn-primary button-red">
                                                        <i class="ace-icon fa fa-lightbulb-o"></i>
                                                        <span class="bigger-110">Submit</span>
                                                    </button>                                                  

                                                </div>

                                                <div class="space-4"></div>
                                            </fieldset>                                           
                                            <?php echo $this->Form->end(); ?> 

                                        </div><!-- /.widget-main -->

                                        <div class="toolbar clearfix">
                                            <div>
                                                <!--<a href="#" data-target="#forgot-box" class="forgot-password-link">-->
                                                <a href="<?= HTTP_ROOT ?>"  class="forgot-password-link">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    Back to Login
                                                </a>
                                            </div>

                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->

                            </div><!-- /.position-relative -->

                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="components/jquery/dist/jquery.js"></script>       

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            function validatePwd() {
                var password = $('#password');
                var confPassword = $('#conf-password');
                if (!password.val()) {
                    $('#password_error').text('Please enter your password.');
                    password.focus();
                    return false;
                } else if (password.val().length < 8) {
                    $('#password_error').text('Password length must be greater than or equal to 8 character.');
                    password.focus();
                    return false;
                } else if (!password.val().match(/((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,15})/)) {
                    $('#password_error').text('Password must contain at least 1 capital letter , 1 small letter , 1 digit & a special letter.');
                    password.focus();
                    return false;
                } else if (!confPassword.val()) {
                    $('#password_error').text('');
                    $('#conf_password_error').text('Please enter confirm password.');
                    confPassword.focus();
                    return false;
                } else if (password.val() != confPassword.val()) {
                    $('#conf_password_error').text("Confirm password does't  matches with password.");
                    confPassword.focus();
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
