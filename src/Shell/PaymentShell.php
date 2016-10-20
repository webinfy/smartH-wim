<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;

class PaymentShell extends Shell {

    public function main() {
        $this->out('Jay Jagannath.........');
    }

    public function importPayments($id, $file) {

        $this->loadModel('UploadedPaymentFiles');
        $this->loadModel('Payments');
        $this->loadModel('Users');

        $getUploadedPaymentFile = $this->UploadedPaymentFiles->find()->where(['UploadedPaymentFiles.id' => $id])->first();

        //Create Log file
        $logFile = fopen(EXCEL_ERROR_LOG . "LogFile-" . $getUploadedPaymentFile->id . ".log", "w") or die("Unable to open file!");

        require_once(ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'vendor' . DS . 'autoload.php');

//        $inputFileName = TEMP_EXCEL . $getUploadedPaymentFile->file;
        $inputFileName = TEMP_EXCEL . urldecode($file);

        try {
            $inputFileType = \PHPExcel_IOFactory::identify($inputFileName);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        //Header
        $getHeading = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1, NULL, TRUE, FALSE);
        $heading = array_map('trim', $getHeading[0]);

        $phoneIndex = array_search('Phone', $heading);
        $totalFeeIndex = array_search('Total', $heading);
        $dueDateIndex = array_search('Due Date', $heading);
        $noOfCustomFields = $totalFeeIndex - ($phoneIndex + 1);

        //Write to log file
        if (empty($phoneIndex) || empty($totalFeeIndex)) {
            $txt = "The heading of the excel file are not correct\n";
            fwrite($logFile, $txt);
            fclose($logFile); //Close Log file
            exit;
        }

        if ($noOfCustomFields > 0) {
            for ($i = $phoneIndex + 1; $i < $totalFeeIndex; $i++) {
                $customFields[strtolower(trim(preg_replace("![^a-z0-9]+!i", "_", trim($heading[$i])), "_"))] = $heading[$i];
            }
            $this->UploadedPaymentFiles->query()->update()->set(["custom_fields" => json_encode($customFields)])->where(['id' => $getUploadedPaymentFile->id])->execute();
        }

        $currDate = date('Y-m-d');

        for ($row = 2; $row <= $highestRow; $row++) {

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $paymentData = $rowData[0];

            $name = filter_var($paymentData[0], FILTER_SANITIZE_STRING);
            $email = filter_var($paymentData[1], FILTER_SANITIZE_EMAIL);
            $phone = filter_var($paymentData[2], FILTER_SANITIZE_NUMBER_INT);
            $totalFee = !empty($paymentData[$totalFeeIndex]) ? $paymentData[$totalFeeIndex] : 0;

            //Validation Start//
            $isValid = TRUE;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $txt = "Invalid email format at row {$row}  \n";
                fwrite($logFile, $txt);
                $isValid = FALSE;
            }
            if (gettype($paymentData[$dueDateIndex]) != 'double') {
                $txt = "Invalid date format at row {$row}  \n";
                fwrite($logFile, $txt);
                $isValid = FALSE;
            } else {
                $dueDate = date('Y-m-d', ($paymentData[$dueDateIndex] - 25569) * 86400);
                if ($dueDate < $currDate) {
                    $txt = "Due date is less than current date at row {$row}  \n";
                    fwrite($logFile, $txt);
                    $isValid = FALSE;
                }
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $txt = "Invalid email format at row {$row}  \n";
                fwrite($logFile, $txt);
                $isValid = FALSE;
            }
            if ($totalFee <= 0) {
                $txt = "Total fee is 0 at row {$row}  \n";
                fwrite($logFile, $txt);
                $isValid = FALSE;
            }
            //Validation End////
            ////////////////////
            //Save to DB Start//
            if ($isValid) {
                $query = $this->Users->find()->where(['Users.email' => $email, 'type' => 4]);
                if ($query->count() > 0) {
                    $user = $query->first();  //User Alreday Exist
                } else {
                    //Create a new User
                    $user = $this->Users->newEntity();
                    $user->name = $name;
                    $user->email = $email;
                    $user->phone = $phone;
                    //$user->address = '';
                    $user->cust_id = 100000000 + time(); //Tenn Digit Uniq Random Numer
                    $user->created_by = $getUploadedPaymentFile->merchant_id;
                    $user->type = 4;
                    $user->uniq_id = md5(uniqid(rand()) . time());
                    $user->is_active = 1;
                    //$this->Users->patchEntity($user, ['email' => $email, 'type' => 4, 'uniq_id' => $this->Custom->generateUniqNumber(), 'cust_id' => uniqid()]);
                    if ($this->Users->save($user)) {
                        $user->cust_id = 100000000 + $user->id;
                        $this->Users->save($user); //Update Customer Id
                    }
                }
                $payment = $this->Payments->newEntity();
                $payment->uniq_id = md5(uniqid(rand()) . time());
                $payment->merchant_id = $getUploadedPaymentFile->merchant_id;
                $payment->uploaded_payment_file_id = $getUploadedPaymentFile->id;
                $payment->user_id = $user->id;
                $payment->name = $name;
                $payment->email = $email;
                $payment->phone = $phone;
                if (!empty($customFields)) {
                    $i = 1;
                    foreach ($customFields as $key => $value) {
                        $customFieldValues[$key] = $paymentData[$phoneIndex + $i];
                        $i++;
                    }
                    $payment->custom_fields = json_encode($customFieldValues);
                }
                $payment->total_fee = $totalFee;
                $payment->due_date = $dueDate;
                $payment = $this->Payments->save($payment);
            }
            //Save to DB End//
        }
        fclose($logFile); //Close Log file

        $this->UploadedPaymentFiles->query()->update()->set(["upload_completed" => 1])->where(['id' => $getUploadedPaymentFile->id])->execute();
        unlink($inputFileName);

        $this->_sendBillEmail($getUploadedPaymentFile->id);

//        $this->out("Jay Jagannath");
    }

    public function _sendBillEmail($uploadedPaymentFileId) {

        $this->loadModel('Payments');
        $this->loadModel('UploadedPaymentFiles');
        $this->loadModel('Users');
        $this->loadModel('MailTemplates');

        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'user_id', 'joinType' => 'INNER']);
        $payments = $this->Payments->find('all')->where(['uploaded_payment_file_id' => $uploadedPaymentFileId, 'followup_counter' => 0])->contain(['Users']);
        if ($payments->count() > 0) {
            $getUploadedPaymentFile = $this->UploadedPaymentFiles->find()->where(['UploadedPaymentFiles.id' => $uploadedPaymentFileId])->first();
            $getMerchant = $this->Users->find()->where(['Users.id' => $getUploadedPaymentFile->merchant_id])->contain([])->first();
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION', 'is_active' => 1])->first();
            foreach ($payments as $payment) {
                $link = HTTP_ROOT . 'customer/payments/make-payment/' . urlencode(base64_encode($payment->uniq_id));
                $directLink = HTTP_ROOT . 'customer/pay-now/' . urlencode(base64_encode($payment->uniq_id));
                $viewTransLink = HTTP_ROOT . 'customer/view-transactions/' . urlencode(base64_encode($getMerchant->uniq_id));
                $message = $this->_formatEmail($mailTemplate['content'], [
                    'NAME' => $payment->name,
                    'MERCHNAT' => $getMerchant->name,
                    'NOTE' => $getUploadedPaymentFile->note,
                    'BILL_AMOUNT' => " Rs." . $payment->total_fee,
                    'DUE_DATE' => date("d M, Y", strtotime($payment->due_date)),
                    'LAST_PAYMENT_DATE' => date("d M, Y", strtotime($getUploadedPaymentFile->last_payment_date)),
                    'LINK' => "<a href='{$link}'>{$link}</a>",
                    'MONTH' => date("F", strtotime($payment->due_date)),
                    'CUST_ID' => $payment->user->cust_id,
                    'DIRECT_LINK' => "<a href='{$directLink}'>{$directLink}</a>",
                    'VIEW_TRANSACTION_LINK' => "<a href='{$viewTransLink}'>{$viewTransLink}</a>",
                ]);
                $this->_sendEmail($payment->email, "noreply@smarthub.com", $mailTemplate->subject, $message);
                $this->Payments->query()->update()->set(['followup_counter' => 'followup_counter' + 1])->where(['id' => $payment->id])->execute();
            }
        }
    }

    public function _formatCustomField($url) {
        if ($url) {
            $url = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "_", $url);
            $value = trim($value, "_");
            return strtolower($value);
        }
    }

    public function sendBillNotifications() {

        $this->loadModel('Payments');
        $this->loadModel('MailTemplates');
        $this->loadModel('UploadedPaymentFiles');
        $this->loadModel('Users');

//        $twoDayBefore = ['followup_counter' => 1, 'due_date' => date('Y-m-d', strtotime(' -2 day'))];
//        $oneDayBefore = ['followup_counter' => 2, 'due_date' => date('Y-m-d', strtotime(' -1 day'))];

        $twoDayBefore = ['due_date' => date('Y-m-d', strtotime(' -2 day'))];
        $oneDayBefore = ['due_date' => date('Y-m-d', strtotime(' -1 day'))];
        $conditions = ['Payments.status' => 0, 'followup_counter <' => 3, 'OR' => [$twoDayBefore, $oneDayBefore]];

        $payments = $this->Payments->find('all')->where($conditions)->contain(['Users'])->limit(1);
        if ($payments->count() > 0) {
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION', 'is_active' => 1])->first();
            foreach ($payments as $payment) {
                $getUploadedPaymentFile = $this->UploadedPaymentFiles->find()->where(['UploadedPaymentFiles.id' => $payment->uploaded_payment_file_id])->first();
                $getMerchant = $this->Users->find()->where(['Users.id' => $payment->merchant_id])->contain([])->first();

                $HTTP_ROOT = "http://dev.raddyx.in/smarthub/";
                $link = $HTTP_ROOT . 'customer/payments/make-payment/' . urlencode(base64_encode($payment->uniq_id));
                $directLink = $HTTP_ROOT . 'customer/pay-now/' . urlencode(base64_encode($payment->uniq_id));
                $viewTransLink = $HTTP_ROOT . 'customer/view-transactions/' . urlencode(base64_encode($getMerchant->uniq_id));

                $message = $this->_formatEmail($mailTemplate['content'], [
                    'NAME' => $payment->name,
                    'MERCHNAT' => $getMerchant->name,
                    'NOTE' => $getUploadedPaymentFile->note,
                    'BILL_AMOUNT' => " Rs." . $payment->total_fee,
                    'DUE_DATE' => date("d M, Y", strtotime($payment->due_date)),
                    'LAST_PAYMENT_DATE' => date("d M, Y", strtotime($getUploadedPaymentFile->last_payment_date)),
                    'LINK' => "<a href='{$link}'>{$link}</a>",
                    'MONTH' => date("F", strtotime($payment->due_date)),
                    'CUST_ID' => $payment->user->cust_id,
                    'DIRECT_LINK' => "<a href='{$directLink}'>{$directLink}</a>",
                    'VIEW_TRANSACTION_LINK' => "<a href='{$viewTransLink}'>{$viewTransLink}</a>",
                ]);

                $this->_sendEmail($payment->email, "noreply@smarthub.com", $mailTemplate->subject, $message);
                $this->Payments->query()->update()->set(['followup_counter=followup_counter+1'])->where(['id' => $payment->id])->execute();
            }
        }

//        mail("pradeepta20@gmail.com", "Cron Job", "Jay Jagannath Ki Jay"); 
        $this->out('Mail Sent Successfully');
    }

    public function _formatEmail($msg, $arrData) {
        foreach ($arrData as $key => $value) {
            if (strstr($msg, "[" . $key . "]")) {
                $msg = str_replace("[" . $key . "]", $value, $msg);
            }
        }
        $HTTP_ROOT = "http://dev.raddyx.in/smarthub/";
        if (strstr($msg, "[SITE_NAME]")) {
            $msg = str_replace('[SITE_NAME]', "<a href='" . $HTTP_ROOT . "'>" . "SmartHub" . "</a>", $msg);
        }
        $SUPPORT_EMAIL = "support@smarthub.com";
        if (strstr($msg, "[SUPPORT_EMAIL]")) {
            $msg = str_replace('[SUPPORT_EMAIL]', "<a href='mailto:" . $SUPPORT_EMAIL . "'>" . $SUPPORT_EMAIL . "</a>", $msg);
        }
        return $msg;
    }

    public function _sendEmail($to, $from, $subject, $message, $header = 1, $footer = 1) {

        $HTTP_ROOT = "http://dev.raddyx.in/smarthub/";
        $SUPPORT_EMAIL = "support@smarthub.com";

        if ($header) {
            $hdr = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
    <html>
    <head>
    <title>Free4lancer</title>
    </head>
    <body>
    <table width="750" style="font-family:arial helvetica sans-serif" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
        <td><table width="750" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td><a href="' . $HTTP_ROOT . '"><img alt="" src="' . $HTTP_ROOT . '/img/logo/smarthub-logo.png"/></a> </td>
                <td align="right" valign="bottom" style="font-family:arial;color:#0093dd;font-size:20px;padding:0 10px 10px 0">
                    <table border="0" align="right" cellspacing="0" cellpadding="0">
                    <tbody><tr><td height="25"></td></tr></tbody></table>
                </td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr> <td bgcolor="#0077b1"><div style="font-size:3px;color:#28a4e2">&nbsp;</div></td></tr>
        <tr> <td bgcolor="#b3efae"><div style="font-size:3px;color:#a6d9f3">&nbsp;</div></td> </tr>
        <tr> <td colspan="3" style="border:1px solid #c6c6c6"><table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
            <tr>
                <td colspan="2" style="padding-left:12px;padding-right:12px;font-family:trebuchet ms,arial;font-size:13px">';
        }
        if ($footer) {

            $ftr = '</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr>
        <td height="34" bgcolor="#f1f1f1" style="border:solid 1px #c6c6c6;border-top:0px;font-family:arial;font-size:13px;text-align:center"><p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
    <td width="150" style="font:12px Helvetica,sans-serif;color:#7b7b7b">EMAIL:<a target="_blank" style="text-decoration:none" href="' . $SUPPORT_EMAIL . '"><font color="#f67d2c"> ' . $SUPPORT_EMAIL . ' </font></a></td>
    <td width="150" style="font:12px Helvetica,sans-serif;color:#7b7b7b">&nbsp;</td>
    <td width="70" align="left" style="font:12px Helvetica,sans-serif;color:#7b7b7b;text-transform:uppercase"><strong>Follow Us On</strong></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Facebook" style="display:block;color:#ffffff" alt="Facebook" src="' . $HTTP_ROOT . '/img/social/facebook.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Google Plus" style="display:block;color:#ffffff" alt="Google Plus" src="' . $HTTP_ROOT . '/img/social/twitter_bird.png"></a></td>
    <!--<td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Pinterest" style="display:block;color:#ffffff" alt="Pinterest" src="' . $HTTP_ROOT . '/img/social/googleplus.png"></a></td>-->
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="YouTube" style="display:block;color:#ffffff" alt="YouTube" src="' . $HTTP_ROOT . '/img/social/pinterest.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Instagram" style="display:block;color:#ffffff" alt="Instagram" src="' . $HTTP_ROOT . '/img/social/youtube.png"></a></td>
    </tr></tbody></table>
        </p></td>
        </tr>
    </tbody>
    </table>
    </body>
    </html>';
        }

        $message = $hdr . $message . $ftr;
        $to = $this->_emailText($to);
        $subject = $this->_emailText($subject);
        $message = $this->_emailText($message);
        $message = str_replace("<script>", "&lt;script&gt;", $message);
        $message = str_replace("</script>", "&lt;/script&gt;", $message);
        $message = str_replace("<SCRIPT>", "&lt;script&gt;", $message);
        $message = str_replace("</SCRIPT>", "&lt;/script&gt;", $message);

        //Send Email by using Cakephp3.x
        $email = new Email('default');
        $email->from([$from => 'SmartHub'])
                ->emailFormat('html')
                ->template(NULL)
                ->to($to)
                ->bcc("pradeepta20@gmail.com")
                ->subject($subject)
                ->send($message);

//        $logFile = fopen("temp_excel/" . md5(uniqid()) . time() . ".html", "w") or die("Unable to open file!");
//        $txt = "$message  \n";
//        fwrite($logFile, $txt);
//        fclose($logFile);

        //Send Email by core php        
//        $from = "Free4lancer<" . $from . ">";
//        $bcc = "prakash.kumarguru@gmail.com";
//        $headers = 'MIME-Version: 1.0' . "\r\n";
//        $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers.= 'From:' . $from . "\r\n";
//        $headers.= 'BCC:' . $bcc . "\r\n";
//        if (mail($to, $subject, $message, $headers)) {
//            return true;
//        } else {
//            return false;
//        }
    }

    public function _emailText($value) {
        $value = stripslashes(trim($value));
        $value = str_replace('"', "\"", $value);
        $value = str_replace('"', "\"", $value);
        $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
        return stripslashes($value);
    }

}
