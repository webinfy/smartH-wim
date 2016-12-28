<?php
$late_fee_amount = 0;
$amount = $payment->fee + $payment->convenience_fee_amount;
if (date('Y-m-d') > date('Y-m-d', strtotime($payment->uploaded_payment_file->payment_cycle_date))) {
    $late_fee_amount = $payment->late_fee_amount;
}
$amount += $late_fee_amount;
?>


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

<div class="main-content"> 

    <?php echo $this->cell('Merchants::header', [$payment->webfront->merchant_id]); ?>  

    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">                           

            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                    Pay Online for <span style="color: green;"><?= $merchant->name ?></span>
                </h1>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?php if (!empty($payment->note)) { ?>
                        <h2 style="text-align: center; font-size: 22px; font-weight: bold; color: #004184;">                                    
                            <?= $payment->note ?>
                        </h2>
                    <?php } ?>
                    <div class="go-back-box">
                        <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                            <a style="font-weight: bold;color: #155092;" href="<?= HTTP_ROOT ?>">Go Back To Dashboard</a>    
                        <?php } ?>&nbsp;&nbsp; |&nbsp;&nbsp;
                        <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                            <a style="font-weight: bold;color: #155092;" href="<?= 'customer/view-transactions/' . $payment->webfront->user->uniq_id; ?>">Payment History</a>    
                        <?php } ?>
                    </div><br>
                    <form action="customer/payments/pay-now-redirect/<?= $payment->uniq_id ?>" role="form" class="form-horizontal ng-pristine ng-valid">
                        <h2 style="font-size: 18px;">Customer Details </h2>
                        <div class="content-main-area">
                            <table style="width:100%">
                                <tr>
                                    <th><?= $payment->webfront->customer_name_alias ?></th>
                                    <th><?= $payment->webfront->customer_email_alias ?></th> 
                                    <th><?= $payment->webfront->customer_phone_alias ?> </th>
                                    <?php
                                    $payeeCustomFields = json_decode($payment->payee_custom_fields, TRUE);
                                    if (count($payeeCustomFields) > 0) {
                                        foreach ($payeeCustomFields as $payeeCustomField) {
                                            ?>
                                            <th><?= $payeeCustomField['field'] ?></th>                                            
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td><?= $payment->name ?></td>
                                    <td><?= $payment->email ?></td>
                                    <td><?= $payment->phone ?></td>
                                    <?php
                                    $payeeCustomFields = json_decode($payment->payee_custom_fields, TRUE);
                                    if (count($payeeCustomFields) > 0) {
                                        foreach ($payeeCustomFields as $payeeCustomField) {
                                            ?>
                                            <td><?= $payeeCustomField['value'] ?></td>                                            
                                            <?php
                                        }
                                    }
                                    ?>                                      
                                </tr>   
                            </table>
                            <br>
                            <h2 style="font-size: 18px;">Payment Details</h2>
                            <table id="t01">
                                <tr>
                                    <th>Due Date</th>
                                    <?php
                                    $paymentCustomFields = json_decode($payment->payment_custom_fields, TRUE);
                                    if (count($paymentCustomFields) > 0) {
                                        foreach ($paymentCustomFields as $paymentCustomField) {
                                            ?>
                                            <th><?= $paymentCustomField['field'] ?></th>                                              
                                            <?php
                                        }
                                    }
                                    ?>                                      
                                    <th>Total Amount </th>                                            
                                    <th>Convenience Fee </th>                                            
                                    <th>Late Fee </th>                                           
                                    <?php if ($payment->status == 1) { ?> 
                                        <th>Status </th>  
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td><?= date('M d, Y', strtotime($payment->uploaded_payment_file->payment_cycle_date)); ?></td>
                                    <?php
                                    $paymentCustomFields = json_decode($payment->payment_custom_fields, TRUE);
                                    if (count($paymentCustomFields) > 0) {
                                        foreach ($paymentCustomFields as $paymentCustomField) {
                                            ?>
                                            <td>Rs. <?= $paymentCustomField['value'] ?></td>                                          
                                            <?php
                                        }
                                    }
                                    ?>
                                    <td>Rs. <?= $payment->fee ?></td>
                                    <td>Rs. <?= $payment->convenience_fee_amount ?></td>                                          
                                    <td>Rs. <?= $late_fee_amount ?></td>                                         
                                    <?php if ($payment->status == 1) { ?> 
                                        <td style="color: green; font-weight: bold;">Paid</td>   
                                    <?php } ?>
                                </tr>
                                <?php
                                $colspan = 4 + count($paymentCustomFields) + (($payment->status == 1) ? 1 : 0);
                                $colspanShow = $colspan - 1;
                                ?>
                                <tr>
                                    <td colspan="<?= $colspanShow; ?>" style="color: #155092;font-weight: bold;font-size: 15px;text-align: right;">Net Bill Amount</td>
                                    <td style="font-weight: bold;">Rs. <?= ($amount) ?></td>
                                </tr>
                            </table>        
                        </div>
                        <?php if ($payment->status == 0) { ?>           

                            <div class="form-group">
                                <div class="as-from-box">                                           
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> &nbsp; </label> 
                                    <div class="col-sm-6 control-label no-padding-right ng-binding" style="text-align: left; color: green; font-weight: bold;"> 
                                        <div class="terms-box">
                                            <input type="checkbox" value="1" required="required" />
                                            <a href="javascript:;" onclick="NewWindow(siteUrl + 'term-and-conditions', 'Term & Conditions', 750, 600, true)">
                                                <label style="font-weight: bold;">Accept Term & Conditions</label>
                                            </a>
                                        </div>
                                        <button type="submit"  class="btn btn-warning" style="margin:0 5px;">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Pay Now
                                        </button>              

                                        <a href="<?= "webfronts/basic/" . $payment->webfront->url ?>" class="btn">
                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                            Back
                                        </a>
                                    </div>       

                                </div>
                            </div>

                        <?php } ?>
                    </form>
                </div><!-- /.row -->     
            </div><!-- /.row -->  
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
