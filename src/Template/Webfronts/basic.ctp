<div class="main-content">             
    <?php echo $this->cell('Merchants::header', [$webfront->merchant_id]); ?>  
    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content" style="min-height: 500px;"> 
            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                    <?= $webfront->title ?>           
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="webfront">                                    
                        <div class="webfront_main">
                            <div class="web_left">

                                <?php if (!empty($webfront->logo)) { ?>
                                    <div class="bnnr profile_cont"> 
                                        <img  src="<?= WEBFRONT_LOGO . $webfront->logo ?>"> 
                                    </div>
                                <?php } else if (!empty($webfront->user->merchant_profile->logo)) { ?>
                                    <div class="bnnr profile_cont"> 
                                        <img  src="<?= MERCHANT_LOGO . $webfront->user->merchant_profile->logo ?>"> 
                                    </div>
                                <?php } ?>

                                <div class="get_in_tch">
                                    <h3 class="touch">Get in Touch</h3>
                                    <ul>
                                        <li class="no_border"><span class="phn_number"></span>
                                            <p class="contact_us ng-binding"><strong>Call</strong><br>
                                                <?= $webfront->phone ?>
                                            </p>
                                        </li>
                                        <li class="no_border"><span class="email"></span>
                                            <p class="contact_us"><strong>Email</strong><br>
                                                <a class="mail_thrw ng-binding" href="mailto:<?= $webfront->email ?>"><?= $webfront->email ?></a>
                                            </p>
                                        </li>
                                        <li class="no_border"><span class="address"></span>
                                            <p class="contact_us ng-binding"><strong>Address</strong><br>
                                                <?= $webfront->address ?> 
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="web_right"> 
                                <h2 class="head">
                                    <span> Payment Description</span>                                                
                                </h2>
                                <div style="clear: both;">&nbsp;</div>
                                <div class="wbfrnt_desc"><?= $webfront->description ?></div>  

                                <div class="space-4"></div>
                                <div class="space-4"></div>
                                <div class="space-4"></div>
                                <!--<div class="hr hr-24"></div>--> 

                                <?php if ($webfront->is_published == 1) { ?>

                                    <?php if (empty($payments) || $payments->count() <= 0) { ?>
                                        <div class="col-xs-12">                                            
                                            <div class="row">  
                                                <form method="POST">
                                                    <h2 class="head">
                                                        <span> Please enter your phone to pay your bill</span>                                                
                                                    </h2>
                                                    <div class="col-xs-6" style="padding-left: 0;">  
                                                        <input name="phone" class="form-control phone" placeholder="Please enter you phone no" required="required" maxlength="15" autocomplete="off" id="name" type="text">
                                                    </div>  
                                                    <div class="col-xs-4"> 
                                                        <button type="submit" class="pay_btn"> Pay Now </button>    
                                                    </div> 
                                                </form>
                                            </div>  
                                        </div>  
                                    <?php } ?>

                                    <?php if (!empty($error)) { ?>                                                
                                        <h4 style='color:red;font-size:15px;'><?= $error ?></h4>
                                    <?php } ?>

                                    <div class="col-xs-12">                                            
                                        <div class="row"> 
                                            <a style="font-size: 16px;" href="<?= HTTP_ROOT . "customer/login/{$webfront->user->uniq_id}" ?>">Click here to login to Customer Dashboard</a>
                                        </div> 
                                    </div> 

                                    <div style="clear: both;">&nbsp;</div>
                                    <div class="space-4"></div>

                                    <?php if (!empty($payments) && $payments->count() > 0) { ?>
                                        <div class="content-main-area">
                                            <div class="row">                                
                                                <div class="col-xs-12">                                                      
                                                    <h2 class="head"><span> Pending Payments </span></h2>                                                               
                                                    <table id="simple-table" class="table  table-bordered table-hover" ng-init="myWebfronts()">
                                                        <thead>
                                                            <tr>                                                                 
                                                                <th style="text-align: center;"> Name </th>
                                                                <th style="text-align: center;"> Bill Amount </th>                                                                       
                                                                <th style="text-align: center;"> Transaction Status </th>
                                                                <th style="text-align: center;"> Payment Status </th>
                                                                <th style="text-align: center;"> Payment Date </th>
                                                                <th style="text-align: center;"> Payment Cycle Date </th>
                                                                <th style="text-align: center;"> Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>  
                                                            <?php foreach ($payments as $payment) { ?>
                                                                <tr> 
                                                                    <td style="text-align: center;"> <?= $payment->name ?> </td>
                                                                    <td style="text-align: center;"> <?= 'Rs.' . $payment->fee ?> </td>
                                                                    <td style="text-align: center;"> <?= !empty($payment->unmappedstatus) ? $payment->unmappedstatus : '--' ?> </td>
                                                                    <td style="text-align: center;"> <?= ($payment->status == 1) ? 'Paid' : 'Unpaid'; ?> </td>
                                                                    <td style="text-align: center;"> 
                                                                        <?= ($payment->status == 1) ? date('M d, Y', strtotime($payment->payment_date)) : '--' ?> 
                                                                    </td>                                            
                                                                    <td style="text-align: center;"> <?= date('M d, Y', strtotime($payment->uploaded_payment_file->payment_cycle_date)) ?> </td>                                            
                                                                    <td style="text-align: center; vertical-align: middle;">  
                                                                        <?php if ($payment->status == 1) { ?>
                                                                            <a href="<?= HTTP_ROOT . "customer/payments/download-receipt/" . $payment->id ?>" title="Pay Now"><span class="label label-success arrowed-in-right arrowed">Download Receipt</span></a>
                                                                        <?php } else { ?>
                                                                            <a href="<?= HTTP_ROOT . "customer/payments/pay-now/" . $payment->uniq_id ?>" title="Pay Now"><span class="label label-success arrowed-in-right arrowed">Pay Now</span></a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr> 
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>                                                            
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>                                                
                                <?php } ?>                                                

                            </div>
                        </div>
                    </div>

                    <!--<div class="hr hr-24"></div>-->
                </div><!-- /.col -->
            </div><!-- /.row -->    

        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
