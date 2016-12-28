<?php

namespace App\Controller\Branchadmin;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class MerchantsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('MerchantProfiles');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('admin');
        $this->Auth->allow(['login']);
        $action = $this->request->params['action'];
        if (!in_array($action, ['login'])) {
            if (!$this->Auth->user('id')) {
                return $this->redirect(HTTP_ROOT);
            } else if ($this->Auth->user('type') != 2) {
                throw new UnauthorizedException;
            }
        }
    }

    public function ajaxNameAvail() {
        $this->viewBuilder()->layout('ajax');
        $name = urldecode(trim($this->request->query['name']));
        $query = $this->MerchantProfiles->find()->where(['name' => $name]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'success', 'avail' => 1]);
        } else {
            echo json_encode(['status' => 'success', 'avail' => 0]);
        }
        exit;
    }

    public function ajaxEmailAvail() {
        $this->viewBuilder()->layout('ajax');
        $email = urldecode(trim($this->request->query['email']));
        $query = $this->MerchantProfiles->find()->where(['email' => $email]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'success', 'avail' => 1]);
        } else {
            echo json_encode(['status' => 'success', 'avail' => 0]);
        }
        exit;
    }

    public function ajaxAddMerchant() {
        $data = $this->request->data;
        if ($data['merchant']['password'] != $data['merchant']['confirm_password']) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
            exit;
        } else {
            $user = $this->Users->newEntity();
            $user->uniq_id = $this->Custom->generateUniqNumber();
            $user->name = $data['merchant']['name'];
            $user->email = $data['merchant']['email'];
            $user->password = $data['merchant']['password'];
            $user->phone = $data['merchant']['phone'];
            $user->type = 3;
            $user->is_active = 1;
            $user->last_login_date = date('Y-m-d H:i:s');
            $user->last_login_ip = $this->Custom->get_ip_address();
            if ($this->Users->save($user)) {
                if (!empty($data['file'])) {
                    $logo = $this->Custom->uploadImage($data['file']['tmp_name'], $data['file']['name'], MERCHANT_LOGO, 257);
                    if ($logo) {
                        $merchant_profiles = $this->MerchantProfiles->newEntity();
                        $merchant_profiles->merchant_id = $user->id;
                        $merchant_profiles->name = $data['merchant']['name'];
                        $merchant_profiles->email = $data['merchant']['email'];
                        $merchant_profiles->phone = $data['merchant']['phone'];
                        $merchant_profiles->address = $data['merchant']['address'];
                        $merchant_profiles->description = $data['merchant']['description'];
                        $merchant_profiles->logo = $logo;
                        $merchant_profiles->payuid = $data['merchant']['payuid'];
                        $merchant_profiles->website = $data['merchant']['website'];
                        $merchant_profiles->facebook_url = $data['merchant']['facebook_url'];
                        $merchant_profiles->twitter_url = $data['merchant']['twitter_url'];
                        $merchant_profiles->convenience_fee_amount = $data['merchant']['convenience_fee_amount'];
                        if ($this->MerchantProfiles->save($merchant_profiles)) {
                            echo json_encode(['status' => 'success', 'msg' => 'Merchant Added Successfully.']);
                        } else {
                            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
                        }
                    }
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Merchant logo not given.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
            }
        }
        exit;
    }

    public function ajaxFetchMerchants() {
//        echo 'Jai Jagannath Swami';
        $query = $this->MerchantProfiles->find()->contain(['Users'])->order(['MerchantProfiles.id' => 'DESC']);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxGetEditMerchant($id = NULL) {
//        echo 'Jai Jagannath Swami';
        $query = $this->MerchantProfiles->find()->where(['MerchantProfiles.id' => $id])->first();
        if (!empty($query)) {
            echo json_encode(['status' => 'success', 'data' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxEditMerchant($id = NULL) {
        $data = $this->request->data;
        $merchant_profiles = $this->MerchantProfiles->newEntity();
        $merchant_profiles->id = $id;
        $merchant_profiles->merchant_id = $data['merchant']['merchant_id'];
        $merchant_profiles->name = $data['merchant']['name'];
        $merchant_profiles->email = $data['merchant']['email'];
        $merchant_profiles->phone = $data['merchant']['phone'];
        $merchant_profiles->address = $data['merchant']['address'];
        $merchant_profiles->description = $data['merchant']['description'];
        if (!empty($data['file']['name'])) {
            $query = $this->MerchantProfiles->find()->where(['MerchantProfiles.id' => $id])->first();
            unlink(WWW_ROOT . MERCHANT_LOGO . $query->logo);
            $logo = $this->Custom->uploadImage($data['file']['tmp_name'], $data['file']['name'], MERCHANT_LOGO, 257);
            if ($logo) {
                $merchant_profiles->logo = $logo;
            }
        }
        $merchant_profiles->payuid = $data['merchant']['payuid'];
        $merchant_profiles->website = $data['merchant']['website'];
        $merchant_profiles->facebook_url = $data['merchant']['facebook_url'];
        $merchant_profiles->twitter_url = $data['merchant']['twitter_url'];
        $merchant_profiles->convenience_fee_amount = $data['merchant']['convenience_fee_amount'];
        if ($this->MerchantProfiles->save($merchant_profiles)) {
            echo json_encode(['status' => 'success', 'msg' => 'Merchant Updated Successfully.', 'logo' => MERCHANT_LOGO . $merchant_profiles->logo]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }


        exit;
    }

    public function ajaxDeleteMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->MerchantProfiles->find()->where(['MerchantProfiles.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error']);
            exit;
        }
        $entity = $this->MerchantProfiles->get($query->first()->id);
        unlink(WWW_ROOT . MERCHANT_LOGO . $entity->logo);
        $userEntity = $this->Users->get($query->first()->merchant_id);
        $this->Users->delete($userEntity);
        if ($this->MerchantProfiles->delete($entity)) {
            echo json_encode(['status' => 'success', 'msg' => 'Merchant deleted successfully']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxInActivateMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'User id is not present']);
            exit;
        } else {
            $this->Users->query()->update()->set(['is_active' => 0])->where(['id' => $id])->execute();
            $merchants = $this->MerchantProfiles->find()->contain(['Users'])->order(['MerchantProfiles.id' => 'DESC']);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant in activated successfully.', 'merchants' => $merchants]);
        }
        exit;
    }

    public function ajaxActivateMerchant($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'msg' => 'User id is not present']);
            exit;
        } else {
            $this->Users->query()->update()->set(['is_active' => 1])->where(['id' => $id])->execute();
            $merchants = $this->MerchantProfiles->find()->contain(['Users'])->order(['MerchantProfiles.id' => 'DESC']);
            echo json_encode(['status' => 'success', 'msg' => 'Merchant activated successfully.', 'merchants' => $merchants]);
        }
        exit;
    }

}
