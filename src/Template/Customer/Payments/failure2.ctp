<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Payment Failure</title>

        <base href="<?= HTTP_ROOT; ?>" target="_self">
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

        <div class="main-container ace-save-state container" id="main-container">
            <div class="main-content">
                
                <?php echo $this->cell('Merchants::header', [$payment->webfront->merchant_id]); ?>

                <div class="main-content-inner">               
                    <div class="page-content">    
                        <!--<div ng-include=""></div>-->
                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 30px;"> Failed!! </h1>
                        </div><!-- /.page-header -->
                        <div class="row">
                            <div class="col-xs-12">
                                <table align="center">
                                    <tr>
                                        <td style="font-size: 16px;" colspan="2">
                                            <h2 style="color: #72BDEF; font-size: 25px;">Your Last transaction was failed </h2>   
                                        </td>                                       
                                    </tr>                                   
                                </table>                          
                                <!--<div style="position: absolute; bottom: 10px; right: 20px;"><a href="<?= HTTP_ROOT . "customer/payments/download-receipt/" . $payment->id ?>"><img style="width: 50px;" src="img/download-128.png" /></a></div>-->
                            </div><!-- /.row -->     
                        </div><!-- /.row -->     

                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <?= $this->element('footer'); ?>

            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
            
        </div>
    </body>
</html>


