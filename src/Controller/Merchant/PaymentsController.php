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
        $this->loadModel('UploadedPaymentFiles');
        $this->loadModel('MailTemplates');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $this->Auth->allow(['importPaymentsInBackground']);
    }

    public function downloadReport($id = null) {
        $query = $this->UploadedPaymentFiles->find()->where(['id' => $id]);
        if ($query->count() > 0) {
            $uploadedPaymentFile = $query->first();
            $payments = $this->Payments->find('all')->where(['uploaded_payment_file_id' => $uploadedPaymentFile['id']])->toArray();

            require_once(ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'index.php');
            $file = downloadReport($payments, $uploadedPaymentFile);
            $filePath = WWW_ROOT . "temp_excel/" . $file;
            $this->response->file($filePath, ['download' => TRUE, 'name' => $file]);
            return $this->response;
        } else {
            $this->redirect($this->referer());
        }
    }

    public function importPaymentsInBackground($id, $file) {
        $this->viewBuilder()->layout('');
        $paymentShell = new \App\Shell\PaymentShell;
        $paymentShell->importPayments($id, $file);
        exit;
    }

    public function updateExcel() {
        $this->viewBuilder()->layout('');
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
            if (empty($data["file"]["name"])) {
                $this->Flash->error(__('Please select file for import.'));
            } else if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
                $this->Flash->error(__('Please select excel file only.'));
            } else {
//                $fileName = time() . "_" . basename($data["file"]["name"]);
                $fileName = md5(uniqid(rand()) . time()) . "-" . basename($data["file"]["name"]);
                $targetFile = TEMP_EXCEL . $fileName;
                move_uploaded_file($data["file"]["tmp_name"], $targetFile);

                if (file_exists($targetFile)) {
                    $this->UploadedPaymentFiles->query()->update()->set(["upload_completed" => 0])->where(['id' => $data['id']])->execute();
                    $file = urlencode($fileName);
                    $url = HTTP_ROOT . "merchant/payments/importPaymentsInBackground/" . $data['id'] . "/" . $file;
                    require_once(ROOT . DS . 'vendor' . DS . 'curleasy' . DS . 'index.php');
                    asynCurl($url);
                }

                $this->Flash->success(__("New payments are updated successfully."));
            }
        }
        return $this->redirect(HTTP_ROOT . "merchant/#/view-payment-files");
    }

    public function ajaxDeletePayment($uniq_id) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq_id, 'merchant_id' => $this->Auth->user('id')]);
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

    public function ajaxImportPayments() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;

        $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
        if (empty($data["file"]["name"])) {
            $this->Flash->error(__('Please select file for import.'));
        } else if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
            $this->Flash->error(__('Please select excel file only.'));
        } else {
            $fileName = md5(uniqid(rand())) . "-" . basename($data["file"]["name"]);
            $targetFile = TEMP_EXCEL . $fileName;
            move_uploaded_file($data["file"]["tmp_name"], $targetFile);

            $uploadedPaymentFile = $this->UploadedPaymentFiles->newEntity();
            $uploadedPaymentFile->merchant_id = $this->Auth->user('id');
            $uploadedPaymentFile->file = $fileName;
            $uploadedPaymentFile->title = $data['file']['name'];
            $uploadedPaymentFile->note = $data['note'];
            $uploadedPaymentFile->last_payment_date = date_format(date_create($data['last_payment_date']), "Y-m-d");
            $uploadedPaymentFile->created = date("Y-m-d H:i:s");

            if ($this->UploadedPaymentFiles->save($uploadedPaymentFile)) {
                $file = urlencode($uploadedPaymentFile->file);
                $url = HTTP_ROOT . "merchant/payments/importPaymentsInBackground/" . $uploadedPaymentFile->id . "/" . $file;
                require_once(ROOT . DS . 'vendor' . DS . 'curleasy' . DS . 'index.php');
                asynCurl($url);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
        exit;
    }

    public function importPayments() {
        $this->viewBuilder()->layout('ajax');

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
            if (empty($data["file"]["name"])) {
                $this->Flash->error(__('Please select file for import.'));
            } else if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
                $this->Flash->error(__('Please select excel file only.'));
            } else {

//                $fileName = time() . "_" . basename($data["file"]["name"]);
                $fileName = md5(uniqid(rand())) . "-" . basename($data["file"]["name"]);
                $targetFile = TEMP_EXCEL . $fileName;
                move_uploaded_file($data["file"]["tmp_name"], $targetFile);

                $uploadedPaymentFile = $this->UploadedPaymentFiles->newEntity();
                $uploadedPaymentFile->merchant_id = $this->Auth->user('id');
                $uploadedPaymentFile->file = $fileName;
                $uploadedPaymentFile->title = $data['file']['name'];
                $uploadedPaymentFile->note = $data['note'];
                $uploadedPaymentFile->last_payment_date = date_format(date_create($data['last_payment_date']), "Y-m-d");
                $uploadedPaymentFile->created = date("Y-m-d H:i:s");

                if ($this->UploadedPaymentFiles->save($uploadedPaymentFile)) {


                    $file = urlencode($uploadedPaymentFile->file);
                    $url = HTTP_ROOT . "merchant/payments/importPaymentsInBackground/" . $uploadedPaymentFile->id . "/" . $file;
                    require_once(ROOT . DS . 'vendor' . DS . 'curleasy' . DS . 'index.php');
                    asynCurl($url);
//                    
//                    
//                    $ch = curl_init();
//                    curl_setopt($ch, CURLOPT_URL, $url);
//                    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
//                    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);
//                    curl_exec($ch);
//                    set_time_limit(0); // unlimited max execution time    
//                    $paymentShell = new \App\Shell\PaymentShell;
//                    $paymentShell->importPayments($uploadedPaymentFile->id);

                    /*

                      require_once(ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'index.php');
                      $paymentArray = getExcelContents($targetFile);

                      $heading = $paymentArray['heading'];
                      $heading = array_map('trim', $heading);

                      $phoneIndex = array_search('Phone', $heading);
                      $totalFeeIndex = array_search('Total', $heading);
                      $dueDateIndex = array_search('Due Date', $heading);

                      $noOfCustomFields = $totalFeeIndex - ($phoneIndex + 1);

                      if ($noOfCustomFields > 0) {
                      for ($i = $phoneIndex + 1; $i < $totalFeeIndex; $i++) {
                      $customFields[$this->Custom->formatCustomField($heading[$i])] = $heading[$i];
                      }
                      $uploadedPaymentFile->custom_fields = json_encode($customFields);
                      $this->UploadedPaymentFiles->save($uploadedPaymentFile);
                      }

                      $paymentDataArray = $paymentArray['data'];

                      foreach ($paymentDataArray as $paymentData) {
                      if (!empty($paymentData[0]) && !empty($paymentData[1]) && !empty($paymentData[2])) {

                      $name = filter_var($paymentData[0], FILTER_SANITIZE_STRING);
                      $email = filter_var($paymentData[1], FILTER_SANITIZE_EMAIL);
                      $phone = filter_var($paymentData[2], FILTER_SANITIZE_NUMBER_INT);

                      $totalFee = !empty($paymentData[$totalFeeIndex]) ? $paymentData[$totalFeeIndex] : 0;
                      $dueDate = date('Y-m-d', ($paymentData[$dueDateIndex] - 25569) * 86400);

                      $query = $this->Users->find()->where(['Users.email' => $email, 'type' => 4]);

                      if ($query->count() > 0) {
                      //User Alreday Exist
                      $user = $query->first();
                      } else {
                      //Create a new User
                      $user = $this->Users->newEntity();
                      $this->Users->patchEntity($user, ['email' => $email, 'type' => 4, 'uniq_id' => $this->Custom->generateUniqNumber(), 'cust_id' => uniqid()]);
                      if ($this->Users->save($user)) {
                      $userDetail = $this->Users->UserDetails->newEntity(['id' => '', 'user_id' => $user->id, 'created_by' => $this->Auth->user('id'), 'name' => $name, 'phone' => $phone, 'address' => '', 'is_active' => 1]);
                      $this->Users->UserDetails->save($userDetail);
                      $user->cust_id = 100000000 + $user->id;
                      $this->Users->save($user);
                      }
                      }

                      $payment = $this->Payments->newEntity();
                      $payment->uniq_id = $this->Custom->generateUniqNumber();
                      $payment->merchant_id = $this->Auth->user('id');
                      $payment->uploaded_payment_file_id = $uploadedPaymentFile->id;
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
                      }

                     */


//                    unlink($targetFile);
//                    $this->_sendEmail($uploadedPaymentFile->id);

                    $this->Flash->success(__("Excel imported successfully."));

//                    return $this->redirect(HTTP_ROOT . "merchant/#/view-payments/" . $uploadedPaymentFile->id);
                    return $this->redirect(HTTP_ROOT . "merchant/#/view-payment-files");
                } else {
                    $this->Flash->error(__('Some error occured. Please try again.'));
                }
            }
            return $this->redirect(HTTP_ROOT . "merchant/#/import-payments");
        }
        return $this->redirect($this->referer());
    }

    public function ajaxGetUploadedFiles() {
        $query = $this->UploadedPaymentFiles->find('all')->where(['merchant_id' => $this->Auth->user('id')])->order(['UploadedPaymentFiles.id' => 'DESC']);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxDeletePaymentFile($id) {
        $this->viewBuilder()->layout('ajax');
        $entity = $this->UploadedPaymentFiles->get($id);
        if ($entity->merchant_id != $this->Auth->user('id')) {
            echo json_encode(['status' => 'error', 'msg' => 'The payment file could not be deleted. Please, try again.']);
            exit;
        }
        if ($this->UploadedPaymentFiles->delete($entity)) {
            echo json_encode(['status' => 'success', 'msg' => 'The payment file has been deleted']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The payment file could not be deleted. Please, try again.']);
        }
        exit;
    }

    public function ajaxfetchCustomFields($uploadedFileId) {
        $query = $this->UploadedPaymentFiles->find('all')->where(['merchant_id' => $this->Auth->user('id'), 'id' => $uploadedFileId]);
        if ($query->count() > 0) {
            $getCustomFields = $query->first()->custom_fields;
            $customFields = json_decode($getCustomFields);
            echo json_encode(['status' => 'success', 'data' => $customFields]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxViewPayments($uploadedFileId) {

        $data = $this->request->data;

        $conditions = ['uploaded_payment_file_id' => $uploadedFileId];

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
            } else if ($searchby == 'bill_amount') {
                $conditions[] = ['Payments.total_fee' => $keyword];
            } else if ($searchby == 'due_date') {
                $conditions[] = ['Payments.due_date LIKE' => "%" . $keyword . "%"];
            }
        }

        $order = ['Payments.id' => 'ASC'];

        $config = [
            'limit' => 20,
            'order' => $order,
            'contain' => [],
            'conditions' => $conditions,
            'page' => !empty($page) ? $page : 1
        ];
        $payments = $this->Paginator->paginate($this->Payments->find(), $config);
        $uploadedPaymentFile = $this->UploadedPaymentFiles->find('all')->where(['id' => $uploadedFileId])->first();
        $this->set(compact('payments', 'uploadedPaymentFile'));
//        $query = $this->Payments->find('all')->where(['uploaded_payment_file_id' => $uploadedFileId])->limit(50);
//        if ($query->count() > 0) {
//            $uploadedPaymentFile = $this->UploadedPaymentFiles->find('all')->where(['id' => $uploadedFileId])->first();
//            echo json_encode(['status' => 'success', 'payments' => $query, 'file' => $uploadedPaymentFile]);
//        } else {
//            echo json_encode(['status' => 'error']);
//        }
//        exit;
    }

    public function downloadSampleExcel() {
        $filePath = WWW_ROOT . "SampleExcel.xlsx";
        $this->response->file($filePath, ['download' => TRUE, 'name' => "SampleExcel.xlsx"]);
        return $this->response;
    }

    public function downloadError($fileId) {
        $uploadedPaymentFile = $this->UploadedPaymentFiles->find('all')->where(['id' => $fileId])->first();
        $fileName = "LogFile-" . $uploadedPaymentFile->id . ".log";
        $filePath = EXCEL_ERROR_LOG . $fileName;
        $this->response->file($filePath, ['download' => TRUE, 'name' => $fileName]);
        return $this->response;
    }

    public function _sendEmail($uploadedPaymentFileId) {
        $payments = $this->Payments->find('all')->where(['uploaded_payment_file_id' => $uploadedPaymentFileId])->contain(['Users']);
        if ($payments->count() > 0) {
            $getUploadedPaymentFile = $this->UploadedPaymentFiles->find()->where(['UploadedPaymentFiles.id' => $uploadedPaymentFileId])->first();
            $getMerchant = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')])->contain(['UserDetails'])->first();
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'PAYMENT_NOTIFICATION', 'is_active' => 1])->first();
            foreach ($payments as $payment) {
                $link = HTTP_ROOT . 'customer/payments/make-payment/' . urlencode(base64_encode($payment->uniq_id));
                $directLink = HTTP_ROOT . 'customer/pay-now/' . urlencode(base64_encode($payment->uniq_id));
                $viewTransLink = HTTP_ROOT . 'customer/view-transactions/' . urlencode(base64_encode($getMerchant->uniq_id));
                $message = $this->Custom->formatEmail($mailTemplate['content'], [
                    'NAME' => $payment->name,
                    'MERCHNAT' => $getMerchant->name,
                    'NOTE' => $getUploadedPaymentFile->note,
                    'BILL_AMOUNT' => " Rs." . $payment->total_fee,
                    'DUE_DATE' => date("d M, Y", strtotime($payment->due_date)),
                    'LINK' => "<a href='{$link}'>{$link}</a>",
                    'MONTH' => date("F", strtotime($payment->due_date)),
                    'CUST_ID' => $payment->user->cust_id,
                    'DIRECT_LINK' => "<a href='{$directLink}'>{$directLink}</a>",
                    'VIEW_TRANSACTION_LINK' => "<a href='{$viewTransLink}'>{$viewTransLink}</a>",
                ]);
                $this->Custom->sendEmail($payment->email, FROM_EMAIL, $mailTemplate->subject, $message);
                $this->Payments->query()->update()->set(['followup_counter' => 'followup_counter' + 1])->where(['id' => $payment->id])->execute();
            }
        }
        return TRUE;
    }

    public function confirmUpload($uploadedFileId) {
        $this->_sendEmail($uploadedFileId);
        $this->Flash->success(__("You have exported the file successfully!!."));
        $this->UploadedPaymentFiles->query()->update()->set(['is_confirmed' => 1])->where(['id' => $uploadedFileId])->execute();
        return $this->redirect(HTTP_ROOT . "merchant/#/view-payment-files");
    }

    public function cancelUpload($uploadedFileId) {
        $entity = $this->UploadedPaymentFiles->get($uploadedFileId);
        if ($entity->merchant_id != $this->Auth->user('id')) {
            $this->Flash->error(__("Error occured. Please try again."));
            return $this->redirect($this->referer());
        }
        if ($this->UploadedPaymentFiles->delete($entity)) {
            $this->Flash->success(__("Excel file export has been canceled successfully."));
            return $this->redirect(HTTP_ROOT . "merchant/#/import-payments");
        } else {
            $this->Flash->error(__("Error occured. Please try again."));
            return $this->redirect($this->referer());
        }
        return $this->redirect($this->referer());
    }

}
