<div id="navbar" class="navbar navbar-default ace-save-state" style="background: #DBDBDB;" >
    <div class="main-container ace-save-state containerXX" id="main-container" style="background: #f1f1f1;">
        <div class="merchant-header">
            <div class="logo-left"> <img src="img/logo/smarthub-logo.png" /></div>            
            <div class="logo-center">
                <?php if (!empty($this->request->session()->read('merchant.merchant_profile.logo'))) { ?>
                    <img style="max-width: 100px;" src="<?= MERCHANT_LOGO . $this->request->session()->read('merchant.merchant_profile.logo') ?>" />
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
            </div>
            <div class="logo-right"><img src="img/logo/hdfc-logo.png" /></div>
        </div>
    </div>
</div>

