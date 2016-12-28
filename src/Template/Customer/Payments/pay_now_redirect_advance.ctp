<?php
$key = $payment->webfront->user->merchant_profile->payu_key; //"xlIeC9";
$salt = $payment->webfront->user->merchant_profile->payu_salt; //"qVCckzCA";
$txn = "TXN" . time() . rand(1111, 9999);

$amount = $payment->paid_amount;
$email = $payment->email;
$name = $payment->name;
$phone = $payment->phone;

$productName = SITE_NAME . " Bill Payment";

$successUrl = HTTP_ROOT . "customer/payments/success2/" . $payment->uniq_id;
$failureUrl = HTTP_ROOT . "customer/payments/failure2/" . $payment->uniq_id;
$cancelUrl = HTTP_ROOT . "customer/payments/cancel2/" . $payment->uniq_id;

$text = "{$key}|{$txn}|{$amount}|{$productName}|{$name}|{$email}|||||||||||{$salt}";
$output = strtolower(hash("sha512", $text));
?>
<form action='<?= PAYU_PAYMENT_URL ?>' method='post' id="payUForm">

    <input type="hidden" name="key" value="<?= $key; ?>" />
    <input type="hidden" name="txnid" value="<?php echo $txn; ?>" />
    <input type="hidden" name="amount" value="<?= $amount; ?>" />
    <input type="hidden" name="productinfo" value="<?= $productName ?>" />
    <input type="hidden" name="firstname" value="<?= $name; ?>" />
    <input type="hidden" name="email" value="<?= $email; ?>" />  
    <input type="hidden" name="phone" value="<?= $phone ?>"/>

    <input type="hidden" name="surl" value="<?= $successUrl ?>" /> <!--Success URL where PayUMoney will redirect after successful payment.-->
    <input type="hidden" name="furl" value="<?= $failureUrl ?>" /> <!--Failure URL where PayUMoney will redirect after failed payment.-->  
    <input type="hidden" name="curl" value="<?= $cancelUrl ?>" />  <!--Cancel URL where PayUMoney will redirect when user cancel the transaction.-->

    <input type="hidden" name="hash" value = <?= $output; ?> /> 

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