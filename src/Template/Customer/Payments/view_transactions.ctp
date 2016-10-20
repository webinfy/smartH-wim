<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>SmartHub</title>

        <base href="<?= HTTP_ROOT; ?>" target="">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />
        <!-- page specific plugin styles -->
        <!--<link rel="stylesheet" href="components/bootstrap-duallistbox/dist/bootstrap-duallistbox.css" />-->
        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/ace-skins.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>     
        <?php echo $this->element('script_file'); ?>
    </head>

    <body class="skin-2">        


        <!--        <div id="navbar" class="navbar navbar-default ace-save-state">
                    <div class="navbar-container ace-save-state" id="navbar-container">               
                        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                            <span class="sr-only">Toggle sidebar</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>               
                        <div class="navbar-header pull-left">                   
                            <a href="javascript:;" class="navbar-brand">
                                <small>
                                    <i class="fa fa-leaf"></i>
                                    SmartHub Customer
                                </small>
                            </a>
                        </div>
                    </div>-->
    </div>   

    <div class="main-container ace-save-state container" id="main-container">

        <?= $this->Flash->render() ?>  

        <!-- /section:basics/sidebar -->
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
                <!--  
                <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="ace-icon fa fa-home home-icon"></i>
                            <a href="javascript:;">Home</a>
                        </li>
                        <li>
                            <a href="javascript:;"> Bills & payments </a>
                        </li>
                        <li>
                            <a href="customer/#/payment-and-bills"> Upcoming Payments </a>
                        </li>
                        <li class="active"> Pay Now </li>
                    </ul>                       
                </div>
                -->

                <!-- /section:basics/content.breadcrumbs -->
                <div class="page-content">    
                    <!--<div ng-include=""></div>-->
                    <div class="page-header">
                        <h1>
                            View Payment History & Upcoming Payments           
                        </h1>
                    </div><!-- /.page-header -->
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <form role="form" class="form-horizontal">

                                <input type="hidden" id='merchnat-id' name="merchnat_id" value="<?= $merchant->id ?>" />

                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Merchant :  </label>
                                    <div class="col-sm-6 pull-left no-padding-left">                                
                                        <label style="text-align: left;" class="col-sm-8 control-label no-padding-right ng-binding" for="form-field-1"> <?= $merchant->name ?> </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Customer Code :  </label>
                                    <div class="col-sm-9">
                                        <input id="customer-id" type="text" class="col-xs-10 col-sm-5" placeholder="Enter customer code to view your transactions." maxlength="10" >

                                    </div>

                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">&nbsp; </label>
                                    <div class="col-sm-9" id='error-msg' style="color: red; margin-top: 5px; display: none;">
                                        Invalid Customer code.
                                    </div>

                                </div>

                                <!--<div class="space-4"></div>-->    
                                <div class="form-group clearfixXX form-actionsXX">
                                    <div class="col-md-offset-3 col-md-9">
                                        <a  href="javascript:;" onclick='viewTransactions()'  class="btn btn-info"> <i class="ace-icon fa fa-check bigger-110"></i> Search </a>
                                        &nbsp; &nbsp; &nbsp;
                                        <button onclick="$('#view-bills-and-payments').hide();" type="reset" class="btn"> <i class="ace-icon fa fa-undo bigger-110"></i> Reset </button>
                                    </div>
                                </div>
                            </form>

                            <!--<div class="hr hr-24"></div>-->

                        </div><!-- /.col -->
                    </div><!-- /.row -->   

                    <div class="row" id="view-bills-and-payments" style="display: none;">
                        <div class='col-xs-12'>
                            <h3 class='header smaller lighter blue'> Bills & Payments  </h3>
                            <div>
                                <table class='table table-striped table-bordered table-hover'>
                                    <thead>
                                        <tr>                                    
                                            <th style='text-align: left;'> Merchant </th>
                                            <th style='text-align: left;'> Customer Name </th>
                                            <th style='text-align: left;'> Customer Email </th>
                                            <th style='text-align: right;'> Due Amount </th>                                   
                                            <th style='text-align: center;'> Due Date </th>
                                            <th style='text-align: center;'> Status </th>
                                            <th style='text-align: center;'> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="ajax-content"> 

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.page-content -->

            </div>
        </div><!-- /.main-content -->

        <?= $this->element('Customer/footer'); ?>

        <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container -->

        <!--<script src="components/jquery/dist/jquery.js"></script>-->
    <script src="components/bootstrap/dist/js/bootstrap.js"></script>

    <script src="assets/js/src/ace.js"></script>
    <script src="assets/js/src/ace.basics.js"></script>
    <script src="assets/js/src/ace.sidebar.js"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">

                                            function viewTransactions() {
                                                var merchnatId = $('#merchnat-id').val();
                                                var customerId = $('#customer-id').val().trim();
                                                if (customerId.length) {
                                                    $.get('customer/payments/ajax-view-transactions', {'merchnat_id': merchnatId, 'customer_id': customerId}, function (response) {
                                                        var response = JSON.parse(response);
                                                        if (response.status == 'success') {
                                                            $('#ajax-content').html(response.html);
                                                            $('#view-bills-and-payments').show();
                                                            $('#error-msg').html("").hide();
                                                        } else if (response.status == 'error') {
                                                            $('#view-bills-and-payments').hide();
                                                            $('#error-msg').html(response.msg).show();
                                                        }
                                                    });
                                                } else {
                                                    $('#customer-id').focus();
                                                }
                                            }

                                            $(document).on('keydown', '#customer-id', function (e) {
                                                if (e.keyCode == 32)
                                                    return false;
                                            });

                                            jQuery(function ($) {
                                                $('[data-rel=tooltip]').tooltip({container: 'body'});
                                                $('[data-rel=popover]').popover({container: 'body'});
                                            });
    </script>
</body>
</html>


