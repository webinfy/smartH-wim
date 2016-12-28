<?php

$phone = '8280955059';
$message = urlencode('Use this Below Link to process Payment of amount 100. https://www.testsyndcollect.payu.in:5006');

$apiUrl = "https://www.payumoney.com/Asynctaskprocessor/smarthub/sendSms?phone={$phone}&text={$message}&type=transactional&application=HDFCBK";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, []);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    $sad = curl_error($ch);
    print_r($sad);
    throw new \Exception($sad);
}
curl_close($ch);
echo "<pre>";
print_r($result);
echo "</pre>";
exit;
?>

