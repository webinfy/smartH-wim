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
                                                    <td colspan="2">
                                                        <h3>Customer Information</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Name </td>
                                                    <td> &nbsp;: <?= $payment->name ?> </td>
                                                </tr>
                                                <tr>
                                                    <td> Email </td>
                                                    <td> &nbsp;: <?= $payment->email ?> </td>
                                                </tr>
                                                <tr>
                                                    <td> Phone No. </td>
                                                    <td> &nbsp;: <?= $payment->phone ?> </td>
                                                </tr>

                                                <?php
                                                $payeeCustomFields = json_decode($payment->payee_custom_fields, true);
                                                if (count($payeeCustomFields)) {
                                                    foreach ($payeeCustomFields as $payeeCustomField) {
                                                        ?>
                                                        <tr>
                                                            <td> <?= $payeeCustomField['field'] ?> </td>
                                                            <td> &nbsp;: <?= $payeeCustomField['value'] ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>

                                                <tr>
                                                    <td colspan="2">
                                                        <h3>Payment Information</h3>
                                                    </td>
                                                </tr>

                                                <?php
                                                $paymentCustomFields = json_decode($payment->payment_custom_fields, true);
                                                if (count($paymentCustomFields)) {
                                                    foreach ($paymentCustomFields as $paymentCustomField) {
                                                        ?>
                                                        <tr>
                                                            <td> <?= $paymentCustomField['field'] ?> </td>
                                                            <td> &nbsp;: Rs. <?= $paymentCustomField['value'] ?> </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>

                                                <tr>
                                                    <td> Convenience Fee </td>
                                                    <td> &nbsp;: Rs. <?= $payment->convenience_fee_amount ?> </td>
                                                </tr>

                                                <?php if (!empty($payment->late_fee_amount)) { ?>
                                                    <tr>
                                                        <td> Late Fee </td>
                                                        <td> &nbsp;: Rs. <?= $payment->late_fee_amount ?> </td>
                                                    </tr>
                                                <?php } ?>

                                                <tr>
                                                    <td> Total Amount. </td>
                                                    <td> &nbsp;: Rs. <?= ($payment->fee + $payment->convenience_fee_amount + $payment->late_fee_amount) ?> </td>
                                                </tr>
                                            </table>
                                        </td>                                       
                                    </tr>                                   
                                </table>   

                                <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                                    <h2 style="color: #72BDEF; font-size: 16px; text-align: center; color: green;"><a href="">Go Back To Dashboard</a>. </h2>     
                                <?php } ?>

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


