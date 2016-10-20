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
                    <a href="javascript:;"> Customers </a>
                </li>
                <li class="active"> Import Customers </li>
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
                    Import Customer data from Excel                         
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form">
                        <!-- #section:elements.form -->



                        <div class="row">                                            
                            <div class="col-xs-6 col-sm-6">
                                <label for="id-date-picker-1"> Select Group </label>
                                <!-- #section:plugins/date-time.datepicker -->
                                <div class="form-controll">
                                    <select id="form-field-select-1" class="form-control" >
                                        <option value="">Select Group</option>
                                        <option value="">IDCO</option>                                                                                                                                          
                                        <option value="">Eagle</option>                                                       
                                        <option value="">SR</option>                                                       
                                    </select>  
                                </div>
                            </div>   


                            <div class="col-xs-6 col-sm-6">
                                <label for="id-date-picker-1">Browse File  &nbsp;<span style="color: red;">*(Excel Only)</span></label>                                           
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <!-- #section:custom/file-input -->
                                        <input type="file" id="id-input-file-2" />
                                    </div>
                                </div>
                            </div>  



                        </div>

                        <div class="space-4"></div>

                        <!--
                        <div class="row">                                            
                            <div class="col-xs-6 col-sm-6">
                                <label for="id-date-picker-1">Due date</label>                                           
                                <div class="input-group">
                                    <input type="text" data-date-format="dd-mm-yyyy" id="id-date-picker-1" class="form-control date-picker">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>  


                            <div class="col-xs-6 col-sm-6">
                                <label>Month</label>                               
                                <div class="form-controll">
                                    <select id="form-field-select-1" class="chosen-selectXX form-control" >
                                        <option value="">Select Month</option>
                                        <option value="">Jan</option>                                                                                                                                          
                                        <option value="">Feb</option>                                                                                                                                          
                                        <option value="">Mar</option>                                                                                                                                          
                                        <option value="">June</option>                                                                                                                                          
                                        <option value="">July</option>                                                                                                                                          
                                        <option value="">Aug</option>                                                                                                                                          
                                        <option value="">Sep</option>                                                                                                                                          
                                        <option value="">Oct</option>                                                                                                                                          
                                        <option value="">Nov</option>                                                                                                                                          
                                        <option value="">Dec</option>                                                                                                        
                                    </select>                                                
                                </div>
                            </div>  

                        </div>
                        
                        -->







                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9" style="text-align: right;">
                                <button class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Import
                                </button>

                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Reset
                                </button>
                            </div>
                        </div>

                        <div class="hr hr-24"></div>                             

                    </form>                                


                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->






