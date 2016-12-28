<style>         
    input[type="text"], input[type="email"], select{ width: 95%;  }           
</style>
<div class="main-content">  
    <?php echo $this->cell('Merchants::header', [$webfront->merchant_id]); ?>  
    <div class="main-content-inner">
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">                           

            <div class="page-header">
                <h1 style="text-align: center; font-size: 25px; font-weight: bold;">                                    
                    Pay Online for <span style="color: green;"><?= $webfront->user->name ?></span>
                </h1>
            </div>

            <div class="row">
                <div class="col-xs-12">                               
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo $this->Form->create(NULL, ['type' => 'post', 'role' => "form", 'class' => "form-horizontal ng-pristine ng-valid tranfrom-box"]); ?>
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
                        <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> <?= $this->Form->input('email', ['type' => 'email', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'required' => TRUE, 'autocomplete' => 'off', 'onKeyupXX' => 'chkEmailAvail(this.value)']); ?> </label>
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
                                                <option value="<?= $webfrontFieldValue->value; ?>"><?= $webfrontFieldValue->value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </label>
                                </div>
                            <?php } else if (!empty($webfrontField->webfront_field_values) && $webfrontField->input_type == 3) { ?>
                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfrontField->name; ?> : </label> 
                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;">
                                        <?php foreach ($webfrontField->webfront_field_values as $webfrontFieldValue) { ?>
                                            <label class="radio-inline" style="padding-top: 0px;">
                                                <input required="required" type="radio" name="payee_custom_fields[]" value="<?= $webfrontFieldValue->value; ?>"><?= $webfrontFieldValue->value; ?>
                                            </label>
                                        <?php } ?>
                                    </label>
                                </div>
                            <?php } else if ($webfrontField->input_type == 2) { ?>
                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfrontField->name; ?> : </label> 
                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> 
                                        <?= $this->Form->input('payee_custom_fields.', [($webfrontField->webfront_id != 0 && $webfrontField->validation->reg_exp != '' ? "required='true' pattern='{$webfrontField->validation->reg_exp}'" : ''), 'type' => 'textarea', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => $webfrontField->name, 'autocomplete' => 'off']); ?> 
                                    </label>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $webfrontField->name; ?> : </label> 
                                    <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style="text-align: left;"> 
                                        <?= $this->Form->input('payee_custom_fields.', [($webfrontField->webfront_id != 0 && $webfrontField->validation->reg_exp != '' ? "required='true' pattern='{$webfrontField->validation->reg_exp}'" : ''), 'type' => 'text', 'class' => 'form-control', 'label' => FALSE, 'placeholder' => $webfrontField->name, 'autocomplete' => 'off']); ?> 
                                    </label>
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
                                <!--
                                <div class="checkbox" style="float: left;margin-top: 2px;">
                                    <input type="checkbox" value="<?= $paymentAttribute->is_required; ?>" <?= ($paymentAttribute->is_required == 1) ? "checked='checked'" : '' ?> <?= ($paymentAttribute->is_required == 1) ? "disabled='disabled'" : '' ?> onclick="toggleRemove(<?= $paymentAttribute->id; ?>)" id="checkbox-id-<?= $paymentAttribute->id; ?>"></label>
                                </div>
                                -->
                                <label for="form-field-1" class="col-sm-3 control-label no-padding-right">  <?= $paymentAttribute->name; ?> : </label> 
                                <label for="form-field-1" class="col-sm-8 control-label no-padding-right ng-binding" style=""> 
                                    <?= $this->Form->input("payment_custom_fields[" . $paymentAttribute->id . "]", ['default' => !empty($paymentAttribute->value) ? $paymentAttribute->value : '', 'readonly' => !empty($paymentAttribute->value) ? 'readonly' : '', 'type' => 'text', 'class' => 'form-control add decimal', 'label' => FALSE, 'placeholder' => $paymentAttribute->name, 'required' => TRUE, 'autocomplete' => 'off', 'onKeyup' => "smarthub.removeInvalidChars('0-9.', this, event);changeTotalAmount($paymentAttribute->id)", 'id' => 'payment-field-' . $paymentAttribute->id]); ?> </label>
                                <?php if ($paymentAttribute->is_required == 0) { ?>
                                    <!--
                                     <a href="javascript:;" style="float: left;margin-top: 13px;" onclick="removeTextField(<?= $paymentAttribute->id; ?>)" id='remove-field-<?= $paymentAttribute->id; ?>'>
                                         <span class="glyphicon glyphicon-minus-sign"></span> &nbsp;Remove
                                     </a>
                                    -->
                                <?php } ?>
                            </div>  
                        <?php } ?>
                        <p class="para">Total Amount Rs. <span class="total_amt"><?= $total_amount[0]['total_price']; ?></span></p>
                        <p class="para"><input type="checkbox" required="" /> &nbsp; <a href="javascript:;" onclick="NewWindow(siteUrl + 'term-and-conditions', 'Term & Conditions', 750, 600, true)" >Accept Term &amp; Conditions</a></p>
                        <?= $this->Form->input('paid_amount', ['id' => 'paid_amount', 'type' => 'hidden', 'value' => $total_amount[0]['total_price']]); ?>
                    <?php } ?>                             
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-8">                                   
                            <button type="submit" name="submit" class="btn btn-warning">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Pay Now
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <a href="webfronts/advance/<?= $this->request->pass[0] ?>" class="btn">
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

