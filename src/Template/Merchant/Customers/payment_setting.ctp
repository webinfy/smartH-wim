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
                    <a href="<?php echo HTTP_ROOT . "merchant/my-customers" ?>"> Customers Group </a>
                </li>
                <li class="active"> Payment Setting </li>
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
                    Payment Setting for the group : Eangle Society                            
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form class="form-horizontal" role="form">
                        <!-- #section:elements.form -->

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Payment Type </label>
                            <div class="col-sm-8" style="padding-top: 5px;">                                  
                                <label style="width: 150px;">
                                    <input type="radio" class="ace" name="payment_type" onclick="$('#recurring_payment').hide();" checked="">
                                    <span class="lbl"> One Time </span>
                                </label>                               
                                <label style="width: 150px;">
                                    <input type="radio" class="ace" name="payment_type" onclick="$('#recurring_payment').show();">
                                    <span class="lbl"> Recurring  </span>
                                </label>
                            </div>
                        </div>

                        <div id='recurring_payment' style="display: none;">

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Recurring Period </label>
                                <div class="col-sm-8" style="padding-top: 5px;">                                  
                                    <label style="width: 150px;">
                                        <input type="radio" class="ace" name="form-field-radio" onclick="$('.rec_setting').hide(), $('#rec_week').show();">
                                        <span class="lbl"> Weekly </span>
                                    </label>                               
                                    <label style="width: 150px;">
                                        <input type="radio" class="ace" name="form-field-radio" onclick="$('.rec_setting').hide(), $('#rec_month').show();">
                                        <span class="lbl"> Monthly  </span>
                                    </label>
                                    <label style="width: 150px;">
                                        <input type="radio" class="ace" name="form-field-radio" onclick="$('.rec_setting').hide(), $('#rec_annul').show();">
                                        <span class="lbl"> Annually  </span>
                                    </label>

                                </div>
                            </div>

                            <div class="rec_setting" id='rec_week' style="display: none;"> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Which Day </label>
                                    <div class="col-sm-9">
                                        <select class="form-control" style="max-width: 120px;">
                                            <option>Select Day</option>
                                            <option>Sunday</option>
                                            <option>Monday</option>
                                            <option>Tuesday</option>
                                            <option>Thursday</option>
                                            <option>Friday</option>
                                            <option>Saturday</option>
                                            <option>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="rec_setting" id='rec_month' style="display: none;"> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  Which Day </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="form-field-1" placeholder="Day of the month" class="col-xs-10 col-sm-5" />
                                    </div>
                                </div>
                            </div>

                            <div class="rec_setting" id='rec_annul' style="display: none;"> 

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Which Month </label>
                                    <div class="col-sm-9">
                                        <select class="form-control" style="max-width: 150px;">
                                            <option>Select Month</option>
                                            <option>January</option>
                                            <option>February</option>
                                            <option>March</option>
                                            <option>April</option>
                                            <option>May</option>
                                            <option>June</option>
                                            <option>July</option>
                                            <option>August</option>
                                            <option>September</option>
                                            <option>October</option>
                                            <option>November</option>
                                            <option>December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">  Which Day </label>
                                    <div class="col-sm-9">
                                        <input type="text" id="form-field-1" placeholder="Day of the month" class="col-xs-10 col-sm-5" />
                                    </div>
                                </div>

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
