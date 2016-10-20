<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>SmartHub : Payment Success</title>

        <base href="<?= HTTP_ROOT; ?>" target="">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/ace-skins.css" />       
        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>     
        <?php echo $this->element('script_file'); ?>
    </head>

    <body class="skin-2">        

        <!--
        <div id="navbar" class="navbar navbar-default ace-save-state">
            <div class="navbar-container ace-save-state" id="navbar-container">               
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>              
                <div class="navbar-header pull-left">                   
                    <a href="<?= HTTP_ROOT ?>" class="navbar-brand"> <small> <i class="fa fa-leaf"></i> SmartHub Customer </small> </a>
                </div>
            </div>
        </div>  
        -->

        <div class="main-container ace-save-state container" id="main-container">
            <div class="main-content">

                <div id="navbar" class="navbar navbar-default ace-save-state" style="background: #bbb;">
                    <div class="main-container ace-save-state container" id="main-container" style="background: #f1f1f1;">
                        <div style="width: 100%; float: left;  padding: 10px;">
                            <div style="width: 30%; float: left;"> <img style="margin-top: 20px;" src="img/logo/smarthub-logo.png" /></div>
                            <div style="width: 40%; float: left; text-align: center;">
                                <img style="width: 250px;" src="<?= !empty($merchant['merchant_profile']['logo']) ? MERCHANT_LOGO . $merchant['merchant_profile']['logo'] : 'img/logo/web-info-mart-logo.png' ?>" />
                            </div>
                            <div style="width: 30%; float: left;"><img style="float:right; margin-top: 20px;" src="img/logo/hdfc-logo.png" /></div>
                        </div>
                    </div>
                </div>

                <div class="main-content-inner">               
                    <div class="page-content">    
                        <!--<div ng-include=""></div>-->
                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 30px; color: #DC5043;"> Failed!! </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <table align="center">
                                    <tr>
                                        <td style="font-size: 16px;" colspan="2">
                                            <h2 style="color: #72BDEF; font-size: 25px;"> Sorry your last transaction was failed due to some reason. Please try again </h2>     
                                            <table align="center" style="line-height: 35px; font-size: 14px;">
                                                <tr>
                                                    <td> Merchant </td>
                                                    <td> &nbsp;: <?= $merchant->name ?> </td>
                                                </tr>
                                                <tr>
                                                    <td> Customer Name </td>
                                                    <td> &nbsp;: <?= $payment->name ?> </td>
                                                </tr>
                                                <tr>
                                                    <td> Customer Id </td>
                                                    <td> &nbsp;: <?= $payment->user->cust_id ?> </td>
                                                </tr>
                                                <tr>
                                                    <td> Payment Amount </td>
                                                    <td> &nbsp;: Rs. <?= $payment->total_fee ?> </td>
                                                </tr>
                                            </table>
                                        </td>                                       
                                    </tr>                                   
                                </table>                          

                            </div><!-- /.row -->     
                        </div><!-- /.row -->     

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <?= $this->element('Customer/footer'); ?>

            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div>
    </body>
</html>


