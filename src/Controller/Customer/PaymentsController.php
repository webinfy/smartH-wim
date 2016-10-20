<?php

namespace App\Controller\Customer;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

require_once(ROOT . DS . 'vendor' . DS . 'pdf' . DS . 'autoload.php');

use \mPDF;

class PaymentsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');

        $this->loadModel('Users');
        $this->loadModel('Payments');
        $this->loadModel('MailTemplates');
//        $this->loadModel('UploadedPaymentFiles');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $this->Auth->allow(['makePayment', 'payNow', 'payNowRedirect', 'ajaxViewTransactions', 'viewTransactions', 'success', 'failure', 'cancel']);
    }

    public function downloadReport() {
        $query = $this->Payments->find()->where(['user_id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            $uploadedPaymentFile = $query->first();
            $conditions = ['Payments.user_id' => $this->Auth->user('id'), 'Payments.status' => 1];
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

    public function success($uniq = null) {

//        $file = $this->generateInvoice($uniq);
//        $files = ["files/receipt/" . $file];
//        sleep(2);
//        $this->_paymentConfEmail($uniq, $files);


        if ($this->request->is('post')) {
            $data = $_POST;
            if ($data['status'] == 'success') {
                $isPaid = $this->Payments->query()->update()->set(["status" => 1, "payment_date" => date('Y-m-d')])->where(['uniq_id' => $uniq])->execute();
                if ($isPaid) {
                    $file = $this->generateInvoice($uniq);
                    $files = ["files/receipt/" . $file];
                    sleep(2);
                    $this->_paymentConfEmail($uniq, $files);
                }
            }
//            mail("pradeepta20@gmail.com", "PayUMoney Success", json_encode($_POST));
        }
        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'user_id', 'joinType' => 'INNER']);
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users', 'UploadedPaymentFiles'])->first();
            $merchant = $this->Users->find()->where(['Users.id' => $payment->merchant_id])->contain(['MerchantProfiles'])->first();
            $this->set(compact('payment', 'merchant'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function generateInvoice($uniq = null) {
        $this->viewBuilder()->layout('');
        $mpdf = new mPDF();

        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'user_id', 'joinType' => 'INNER']);
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Users', 'UploadedPaymentFiles'])->first();

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

        $message = "<table width='100%'><tr><td style='font-family:trebuchet ms,arial; padding: 25px 10px;'>";
        $message .= "<p>&nbsp;</p>";
        $message .= "<p>Payment Id : {$payment->id}</p><br/>";
        $message .= "<p>Customer Id : {$payment->user->cust_id}</p><br/>";
        $message .= "<p>Due Date : " . date("d/m/Y", strtotime($payment->due_date)) . "</p><br/>";
        $message .= "<p>Bill Date : " . date("d/m/Y", strtotime($payment->uploaded_payment_file->created)) . "</p><br/>";
        $message .= "<p>&nbsp;</p>";
        $message .= "<p>Net Bill Amount : Rs. {$payment->total_fee}</p><br/>";
        $message .= "<p>&nbsp;</p>";
        $message .= "</td><td align='right'>";
        $message .= "<p style='font-family:trebuchet ms,arial;'><b>Paid on : " . date("d/m/Y", strtotime($payment->payment_date)) . "</b></p><br/>";
        $message .= "<p style='font-family:trebuchet ms,arial; width: 200px; text-align: center;'><b>Paid Amount <br/> <span style='font-size: 25px;'> Rs. {$payment->total_fee}</span></b></p><br/>";
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

    public function _paymentConfEmail($uniq = null, $files) {
        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_CONFIRMATION', 'is_active' => 1])->first();
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Users', 'UploadedPaymentFiles'])->first();
        $getMerchant = $this->Users->find()->where(['Users.id' => $payment->merchant_id])->first();
        $message = $this->Custom->formatEmail($mailTemplate['content'], [
            'NAME' => $payment->name,
            'MERCHANT' => $getMerchant->name,
            'NOTE' => $payment->uploaded_payment_file->note,
            'BILL_AMOUNT' => " Rs." . $payment->total_fee,
            'PAYMENT_DATE' => date("d M, Y", strtotime($payment->payment_date)),
            'MONTH' => date("F", strtotime($payment->due_date)),
            'CUST_ID' => $payment->user->cust_id,
        ]);
        $this->Custom->sendEmail($payment->email, FROM_EMAIL, $mailTemplate->subject, $message, $files);
        return TRUE;
    }

    public function failure($uniq = null) {
        if ($this->request->is('post')) {
            $this->Payments->query()->update()->set(["status" => 0])->where(['uniq_id' => $uniq])->execute();
            $this->_paymentFailureEmail($uniq);
            mail("pradeepta20@gmail.com", "PayUMoney Failure", json_encode($_POST));
        }
        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'user_id', 'joinType' => 'INNER']);
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users', 'UploadedPaymentFiles'])->first();
            $merchant = $this->Users->find()->where(['Users.id' => $payment->merchant_id])->contain(['MerchantProfiles'])->first();

            $this->set(compact('payment', 'merchant'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function _paymentFailureEmail($uniq = null) {
        $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_FAILURE', 'is_active' => 1])->first();
        $payment = $this->Payments->find()->where(['Payments.uniq_id' => $uniq])->contain(['Users', 'UploadedPaymentFiles', 'Users'])->first();
        $message = $this->Custom->formatEmail($mailTemplate['content'], [
            'NAME' => $payment->name,
            'MERCHANT' => $payment->merchant->name,
            'NOTE' => $payment->uploaded_payment_file->note,
            'BILL_AMOUNT' => " Rs." . $payment->total_fee,
            'DUE_DATE' => date("d M, Y", strtotime($payment->due_date)),
            'MONTH' => date("F", strtotime($payment->due_date)),
            'CUST_ID' => $payment->user->cust_id,
        ]);
        $this->Custom->sendEmail($payment->email, FROM_EMAIL, $mailTemplate->subject, $message);
        return TRUE;
    }

    public function cancel($uniq = null) {
        if ($this->request->is('post')) {
            $this->Payments->query()->update()->set(["status" => 0])->where(['uniq_id' => $uniq])->execute();
            mail("pradeepta20@gmail.com", "PayUMoney Cancel", json_encode($_POST));
        }
        $this->Payments->belongsTo('Users', [ 'foreignKey' => 'user_id', 'joinType' => 'INNER']);
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users', 'UploadedPaymentFiles'])->first();
            $merchant = $this->Users->find()->where(['Users.id' => $payment->merchant_id])->contain(['MerchantProfiles'])->first();
            $this->set(compact('payment', 'merchant'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function payNow($uniq = null) {
        $uniq = urldecode(base64_decode($uniq));
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['Users', 'UploadedPaymentFiles'])->first();
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function payNowRedirect($uniq = null) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() > 0) {
            $payment = $query->contain(['UploadedPaymentFiles'])->first();
            if (date('Y-m-d') > $payment->uploaded_payment_file->last_payment_date) {
                $this->Flash->error(__('Sorry!!. This payment link has been expired.'));
                return $this->redirect($this->referer());
            }
            $this->set(compact('payment'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function viewTransactions($uniq = NULL) {
        $uniq = urldecode(base64_decode($uniq));
        $query = $this->Users->find()->where(['Users.uniq_id' => $uniq, 'type' => 3])->contain(['MerchantProfiles']);
        if ($query->count() > 0) {
            $merchant = $query->first();
            $this->set(compact('merchant'));
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function ajaxViewTransactions($uniq = NULL) {
        $data = $this->request->query;
        $merchantId = $data['merchnat_id'];
        $customerId = $data['customer_id'];
        $userId = null;
        $query = $this->Users->find()->where(['Users.cust_id' => $customerId]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid Customer Id.']);
            exit;
        } else {
            $userId = $query->select('id')->first()->id;
        }
        $payments = $this->Payments->find('all')->where(['Payments.merchant_id' => $merchantId, 'Payments.user_id' => $userId])->contain(['Users'])->order(['Payments.due_date' => 'DESC']);
        $this->set(compact('payments'));
    }

    public function ajaxUpcomingPayments() {
        $this->viewBuilder()->layout('ajax');
        $conditions = ['Payments.user_id' => $this->Auth->user('id'), 'Payments.status' => 0];
        $payments = $this->Payments->find('all')->where($conditions)->contain(['Users']);
        if ($payments->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $payments]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxPaymentHistory() {
        $this->viewBuilder()->layout('ajax');
        $conditions = ['Payments.user_id' => $this->Auth->user('id'), 'Payments.status' => 1];
        $payments = $this->Payments->find('all')->where($conditions)->contain(['Users']);
        if ($payments->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $payments]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxViewPaymentDetails($uniqId) {
        $this->viewBuilder()->layout('ajax');
        $conditions = ['Payments.user_id' => $this->Auth->user('id'), 'Payments.status' => 0, 'Payments.uniq_id' => $uniqId];
        $payment = $this->Payments->find('all')->where($conditions)->contain(['Users', 'UploadedPaymentFiles']);
        if ($payment->count() > 0) {
            $payment = $payment->first();
            echo json_encode(['status' => 'success', 'data' => $payment]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function makePayment($uniq) {

        $uniq = urldecode(base64_decode($uniq));

        if ($this->Auth->user('id')) {
            $this->redirect(HTTP_ROOT . 'customer/#/pay-now/' . $uniq);
        }

        $query = $this->Payments->find('all')->where(['uniq_id' => $uniq]);
        if ($query->count() <= 0) {
            $this->redirect(HTTP_ROOT);
        }

        $email = $query->first()->email;

        $accountExist = $this->Users->find('all')->where(['email' => $email, 'password !=' => '']);
        if ($accountExist->count() > 0) {
            $this->redirect(HTTP_ROOT);
        } else {
            $this->redirect(HTTP_ROOT . "customer/users/register/" . $uniq);
        }
    }

}
