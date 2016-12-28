<div class="main-content">    
    <?php echo $this->cell('Merchants::header', [$merchant->id]); ?>  
    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content" style="min-height: 500px;"> 
            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                    Send OTP              
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="" method="POST" role="form" class="form-horizontal ng-pristine ng-valid">
                        <!-- #section:elements.form -->
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Phone No : </strong> </label> 
                            <div class="col-sm-6">                                
                                <input type="text" required="required"  name="phone" class="form-control phone" maxlength="15" placeholder="Enter your phone number." />
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-success" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Send OTP
                                </button>
                                &nbsp; &nbsp; &nbsp;
                                <button class="btn btn-default" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--<div class="hr hr-24"></div>-->
                </div><!-- /.col -->
            </div><!-- /.row -->    

        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

