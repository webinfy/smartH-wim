<?php

namespace App\Controller\Merchant;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class PaymentsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Custom');

        $this->loadModel('Users');
        $this->loadModel('AdminSettings');
        $this->loadModel('MailTemplates');
        $this->loadModel('Webfronts');
        $this->loadModel('UploadedPaymentFiles');
        $this->loadModel('WebfrontFields');
        $this->loadModel('WebfrontFieldValues');
        $this->loadModel('WebfrontPaymentAttributes');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
//$this->Auth->allow(['']);
    }

    public function webfrontReport($id = NULL, $option = 0) {

        $conditions[] = ['Payments.webfront_id' => $id];
        if ($option == 1) {
            $conditions[] = ['Payments.status' => 1];
        } else if ($option == 2) {
            $conditions[] = ['Payments.status' => 0];
        }

        $webfront = $this->Webfronts->find('all')->where(['Webfronts.id' => $id])->contain(['Users.MerchantProfiles'])->first();
        $payments = $this->Payments->find('all')->where($conditions)->limit(1000);

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $style = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("D1:D1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("F1:L1")->applyFromArray($style);

        foreach (range('A', 'K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
///SetHeading//  
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Sr.No.");
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', "Flat/Shop No");
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', "First Holder");
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', "Invoice Number");
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', "Email Id");
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', "Mobile No");
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', "Total Amt");
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', "Payment Date");
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', "Payment Id");
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', "Paid Amount");
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', "Transaction Id");
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', "Mode");
//Set Content
        $rowCount = 2;
        foreach ($payments as $payment) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, ($rowCount - 1));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $webfront->user->merchant_profile->regd_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $payment->name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $payment->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $payment->email);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $payment->phone);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $payment->fee);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $payment->payment_date);
            //Below filed will be used for Paid Payments
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $payment->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $payment->paid_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $payment->txn_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $payment->mode);
            //Apply Style
            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle("D$rowCount:D$rowCount")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle("F$rowCount:L$rowCount")->applyFromArray($style);

            $rowCount++;
        }

        $filename = "Transaction-Report-" . time() . ".xlsx";
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save("files/reports/$filename");

        if (ob_get_contents()) {
            ob_end_clean();
        }

        $filePath = 'files/reports/' . $filename;
        $size = filesize($filePath);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($filePath);

        $file = new \Cake\Filesystem\File($filePath);
        $file->delete();
        exit();
    }

    public function downloadReport($fileId = NULL, $option = 0) {

        $conditions[] = ['Payments.uploaded_payment_file_id' => $fileId];
        if ($option == 1) {
            $conditions[] = ['Payments.status' => 1];
        } else if ($option == 2) {
            $conditions[] = ['Payments.status' => 0];
        }
        $uploadedPaymentFile = $this->UploadedPaymentFiles->find('all')->where(['UploadedPaymentFiles.id' => $fileId])->contain(['Webfronts.Users.MerchantProfiles'])->first();
        $payments = $this->Payments->find('all')->where($conditions)->limit(5000);

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $style = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:B1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("D1:D1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->getStyle("F1:L1")->applyFromArray($style);

        foreach (range('A', 'K') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        /* SetHeading */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Sr.No.");
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', "Flat/Shop No");
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', "First Holder");
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', "Invoice Number");
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', "Email Id");
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', "Mobile No");
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', "Total Amt");
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', "Payment Date");
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', "Payment Id");
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', "Paid Amount");
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', "Transaction Id");
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', "Mode");
        /* Set Content */
        $rowCount = 2;
        foreach ($payments as $payment) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, ($rowCount - 1));
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $uploadedPaymentFile->webfront->user->merchant_profile->regd_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $payment->name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $payment->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $payment->email);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $payment->phone);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $payment->fee);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $payment->payment_date);
            /* Below filed will be used for Paid Payments */
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $payment->id);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $payment->paid_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $payment->txn_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $payment->mode);
            /* Apply Style */
            $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:B$rowCount")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle("D$rowCount:D$rowCount")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle("F$rowCount:L$rowCount")->applyFromArray($style);

            $rowCount++;
        }

        $filename = "Transaction-Report-" . time() . ".xlsx";
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save("files/reports/$filename");

        if (ob_get_contents()) {
            ob_end_clean();
        }

        $filePath = 'files/reports/' . $filename;
        $size = filesize($filePath);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($filePath);

        $file = new \Cake\Filesystem\File($filePath);
        $file->delete();
        exit();
    }

    public function ajaxUploadReuse($webfrontId = NULL) {
        $data = $this->request->data;
        $paymentCycleDate = $data['payment_cycle_date'];
        if ($paymentCycleDate == '') {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter payment cycle date!!']);
            exit;
        }
        if ($paymentCycleDate <= date('Y-m-d')) {
            echo json_encode(['status' => 'error', 'msg' => 'Payment cycle date must be greater than current date!!']);
            exit;
        }
        $getUploadedPaymentFile = $this->UploadedPaymentFiles->get($data['id']);
        $uploadedPaymentFile = $this->UploadedPaymentFiles->newEntity();
        $uploadedPaymentFile->webfront_id = $getUploadedPaymentFile->webfront_id;
        $uploadedPaymentFile->payment_cycle_date = $data['payment_cycle_date'];
        $uploadedPaymentFile->file = $getUploadedPaymentFile->file;
        if ($this->UploadedPaymentFiles->save($uploadedPaymentFile)) {
            $getPayments = $this->Payments->find('all')->where(['uploaded_payment_file_id' => $data['id']]);
            foreach ($getPayments as $getPayment) {
                $payment = $this->Payments->newEntity();
                $payment->uniq_id = $this->Custom->generateUniqId();
                $payment->webfront_id = $uploadedPaymentFile->webfront_id;
                $payment->uploaded_payment_file_id = $uploadedPaymentFile->id;
                $payment->customer_id = $getPayment->customer_id;
                $payment->name = $getPayment->name;
                $payment->email = $getPayment->email;
                $payment->phone = $getPayment->phone;
                $payment->payee_custom_fields = $getPayment->payee_custom_fields;
                $payment->convenience_fee_amount = $getPayment->convenience_fee_amount;
                $payment->late_fee_amount = $getPayment->late_fee_amount;
                $payment->fee = $getPayment->fee;
                $payment->payment_custom_fields = $getPayment->payment_custom_fields;
                $this->Payments->save($payment);
            }

            $url = HTTP_ROOT . "merchant/webfronts/sendEmailInBackground/{$uploadedPaymentFile->id}";
            $request = new \cURL\Request($url);
            $request->getOptions()
                    ->set(CURLOPT_TIMEOUT, 5)
                    ->set(CURLOPT_RETURNTRANSFER, true);
            while ($request->socketPerform()) {
                $request->socketSelect();
            }

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try gain!!']);
        }
        exit;
    }

    public function ajaxViewUploads($webfrontId = NULL) {
        $conditions = ['UploadedPaymentFiles.webfront_id' => $webfrontId];
        $webfront = $this->Webfronts->get($webfrontId);
        $uploadedPaymentFiles = $this->UploadedPaymentFiles->find('all')->where($conditions)->order(['UploadedPaymentFiles.id' => 'DESC']);
        echo json_encode(['status' => 'success', 'data' => ['uploaded_payment_files' => $uploadedPaymentFiles, 'webfront' => $webfront]]);
        exit;
    }

    public function ajaxDeleteUploadedFile($id = NULL) {
        $entity = $this->UploadedPaymentFiles->get($id);
        if ($this->UploadedPaymentFiles->delete($entity)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured.Please try again!!.']);
        }
        exit;
    }

    public function ajaxAdvanceWebfrontPayments($webfrontId = NULL) {
        $data = $this->request->data;
        $conditions = ['webfront_id' => $webfrontId];
        if (isset($data['status']) && $data['status'] == 'paid') {
            $conditions[] = ['Payments.status' => 1];
        } else if (isset($data['status']) && $data['status'] == 'unpaid') {
            $conditions[] = ['Payments.status' => 0];
        }
        $payments = $this->Payments->find()->where($conditions);
        $webfront = $this->Webfronts->find('all')->where(['Webfronts.id' => $webfrontId])->first();
        echo json_encode(['status' => 'success', 'payments' => $payments, 'webfront' => $webfront]);
        exit;
    }

    public function ajaxViewPayments($uploadedPaymentFileId = NULL) {
        $data = $this->request->data;
        $conditions = ['uploaded_payment_file_id' => $uploadedPaymentFileId];
        $page = !empty($data['page']) ? $data['page'] : 1;
        if (!empty($data['searchby'])) {
            $searchby = strtolower(urldecode($data['searchby']));
            $keyword = urldecode($data['keyword']);
            if ($searchby == 'name') {
                $conditions[] = ['Payments.name LIKE' => "%" . $keyword . "%"];
            } else if ($searchby == 'email') {
                $conditions[] = ['Payments.email LIKE' => "%" . $keyword . "%"];
            } else if ($searchby == 'phone') {
                $conditions[] = ['Payments.phone LIKE' => "%" . $keyword . "%"];
            }
        }
        if ($data['status'] == 'paid') {
            $conditions[] = ['Payments.status' => 1];
        } else if ($data['status'] == 'unpaid') {
            $conditions[] = ['Payments.status' => 0];
        }

        $order = ['Payments.id' => 'ASC'];
        $config = [
            'limit' => 20,
            'order' => $order,
            'contain' => [],
            'conditions' => $conditions,
            'page' => !empty($page) ? $page : 1,
            'contain' => ['UploadedPaymentFiles']
        ];
        $payments = $this->Paginator->paginate($this->Payments->find(), $config);

        $webfrontId = $this->UploadedPaymentFiles->find()->where(['id' => $uploadedPaymentFileId])->first()->webfront_id;
        $webfront = $this->Webfronts->find('all')->where(['Webfronts.id' => $webfrontId])->first();
        $webfront->customer_fields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfront->id]);
        $webfront->payment_fields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfront->id]);

        $this->set(compact('payments', 'webfront'));
    }

    public function ajaxDeletePayment($uniq_id) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq_id, 'Payments.status' => 0]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error']);
            exit;
        }
        $entity = $this->Payments->get($query->first()->id);
        if ($this->Payments->delete($entity)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxDeleteSelectedPayments() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;
        if ($this->Payments->deleteAll(['Payments.uniq_id IN' => $data['ids'], 'Payments.status' => 0])) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxRemindPayment($id) {
        $this->viewBuilder()->layout('ajax');
        $status = $this->_sendReminderEmail($id);
        if ($status) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxRemindSelectedPayment() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;
        if (!empty($data['ids'])) {
            foreach ($data['ids'] as $id) {
                $status = $this->_sendReminderEmail($id);
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function _sendReminderEmail($paymentId) {
        $query = $this->Payments->find('all')->where(['Payments.id' => $paymentId])->contain(['Users', 'Webfronts', 'Webfronts.Users']);
        if ($query->count() > 0) {
            $payment = $query->first();
            $adminSetting = $this->AdminSettings->find()->where(['id' => 1])->first();
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION', 'is_active' => 1])->first();

            $link = HTTP_ROOT . "customer/payments/make-payment/" . $payment->uniq_id;
            $directLink = HTTP_ROOT . "webfronts/basic/{$payment->webfront->url}";
            $viewTransLink = HTTP_ROOT . "customer/view-transactions/" . $payment->webfront->user->uniq_id;

            $billAmount = $payment->fee; // + $payment->convenience_fee_amount + $payment->late_fee_amount;

            $message = $this->Custom->formatEmail($mailTemplate['content'], [
                'NAME' => $payment->name,
                'MERCHANT' => $payment->webfront->user->name,
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
            $sms = "Use this Below Link to process Payment of amount INR [BILL_AMOUNT]. [DIRECT_LINK]";
            $message = $this->Custom->formatEmail($sms, [
                'BILL_AMOUNT' => $payment->fee,
                'DIRECT_LINK' => HTTP_ROOT . "webfronts/basic/{$payment->webfront->url}"
            ]);
            $this->Custom->sendSMS($phone, $message);
            /* ======================For SMS Sending Ends here==================================== */

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function ajaxEditPayment() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;

        $payment = $this->Payments->newEntity();
        $payment->id = $data['id'];
        $payment->fee = $data['fee'];

        if (!empty($data['payee_field_keys'])) {
            $customerFieldValues = [];
            for ($i = 0; $i < count($data['payee_field_keys']); $i++) {
                $customerFieldValues["$i"]['field'] = $data['payee_field_keys'][$i];
                $customerFieldValues["$i"]['value'] = $data['payee_field_values'][$i];
            }
            $payment->payee_custom_fields = json_encode($customerFieldValues);
        }

        if (!empty($data['payment_field_keys'])) {
            $customerFieldValues = [];
            for ($i = 0; $i < count($data['payment_field_keys']); $i++) {
                $paymentFieldValues["$i"]['field'] = $data['payment_field_keys'][$i];
                $paymentFieldValues["$i"]['value'] = $data['payment_field_values'][$i];
            }
            $payment->payment_custom_fields = json_encode($paymentFieldValues);
        }

        if ($this->Payments->save($payment)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function downloadError($webfronId) {
        $query = $this->Webfronts->find('all')->where(['id' => $webfronId]);
        if ($query->count() <= 0) {
            echo "No File Found.";
            exit;
        }
        $webfront = $query->first();
        $fileName = "ErrorLog-{$webfront->id}.log";
        $filePath = UPLOAD_ERROR_LOG . $fileName;
        if (!(is_file($filePath) && file_exists($filePath))) {
            echo "No File Found.";
            exit;
        }
        $this->response->file($filePath, ['download' => TRUE, 'name' => $fileName]);
        return $this->response;
    }

}
