<?php

namespace App\Controller\Merchant;

use App\Controller\AppController;
use Cake\Event\Event;

class WebfrontsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');

        $this->loadModel('Payments');
        $this->loadModel('Users');
        $this->loadModel('AdminSettings');
        $this->loadModel('MailTemplates');
        $this->loadModel('WebfrontFields');
        $this->loadModel('WebfrontFieldValues');
        $this->loadModel('WebfrontPaymentAttributes');
        $this->loadModel('UploadedPaymentFiles');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('');
        $this->Auth->allow(['sendEmailInBackground']);
    }

    public function ajaxGetMerchantData() {
        $query = $this->Users->find()->contain(['MerchantProfiles'])->where(['Users.id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            $merchnat = $query->first();
            $webfront['email'] = $merchnat->email;
            $webfront['phone'] = $merchnat->merchant_profile->phone;
            $webfront['address'] = $merchnat->merchant_profile->address;
            $webfront['description'] = $merchnat->merchant_profile->description;
            echo json_encode(['status' => 'success', 'webfront' => $webfront]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxNameAvail() {
        $this->viewBuilder()->layout('ajax');
        $name = urldecode(trim($this->request->query['name']));
        $query = $this->Webfronts->find()->where(['url' => $name]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'success', 'avail' => 1]);
        } else {
            echo json_encode(['status' => 'success', 'avail' => 0]);
        }
        exit;
    }

    public function ajaxAppendRecords() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;

        $uploadedPaymentFile = $this->UploadedPaymentFiles->get($data['id']);

        $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
        if (empty($data["file"]["name"])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please select file for import.']);
        } else if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please select excel/csv file only.']);
        } else {

            $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
            $fileName = time() . "." . $ext;
            $targetFile = UPLOADED_PAYMENT_FILES . $fileName;
            move_uploaded_file($data["file"]["tmp_name"], $targetFile);

            $webfront = $this->Webfronts->find()->where(['Webfronts.id' => $uploadedPaymentFile->webfront_id])->contain(['MerchantProfiles'])->first();
            $customerFields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfront->id]);
            $paymentFields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfront->id]);

            $customerFieldCount = $customerFields->count();
            $paymentFieldCount = $paymentFields->count();
            $totalColumn = $customerFieldCount + $paymentFieldCount + 5;

            $customerFields = $customerFields->toArray();
            $paymentFields = $paymentFields->toArray();

            $inputFileName = UPLOADED_PAYMENT_FILES . $fileName;

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

            /* Header */
            $getHeading = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1, NULL, TRUE, FALSE);
            $heading = array_filter(array_map('trim', $getHeading[0]));

            $validateData = $this->_validateExcel($webfront, $fileName);

            if ($validateData['status'] == 'error') {
                echo json_encode(['status' => 'error', 'msg' => $validateData['msg']]);
                exit;
            }

            for ($row = 2; $row <= $highestRow; $row++) {

                $paymentData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];

                $name = $paymentData[0];
                $email = filter_var($paymentData[1], FILTER_SANITIZE_EMAIL);
                $phone = trim($paymentData[2]);
                $fee = $paymentData[$totalColumn - 2];
                $note = $paymentData[$totalColumn - 1];

                $query = $this->Users->find()->where(['Users.phone' => $phone, 'type' => 4]);

                if ($query->count() > 0) {
                    $user = $query->first();  //User Alreday Exist//
                } else {
                    /* Create a new User */
                    $emailExist = $this->Users->find()->where(['Users.email' => $email])->count();
                    if (!$emailExist) {
                        $user = $this->Users->newEntity();
                        $user->name = $name;
                        $user->email = $email;
                        $user->phone = $phone;
                        $user->type = 4;
                        $user->uniq_id = $this->Custom->generateUniqNumber();
                        $user->is_active = 1;
                        $user = $this->Users->save($user);
                    }
                }

                if (!empty($user->id)) {

//                    $count = $this->Payments->find()->where(['uploaded_payment_file_id' => $uploadedPaymentFile->id, 'OR' => [['phone' => $phone], ['email' => $email]]])->count();
//
//                    if (!$count) {

                    $payment = $this->Payments->newEntity();

                    $getPayment = $this->Payments->find()->where(['uploaded_payment_file_id' => $uploadedPaymentFile->id, 'status' => 0, 'phone' => $phone, 'email' => $email]);
                    if ($getPayment->count()) {
                        $payment->id = $getPayment->select(['id'])->first()->id;
                    } else {
                        $count = $this->Payments->find()->where(['uploaded_payment_file_id' => $uploadedPaymentFile->id, 'OR' => [['phone' => $phone], ['email' => $email]]])->count();
                        if ($count) {
                            continue;
                        }
                    }


                    $payment->uniq_id = $this->Custom->generateUniqId();
                    $payment->webfront_id = $uploadedPaymentFile->webfront_id;
                    $payment->uploaded_payment_file_id = $uploadedPaymentFile->id;
                    $payment->customer_id = $user->id;
                    $payment->name = $name;
                    $payment->email = $email;
                    $payment->phone = $phone;
                    $payment->note = $note;

                    if ($customerFieldCount) {
                        $customerFieldValues = [];
                        $i = 1;
                        foreach ($customerFields as $customerField) {
                            $customerFieldValues[$customerField->id]['field'] = $customerField->name;
                            $customerFieldValues[$customerField->id]['value'] = $paymentData[2 + $i];
                            $i++;
                        }
                        $payment->payee_custom_fields = json_encode($customerFieldValues);
                    }
                    if ($paymentFieldCount) {
                        $paymentFieldValues = [];
                        $i = 1;
                        foreach ($paymentFields as $paymentField) {
                            $paymentFieldValues[$paymentField->id]['field'] = $paymentField->name;
                            $paymentFieldValues[$paymentField->id]['value'] = $paymentData[2 + $customerFieldCount + $i];
                            $i++;
                        }
                        $payment->payment_custom_fields = json_encode($paymentFieldValues);
                    }
                    $payment->late_fee_amount = $webfront->late_fee_amount;
                    $payment->convenience_fee_amount = !empty($webfront->merchant_profile->convenience_fee_amount) ? $webfront->merchant_profile->convenience_fee_amount : 0;
                    $payment->fee = $fee;
                    $payment->created = date('Y-m-d H:i:s');
                    $payment->modified = date('Y-m-d H:i:s');
                    $this->Payments->save($payment);
//                    }
                }
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
        }
        exit;
    }

    public function ajaxImportPayments() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;
        $id = $data['id'];

        $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
        if (empty($data["file"]["name"])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please select file for import.']);
        } else if (!in_array($ext, ['xls', 'xlsx', 'csv'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please select excel/csv file only.']);
        } else {

            $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
            $fileName = time() . "." . $ext;
            $targetFile = UPLOADED_PAYMENT_FILES . $fileName;
            move_uploaded_file($data["file"]["tmp_name"], $targetFile);

            $webfront = $this->Webfronts->find()->where(['Webfronts.id' => $id])->contain(['MerchantProfiles'])->first();
            $customerFields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfront->id]);
            $paymentFields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfront->id]);

            $customerFieldCount = $customerFields->count();
            $paymentFieldCount = $paymentFields->count();
            $totalColumn = $customerFieldCount + $paymentFieldCount + 5;

            $customerFields = $customerFields->toArray();
            $paymentFields = $paymentFields->toArray();

            $inputFileName = UPLOADED_PAYMENT_FILES . $fileName;

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
            $heading = array_filter(array_map('trim', $getHeading[0]));


            $validateData = $this->_validateExcel($webfront, $fileName);

            if ($validateData['status'] == 'error') {
                echo json_encode(['status' => 'error', 'msg' => $validateData['msg']]);
                exit;
            }

            $uploadedPaymentFile = $this->UploadedPaymentFiles->newEntity();
            $uploadedPaymentFile->webfront_id = $webfront->id;
            $uploadedPaymentFile->payment_cycle_date = $data['payment_cycle_date'];
            $uploadedPaymentFile->file = $fileName;

            if ($this->UploadedPaymentFiles->save($uploadedPaymentFile)) {

                for ($row = 2; $row <= $highestRow; $row++) {

                    $paymentData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];

                    $name = $paymentData[0];
                    $email = filter_var($paymentData[1], FILTER_SANITIZE_EMAIL);
                    $phone = trim($paymentData[2]);
                    $fee = $paymentData[$totalColumn - 2];
                    $note = $paymentData[$totalColumn - 1];

                    $query = $this->Users->find()->where(['Users.phone' => $phone, 'type' => 4]);

                    if ($query->count() > 0) {
                        $user = $query->first();  //User Alreday Exist//
                    } else {
                        //Create a new User//
                        $emailExist = $this->Users->find()->where(['Users.email' => $email])->count();
                        if (!$emailExist) {
                            $user = $this->Users->newEntity();
                            $user->name = $name;
                            $user->email = $email;
                            $user->phone = $phone;
                            $user->type = 4;
                            $user->uniq_id = $this->Custom->generateUniqNumber();
                            $user->is_active = 1;
                            $user = $this->Users->save($user);
                        }
                    }

                    if (!empty($user->id)) {

//                        $count = $this->Payments->find()->where(['uploaded_payment_file_id' => $uploadedPaymentFile->id, 'OR' => [['phone' => $phone], ['email' => $email]]])->count();
//                        if (!$count) {

                        $payment = $this->Payments->newEntity();
                        $payment->uniq_id = $this->Custom->generateUniqId();
                        $payment->webfront_id = $uploadedPaymentFile->webfront_id;
                        $payment->uploaded_payment_file_id = $uploadedPaymentFile->id;
                        $payment->customer_id = $user->id;
                        $payment->name = $name;
                        $payment->email = $email;
                        $payment->phone = $phone;
                        $payment->note = $note;

                        if ($customerFieldCount) {
                            $customerFieldValues = [];
                            $i = 1;
                            foreach ($customerFields as $customerField) {
                                $customerFieldValues[$customerField->id]['field'] = $customerField->name;
                                $customerFieldValues[$customerField->id]['value'] = $paymentData[2 + $i];
                                $i++;
                            }
                            $payment->payee_custom_fields = json_encode($customerFieldValues);
                        }

                        if ($paymentFieldCount) {
                            $paymentFieldValues = [];
                            $i = 1;
                            foreach ($paymentFields as $paymentField) {
                                $paymentFieldValues[$paymentField->id]['field'] = $paymentField->name;
                                $paymentFieldValues[$paymentField->id]['value'] = $paymentData[2 + $customerFieldCount + $i];
                                $i++;
                            }
                            $payment->payment_custom_fields = json_encode($paymentFieldValues);
                        }

                        $payment->late_fee_amount = $webfront->late_fee_amount;
                        $payment->convenience_fee_amount = !empty($webfront->merchant_profile->convenience_fee_amount) ? $webfront->merchant_profile->convenience_fee_amount : 0;
                        $payment->fee = $fee;
                        $payment->created = date('Y-m-d H:i:s');
                        $payment->modified = date('Y-m-d H:i:s');
                        $this->Payments->save($payment);
                        //}
                    }
                }
            }

            $url = HTTP_ROOT . "merchant/webfronts/sendEmailInBackground/{$uploadedPaymentFile->id}";
            $request = new \cURL\Request($url);
            $request->getOptions()
                    ->set(CURLOPT_TIMEOUT, 5)
                    ->set(CURLOPT_RETURNTRANSFER, true);
            while ($request->socketPerform()) {
                $request->socketSelect();
            }
            echo json_encode(['status' => 'success', 'msg' => 'Imported Successfully!!']);
            exit;
        }
        echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try again!!']);
        exit;
    }

    public function sendEmailInBackground($id = NULL) {
        $this->viewBuilder()->layout('');
        $paymentShell = new \App\Shell\PaymentShell;
        $paymentShell->sendEmailInBackground($id);
        exit;
    }

    function _hasDuplicatedValues($objPHPExcel, $column = 'A', $ignoreEmptyCells = false) {
        $worksheet = $objPHPExcel->getActiveSheet();
        $cells = array();
        foreach ($worksheet->getRowIterator() as $row) {
            $cell = $worksheet->getCell($column . $row->getRowIndex())->getValue();
            if (($ignoreEmptyCells == false) | (empty($cell) == false)) {
                $cells[] = $cell;
            }
        }
        if (count(array_unique($cells)) < count($cells)) {
            unset($cells);
            unset($cell);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _validateExcel($webfront = NULL, $fileName = NULL, $errorFileName = NULL) {

        $errorFound = FALSE;

        $errorFileName = "ErrorLog-{$webfront->id}.log";

        $logFile = fopen(UPLOAD_ERROR_LOG . $errorFileName, "w") or die("Unable to open file!");

        $inputFileName = UPLOADED_PAYMENT_FILES . $fileName;

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

        $customFieldCount = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfront->id])->count();
        $paymentFieldCount = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfront->id])->count();
        $totalColumn = $customFieldCount + $paymentFieldCount + 5;


        //Header//
        $getHeading = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1, NULL, TRUE, FALSE);
        $heading = array_filter(array_map('trim', $getHeading[0]));

        if ($totalColumn != count($heading)) {
            $txt = "Invalid Excel File. Colums does't matches!! \n";
            fwrite($logFile, $txt);
            fclose($logFile); //Close Log file
            return ['status' => 'error', 'msg' => $txt];
            exit;
        }

        if ($this->_hasDuplicatedValues($objPHPExcel, 'B')) {
            $txt = "File contains duplicate entry for Email \n";
            fwrite($logFile, $txt);
            fclose($logFile); //Close Log file
            return ['status' => 'error', 'msg' => $txt];
            exit;
        }

        if ($this->_hasDuplicatedValues($objPHPExcel, 'C')) {
            $txt = "File contains duplicate entry for Phone No. \n";
            fwrite($logFile, $txt);
            fclose($logFile); //Close Log file
            return ['status' => 'error', 'msg' => $txt];
            exit;
        }

        for ($row = 2; $row <= $highestRow; $row++) {

            $paymentData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];

            $name = $paymentData[0];
            $email = filter_var($paymentData[1], FILTER_SANITIZE_EMAIL);
            $phone = trim($paymentData[2]);
            $fee = $paymentData[$totalColumn - 2];
            $note = $paymentData[$totalColumn - 1];

            /* Validation Start */
            $isValid = TRUE;
            if ($name == "") {
                $txt = "Name is empty at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $txt = "Invalid email at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }
            if ($email == "") {
                $txt = "Email is empty at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }

            if ($phone == "") {
                $txt = "Phone No. is empty at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }
            if (strlen($phone) != 10) {
                $txt = "Phone No. must be of 10 digit at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }
            if (!ctype_digit($phone)) {
                $txt = "Invalid Phone No.  at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }

            if ($fee <= 0) {
                $txt = "Bill amount must be greater than 0 at row {$row}  \n";
                fwrite($logFile, $txt);
                $errorFound = TRUE;
            }
        }

        fclose($logFile); //Close Log file

        if ($errorFound) {
            $msg = "Excel file contain error. Please <a target='_blank' href='merchant/payments/download-error/" . $webfront->id . "'>Click here</a> to view it.";
            return ['status' => 'error', 'msg' => $msg];
        } else {
            return ['status' => 'success'];
        }
    }  

    public function downloadSampleExcel($id = NULL) {
        $query = $this->Webfronts->find()->where(['id' => $id]);
        if ($query->count() > 0) {

            $webfront = $query->first();
            $customerFields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfront->id]);
            $paymentFields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfront->id]);

            $totalColumn = $customerFields->count() + $paymentFields->count() + 5;

            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $style = [
                'alignment' => [
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ]
            ];
            $objPHPExcel->getActiveSheet()->getStyle("A1:Z1")->applyFromArray($style);
            $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getFont()->setBold(true);
            $head = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            $count = 0;
            foreach (range('A', $head[$totalColumn - 1]) as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
//SetHeading//   
            $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $webfront->customer_name_alias);
            $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $webfront->customer_email_alias);
            $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $webfront->customer_phone_alias);
            if ($customerFields->count() > 0) {
                foreach ($customerFields as $customerField) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $customerField->name);
                }
            }
            if ($paymentFields->count() > 0) {
                foreach ($paymentFields as $paymentField) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $paymentField->name);
                }
            }
            $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $webfront->total_amount_alias);
            $objPHPExcel->getActiveSheet()->SetCellValue($head[$count++] . '1', $webfront->customer_note_alias);
            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
            $fileName = "SampleExcel-" . time() . '.xlsx';
            $filePath = "files/sample-excel/$fileName";
            $objWriter->save($filePath);
            $this->response->file($filePath, ['download' => TRUE, 'name' => $fileName]);
            return $this->response;
        } else {
            return $this->redirect($this->referer());
        }
        exit;
    }

    public function create() {
        $data = $this->request->data;
        $url = trim($data['webfront']['url']);
        $query = $this->Webfronts->find()->where(['Webfronts.url' => $url]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Name Not Available!!']);
            exit;
        }
        $webfront = $this->Webfronts->newEntity();
        $webfront = $this->Webfronts->patchEntity($webfront, $data['webfront']);
        $webfront->merchant_id = $this->Auth->user('id');
        $webfront->url = $url;
        if ($this->Webfronts->save($webfront)) {
            if (!empty($data['croppedImage'])) {
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($imageData) {
                    $logo = time() . rand(100, 999) . '.png';
                    if (file_put_contents(WEBFRONT_LOGO . $logo, $imageData)) {
                        $this->Webfronts->query()->update()->set(['logo' => $logo])->where(['id' => $webfront->id])->execute();
                    }
                }
            }
            echo json_encode(['status' => 'success', 'webfront' => $webfront]);
            exit;
        }
        echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try again!!']);
        exit;
    }

    public function edit() {
        $data = $this->request->data;
        $webfrontId = $data['webfront']['id'];
        unset($data['webfront']['webfront_fields']);
        unset($data['webfront']['created']);
        unset($data['webfront']['modified']);
        $webfront = $this->Webfronts->newEntity();
        $webfront = $this->Webfronts->patchEntity($webfront, $data['webfront']);
        $webfront->merchant_id = $this->Auth->user('id');
        $webfront->id = $webfrontId;
        if ($this->Webfronts->save($webfront)) {
            if (!empty($data['croppedImage'])) {
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($imageData) {
                    /* Upload New  Logo */
                    $logo = time() . rand(100, 999) . '.png';
                    if (file_put_contents(WEBFRONT_LOGO . $logo, $imageData)) {
                        /* Delete Old Logo */
                        if (!empty($webfront->logo) && is_file(WEBFRONT_LOGO . $webfront->logo) && file_exists(WEBFRONT_LOGO . $webfront->logo)) {
                            unlink(WEBFRONT_LOGO . $webfront->logo);
                        }
                        $this->Webfronts->query()->update()->set(['logo' => $logo])->where(['id' => $webfront->id])->execute();
                    }
                }
            }
            $webfront = $this->Webfronts->get($webfrontId);
            echo json_encode(['status' => 'success', 'webfront' => $webfront]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxGetDetails($webfrontId) {
        $query = $this->Webfronts->find()->where(['Webfronts.id' => $webfrontId, 'Webfronts.merchant_id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            $webfront = $query->first();
            $webfront->customer_fields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfrontId]);
            $webfront->payment_fields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfrontId]);
            $webfront->payment_cycle_date = date('Y-m-d', strtotime($webfront->payment_cycle_date));
            echo json_encode(['status' => 'success', 'webfront' => $webfront]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxMyBasicWebfronts() {
        $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id'), 'Webfronts.type' => 0, 'Webfronts.is_deleted' => 0]);
        if ($webfronts->count() > 0) {
            echo json_encode(['status' => 'success', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxMyWebfronts() {
        $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id'), 'Webfronts.is_deleted' => 0]);
        if ($webfronts->count() > 0) {
            echo json_encode(['status' => 'success', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $webfront = $this->Webfronts->get($id);
        if ($webfront->merchant_id != $this->Auth->user('id')) {
            echo json_encode(['status' => 'error', 'msg' => 'UnAthorized Access']);
            exit;
        }
        $webfront->is_deleted = 1;
        if ($this->Webfronts->save($webfront)) {
            echo json_encode(['status' => 'success', 'msg' => 'The webfront has been deleted.']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The webfront could not be deleted. Please, try again.']);
        }
        exit;
    }

    public function publish($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Webfronts->query()->update()->set(['is_published' => 1])->where(['id' => $id])->execute();
        if ($status) {
            $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id')]);
            echo json_encode(['status' => 'success', 'msg' => 'The webfront published successfully.', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The webfront could not be published. Please, try again.']);
        }
        exit;
    }

    public function unpublish($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Webfronts->query()->update()->set(['is_published' => 0])->where(['id' => $id])->execute();
        if ($status) {
            $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id')]);
            echo json_encode(['status' => 'success', 'msg' => 'The webfront unpublished successfully.', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The webfront could not be unpublished. Please, try again.']);
        }
        exit;
    }

    public function ajaxUpdatePayeeFields() {
        $data = $this->request->data;

        $fields['customer_name_alias'] = !empty($data['webfront']['customer_name_alias']) ? $data['webfront']['customer_name_alias'] : 'Name';
        $fields['customer_email_alias'] = !empty($data['webfront']['customer_email_alias']) ? $data['webfront']['customer_email_alias'] : 'Email';
        $fields['customer_phone_alias'] = !empty($data['webfront']['customer_phone_alias']) ? $data['webfront']['customer_phone_alias'] : 'Phone';
        $fields['customer_note_alias'] = !empty($data['webfront']['customer_note_alias']) ? $data['webfront']['customer_note_alias'] : 'Note';

        $webfrontId = $data['webfront']['id'];
        $status = $this->Webfronts->query()->update()->set($fields)->where(['id' => $data['webfront']['id']])->execute();
        $this->WebfrontFields->deleteAll(['webfront_id' => $webfrontId]);

        for ($i = 1; $i <= 10; $i++) {
            if (!empty($data["customer_fields"]["ca{$i}"])) {
                $webfrontField = $this->WebfrontFields->newEntity();
                $webfrontField->id = 0;
                $webfrontField->webfront_id = $data['webfront']['id'];
                $webfrontField->name = $data["customer_fields"]["ca{$i}"];
                $webfrontField->is_mandatory = 1;
                $this->WebfrontFields->save($webfrontField);
            }
        }

        $webfront = $this->Webfronts->get($webfrontId);
        $webfront->customer_fields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfrontId]);
        $webfront->payment_fields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfrontId]);
        $webfront->payment_cycle_date = date('Y-m-d', strtotime($webfront->payment_cycle_date));

        echo json_encode(['status' => 'success', 'webfront' => $webfront]);
        exit;
    }

    public function ajaxUpdatePaymentFields() {
        $data = $this->request->data;

        $webfrontId = $data['webfront']['id'];
        $fields['total_amount_alias'] = !empty($data['webfront']['total_amount_alias']) ? $data['webfront']['total_amount_alias'] : 'Total Amount';
        $status = $this->Webfronts->query()->update()->set($fields)->where(['id' => $webfrontId])->execute();

        $this->WebfrontPaymentAttributes->deleteAll(['WebfrontPaymentAttributes.webfront_id' => $webfrontId]);

        for ($i = 1; $i <= 10; $i++) {
            if (!empty($data["payment_fields"]["pa{$i}"])) {
                $webfrontPaymentAttribute = $this->WebfrontPaymentAttributes->newEntity();
                $webfrontPaymentAttribute->id = 0;
                $webfrontPaymentAttribute->webfront_id = $webfrontId;
                $webfrontPaymentAttribute->name = $data["payment_fields"]["pa{$i}"];
                $this->WebfrontPaymentAttributes->save($webfrontPaymentAttribute);
            }
        }
        $webfront = $this->Webfronts->get($webfrontId);
        $webfront->customer_fields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfrontId]);
        $webfront->payment_fields = $this->WebfrontPaymentAttributes->find('all')->where(['webfront_id' => $webfrontId]);

        echo json_encode(['status' => 'success', 'webfront' => $webfront]);
        exit;
    }

//**************************Advance Webfront Section Coding Starts by Prakash*************************************
    public function createAdvanceWebfront() {
        $data = $this->request->data;
        $url = trim($data['webfront']['url']);
        $query = $this->Webfronts->find()->where(['Webfronts.url' => $url]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Name not available!!']);
            exit;
        }
        $webfront = $this->Webfronts->newEntity();
        $webfront = $this->Webfronts->patchEntity($webfront, $data['webfront']);
        $webfront->merchant_id = $this->Auth->user('id');
        $webfront->url = $url;
        $webfront->type = 1;
        if ($this->Webfronts->save($webfront)) {
            if (!empty($data['croppedImage'])) {
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
                if ($imageData) {
                    $logo = time() . rand(100, 999) . '.png';
                    if (file_put_contents(WEBFRONT_LOGO . $logo, $imageData)) {
                        $this->Webfronts->query()->update()->set(['logo' => $logo])->where(['id' => $webfront->id])->execute();
                    }
                }
            }
            echo json_encode(['status' => 'success', 'webfront' => $webfront]);
            exit;
        }
        echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try again!!']);
        exit;
    }

    public function ajaxMyAdvanceWebfronts() {
        $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id'), 'Webfronts.type' => 1, 'Webfronts.is_deleted' => 0]);
        if ($webfronts->count() > 0) {
            echo json_encode(['status' => 'success', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function publishAdvanceWebfront($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Webfronts->query()->update()->set(['is_published' => 1])->where(['id' => $id])->execute();
        if ($status) {
            $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id'), 'Webfronts.type' => 1]);
            echo json_encode(['status' => 'success', 'msg' => 'The webfront published successfully.', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The webfront could not be published. Please, try again.']);
        }
        exit;
    }

    public function unPublishAdvanceWebfront($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $status = $this->Webfronts->query()->update()->set(['is_published' => 0])->where(['id' => $id])->execute();
        if ($status) {
            $webfronts = $this->Webfronts->find('all')->where(['Webfronts.merchant_id' => $this->Auth->user('id'), 'Webfronts.type' => 1]);
            echo json_encode(['status' => 'success', 'msg' => 'The webfront unpublished successfully.', 'webfronts' => $webfronts]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The webfront could not be unpublished. Please, try again.']);
        }
        exit;
    }

    public function ajaxAdvanceGetDetails($id) {
        $query = $this->Webfronts->find()->where(['Webfronts.id' => $id, 'Webfronts.merchant_id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {

            $webfront = $query->first();
            $webfront->customer_fields = $this->WebfrontFields->find('all')->where(['WebfrontFields.webfront_id' => $webfront->id])->contain(['WebfrontFieldValues'])->toArray();
            $webfront_payment_attributes = $this->WebfrontPaymentAttributes->find('all')->where(['WebfrontPaymentAttributes.webfront_id' => $webfront->id])->order(['WebfrontPaymentAttributes.id' => 'DESC'])->toArray();
            $query = $this->WebfrontPaymentAttributes->find();
            $total_amount = $query->select([ 'total_price' => $query->func()->sum('value')])->where(['webfront_id' => $webfront->id])->toArray();

            $webfront->payment_cycle_date = date('Y-m-d', strtotime($webfront->payment_cycle_date));
            foreach ($webfront->customer_fields as $key => $value) {
                $webfront->customer_fields[$key]['customer_checkbox'] = true;
            }
            echo json_encode(['status' => 'success', 'webfront' => $webfront, 'webfront_payment_attributes' => $webfront_payment_attributes, 'total_amount' => $total_amount[0]['total_price']]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxUpdateCustomerFieldsAdvance() {
        $data = $this->request->data;
        $fields['customer_name_alias'] = !empty($data['webfront']['customer_name_alias']) ? $data['webfront']['customer_name_alias'] : 'Name';
        $fields['customer_email_alias'] = !empty($data['webfront']['customer_email_alias']) ? $data['webfront']['customer_email_alias'] : 'Email';
        $fields['customer_phone_alias'] = !empty($data['webfront']['customer_phone_alias']) ? $data['webfront']['customer_phone_alias'] : 'Phone';

        $webfrontId = $data['webfront']['id'];
        $status = $this->Webfronts->query()->update()->set($fields)->where(['id' => $data['webfront']['id']])->execute();

//For deleting the webfront field values starts
        $webfrontFieldsValues = $this->WebfrontFields->find()->where(['WebfrontFields.webfront_id' => $data['webfront']['id']])->contain(['WebfrontFieldValues']);
        foreach ($webfrontFieldsValues as $webfrontFieldsValue) {
            foreach ($webfrontFieldsValue->webfront_field_values as $webfrontFieldValue) {
                $this->WebfrontFieldValues->deleteAll(['WebfrontFieldValues.id' => $webfrontFieldValue->id]);
            }
        }
//For deleting the webfront field values ends

        $this->WebfrontFields->deleteAll(['WebfrontFields.webfront_id' => $data['webfront']['id']]);
        $payeeCustomFields = count($data['webfront']['customer_fields']);

        if (!empty($payeeCustomFields)) {
            if (!empty($data['webfront']['customer_fields'])) {
                foreach ($data['webfront']['customer_fields'] as $key => $value) { //pj($key);               
                    if (!empty($value['name']) || (!empty($value['customer_checkbox']) && $value['customer_checkbox'] == true)) {
                        $webfrontField = $this->WebfrontFields->newEntity();
                        $webfrontField->webfront_id = $data['webfront']['id'];
                        $CA_key = $key + 1;
                        $webfrontField->name = !empty($value['name']) ? $value['name'] : "CA{$CA_key}";
                        $webfrontField->input_type = !empty($value['input_type']) ? $value['input_type'] : 0;
                        $webfrontField->validation_id = !empty($value['validation_id']) ? $value['validation_id'] : 1;
                        $webfrontField->is_mandatory = 1;
                        $this->WebfrontFields->save($webfrontField);
//For add time code stars here\\
                        if (!empty($data['customer_choices'][$key])) {
                            foreach ($data['customer_choices'][$key] as $choice) { //pj($choice['value']);                               
                                if (!empty($choice['value'])) {
                                    $saveWebfrontFieldValue = $this->WebfrontFieldValues->newEntity();
                                    $saveWebfrontFieldValue->webfront_field_id = $webfrontField->id;
                                    $saveWebfrontFieldValue->value = $choice['value'];
                                    $this->WebfrontFieldValues->save($saveWebfrontFieldValue);
                                }
                            }
                        }
// for add time code ends here
//For edit time code starts here\\
                        if (!empty($value['webfront_field_values'])) {
                            foreach ($value['webfront_field_values'] as $webfrontFieldValue) {
                                if (!empty($webfrontFieldValue['id'])) {
                                    $this->WebfrontFieldValues->deleteAll(['WebfrontFieldValues.id' => $webfrontFieldValue['id']]);
                                }
                                if (!empty($webfrontFieldValue['value'])) {
                                    $saveWebfrontFieldValue = $this->WebfrontFieldValues->newEntity();
                                    $saveWebfrontFieldValue->webfront_field_id = $webfrontField->id;
                                    $saveWebfrontFieldValue->value = !empty($webfrontFieldValue['value']) ? $webfrontFieldValue['value'] : '';
                                    $this->WebfrontFieldValues->save($saveWebfrontFieldValue);
                                }
                            }
                        }
//For edit time code ends here\\
                    }
                }
            }
        }

        $webfront = $this->Webfronts->get($webfrontId);
        $webfront->customer_fields = $this->WebfrontFields->find('all')->where(['webfront_id' => $webfront->id])->contain(['WebfrontFieldValues'])->toArray();
        $webfront->payment_cycle_date = date('Y-m-d', strtotime($webfront->payment_cycle_date));
        foreach ($webfront->customer_fields as $key => $value) {
            $webfront->customer_fields[$key]['customer_checkbox'] = true;
        }
        echo json_encode(['status' => 'success', 'webfront' => $webfront]);
        exit;
    }

    public function removeWebfrontFieldValues($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $webfrontFieldValue = $this->WebfrontFieldValues->get($id);
        $this->WebfrontFieldValues->delete($webfrontFieldValue);
        exit;
    }

    /* Payment attribute section starts here */

    public function ajaxAddPaymentAttribute() {
        $data = $this->request->data;
        $webfrontPaymentAttribute = $this->WebfrontPaymentAttributes->newEntity();
        $webfrontPaymentAttribute->webfront_id = $data['webfront_id'];
        $webfrontPaymentAttribute->name = $data['paymentAttributeData']['name'];
        $webfrontPaymentAttribute->is_required = (!empty($data['paymentAttributeData']['isRequired']) && $data['paymentAttributeData']['isRequired'] == 'true') ? 1 : 0;
        $webfrontPaymentAttribute->is_user_entered = (!empty($data['paymentAttributeData']['isUserEntered']) && $data['paymentAttributeData']['isUserEntered'] == 'true') ? 1 : 0;
        $webfrontPaymentAttribute->value = (!empty($data['paymentAttributeData']['value']) && !empty($data['paymentAttributeData']['isUserEntered'])) ? $data['paymentAttributeData']['value'] : 0;

        if ($this->WebfrontPaymentAttributes->save($webfrontPaymentAttribute)) {
            $webfront_payment_attributes = $this->WebfrontPaymentAttributes->find('all')->where(['WebfrontPaymentAttributes.webfront_id' => $data['webfront_id']])->order(['WebfrontPaymentAttributes.id' => 'DESC'])->toArray();
            $query = $this->WebfrontPaymentAttributes->find();
            $total_amount = $query->select([ 'total_price' => $query->func()->sum('value')])->where(['webfront_id' => $data['webfront_id']])->toArray();
            echo json_encode(['status' => 'success', 'webfront_payment_attributes' => $webfront_payment_attributes, 'total_amount' => $total_amount[0]['total_price']]);
            exit;
        }
        echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try again!!']);
        exit;
    }

    public function ajaxUpdatePaymentAttribute() {
        $data = $this->request->data;
        $webfrontPaymentAttribute = $this->WebfrontPaymentAttributes->newEntity();
        $webfrontPaymentAttribute->id = $data['payment_attribute']['id'];
        $webfrontPaymentAttribute->webfront_id = $data['payment_attribute']['webfront_id'];
        $webfrontPaymentAttribute->name = $data['payment_attribute']['name'];
        $webfrontPaymentAttribute->is_required = (!empty($data['payment_attribute']['is_required']) && $data['payment_attribute']['is_required'] == 'true') ? 1 : 0;
        $webfrontPaymentAttribute->is_user_entered = (!empty($data['payment_attribute']['is_user_entered']) && $data['payment_attribute']['is_user_entered'] == 1) ? 1 : 0;
        $webfrontPaymentAttribute->value = (!empty($data['payment_attribute']['value']) && !empty($data['payment_attribute']['is_user_entered'])) ? $data['payment_attribute']['value'] : 0;

        if ($this->WebfrontPaymentAttributes->save($webfrontPaymentAttribute)) {
            $webfront_payment_attributes = $this->WebfrontPaymentAttributes->find('all')->where(['WebfrontPaymentAttributes.webfront_id' => $data['payment_attribute']['webfront_id']])->order(['WebfrontPaymentAttributes.id' => 'DESC'])->toArray();
            $query = $this->WebfrontPaymentAttributes->find();
            $total_amount = $query->select([ 'total_price' => $query->func()->sum('value')])->where(['webfront_id' => $data['payment_attribute']['webfront_id']])->toArray();
            echo json_encode(['status' => 'success', 'webfront_payment_attributes' => $webfront_payment_attributes, 'total_amount' => $total_amount[0]['total_price']]);
            exit;
        }
        echo json_encode(['status' => 'error', 'msg' => 'Some error occured. Please try again!!']);
        exit;
    }

    public function ajaxDeletePaymentAttribute($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $webfrontPaymentAttribute = $this->WebfrontPaymentAttributes->get($id);
        if (empty($webfrontPaymentAttribute)) {
            echo json_encode(['status' => 'error', 'msg' => 'This payment attribute is not present']);
            exit;
        }
        if ($this->WebfrontPaymentAttributes->delete($webfrontPaymentAttribute)) {
            $webfront_payment_attributes = $this->WebfrontPaymentAttributes->find('all')->where(['WebfrontPaymentAttributes.webfront_id' => $webfrontPaymentAttribute->webfront_id])->order(['WebfrontPaymentAttributes.id' => 'DESC'])->toArray();
            $query = $this->WebfrontPaymentAttributes->find();
            $total_amount = $query->select([
                        'total_price' => $query->func()->sum('value')
                    ])->where(['webfront_id' => $webfrontPaymentAttribute->webfront_id])->toArray();
            echo json_encode(['status' => 'success', 'msg' => 'The webfront has been deleted.', 'webfront_payment_attributes' => $webfront_payment_attributes, 'total_amount' => $total_amount[0]['total_price']]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'The webfront could not be deleted. Please, try again.']);
        }
        exit;
    }

//Payment attribute section ends here
//**************************Advance Webfront Section Coding Ends***************************************
}
