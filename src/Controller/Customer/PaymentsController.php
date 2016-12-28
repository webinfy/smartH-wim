<?php

namespace App\Controller\Customer;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

require_once(ROOT . DS . 'vendor' . DS . 'mpdf' . DS . 'autoload.php');

use \mPDF;

class PaymentsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');

        $this->loadModel('Users');
        $this->loadModel('Payments');
        $this->loadModel('AdminSettings');
        $this->loadModel('MailTemplates');
        $this->loadModel('Webfronts');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $beforeLoginActions = ['makePayment', 'payNow', 'payNowRedirect', 'payNowRedirectAdvance', 'ajaxViewTransactions', 'viewTransactions', 'success', 'failure', 'cancel', 'sendOtp', 'validateOtp', 'register', 'resendOtp', 'payNowRedirect', 'success2', 'failure2', 'cancel2', 'downloadReceipt', 'printReceipt'];
        $this->Auth->allow($beforeLoginActions);
    }

    public function confirmLogin($uniqId = NULL) {
        $this->viewBuilder()->layout('default');
        $payment = $this->Payments->find('all')->where(['Payments.uniq_id' => $uniqId])->contain(['UploadedPaymentFiles', 'Webfronts'])->first();
        $merchant = $this->Users->find()->where(['Users.id' => $payment->webfront->merchant_id])->first();
        $this->set(compact('merchant', 'payment'));
    }

    public function makePayment($uniqId = NULL) {
        $query = $this->Payments->find('all')->where(['Payments.uniq_id' => $uniqId]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $payment = $query->contain(['Users', 'UploadedPaymentFiles', 'Webfronts', 'Webfronts.Users'])->first();
        //If Not Loggedin//
        if (!$this->Auth->user('id')) {
            if (!empty($payment->user->password)) {
                //Existing User//
                return $this->redirect(HTTP_ROOT . "customer/login/{$payment->webfront->user->uniq_id}/" . $this->Custom->makeSeoUrl($payment->webfront->user->name));
            } else {
                //First Time User//
                return $this->redirect(HTTP_ROOT . "customer/send-otp/{$payment->user->uniq_id}/{$payment->webfront->user->uniq_id}/{$uniqId}");
            }
        } else {
            return $this->redirect(HTTP_ROOT . "customer/confirm-login/$uniqId");
        }
    }

    public function sendOtp($userUniqId = NULL, $merchantUniqId = NULL, $uniqId = NULL) {
        $this->viewBuilder()->layout('default');
        $query = $this->Users->find()->where(['Users.uniq_id' => $userUniqId]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $userDetails = $query->first();

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $phone = trim($data['phone']);
            if ($userDetails->phone == $phone) {
                $this->loadModel('Otps');
                $otp = $this->Otps->newEntity();
                $otp->uniqid = $this->Custom->generateUniqId();
                $otp->user_id = $userDetails->id;
                $otp->otp = $this->Custom->generateOTP();
                $otp->created = time();
                if ($this->Otps->save($otp)) {
                    $this->_sendOtp($otp->uniqid);
                    $this->Flash->success(__('OTP sent successfully. Please check your phone!!.'));
                    return $this->redirect(HTTP_ROOT . "customer/validate-otp/{$otp->uniqid}/{$merchantUniqId}/{$uniqId}");
                } else {
                    $this->Flash->error(__('Some error eccured. Please try again!!.'));
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__('Phone No not found.'));
                return $this->redirect($this->referer());
            }
        }
        $merchant = $this->Users->find()->where(['Users.uniq_id' => $merchantUniqId])->contain(['MerchantProfiles'])->first();
        $this->set(compact('merchant'));
    }

    public function resendOtp($uniqid) {
        $this->viewBuilder()->layout('');
        $this->loadModel('Otps');
        $this->_sendOtp($uniqid);
        $this->Flash->success(__('OTP Resent Successfully!!.'));
        return $this->redirect($this->referer());
    }

    public function _sendOtp($uniqid) {
        $getOtp = $this->Otps->find()->where(['Otps.uniqid' => $uniqid])->contain(['Users'])->first();
//        $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();
//        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'REGISTER_OTP', 'is_active' => 1])->first();        
//        $message = $this->Custom->formatEmail($mailTemplate['content'], [
//            'NAME' => $getOtp->user->name,
//            'OTP' => $getOtp->otp
//        ]);
//        $this->Custom->sendEmail($getOtp->user->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);

        /* ======================For SMS Sending Starts here==================================== */
        $phone = $getOtp->user->phone;
        $sms = "Your OTP is [OTP]";
        $message = $this->Custom->formatEmail($sms, [
            'OTP' => $getOtp->otp
        ]);
        $this->Custom->sendSMS($phone, $message);
        /* ======================For SMS Sending Ends here==================================== */
        return TRUE;
    }

    public function validateOtp($uniqid = NULL, $merchantUniqId = NULL, $uniqId = NULL) {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Otps');
        $query = $this->Otps->find()->where(['Otps.uniqid' => $uniqid]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $getOtp = $query->contain(['Users'])->first();
        if ($this->request->is('post')) {
            $otp = $this->request->data['otp'];
            if ($getOtp->otp == $otp) {
                $qstr = $this->Custom->generateUniqId();
                $status = $this->Users->query()->update()->set(["qstr" => $qstr])->where(['id' => $getOtp->user->id])->execute();
                if ($status) {
                    $this->Otps->deleteAll(['Otps.uniqid' => $uniqid]);
                    $this->Flash->success(__('OTP validated successfully!!.'));
                    return $this->redirect(HTTP_ROOT . "customer/register/{$qstr}/$merchantUniqId?paymentUniqId={$uniqId}");
                } else {
                    $this->Flash->error(__('Error occured.Please try again!!.'));
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__('Invalid OTP!!.'));
                return $this->redirect($this->referer());
            }
        }
        $merchant = $this->Users->find()->where(['Users.uniq_id' => $merchantUniqId])->contain(['MerchantProfiles'])->first();
        $this->set(compact('merchant'));
    }

    public function register($qstr = NULL, $merchantUniqId = NULL) {
        $this->viewBuilder()->layout('default');
        $query = $this->Users->find()->where(['Users.qstr' => $qstr]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $getUser = $query->first();

        $merchant = $this->Users->find()->where(['Users.uniq_id' => $merchantUniqId])->contain(['MerchantProfiles'])->first();
        $this->set(compact('merchant', 'getUser'));

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $password = $data['password'];
            $confirmPassword = $data['confirm_password'];
            if ($password == $confirmPassword) {

                $user = $this->Users->get($getUser->id);
                $user->password = $password;
                $user->qstr = "";
                $this->Users->save($user);

                $this->Auth->setUser($getUser->toArray());
                $this->request->session()->write('merchant', $merchant);
                $this->Flash->success(__("Registered successfully!!."));
                if (!empty($_GET['paymentUniqId'])) {
                    $uniqId = urldecode($_GET['paymentUniqId']);
                    return $this->redirect(HTTP_ROOT . "customer/#/pay-now/{$uniqId}");
                } else {
                    return $this->redirect(HTTP_ROOT . 'customer/#/dashboard');
                }
            } else {
                $this->Flash->error(__("Password & Confirm password does't matches."));
                return $this->redirect($this->referer());
            }
        }
    }

    public function ajaxPaymentHistory() {
        $this->viewBuilder()->layout('ajax');
        $merchantId = $this->request->session()->read('merchant.id');
        $conditions = ['Payments.customer_id' => $this->Auth->user('id'), 'Webfronts.merchant_id' => $merchantId, 'Payments.status' => 1];
        $payments = $this->Payments->find('all')->where($conditions)->contain(['Users', 'UploadedPaymentFiles', 'UploadedPaymentFiles.Webfronts'])->order(['Payments.id' => 'DESC'])->limit(6);
        if ($payments->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $payments]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxViewPaymentDetails($uniqId) {
        $this->viewBuilder()->layout('ajax');
        $conditions = ['Payments.customer_id' => $this->Auth->user('id'), 'Payments.uniq_id' => $uniqId];
        $payment = $this->Payments->find('all')->where($conditions)->contain(['Users', 'UploadedPaymentFiles', 'Webfronts']);
        if ($payment->count() > 0) {
            $payment = $payment->first();
            if (date('Y-m-d') <= date('Y-m-d', strtotime($payment->uploaded_payment_file->payment_cycle_date))) {
                $payment->late_fee_amount = 0;
            }
            echo json_encode(['status' => 'success', 'payment' => $payment]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxUpcomingPayments() {
        $this->viewBuilder()->layout('ajax');
        $merchantId = $this->request->session()->read('merchant.id');
        $conditions = ['Payments.customer_id' => $this->Auth->user('id'), 'Webfronts.merchant_id' => $merchantId, 'Payments.status' => 0];
        $payments = $this->Payments->find('all')->where($conditions)->contain(['Users', 'UploadedPaymentFiles', 'UploadedPaymentFiles.Webfronts']);
        if ($payments->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $payments]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function payNowRedirect($uniq = null) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['UploadedPaymentFiles', 'Webfronts', 'Webfronts.Users', 'Webfronts.Users.MerchantProfiles']);
        if ($query->count() > 0) {
            $payment = $query->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function payNowRedirectAdvance($uniq = null) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Webfronts', 'Webfronts.Users', 'Webfronts.Users.MerchantProfiles']);
        if ($query->count() > 0) {
            $payment = $query->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    ///////////////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//////////////////////////

    public function downloadReport() {
        $query = $this->Payments->find()->where(['customer_id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            $uploadedPaymentFile = $query->first();
            $conditions = ['Payments.customer_id' => $this->Auth->user('id'), 'Payments.status' => 1];
            $payments = $this->Payments->find('all')->where($conditions)->toArray();
            require_once(ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'index.php');
            $file = downloadCustomerReport($payments, $uploadedPaymentFile);
            $filePath = WWW_ROOT . "temp_excel/" . $file;
            $this->response->file($filePath, ['download' => TRUE, 'name' => $file]);
            return $this->response;
        } else {
            $this->redirect($this->referer());
        }
    }

    public function downloadReceipt($id) {
        $payment = $this->Payments->find()->where(['Payments.id' => $id])->first();
        $filePath = WWW_ROOT . "files/receipt/PaymentReceipt-{$payment->id}.pdf";
        $this->response->file($filePath, ['download' => TRUE, 'name' => "PaymentReceipt-{$payment->id}.pdf"]);
        return $this->response;
    }

    public function printReceipt($id) {
        $payment = $this->Payments->find()->where(['Payments.id' => $id])->first();
        $filePath = WWW_ROOT . "files/receipt/PaymentReceipt-{$payment->id}.pdf";
        $this->response->file($filePath, ['name' => "PaymentReceipt-{$payment->id}.pdf"]);
        return $this->response;
    }

    public function ajaxEmailReceipt($uniq) {
        $this->_paymentConfEmail($uniq);       
        echo json_encode(['status' => 'success']);
        exit;
    }

    public function success($uniq = null) {

        if ($this->request->is('post')) {

            $data = $_POST;

            if ($data['status'] == 'success') {

                $status = $_POST["status"];
                $firstname = $_POST["firstname"];
                $amount = $_POST["amount"];
                $txnid = $_POST["txnid"];
                $key = $_POST["key"];
                $productinfo = $_POST["productinfo"];
                $email = $_POST["email"];
                $mode = $_POST['mode'];

                $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Webfronts.Users.MerchantProfiles'])->first();
                $key = $payment->webfront->user->merchant_profile->payu_key;
                $salt = $payment->webfront->user->merchant_profile->payu_salt;
                $postedHash = $_POST["hash"];
                $additionalCharges = 0;
                if (isset($_POST["additionalCharges"])) {
                    $additionalCharges = $_POST["additionalCharges"];
                    $retHashSeq = "{$additionalCharges}|{$salt}|{$status}|||||||||||{$email}|{$firstname}|{$productinfo}|{$amount}|{$txnid}|{$key}";
                } else {
                    $retHashSeq = "{$salt}|{$status}|||||||||||{$email}|{$firstname}|{$productinfo}|{$amount}|{$txnid}|{$key}";
                }
                $hash = hash("sha512", $retHashSeq);
                if ($hash == $postedHash) {
                    $status = ($_POST['unmappedstatus'] == 'captured') ? 1 : 0;
                    $paidAmount = $amount + $additionalCharges;
                    $fileds = ["status" => $status, "unmappedstatus" => $_POST['unmappedstatus'], 'txn_id' => $txnid, "payment_date" => date('Y-m-d'), 'paid_amount' => $paidAmount, 'convenience_fee_amount' => $additionalCharges, 'mode' => $mode];
                    $isPaid = $this->Payments->query()->update()->set($fileds)->where(['uniq_id' => $uniq])->execute();
                    if ($isPaid) {
                        $this->generateInvoice($uniq);
                        sleep(2);
                        $this->_paymentConfEmail($uniq);
                    }
                    return $this->redirect(HTTP_ROOT . "customer/payments/success/" . $payment->uniq_id);
                }
            }
        }

        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Webfronts.Users'])->first();
            $this->set(compact('payment'));
        } else {
            throw new \Exception;
        }
    }

    public function generateInvoice($uniq = null) {
        $this->viewBuilder()->layout('');
        $mpdf = new mPDF();

        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'customer_id', 'joinType' => 'INNER']);
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Users', 'UploadedPaymentFiles', 'UploadedPaymentFiles.Webfronts'])->first();

        $hdr = '            
    <table style="font-family:arial helvetica sans-serif; font-size: 16px;" border="0" cellspacing="0" cellpadding="0" >
    <tbody>        
        <tr> <td style="text-align:center; background: #F2F2F2; font-size : 35px; padding:10px; width: 1000px;"><h1 style="font-family:trebuchet ms,arial;font-size:35px">Payment Receipt</h1></td></tr>      
        <tr> <td colspan="3" style="border:1px solid #c6c6c6"><table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
            <tr>
                <td style="padding-left:12px;padding-right:12px;font-family:trebuchet ms,arial;font-size:13px">';

        $ftr = '</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr>
        <td height="34" bgcolor="#f1f1f1" style="border:solid 1px #c6c6c6;border-top:0px;font-family:arial;text-align:center"><p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
        <td style="float:left; padding:10px;"><img src="img/logo/smarthub-logo.png" style="margin-top: 20px;"></td>
        <td style="float:right; padding:10px;"><img src="img/logo/hdfc-logo.png" style="margin-top: 20px;"></td>
        </tbody></table>
        </p></td>
        </tr>
    </tbody>
    </table>
    </div>
    ';

        $message = "";

        $totalFee = $payment->paid_amount;

        $message = "<table width='100%'><tr><td style='font-family:trebuchet ms,arial; padding: 25px 10px;'>";
        $message .= "<p>&nbsp;</p>";
        $message .= "<p>Payment Id : {$payment->id}</p><br/>";
        $message .= "<p>Customer Name : {$payment->name}</p><br/>";
        $message .= "<p>Customer Email : {$payment->email}</p><br/>";
        $message .= "<p>Customer Phone : {$payment->phone}</p><br/>";
        $message .= "<p>Due Date : " . date("d/m/Y", strtotime($payment->uploaded_payment_file->payment_cycle_date)) . "</p><br/>";
        $message .= "<p>Bill Date : " . date("d/m/Y", strtotime($payment->payment_date)) . "</p><br/>";
        $message .= "<p>&nbsp;</p>";
        $message .= "<p>Net Bill Amount : Rs. " . $totalFee . "</p><br/>";
        $message .= "<p>&nbsp;</p>";
        $message .= "</td><td align='right'>";
        $message .= "<p style='font-family:trebuchet ms,arial;'><b>Paid on : " . date("d/m/Y", strtotime($payment->payment_date)) . "</b></p><br/>";
        $message .= "<p style='font-family:trebuchet ms,arial; width: 200px; text-align: center;'><b>Paid Amount <br/> <span style='font-size: 25px;'> Rs. {$totalFee}</span></b></p><br/>";
        $message .= "</td>";
        $message .= "</tr></table>";

        $html = $hdr . $message . $ftr;
        $mpdf->WriteHTML($html);
        $file = "PaymentReceipt-" . $payment->id . ".pdf";
//        $mpdf->Output();
        $mpdf->Output("files/receipt/$file", 'F');
        return $file;
        exit;
    }

    public function _paymentConfEmail($uniq = null) {
        $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Webfronts.Users'])->first();
        $totalFee = $payment->paid_amount;
        /* Send Email To Customer */
        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_CONFIRMATION', 'is_active' => 1])->first();
        $message = $this->Custom->formatEmail($mailTemplate['content'], [
            'NAME' => $payment->name,
            'BILL_AMOUNT' => $totalFee,
            'INVOICE_NO' => $payment->id
        ]);
        $files = ["files/receipt/" . "PaymentReceipt-" . $payment->id . ".pdf"];
        $this->Custom->sendEmail($payment->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email, $files);

        /* ======================For SMS Sending Starts here=================================== */
        $phone = $payment->phone;
        $sms = "Transaction No. [TXN_ID]  for Rs [BILL_AMOUNT] done for [MERCHANT] has [STATUS]";
        $message = $this->Custom->formatEmail($sms, [
            'TXN_ID' => $payment->txn_id,
            'BILL_AMOUNT' => $payment->paid_amount,
            'MERCHANT' => $payment->webfront->user->name,
            'STATUS' => ' been Paid'
        ]);
        $this->Custom->sendSMS($phone, $message);
        /* ======================For SMS Sending Ends here==================================== */

        /* Send Email To Merchant */
        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_CONFIRMATION_MERCHANT', 'is_active' => 1])->first();
        $message = $this->Custom->formatEmail($mailTemplate['content'], [
            'MERCHANT' => $payment->webfront->user->name,
            'NAME' => $payment->name,
            'BILL_AMOUNT' => $totalFee,
            'INVOICE_NO' => $payment->id,
            'PAYMENT_DATE' => date('M d, Y', strtotime($payment->payment_date))
        ]);
        $this->Custom->sendEmail($payment->webfront->user->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);
        return TRUE;
    }

    public function _paymentConfSms($uniq = null) {
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Webfronts.Users'])->first();
        /* ======================For SMS Sending Starts here=================================== */
        $phone = $payment->phone;
        $sms = "Transaction No. [TXN_ID]  for Rs [BILL_AMOUNT] done for [MERCHANT] has [STATUS]";
        $message = $this->Custom->formatEmail($sms, [
            'TXN_ID' => $payment->txn_id,
            'BILL_AMOUNT' => $payment->paid_amount,
            'MERCHANT' => $payment->webfront->user->name,
            'STATUS' => ' been Paid'
        ]);
        $this->Custom->sendSMS($phone, $message);
        /* ======================For SMS Sending Ends here==================================== */
        return TRUE;
    }

    public function failure($uniq = null) {
        if ($this->request->is('post')) {
            $this->Payments->query()->update()->set(["status" => 0, "unmappedstatus" => $_POST['unmappedstatus']])->where(['uniq_id' => $uniq])->execute();
            $this->_paymentFailureEmail($uniq);
            return $this->redirect(HTTP_ROOT . "customer/payments/failure/" . $uniq);
        }
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Webfronts'])->first();
            $this->set(compact('payment'));
        } else {
            throw new \Exception;
        }
    }

    public function _paymentFailureEmail($uniq = null) {
        $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();
        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_FAILURE', 'is_active' => 1])->first();
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Users', 'UploadedPaymentFiles', 'Webfronts', 'Webfronts.Users'])->first();
        $totalFee = $payment->fee;
        $message = $this->Custom->formatEmail($mailTemplate['content'], [
            'NAME' => $payment->name,
            'MERCHANT' => $payment->webfront->user->name,
            'WEBFRONT_TITLE' => $payment->webfront->title,
            'EMAIL' => $payment->email,
            'PHONE' => $payment->phone,
            'BILL_AMOUNT' => " Rs." . $totalFee,
            'PAYMENT_CYCLE_DATE' => date("d M, Y", strtotime($payment->uploaded_payment_file->payment_cycle_date)),
        ]);
        $this->Custom->sendEmail($payment->email, $adminSetting->from_email, $mailTemplate->subject, $message, $adminSetting->bcc_email);

        /* ======================For SMS Sending Starts here=================================== */
//        $phone = $payment->phone;
//        $sms = "Transaction No. [TXN_ID]  for Rs [BILL_AMOUNT] done for [MERCHANT] has [STATUS]";
//        $message = $this->Custom->formatEmail($sms, [
//            'TXN_ID' => $payment->txn_id,
//            'BILL_AMOUNT' => $payment->paid_amount,
//            'MERCHANT' => $payment->webfront->user->name,
//            'STATUS' => 'not Paid'
//        ]);
//        $this->Custom->sendSMS($phone, $message);
        /* ======================For SMS Sending Ends here==================================== */

        return TRUE;
    }

    public function cancel($uniq = null) {
        if ($this->request->is('post')) {
            $this->Payments->query()->update()->set(["status" => 0, "unmappedstatus" => $_POST['unmappedstatus']])->where(['uniq_id' => $uniq])->execute();
            return $this->redirect(HTTP_ROOT . "customer/payments/cancel/" . $uniq);
        }
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users', 'UploadedPaymentFiles', 'Webfronts'])->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function payNow($uniq = null) {
        $this->viewBuilder()->layout('default');
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users', 'UploadedPaymentFiles', 'Webfronts.Users'])->first();
            $merchant = $this->Users->find()->where(['Users.id' => $payment->webfront->merchant_id])->first();
            $this->set(compact('payment', 'merchant'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function viewDetails($uniq = null) {
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users'])->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function viewTransactions($uniq = NULL) {
        $this->viewBuilder()->layout('default');
        $query = $this->Users->find()->where(['Users.uniq_id' => $uniq, 'type' => 3])->contain(['MerchantProfiles']);
        if ($query->count() > 0) {
            $merchant = $query->first();
            $this->set(compact('merchant'));
        } else {
            throw new \Exception;
        }
    }

    public function ajaxViewTransactions($uniq = NULL) {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->query;
        $merchantId = $data['merchnat_id'];
        $phone = $data['phone'];
        $payments = $this->Payments->find('all')->where(['Payments.phone' => $phone, 'Webfronts.merchant_id' => $merchantId])->contain(['Users', 'Webfronts', 'UploadedPaymentFiles'])->order(['Payments.id' => 'DESC']);
        if ($payments->count() <= 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid Phone Number.']);
            exit;
        }
        $this->set(compact('payments'));
    }

    public function success2($uniq = null) {
        if ($this->request->is('post')) {
            $data = $_POST;
            if ($data['status'] == 'success') {

                $status = $_POST["status"];
                $firstname = $_POST["firstname"];
                $amount = $_POST["amount"];
                $txnid = $_POST["txnid"];
                $key = $_POST["key"];
                $productinfo = $_POST["productinfo"];
                $email = $_POST["email"];
                $mode = $_POST["mode"];

                $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Webfronts.Users.MerchantProfiles'])->first();
                $key = $payment->webfront->user->merchant_profile->payu_key;
                $salt = $payment->webfront->user->merchant_profile->payu_salt;

                $postedHash = $_POST["hash"];

                $additionalCharges = 0;
                if (isset($_POST["additionalCharges"])) {
                    $additionalCharges = $_POST["additionalCharges"];
                    $retHashSeq = "{$additionalCharges}|{$salt}|{$status}|||||||||||{$email}|{$firstname}|{$productinfo}|{$amount}|{$txnid}|{$key}";
                } else {
                    $retHashSeq = "{$salt}|{$status}|||||||||||{$email}|{$firstname}|{$productinfo}|{$amount}|{$txnid}|{$key}";
                }
                $hash = hash("sha512", $retHashSeq);

                $retHashSeq = "{$salt}|{$status}|||||||||||{$email}|{$firstname}|{$productinfo}|{$amount}|{$txnid}|{$key}";
                $hash = hash("sha512", $retHashSeq);

                if ($hash == $postedHash) {
                    $status = ($_POST['unmappedstatus'] == 'captured') ? 1 : 0;
                    $paidAmount = $amount + $additionalCharges;
                    $fileds = ["status" => $status, "unmappedstatus" => $_POST['unmappedstatus'], 'txn_id' => $txnid, "payment_date" => date('Y-m-d'), 'fee' => $amount, 'paid_amount' => $paidAmount, 'mode' => $mode];
                    $isPaid = $this->Payments->query()->update()->set($fileds)->where(['uniq_id' => $uniq])->execute();
                    if ($isPaid) {
                        $this->generateInvoiceAdvance($uniq);
                        sleep(2);
                        $this->_paymentConfEmail($uniq);
                    }
                    return $this->redirect(HTTP_ROOT . "customer/payments/success2/" . $payment->uniq_id);
                }
            }
        }

        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Webfronts.Users'])->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function generateInvoiceAdvance($uniq = null) {
        $this->viewBuilder()->layout('');
        $mpdf = new mPDF();

        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->first();

        $hdr = '            
    <table style="font-family:arial helvetica sans-serif; font-size: 16px;" border="0" cellspacing="0" cellpadding="0" >
    <tbody>        
        <tr> <td style="text-align:center; background: #F2F2F2; font-size : 35px; padding:10px; width: 1000px;"><h1 style="font-family:trebuchet ms,arial;font-size:35px">Payment Receipt</h1></td></tr>      
        <tr> <td colspan="3" style="border:1px solid #c6c6c6"><table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
            <tr>
                <td style="padding-left:12px;padding-right:12px;font-family:trebuchet ms,arial;font-size:13px">';

        $ftr = '</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr>
        <td height="34" bgcolor="#f1f1f1" style="border:solid 1px #c6c6c6;border-top:0px;font-family:arial;text-align:center"><p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
        <td style="float:left; padding:10px; "><img src="' . HTTP_ROOT . 'img/logo/smarthub-logo.png" style="margin-top: 20px;"></td>
        <td style="float:right; padding:10px;"><img src="' . HTTP_ROOT . 'img/logo/hdfc-logo.png" style="margin-top: 20px;"></td>
        </tbody></table>
        </p></td>
        </tr>
    </tbody>
    </table>
    </div>
    ';

        $message = "";

        $totalFee = $payment->paid_amount;

        $message = "<table width='100%'><tr><td style='font-family:trebuchet ms,arial; padding: 25px 10px;'>";
        $message .= "<p>&nbsp;</p>";
        $message .= "<p>Payment Id : {$payment->id}</p><br/>";
        $message .= "<p>Customer Name : {$payment->name}</p><br/>";
        $message .= "<p>Customer Email : {$payment->email}</p><br/>";
        $message .= "<p>Customer Phone : {$payment->phone}</p><br/>";
        $message .= "<p>Bill Date : " . date("d/m/Y", strtotime($payment->payment_date)) . "</p><br/>";
        $message .= "<p>&nbsp;</p>";
        $message .= "<p>Net Bill Amount : Rs. " . $totalFee . "</p><br/>";
        $message .= "<p>&nbsp;</p>";
        $message .= "</td><td align='right'>";
        $message .= "<p style='font-family:trebuchet ms,arial;'><b>Paid on : " . date("d/m/Y", strtotime($payment->payment_date)) . "</b></p><br/>";
        $message .= "<p style='font-family:trebuchet ms,arial; width: 200px; text-align: center;'><b>Paid Amount <br/> <span style='font-size: 25px;'> Rs. {$totalFee}</span></b></p><br/>";
        $message .= "</td>";
        $message .= "</tr></table>";

        $html = $hdr . $message . $ftr;
        $mpdf->WriteHTML($html);
        $file = "PaymentReceipt-" . $payment->id . ".pdf";
//        $mpdf->Output();
        $mpdf->Output("files/receipt/$file", 'F');
        return $file;
        exit;
    }

    public function failure2($uniq = null) {
        if ($this->request->is('post')) {
            $this->Payments->query()->update()->set(["status" => 0, "unmappedstatus" => $_POST['unmappedstatus']])->where(['uniq_id' => $uniq])->execute();
            return $this->redirect(HTTP_ROOT . "customer/payments/failure2/" . $uniq);
        }
        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'customer_id', 'joinType' => 'INNER']);
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users'])->contain(['Webfronts'])->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function cancel2($uniq = null) {
        if ($this->request->is('post')) {
            $this->Payments->query()->update()->set(["status" => 0, "unmappedstatus" => $_POST['unmappedstatus']])->where(['uniq_id' => $uniq])->execute();
            return $this->redirect(HTTP_ROOT . "customer/payments/cancel2/" . $uniq);
        }
        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'customer_id', 'joinType' => 'INNER']);
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Webfronts'])->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

}
