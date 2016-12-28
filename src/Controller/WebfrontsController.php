<?php

namespace App\Controller;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class WebfrontsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Webfronts');
        $this->loadModel('Users');
        $this->loadModel('Payments');
        $this->loadModel('WebfrontFields');
        $this->loadModel('WebfrontPaymentAttributes');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $beforeLoginActions = ['basic', 'advance', 'payNow'];
        $this->Auth->allow($beforeLoginActions);
    }

    public function basic($url = NUll) {
        $this->viewBuilder()->layout('default');
        $query = $this->Webfronts->find()->where(['url' => $url]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }

        $webfront = $query->contain(['Users', 'Users.MerchantProfiles'])->first();

        if ($this->request->is('post')) {
            $phone = trim($this->request->data['phone']);

            $conditions = ['Payments.phone' => $phone, 'Payments.status' => '0', 'Payments.webfront_id' => $webfront->id];
            $payments = $this->Payments->find('all')->where($conditions);

            if ($payments->count() == 1) {
                return $this->redirect(HTTP_ROOT . "customer/payments/pay-now/" . $payments->first()->uniq_id);
            } else {

                $conditions = ['Payments.phone' => $phone, 'Payments.webfront_id' => $webfront->id];
                $payments = $this->Payments->find('all')->where($conditions)->contain(['UploadedPaymentFiles'])->order(['Payments.id' => 'DESC']);

                if ($payments->count() > 0) {
                    $this->set(compact('payments'));
                } else {
                    $phoneExist = $this->Users->find('all')->where(['phone' => $phone])->count();
                    if ($phoneExist) {
                        $error = "No record found for the phone no \"<b>{$phone}</b>\"";
                    } else {
                        $error = "This phone no \"<b>{$phone}</b>\" is not registered";
                    }
                    $this->set(compact('error'));
                }
            }
        }
        $this->set(compact('webfront'));
    }

    public function payment($url = NUll) {
        $this->viewBuilder()->layout('default');
        $query = $this->Webfronts->find()->where(['url' => $url]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $webfront = $query->first();
        $this->set(compact('webfront'));
    }

    public function advance($url = NUll) {
        $this->viewBuilder()->layout('default');
        $query = $this->Webfronts->find()->where(['url' => $url]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $webfront = $query->contain(['Users', 'Users.MerchantProfiles'])->first();
        $this->set(compact('webfront'));
    }

    public function payNow($url = NUll) {
        $this->viewBuilder()->layout('default');
        $query = $this->Webfronts->find()->where(['url' => $url]);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }
        $webfront = $query->contain(['Users'])->first();
        $webfront->payee_custom_fields = $this->WebfrontFields->find()->where(['WebfrontFields.webfront_id' => $webfront->id])->contain(['WebfrontFieldValues', 'Validations'])->order(['WebfrontFields.id' => 'ASC']);
        $webfront_payment_attributes = $this->WebfrontPaymentAttributes->find()->where(['WebfrontPaymentAttributes.webfront_id' => $webfront->id])->order(['WebfrontPaymentAttributes.id' => 'DESC']);
        $query = $this->WebfrontPaymentAttributes->find();
        $total_amount = $query->select(['total_price' => $query->func()->sum('value')])->where(['webfront_id' => $webfront->id])->toArray();
        $this->set(compact('webfront', 'webfront_payment_attributes', 'total_amount'));
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $webfront = $this->Webfronts->find()->where(['url' => $url])->first();
            $chkUsers = $this->Users->find()->where(['phone' => $data['phone']]);

            if ($chkUsers->count() > 0) {
                $user = $chkUsers->first();
            } else {
                $user = $this->Users->newEntity();
                $user->uniq_id = md5(uniqid(rand()) . time());
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->phone = $data['phone'];
                $user->created_by = $this->Auth->user('id');
                $user->is_active = 1;
                $user->type = 4;
                $this->Users->save($user);
            }

            $payment = $this->Payments->newEntity();
            $payment->uniq_id = md5(uniqid(rand()) . time());
            $payment->webfront_id = $webfront->id;
            $payment->customer_id = $user->id;
            $payment->name = $user->name;
            $payment->email = $user->email;
            $payment->phone = $user->phone;
            $payment->convenience_fee_amount = 0;
            $payment->fee = $data['paid_amount'];
            $payment->paid_amount = $data['paid_amount'];
            $payment->payment_date = date("Y-m-d");

            $customerFields = $this->WebfrontFields->find('all')->where(['WebfrontFields.webfront_id' => $webfront->id]);
            $paymentFields = $this->WebfrontPaymentAttributes->find('all')->where(['WebfrontPaymentAttributes.webfront_id' => $webfront->id])->order(['WebfrontPaymentAttributes.id' => 'DESC']);

            $customerFieldCount = $customerFields->count();

            if ($customerFieldCount) {
                $customerFieldValues = [];
                $i = 0;
                foreach ($customerFields as $customerField) {
                    foreach ($data['payee_custom_fields'] as $payeeCustomFields) {
                        $paymentData[] = $payeeCustomFields;
                    }
                    $customerFieldValues[$customerField->id]['field'] = $customerField->name;
                    $customerFieldValues[$customerField->id]['value'] = $paymentData[$i];
                    $i++;
                }

                $payment->payee_custom_fields = json_encode($customerFieldValues);
            }

            if ($paymentFields->count() > 0) {
                foreach ($paymentFields as $paymentField) {
                    $paymentFieldKeyNames[] = $paymentField->id;
                    $paymentFieldValueNames[] = $paymentField->name;
                    $combinePaymenFieldtData = array_combine($paymentFieldKeyNames, $paymentFieldValueNames);
                }

                foreach ($data['payment_custom_fields'] as $key => $value) {
                    $paymentValueKeyNames[] = $key;
                    $paymentValueNames[] = $value;
                    $combinePaymentValueData = array_combine($paymentValueKeyNames, $paymentValueNames);
                }
                foreach ($combinePaymenFieldtData as $key => $value) {
                    foreach ($combinePaymentValueData as $data2Key => $data2Value) {
                        if ($key == $data2Key) {
                            $tmp1[] = $value;
                            $tmp2[] = $data2Value;
                            $tmp = array_combine($tmp1, $tmp2);
                            $result = $tmp;
                        }
                    }
                }
                $combinePaymentData = $result;
                $payment->payment_custom_fields = json_encode($combinePaymentData);
            }

            if ($this->Payments->save($payment)) {
                return $this->redirect(HTTP_ROOT . 'customer/payments/payNowRedirectAdvance/' . $payment->uniq_id);
            } else {
                $this->Flash->error(__('Some error occured, try again'));
                $this->redirect($this->referer());
            }
        }
    }

    public function ajaxCheckEmailAvail($email) {
        $this->viewBuilder()->layout('ajax');
        $emailExist = $this->Users->find()->where(['Users.email' => $email])->count();
        if ($emailExist > 0) {
            echo json_encode(['status' => 'success', 'mail_exist' => 'yes']);
        } else {
            echo json_encode(['status' => 'success', 'mail_exist' => 'no']);
        }
        exit;
    }

}
