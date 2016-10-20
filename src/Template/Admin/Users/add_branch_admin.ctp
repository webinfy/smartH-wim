<!-- /section:basics/sidebar -->
<div class="main-content">
    <div class="main-content-inner">
        <!-- #section:basics/content.breadcrumbs -->
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="javascript:;"> Home </a>
                </li>

                <li>
                    <a href="javascript:;"> Branch Admins </a>
                </li>
                <li class="active"> Add New Branch Admin </li>
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
            <!-- #section:settings.box -->

            <?php echo $this->element('change_skin'); ?>

            <!-- /section:settings.box -->

            <div class="page-header">
                <h1>
                    Add New Branch Admin                            
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form">
                        <!-- #section:elements.form -->

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bank </label>
                            <div class="col-sm-9">
                                <select class="col-xs-10 col-sm-5">
                                    <option>Select Bank</option>
                                    <option>HDFC</option>
                                    <option>SBI</option>
                                    <option>Axis</option>
                                    <option>ICICI</option>
                                </select>                               
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Branch </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> IFSC Code </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="IFSC Code" class="col-xs-10 col-sm-5" />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Branch Code </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>   
                        

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> MICR Code </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>  

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> State </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>        

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> District </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>       

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Branch </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>      

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Contact </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Bank Name" class="col-xs-10 col-sm-5" />
                            </div>
                        </div>     


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bank Address </label>
                            <div class="col-sm-9">                                            
                                <textarea  class="col-xs-10 col-sm-5" placeholder="Bank Address"></textarea>
                            </div>
                        </div>


                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Submit
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Reset
                                </button>
                            </div>
                        </div>

                    </form>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

