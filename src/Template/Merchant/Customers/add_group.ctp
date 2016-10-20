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
                    <a href="javascript:;">Forms</a>
                </li>
                <li class="active">Form Elements</li>
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
            <!-- /.ace-settings-container -->

            <!-- /section:settings.box -->

            <div class="page-header">
                <h1>
                    Add New Group                           
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form">
                        <!-- #section:elements.form -->


                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Group Name </label>
                            <div class="col-sm-9">
                                <input type="text" id="form-field-1" placeholder="Please enter group name." class="col-xs-10 col-sm-5" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Note </label>
                            <div class="col-sm-9">                                
                                <textarea maxlength="150" id="form-field-9" class="col-xs-20 col-sm-5 autosize-transition limited"></textarea>
                            </div>
                        </div>

                        <!--<div class="hr hr-16 hr-dotted"></div>-->

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-top" for="duallist"> Select Fields for the Group </label>
                            <div class="col-sm-8">                               
                                <select multiple="multiple" size="10" name="duallistbox_demo1[]" id="duallist">
                                    <option  selected="selected"> ID </option>
                                    <option  selected="selected"> Name </option>
                                    <option  selected="selected"> Email </option>
                                    <option  selected="selected"> Phone No </option>
                                    <option> Custom Field 1</option>
                                    <option> Custom Field 2</option>
                                    <option> Custom Field 3</option>
                                    <option> Custom Field 4</option>
                                    <option> Custom Field 5</option>                               
                                </select>                               
                                <div class="hr hr-16 hr-dotted"></div>
                            </div>
                        </div>




                        <!--
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> &nbsp; </label>
                            <div class="col-sm-9">
                                <a onclick="addCustomFields()" class="btn btn-primary btn-xs" href="javascript:void(0);"><i class="fa fa-plus"></i> Add Custom Fields</a>
                            </div>
                        </div>
                        -->


                        <div id="custom_fields_box">


                            <!--                            <div class="form-group custom_fields" >
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Custom Field <span class="custom_field_counter"></span> </label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="form-field-1" placeholder="Give alias name for custom field" class="col-xs-10 col-sm-5" />
                                                                &nbsp; <a onclick="removeCustomField(1);" title="" data-toggle="tooltip" class="btn btn-danger btn-xs" href="javascript:void(0);" data-original-title="Delete Row"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </div>   
                            
                                                        <div class="form-group custom_fields" >
                                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Custom Field <span class="custom_field_counter"></span> </label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="form-field-1" placeholder="Give alias name for custom field" class="col-xs-10 col-sm-5" />
                                                                &nbsp; <a onclick="removeCustomField(2);" title="" data-toggle="tooltip" class="btn btn-danger btn-xs" href="javascript:void(0);" data-original-title="Delete Row"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </div>   -->


                        </div>








                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="submit">
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

