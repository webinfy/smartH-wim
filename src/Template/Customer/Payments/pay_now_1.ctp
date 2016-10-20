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


        <!--        <div id="navbar" class="navbar navbar-default          ace-save-state">
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
                    </div>
                </div>   -->

        <div class="main-container ace-save-state container" id="main-container">

            <?= $this->Flash->render() ?>  

            <!-- /section:basics/sidebar -->
            <div class="main-content">

                <div id="navbar" class="navbar navbar-default ace-save-state" style="background: #bbb;">
                    <div class="main-container ace-save-state container" id="main-container" style="background: #f1f1f1;">
                        <div style="width: 100%; float: left;  padding: 10px;">
                            <div style="width: 30%; float: left;"> <img style="margin-top: 20px;" src="img/logo/smarthub-logo.png" /></div>
                            <div style="width: 40%; float: left; text-align: center;"><img style="width: 180px;" src="img/logo/web-info-mart-logo.png" /></div>
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
                                Make Payment                 
                            </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <form ng-init="viewPaymentDetail()" role="form" class="form-horizontal ng-pristine ng-valid">
                                    <!-- #section:elements.form -->

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Merchant : </label> 
                                        <div class="col-sm-6 pull-left">                                
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->merchant->name ?> </label>
                                        </div>
                                    </div> 

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Merchant Note: </label> 
                                        <div class="col-sm-6 pull-left">                                
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->uploaded_payment_file->note ?>  </label>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Customer Name : </label> 
                                        <div class="col-sm-6 pull-left">                                
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->name ?> </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Customer Email : </label> 
                                        <div class="col-sm-6 pull-left">                                
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->email ?> </label>
                                        </div>
                                    </div>                                    

                                    <?php
                                    $customFields = json_decode($payment->uploaded_payment_file->custom_fields);
                                    $customFieldValues = json_decode($payment->custom_fields);
                                    ?>
                                    <?php if (count($customFields) > 0) { ?>
                                        <?php foreach ($customFields as $key => $value) { ?>
                                            <div class="form-group ng-scope">
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right ng-binding"> <?= $value ?> : </label> 
                                                <div class="col-sm-6 pull-left">                                
                                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;">Rs. <?= $customFieldValues->$key ?> </label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>


                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Due Date : </label> 
                                        <div class="col-sm-6 pull-left">                                
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= date('M d, Y', strtotime($payment->due_date)); ?> </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Total Due : </label> 
                                        <div class="col-sm-6 pull-left">                                
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> Rs. <?= $payment->total_fee ?> </label>
                                        </div>
                                    </div>

                                    <?php if ($payment->status == 1) { ?>              
                                        <div class="form-group">
                                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Status : </label> 
                                            <div class="col-sm-6 pull-left">                                
                                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left; color: green; font-weight: bold;"> Paid </label>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if ($payment->status == 0) { ?>                                    
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <a href="customer/payments/pay-now-redirect/<?= $payment->uniq_id ?>" class="btn btn-info">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Pay Now
                                                </a>
                                                &nbsp; &nbsp; &nbsp;
                                                <a href="customer/#/payment-and-bills" class="btn">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Cancel
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>


                                </form>
                                <div class="hr hr-24"></div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->     

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
                                    jQuery(function ($) {
                                        $('[data-rel=tooltip]').tooltip({container: 'body'});
                                        $('[data-rel=popover]').popover({container: 'body'});
                                    });
        </script>
    </body>
</html>


