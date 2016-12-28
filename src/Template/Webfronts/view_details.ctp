<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>SmartHub</title>

        <base href="<?= HTTP_ROOT; ?>" target="_self">
        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css" />
        <!-- page specific plugin styles -->
        <!--<link rel="stylesheet" href="components/bootstrap-duallistbox/dist/bootstrap-duallistbox.css" />-->
        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/ace-fonts.css" />
        <link rel="stylesheet" href="assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="assets/css/ace-skins.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.css" />
        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script> window.jQuery || document.write('<script src="components/jquery/dist/jquery.js"><\/script>');</script>    
        <?php echo $this->element('script_file'); ?>        
        <script>
            var smarthub = {
                removeInvalidChars: function (d, a, c) {
                    var f = c != null ? c : event;
                    var h = f.charCode ? f.charCode : f.keyCode;
                    var g = String.fromCharCode(h);
                    if (h < 32 || h > 222 || h == 37 || h == 39) {
                        return;
                    }
                    var b = "[^" + d + "]";
                    a.value = a.value.replace(new RegExp(b, "g"), "");
                }
            }
            function chkEmailAvail(email) {
                $("#email_msg").html('');
                var url = '<?= HTTP_ROOT ?>';
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (email.match(re)) {
                    $("#emailloader_ajax").show();
                    $.get(url + "webfronts/ajaxCheckEmailAvail/" + email, function (response) {
                        if (response.mail_exist == 'yes') {
                            $("#email_msg").html("<p style='color:red;border: 0 none;font-size: 13px;left: -57px;position: absolute;top: 20px;width: 350px;'>This email address is already exist.</p>");
                        } else if (response.mail_exist == 'no') {
                            $("#email_msg").html("<p style='color:green;border: 0 none;font-size: 13px;left: -57px;position: absolute;top: 20px;width: 200px;'>You can use this email adress</p>");
                        }
                        $("#emailloader_ajax").hide();
                    }
                    , 'json');
                } else {
                    $("#email_msg").html('');
                }
            }
            function removeTextField(id) {
                $('#textfield-' + id).remove();
                changeTotalAmount(id);
            }
            function toggleRemove(id) {
                $('#remove-field-' + id).toggle();
                $('#payment-field-' + id).val('');

                var sum = 0;
                $("input[class *= 'add']").each(function () {
                    sum += +$(this).val();
                });
                var new_total_amount = parseInt(sum);
                $('.total_amt').html(new_total_amount);
                $('#paid_amount').val(new_total_amount);
            }

            function changeTotalAmount(id) {
                var sum = 0;
                $("input[class *= 'add']").each(function () {
                    sum += +$(this).val();
                });
                if (sum) {
                    $('#remove-field-' + id).hide();
                    $("#checkbox-id-" + id).prop('checked', true);
                } else {
                    $('#remove-field-' + id).show();
                    $("#checkbox-id-" + id).prop('checked', false);
                }
                var new_total_amount = parseInt(sum);
                $('.total_amt').html(new_total_amount);
                $('#paid_amount').val(new_total_amount);
            }
        </script>
        <style>         
            input[type="text"],    
            input[type="email"],    
            select{             
                width: 95%;
            }           
        </style>
    </head>

    <body class="skin-2">          

        <div class="main-container ace-save-state container" id="main-container">

            <?= $this->Flash->render() ?>  

            <!-- /section:basics/sidebar -->
            <div class="main-content">             

                <?php echo $this->cell('Merchants::header', [$webfront->merchant_id]); ?>  

                <div class="main-content-inner">
                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">                           

                        <div class="page-header">
                            <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                                Bill payment for the merchant <span style="color: green;"><?= $webfront->user->name ?></span>
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">                               
                                <!-- PAGE CONTENT BEGINS -->
                                <?php echo $this->Form->create(NULL, ['type' => 'post', 'role' => "form", 'class' => "form-horizontal ng-pristine ng-valid", 'style' => "width: 500px; margin: auto;"]); ?>
                                <!-- #section:elements.form --> 

                                <div class="form-group">                                      
                                    <h4 class="col-md-offset-3">Customer Details</h4>                                        
                                </div>

                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfront->customer_name_alias; ?> : </label> 
                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $this->Form->input('name', ['type' => 'text', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Name', 'required' => TRUE, 'autocomplete' => 'off']); ?> </label>
                                </div>
                                <div class="form-group" style="position: relative;">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfront->customer_email_alias; ?> : </label> 
                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $this->Form->input('email', ['type' => 'email', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'required' => TRUE, 'autocomplete' => 'off', 'onKeyup' => 'chkEmailAvail(this.value)']); ?> </label>
                                    <span id="emailloader_ajax"  style="position: absolute;display: none; margin-top: 8px; position: absolute; right: 10px;"><img src="<?php echo HTTP_ROOT . 'img/ajax-loader-small.gif'; ?>" alt=""/></span>
                                    <span id="email_msg" style="float: right;position: absolute; right: 0px;top: -7px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfront->customer_phone_alias; ?> : </label> 
                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $this->Form->input('phone', ['onkeyup' => "smarthub.removeInvalidChars('0-9', this, event);", 'type' => 'text', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Phone', 'required' => TRUE, 'autocomplete' => 'off']); ?> </label>
                                </div>                                   
                                <?php if (!empty($webfront->payee_custom_fields)) { ?>
                                    <?php foreach ($webfront->payee_custom_fields as $webfrontField) { //pj($webfrontField->webfront_id);exit;?>   
                                        <?php if (!empty($webfrontField->webfront_field_values) && $webfrontField->input_type == 4) { ?>
                                            <div class="form-group">
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfrontField->name; ?> : </label> 
                                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;">
                                                    <select name="payee_custom_fields[]" required="required">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($webfrontField->webfront_field_values as $webfrontFieldValue) { ?>
                                                            <option value="<?= $webfrontFieldValue->id; ?>"><?= $webfrontFieldValue->value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </label>
                                            </div>
                                        <?php } if (!empty($webfrontField->webfront_field_values) && $webfrontField->input_type == 3) { ?>
                                            <div class="form-group">
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfrontField->name; ?> : </label> 
                                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;">
                                                    <?php foreach ($webfrontField->webfront_field_values as $webfrontFieldValue) { ?>
                                                        <label class="radio-inline" style="padding-top: 0px;">
                                                            <input required="required" type="radio" name="payee_custom_fields[]" value="<?= $webfrontFieldValue->id; ?>"><?= $webfrontFieldValue->value; ?>
                                                        </label>
                                                    <?php } ?>
                                                </label>
                                            </div>
                                        <?php } if (empty($webfrontField->webfront_field_values)) { ?>
                                            <div class="form-group">
                                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfrontField->name; ?> : </label> 
                                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> 
                                                    <?= $this->Form->input('payee_custom_fields.', [($webfrontField->webfront_id != 0 && $webfrontField->validation->reg_exp != '' ? "required='true' pattern='{$webfrontField->validation->reg_exp}'" : ''), 'type' => 'text', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Custom Field Name', 'autocomplete' => 'off']); ?> </label>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                <div class="form-group">
                                    <h4 class="col-md-offset-3">Payment Details</h4>
                                </div>

                                <?php if (!empty($webfront_payment_attributes)) { ?>
                                    <?php foreach ($webfront_payment_attributes as $paymentAttribute) { ?>                                          
                                        <div class="form-group" id="textfield-<?= $paymentAttribute->id; ?>">
                                            <div class="checkbox" style="float: left;margin-top: 2px;">
                                                <input type="checkbox" value="<?= $paymentAttribute->is_required; ?>" <?= ($paymentAttribute->is_required == 1) ? "checked='checked'" : '' ?> <?= ($paymentAttribute->is_required == 1) ? "disabled='disabled'" : '' ?> onclick="toggleRemove(<?= $paymentAttribute->id; ?>)" id="checkbox-id-<?= $paymentAttribute->id; ?>"></label>
                                            </div>
                                            <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $paymentAttribute->name; ?> : </label> 
                                            <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="width: 60%;"> 
                                                <?= $this->Form->input("payment_custom_fields[" . $paymentAttribute->id . "]", ['default' => !empty($paymentAttribute->value) ? $paymentAttribute->value : '', 'readonly' => !empty($paymentAttribute->value) ? 'readonly' : '', 'type' => 'text', 'class' => 'form-control add', 'label' => FALSE, 'placeholder' => 'Payment Field Name', 'required' => TRUE, 'autocomplete' => 'off', 'onKeyup' => "smarthub.removeInvalidChars('0-9', this, event);changeTotalAmount($paymentAttribute->id)", 'id' => 'payment-field-' . $paymentAttribute->id]); ?> </label>
                                            <?php if ($paymentAttribute->is_required == 0) { ?>
                                                <a href="javascript:;" style="float: left;margin-top: 13px;" onclick="removeTextField(<?= $paymentAttribute->id; ?>)" id='remove-field-<?= $paymentAttribute->id; ?>'>
                                                    <span class="glyphicon glyphicon-minus-sign"></span> &nbsp;Remove
                                                </a>
                                            <?php } ?>
                                        </div>  
                                    <?php } ?>
                                    <p style="font-weight: bold;margin-left: 145px;">Total Amount $<span class="total_amt"><?= $total_amount[0]['total_price']; ?></span></p>
                                    <?= $this->Form->input('paid_amount', ['id' => 'paid_amount', 'type' => 'hidden', 'value' => $total_amount[0]['total_price']]); ?>
                                <?php } ?>                             
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-8">                                   
                                        <button type="submit" name="submit" class="btn btn-warning">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Pay Now
                                        </button>
                                        &nbsp; &nbsp; &nbsp;
                                        <a href="webfronts/payment/<?= $this->request->pass[0] ?>" class="btn">
                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                            Back
                                        </a>
                                    </div>
                                </div>   

                                <?php echo $this->Form->end(); ?>                                     
                                <!--<div class="hr hr-24"></div>-->
                            </div><!-- /.col -->
                        </div><!-- /.row -->   
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

            <?= $this->element('footer'); ?>

            <a href="javascript:;" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!--<script src="components/jquery/dist/jquery.js"></script>-->
        <script src="components/bootstrap/dist/js/bootstrap.js"></script>

        <script src="assets/js/src/ace.js"></script>
        <script src="assets/js/src/ace.basics.js"></script>
        <script src="assets/js/src/ace.sidebar.js"></script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
                                                    jQuery(function ($) {
                                                        $('[data-rel=tooltip]').tooltip({container: 'body'});
                                                        $('[data-rel=popover]').popover({container: 'body'});
                                                    });
        </script>
    </body>
</html>


