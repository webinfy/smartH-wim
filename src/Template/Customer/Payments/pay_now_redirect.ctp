<?php
$key = "xlIeC9";
$salt = "qVCckzCA";
$txn = "TXN" . time();

$amount = $payment->total_fee;
$email = $payment->email;
$name = $payment->name;
$phone = $payment->phone;

$productName = $payment->uploaded_payment_file->note; //"tshirt";

$successUrl = HTTP_ROOT . "customer/payments/success/" . $payment->uniq_id;
$failureUrl = HTTP_ROOT . "customer/payments/failure/" . $payment->uniq_id;
$cancelUrl = HTTP_ROOT . "customer/payments/cancel/" . $payment->uniq_id;

$text = "{$key}|{$txn}|{$amount}|{$productName}|{$name}|{$email}|||||||||||{$salt}";
$output = strtolower(hash("sha512", $text));
?>
<form action='https://test.payu.in/_payment' method='post' id="payUForm">

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