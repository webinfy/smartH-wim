<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title><?= SITE_NAME ?> : Payment Success</title>

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
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
            table#t01 {
                width: 100%;    
                background-color: #f1f1c1;
            }
        </style>
    </head>

    <body class="skin-2">    

        <div class="main-container ace-save-state container" id="main-container">
            <div class="main-content">                

                <?php echo $this->cell('Merchants::header', [$payment->webfront->merchant_id]); ?> 
                <div class="main-content-inner">               
                    <div class="page-content">    
                        <?php if ($payment->status == 1) { ?>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div style="width: 100%;float: left;text-align: right;padding: 10px;box-sizing: border-box;">
                                        <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                                            <a style="font-weight: bold;color: #155092;" href="<?= HTTP_ROOT ?>">Go Back To Dashboard</a>    
                                        <?php } ?>&nbsp;&nbsp; |&nbsp;&nbsp;
                                        <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                                            <a style="font-weight: bold;color: #155092;" href="<?= 'customer/view-transactions/' . $payment->webfront->user->uniq_id; ?>">Payment History</a>    
                                        <?php } ?>
                                    </div><br>

                                    <h2 style="color: #155092; font-size: 25px;text-align: center;">Thank you , your payment was successful. </h2><br><br>
                                    <br>
                                    <div style="right: 20px;margin-top:-30px;"><a  style="font-weight: bold;color: #DE3029;" href="<?= HTTP_ROOT . "customer/payments/download-receipt/" . $payment->id ?>">Download Receipt</a>&nbsp;&nbsp; |&nbsp;&nbsp;
                                        <a target="_blank" style="font-weight: bold;color: #DE3029;" href="<?= HTTP_ROOT . "customer/payments/print-receipt/" . $payment->id ?>">Print Receipt</a></div>
                                    <div class="content-main-area">
                                        <h2 style="font-size: 18px;">Customer Information </h2>
                                        <table style="width:100%">
                                            <tr>
                                                <th>Name</th>                                               
                                                <th>Email</th> 
                                                <th>Phone No. </th>
                                                <?php
                                                $payeeCustomFields = json_decode($payment->payee_custom_fields, true);
                                                if (count($payeeCustomFields)) {
                                                    foreach ($payeeCustomFields as $payeeCustomField) {
                                                        ?>
                                                        <th><?= $payeeCustomField['field'] ?> </th>                                               
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><?= $payment->name ?></td>                                               
                                                <td><?= !empty($payment->email) ? $payment->email : 'NA' ?></td>
                                                <td><?= !empty($payment->phone) ? $payment->phone : 'NA'; ?></td>
                                                <?php
                                                $payeeCustomFields = json_decode($payment->payee_custom_fields, true);
                                                if (count($payeeCustomFields)) {
                                                    foreach ($payeeCustomFields as $payeeCustomField) {
                                                        ?>                                              
                                                        <td> &nbsp; <?= $payeeCustomField['value'] ?> </td>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>    
                                        </table>
                                        <br>
                                        <h2 style="font-size: 18px;">Payment Information</h2>
                                        <table id="t01">

                                            <tr>
                                                <?php
                                                $paymentCustomFields = json_decode($payment->payment_custom_fields, true);
                                                if (count($paymentCustomFields)) {
                                                    foreach ($paymentCustomFields as $key => $value) {
                                                        ?>
                                                        <th><?= $key ?></th>                                            
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                $paymentCustomFields = json_decode($payment->payment_custom_fields, true);
                                                if (count($paymentCustomFields)) {
                                                    foreach ($paymentCustomFields as $key => $value) {
                                                        ?>
                                                        <th><?= $value ?></th>                                            
                                                    <?php } ?>
                                                <?php } ?>                                       
                                            </tr> 
                                            <?php
                                            $colspan = count($paymentCustomFields);
                                            $colspanShow = $colspan - 1;
                                            ?>
                                            <tr>
                                                <td colspan="<?= $colspanShow ?>" style="color: #155092;font-weight: bold;font-size: 15px;text-align: right;">Net Bill Amount</td>
                                                <td style="font-weight: bold;">Rs. <?= ($payment->paid_amount) ?></td>
                                            </tr>
                                        </table>                                 
                                    </div>    
                                </div><!-- /.row -->     
                            </div><!-- /.row -->    

                        <?php } else { ?>
                            <div class="page-header">
                                <h1 style="text-align: center; font-size: 30px; color: red;"> Invalid Transaction. Please try again.</h1>                          
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table align="center">
                                        <tr>
                                            <td style="font-size: 16px;" colspan="2">
                                                <h2 style="font-size: 20px; text-align: center;"><a href="<?= HTTP_ROOT ?>">Go Back To Dashboard</a>. </h2>     
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>


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


