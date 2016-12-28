<div class="main-content">

    <?php echo $this->cell('Merchants::header', [$payment->webfront->merchant_id]); ?>

    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content" style="min-height: 500px;"> 
            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                    Login Confirmation         
                </h1>
            </div><!-- /.page-header -->
            <div class="row" >
                <div class="col-xs-12" style="text-align: center;">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="" method="POST" role="form" class="form-horizontal ng-pristine ng-valid">
                        <!-- #section:elements.form -->
                        <div class="form-group">
                            <label style="font-size: 20px; line-height: 40px; margin-top: 40px;"> 
                                You are currently logged in as <strong><?php echo $this->request->session()->read('Auth.User.email') ?></strong>. <br/>
                                Are you sure you want to continue? 
                            </label>
                        </div>  

                        <div class="form-group">
                            <a href="<?= HTTP_ROOT . "customer/#/pay-now/{$payment->uniq_id}" ?>" class="btn btn-success" >
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Yes
                            </a>
                            &nbsp; &nbsp; &nbsp;
                            <a href="<?= HTTP_ROOT . "customer/logout/{$merchant->uniq_id}" ?>" class="btn btn-default" >
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Logout
                            </a>
                        </div>

                    </form>
                    <!--<div class="hr hr-24"></div>-->
                </div><!-- /.col -->
            </div><!-- /.row -->    

        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

