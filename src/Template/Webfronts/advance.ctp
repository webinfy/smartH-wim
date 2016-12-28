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
                                <?php if ($webfront->is_published == 1) { ?>
                                    <div class="wbfrnt_paynow"><a href="<?= HTTP_ROOT . "webfronts/pay-now/" . $webfront->url ?>" class="pay_btn" > Pay Now </a></div>                                          
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



