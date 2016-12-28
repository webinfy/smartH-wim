<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>SmartHub</title>

        <base href="<?= HTTP_ROOT; ?>" target="_self">
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

        <div class="main-container ace-save-state container" id="main-container">

            <?= $this->Flash->render() ?>  

            <!-- /section:basics/sidebar -->
            <div class="main-content">             

                <?php echo $this->cell('Merchants::header', [$payment->uploaded_payment_file->webfront->merchant_id]); ?>  

                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">                           

                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                                Bill payment for the merchant <span style="color: green;"><?= $merchant->name ?></span>
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">                               
                                <!-- PAGE CONTENT BEGINS -->

                                <form role="form" class="form-horizontal ng-pristine ng-valid" style="width: 500px; margin: auto;">
                                    <!-- #section:elements.form --> 

                                    <div class="form-group">                                      
                                        <h4 class="col-md-offset-3">Customer Details</h4>                                        
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  Name : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->name ?> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  Email : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->email ?> </label>
                                    </div>    

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  Phone : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $payment->phone ?> </label>
                                    </div>                                    

                                    <?php
                                    $payeeCustomFields = json_decode($payment->payee_custom_fields, TRUE);
                                    if (count($payeeCustomFields) > 0) {
                                        foreach ($payeeCustomFields as $payeeCustomField) {
                                            ?>
                                            <div class="form-group ng-scope">
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right ng-binding"> <?= $payeeCustomField['field'] ?> : </label> 
                                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"><?= $payeeCustomField['value'] ?> </label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="form-group">
                                        <h4 class="col-md-offset-3">Payment Details</h4>
                                    </div>

                                    <?php
                                    $paymentCustomFields = json_decode($payment->payment_custom_fields, TRUE);
                                    if (count($paymentCustomFields) > 0) {
                                        foreach ($paymentCustomFields as $paymentCustomField) {
                                            ?>
                                            <div class="form-group ng-scope">
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right ng-binding"> <?= $paymentCustomField['field'] ?> : </label> 
                                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;">Rs. <?= $paymentCustomField['value'] ?> </label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Due Date : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= date('M d, Y', strtotime($payment->uploaded_payment_file->webfront->payment_cycle_date)); ?> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Convenience Fee : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> Rs. <?= $payment->convenience_fee_amount ?> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Late Fee : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> Rs. <?= $payment->late_fee_amount ?> </label>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Total Amount : </label> 
                                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> Rs. <?= ($payment->fee + $payment->convenience_fee_amount + $payment->late_fee_amount) ?> </label>
                                    </div>

                                    <?php if ($payment->status == 1) { ?>              
                                        <div class="form-group">
                                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Status : </label> 
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left; color: green; font-weight: bold;"> Paid </label>
                                        </div>
                                    <?php } ?>

                                    <?php if ($payment->status == 0) { ?>                                    
                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-md-8">
                                                <a href="customer/payments/pay-now-redirect/<?= $payment->uniq_id ?>" class="btn btn-warning">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Pay Now
                                                </a>
                                                &nbsp; &nbsp; &nbsp;
                                                <a href="webfronts/basic/<?= $payment->uploaded_payment_file->webfront->url ?>" class="btn">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Back
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>                                       
                                <!--<div class="hr hr-24"></div>-->
                            </div><!-- /.col -->
                        </div><!-- /.row -->   
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <?= $this->element('footer'); ?>

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


