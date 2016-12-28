<div class="main-content">
    <?php echo $this->cell('Merchants::header', [$merchant->id]); ?>  
    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">    
            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                    View Payment History & Upcoming Payments
                </h1>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <form role="form" class="form-horizontal tranfrom-box">
                        <input type="hidden" id='merchnat-id' name="merchnat_id" value="<?= $merchant->id ?>" />
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Merchant :  </label>
                            <div class="col-sm-9  no-padding-left">                                
                                <label style="text-align: left;" class="col-sm-12 control-label no-padding-right ng-binding" for="form-field-1"> <?= $merchant->name ?> </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> Phone No. :  </label>
                            <div class="col-sm-9">
                                <input id="customer-phone" type="text" class="col-xs-10 col-sm-10 phone" placeholder="Enter Customer Phone No." maxlength="15" >
                            </div>
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right">&nbsp; </label>
                            <div class="col-sm-9" id='error-msg' style="color: red; margin-top: 5px; display: none;">
                                Invalid Phone
                            </div>
                        </div>
                        <!--<div class="space-4"></div>-->    
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <a  href="javascript:;" onclick='viewTransactions()'  class="btn btn-info"> <i class="ace-icon fa fa-check bigger-110"></i> Search </a>
                                &nbsp; &nbsp; &nbsp;
                                <button onclick="$('#view-bills-and-payments').hide();" type="reset" class="btn"> <i class="ace-icon fa fa-undo bigger-110"></i> Reset </button>
                            </div>
                        </div>
                    </form>
                    <!--<div class="hr hr-24"></div>-->

                </div><!-- /.col -->
            </div><!-- /.row -->   

            <div class="row" id="view-bills-and-payments" style="display: none;">
                <div class='col-xs-12'>
                    <h3 class='header smaller lighter blue'> Bills & Payments </h3>
                    <div class="content-main-area">
                        <table class='table table-striped table-bordered table-hover'>
                            <thead>
                                <tr>   
                                    <th style='text-align: left;'> Name </th>
                                    <th style='text-align: left;'> Email </th>
                                    <!--<th style='text-align: left;'> Phone </th>-->
                                    <th style='text-align: right;'> Bill Amount </th>                                   
                                    <th style='text-align: center;'> Due Date </th>
                                    <th style='text-align: center;'> Payment Date </th>
                                    <th style='text-align: center;'> Transaction Status </th>
                                    <th style='text-align: center;'> Payment Status </th>
                                    <th style='text-align: center;'> Action </th>
                                </tr>
                            </thead>
                            <tbody id="ajax-content"> 
                                <!-- Ajax Content-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.page-content -->

    </div>
</div><!-- /.main-content -->
