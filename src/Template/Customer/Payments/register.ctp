<div class="main-content">
    <?php echo $this->cell('Merchants::header', [$merchant->id]); ?>
    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content" style="min-height: 500px;"> 
            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">
                    Customer Registration         
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12" style="margin-left: 15%;">
                    <!-- PAGE CONTENT BEGINS -->
                    <form action="" method="POST" role="form" class="form-horizontal ng-pristine ng-valid">
                        <!-- #section:elements.form -->
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Name : </strong> </label> 
                            <div class="col-sm-6 ">                                
                                <label class="control-label" style="text-transform: capitalize;"> <?= $getUser->name ?> </label>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Email : </strong> </label> 
                            <div class="col-sm-6 ">                                
                                <label class="control-label"> <?= $getUser->email ?> </label>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Phone No : </strong> </label> 
                            <div class="col-sm-6">                                
                                <label class="control-label"> <?= $getUser->phone ?> </label>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Password : </strong> </label> 
                            <div class="col-sm-6">                                
                                <input type="password"  name="password" id="password" class="form-control" placeholder="Password" style="width: 60%;" pattern=".{6,15}"  title="6 to 15 characters" maxlength="15" required="required" />
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> <strong>Confirm Password : </strong> </label> 
                            <div class="col-sm-6 ">                                
                                <input type="password"  name="confirm_password"  id="confirm_password" class="form-control" placeholder="Confirm Password" style="width: 60%;" pattern=".{6,15}" title="6 to 15 characters" maxlength="15" minlength="6" required="required" oninput="check(this)" />
                            </div>
                        </div> 

                        <script language='javascript' type='text/javascript'>
                            function check(input) {
                                if (input.value != document.getElementById('password').value) {
                                    input.setCustomValidity("Confrim Password doesn't matches with password.");
                                } else {
                                    // input is valid -- reset the error message
                                    input.setCustomValidity('');
                                }
                            }
                        </script>

                        <div class="form-group clearfixXX form-actionsXX">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-success" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Submit
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
