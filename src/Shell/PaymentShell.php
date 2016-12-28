<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;

require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'Component' . DS . 'CustomComponent.php');

class PaymentShell extends Shell {

    public function main() {
        $this->out('Jay Jagannath.........');
    }

    public function tstEmail() {
        $this->Custom = new \App\Controller\Component\CustomComponent;
        $to = $this->Custom->emailText('pradeepta.raddyx@gmail.com');
        $this->Custom->sendEmail($to, 'someone@xyz.com', 'Testing Shell', 'Jay Jagnnath', 'pradeepta20@gmail.com');
        $this->out('Testing Shell..');
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 5 Dec 2016
     * Desc:  Very Failed Transactions
     */

    public function chekFailedTransactions() {

        $this->Custom = new \App\Controller\Component\CustomComponent;

        //mail('pradeepta.raddyx@gmail.com', 'Syndicate Cronjob', 'Jay Jagannath....');

        $this->loadModel('Payments');
        $conditions = ['Payments.status' => 0, 'Payments.txn_id !=' => '', 'Payments.unmappedstatus IN' => ['auth', 'pending', 'bounced', 'dropped']];
        $payments = $this->Payments->find('all')->where($conditions)->order(['Payments.id' => 'DESC'])->contain(['Webfronts.Users.MerchantProfiles'])->limit(1000);

        foreach ($payments as $payment) {
            $var1 = $payment->txn_id;
            $key = $payment->webfront->user->merchant_profile->payu_key;
            $salt = $payment->webfront->user->merchant_profile->payu_salt;
            $command = "verify_payment";
            $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
            $hash = strtolower(hash('sha512', $hash_str));
            $r = ['key' => $key, 'hash' => $hash, 'var1' => $var1, 'command' => $command];
            $qs = http_build_query($r);
            $apiUrl = PAYU_API_URL;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $jsonData = curl_exec($ch);
            if (curl_errno($ch)) {
                $sad = curl_error($ch);
                throw new \Exception($sad);
            }
            curl_close($ch);
            $data = json_decode($jsonData, TRUE);
            if ($data['status'] == 1) {
                $transactionDetails = $data['transaction_details'];
                foreach ($transactionDetails as $transactionDetail) {
                    if ($transactionDetail['status'] == 'success') {
                        $status = $this->Payments->query()->update()->set(['unmappedstatus' => $transactionDetail['unmappedstatus']])->where(['txn_id' => $payment->txn_id])->execute();
                        if ($transactionDetail['unmappedstatus'] == 'captured') {
                            $transactionId = $transactionDetail['txnid'];
                            $this->Payments->query()->update()->set(['status' => 1, 'unmappedstatus' => 'captured'])->where(['txn_id' => $payment->txn_id])->execute();
                        }
                    }
                }
            }
        }
        $this->out('Cron Executed!!');
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 10 Nov 2016
     * Desc:  When a file will be imported successfully then immediate notification wemail will be sent to each customer by using this code.
     */

    public function sendEmailInBackground($id = NULL) {

        $this->Custom = new \App\Controller\Component\CustomComponent;
        $this->loadModel('Payments');
        $this->loadModel('Webfronts');
        $this->loadModel('UploadedPaymentFiles');
        $this->loadModel('Users');
        $this->loadModel('AdminSettings');
        $this->loadModel('MailTemplates');

        $payments = $this->Payments->find('all')->where(['Payments.uploaded_payment_file_id' => $id, 'Payments.followup_counter' => 0]);
        if ($payments->count()) {
            $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION', 'is_active' => 1])->first();
            $uploadedPaymentFile = $this->UploadedPaymentFiles->get($id);
            $webfront = $this->Webfronts->find()->where(['Webfronts.id' => $uploadedPaymentFile->webfront_id])->contain(['Users'])->first();

            foreach ($payments as $payment) {
                $uniqId = $payment->uniq_id;
                $link = HTTP_ROOT . "customer/payments/make-payment/" . $uniqId;
                $billAmount = $payment->fee;
                $directLink = HTTP_ROOT . "webfronts/basic/$webfront->url";
                $viewTransLink = HTTP_ROOT . "customer/view-transactions/" . $webfront->user->uniq_id;

                $message = $this->Custom->formatEmail($mailTemplate['content'], [
                    'NAME' => $payment->name,
                    'MERCHANT' => $webfront->user->name,
                    'BILL_AMOUNT' => $billAmount,
                    'INVOICE_NO' => $payment->id,
                    'PAYMENT_LINK' => $link,
                    'DIRECT_LINK' => "<a href='{$directLink}'>{$directLink}</a>",
                    'VIEW_TRANSACTION_LINK' => "<a href='{$viewTransLink}'>{$viewTransLink}</a>",
                ]);
                $this->Custom->sendEmail($payment->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);
                $this->Payments->query()->update()->set(['followup_counter' => 'followup_counter' + 1])->where(['id' => $payment->id])->execute();


                /* ======================For SMS Sending Starts here=================================== */
                $phone = $payment->phone;
                $sms = "Use this Below Link to process Payment of amount INR [BILL_AMOUNT].[DIRECT_LINK]";
                $message = $this->Custom->formatEmail($sms, [
                    'BILL_AMOUNT' => $payment->fee,
                    'DIRECT_LINK' => HTTP_ROOT . "webfronts/basic/{$payment->webfront->url}"
                ]);
                $this->Custom->sendSMS($phone, $message);
                /* ======================For SMS Sending Ends here==================================== */
            }
        }
        $this->out("Mail sent successfully!!");
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 10 Nov 2016
     * Desc:  Cronjob For sending Email
     */

    public function sendBillNotifications() {

        $this->Custom = new \App\Controller\Component\CustomComponent;
        $this->loadModel('Payments');
        $this->loadModel('MailTemplates');
        $this->loadModel('AdminSettings');
        $this->loadModel('Webfronts');
        $this->loadModel('Users');

        $conditions = [];
        $twoDayBefore = ['Webfronts.payment_cycle_date' => date('Y-m-d', strtotime(' +2 day'))];
        $oneDayBefore = ['Webfronts.payment_cycle_date' => date('Y-m-d', strtotime(' +1 day'))];
        $conditions = ['Webfronts.is_published' => 1, 'OR' => [$twoDayBefore, $oneDayBefore]];
        $webfronts = $this->Webfronts->find('all')->where($conditions)->contain(['Users']);

        if ($webfronts->count() > 0) {
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION', 'is_active' => 1])->first();
            $smsTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION_SMS', 'is_active' => 1])->first();
            $adminSetting = $this->AdminSettings->find()->first();

            foreach ($webfronts as $webfront) {
                $payments = $this->Payments->find('all')->where(['Payments.webfront_id' => $webfront->id])->contain(['Webfronts', 'Webfronts.Users']);
                if ($payments->count() > 0) {
                    foreach ($payments as $payment) {
                        if ($payment->status == 0) {
                            /* ======================For Mail Sending Starts here==================================== */
                            $uniqId = $payment->uniq_id;
                            $link = HTTP_ROOT . "customer/payments/make-payment/" . $uniqId;
                            $directLink = HTTP_ROOT . "webfronts/basic/$payment->webfront->url";
                            $viewTransLink = HTTP_ROOT . "customer/view-transactions/" . $payment->webfront->user->uniq_id;

                            $billAmount = $payment->fee; // + $payment->convenience_fee_amount + $payment->late_fee_amount;

                            $message = $this->Custom->formatEmail($mailTemplate['content'], [
                                'NAME' => $payment->name,
                                'MERCHANT' => $webfront->user->name,
                                'BILL_AMOUNT' => $billAmount,
                                'INVOICE_NO' => $payment->id,
                                'PAYMENT_LINK' => $link,
                                'DIRECT_LINK' => "<a href='{$directLink}'>{$directLink}</a>",
                                'VIEW_TRANSACTION_LINK' => "<a href='{$viewTransLink}'>{$viewTransLink}</a>",
                            ]);

                            $this->Custom->sendEmail($payment->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);
                            $this->Payments->query()->update()->set(['followup_counter' => 'followup_counter' + 1])->where(['id' => $payment->id])->execute();
                            /* ======================For Mail Sending Ends here==================================== */

                            /* ======================For SMS Sending Starts here==================================== */
                            $phone = $payment->phone;
                            $sms = "Use this Below Link to process Payment of amount INR [BILL_AMOUNT].[DIRECT_LINK]";
                            $message = $this->Custom->formatEmail($sms, [
                                'BILL_AMOUNT' => $payment->fee,
                                'DIRECT_LINK' => HTTP_ROOT . "webfronts/basic/{$payment->webfront->url}"
                            ]);
                            $this->Custom->sendSMS($phone, $message);
                            /* ======================For SMS Sending Ends here==================================== */
                        }
                    }
                }
            }
        }

        $this->out('Mail Sent Successfully');
    }

}
