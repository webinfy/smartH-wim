<?php
$key = "xlIeC9";
$salt = "qVCckzCA";
$txn = "TXN" . time();

$amount = $payment->total_fee;
$email = $payment->email;
$name = $payment->name;
$phone = $payment->phone;

$productName = $payment->uploaded_payment_file->note; //"tshirt";

$text = "{$key}|{$txn}|{$amount}|{$productName}|{$name}|{$email}|||||||||||{$salt}";
$output = strtolower(hash("sha512", $text));
?>
<form action='https://test.payu.in/_payment' method='post' id="payUForm">
    <input type="hidden" name="firstname" value="<?= $name; ?>" />
    <input type="hidden" name="lastname" value="" />
    <input type="hidden" name="surl" value="http://dev.raddyx.in/smarthub/" />
    <input type="hidden" name="phone" value="<?= $phone ?>"/>
    <input type="hidden" name="key" value="<?= $key; ?>" />
    <input type="hidden" name="hash" value = <?= $output; ?> />
    <input type="hidden" name="curl" value="http://dev.raddyx.in/smarthub/" />
    <input type="hidden" name="furl" value="http://dev.raddyx.in/smarthub/" />
    <input type="hidden" name="txnid" value="<?php echo $txn; ?>" />
    <input type="hidden" name="productinfo" value="<?= $productName ?>" />
    <input type="hidden" name="amount" value="<?= $amount; ?>" />
    <input type="hidden" name="email" value="<?= $email; ?>" />    
</form>

<script>
    setTimeout(function () {
        document.getElementById("payUForm").submit();
    }, 1000);
</script>
<div style="position: relative; width: 600px; margin: auto;">
    <div style="font:bold 16px Arial;color:#333333;text-align:center;display:block;opacity:1;z-index:9999999; margin-top: 100px;">
        <div><?php echo $this->Html->image('loader_100x100.gif', array('alt' => "Loading...", 'title' => 'Please wait...')); ?></div>
        <br/><br/>
        <div>Please wait. We are redirecting you to PayU payment page.</div>
    </div>
</div>