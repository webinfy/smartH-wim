<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="javascript:;">Home</a>
                </li>

                <li>
                    <a href="javascript:;"> Bills & payments </a>
                </li>
                <li class="active"> Pay Now </li>
            </ul><!-- /.breadcrumb -->

            <!-- #section:basics/content.searchbox -->
            <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->

            <!-- /section:basics/content.searchbox -->
        </div>

        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">        

            <?php echo $this->element('change_skin'); ?>

            <div class="page-header">
                <h1>
                    Payment Details                 
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form">
                        <!-- #section:elements.form -->


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Merchant : </label> 
                            <div class="col-sm-6 pull-left">                                
                                <label style="text-align: left;" class="col-sm-8 control-label no-padding-right" for="form-field-1"> Eagle Colony </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Merchant Phone : </label> 
                            <div class="col-sm-6 pull-left">                                
                                <label style="text-align: left;" class="col-sm-8 control-label no-padding-right" for="form-field-1"> 8564676838 </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Merchant Address : </label> 
                            <div class="col-sm-6 pull-left">                                
                                <label style="text-align: left;" class="col-sm-8 control-label no-padding-right" for="form-field-1"> BBSR, Rasulgarh </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Due Date : </label> 
                            <div class="col-sm-6 pull-left">                                
                                <label style="text-align: left;" class="col-sm-8 control-label no-padding-right" for="form-field-1"> 17 July, 2016 </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Fee Amount : </label> 
                            <div class="col-sm-6 pull-left">                                
                                <label style="text-align: left;" class="col-sm-8 control-label no-padding-right" for="form-field-1"> Rs. 1000.00 </label>
                            </div>
                        </div>


                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Pay Now
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="hr hr-24"></div>
                </div><!-- /.col -->
            </div><!-- /.row -->     

        </div><!-- /.page-content -->



    </div>
</div><!-- /.main-content -->
