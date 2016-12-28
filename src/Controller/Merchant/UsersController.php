<?php

namespace App\Controller\Merchant;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Customers');
        $this->loadModel('MerchantProfiles');
        $this->loadModel('Users');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('merchant');
        $this->Auth->allow(['login']);
//        $action = $this->request->params['action'];
//        if (!in_array($action, ['login'])) {
//            if (!$this->Auth->user('id')) {
//                return $this->redirect(HTTP_ROOT);
//            } else if ($this->Auth->user('type') != 3) {
//                throw new UnauthorizedException;
//            }
//        }
    }

    public function dashboard() {
        if (!$this->Auth->user('id')) {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function login($uniqId = NULL, $title = NULL) {
        $this->viewBuilder()->layout('');

        if ($this->Auth->user('id')) {
            if ($this->Auth->user('type') == 1) {
                return $this->redirect(HTTP_ROOT . 'admin/#/dashboard');
            } else if ($this->Auth->user('type') == 2) {
                return $this->redirect(HTTP_ROOT . 'branchadmin/#/dashboard');
            } else if ($this->Auth->user('type') == 3) {
                return $this->redirect(HTTP_ROOT . 'merchant/#/dashboard');
            } else {
                return $this->redirect(HTTP_ROOT . 'customer/#/payment-and-bills');
            }
        }

        if (empty($uniqId)) {
            throw new \Exception;
            exit;
        }
        $query = $this->Users->find()->where(['Users.id' => $uniqId])->contain(['MerchantProfiles']);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }

        $merchant = $query->first();
        $this->set(compact('merchant'));


        //Login and Redirect to appropriate user dashboard
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $this->Auth->config('authenticate', [
                'Form' => [
                    'fields' => ['username' => 'email']
                ]
            ]);
            $this->Auth->constructAuthenticate();
            $user = $this->Auth->identify();

            if (!$user) {
                $this->Flash->error(__('Invalid Phone No. or Password, try again'));
                return $this->redirect($this->referer());
                exit;
            }

//            $user = $query->first()->toArray();
            $this->Auth->setUser($user);

            //User Login Information//           
            $ip = $this->Custom->getRealIpAddress();
            $date = date('Y-m-d H:i:s');
            $this->loadModel('UserLogins');
            $query = $this->UserLogins->find()->where(['user_id' => $this->Auth->user('id')])->order(['UserLogins.id' => 'DESC']);
            if ($query->count() > 0) {
                $userLogin = $query->first();
                $this->Users->query()->update()->set(['last_login_date' => $userLogin->login_date, 'last_login_ip' => $userLogin->login_ip])->where(['id' => $this->Auth->user('id')])->execute(); //
            } else {
                $this->Users->query()->update()->set(['last_login_date' => $date, 'last_login_ip' => $ip])->where(['id' => $this->Auth->user('id')])->execute(); //
            }
            $userLogin = $this->UserLogins->newEntity();
            $userLogin->user_id = $this->Auth->user('id');
            $userLogin->login_ip = $ip;
            $userLogin->login_date = $date;
            $this->UserLogins->save($userLogin);
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("DELETE FROM `user_logins` WHERE id NOT IN (SELECT id FROM (SELECT id FROM `user_logins` ORDER BY id DESC  LIMIT 2) ul)");
            //User Login Information End// 
            $this->Flash->success(__('Logged in successfully.'));
            return $this->redirect(HTTP_ROOT . 'merchant/#/dashboard');
        }
    }

////////////////////////Prakash Code Starts Here\\\\\\\\\\\\\\\\\\\\\\\\
    public function ajaxGetProfileData() {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            $merchant = $query->contain(['MerchantProfiles'])->first()->toArray();
            echo json_encode(['status' => 'success', 'merchant' => $merchant]);
        }
        exit;
    }

    public function ajaxEditMerchant($id = NULL) {
        $data = $this->request->data;

        $oldLogo = @$data['merchant_profile']['logo'];

        $email = $data['merchant']['email'];
        $query = $this->Users->find()->where(['Users.email' => $email, 'Users.type IN' => [1, 2, 3], 'Users.id !=' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'error', 'msg' => 'Email not Available!!.']);
            exit;
        }

        $user = $this->Users->newEntity();
        $user = $this->Users->patchEntity($user, $data['merchant']);
        $user->id = $this->Auth->user('id');
        $this->Users->save($user);

        $merchantProfile = $this->MerchantProfiles->newEntity();
        $merchantProfile = $this->MerchantProfiles->patchEntity($merchantProfile, $data['merchant_profile']);
        $merchantProfile->merchant_id = $this->Auth->user('id');
        if (!empty($data['croppedImage'])) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data['croppedImage']));
            if ($imageData) {
                $logo = time() . rand(100, 999) . '.png';
                if (file_put_contents(MERCHANT_LOGO . $logo, $imageData)) {
                    $merchantProfile->logo = $logo;
                    if (!empty($oldLogo) && is_file(MERCHANT_LOGO . $oldLogo) && file_exists(MERCHANT_LOGO . $oldLogo)) {
                        unlink(MERCHANT_LOGO . $oldLogo);
                    }
                }
            }
        }

        if ($this->MerchantProfiles->save($merchantProfile)) {
            $merchant = $this->Users->get($this->Auth->user('id'), ['contain' => ['MerchantProfiles']]);
            echo json_encode(['status' => 'success', 'msg' => 'Profile Updated successfully!!.', 'merchant' => $merchant]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }
        exit;
    }

// ***********************   Users Add Section by Merchant *********************
    public function ajaxNameAvail() {
        $this->viewBuilder()->layout('ajax');
        $name = urldecode(trim($this->request->query['name']));
        $query = $this->Users->find()->where(['name' => $name]);
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
        $query = $this->Users->find()->where(['email' => $email]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'success', 'avail' => 1]);
        } else {
            echo json_encode(['status' => 'success', 'avail' => 0]);
        }
        exit;
    }

    public function ajaxAddUser() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;
        if ($data['user']['password'] != $data['user']['confirm_password']) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
            exit;
        }
        $email = filter_var($data['user']['email'], FILTER_SANITIZE_EMAIL);
        $phone = $data['user']['phone'];

        $emailCount = $this->Users->find()->where(['Users.email' => $email])->count();
        if ($emailCount) {
            echo json_encode(['status' => 'error', 'msg' => 'Email not availavle. Please use another email.']);
            exit;
        }
        $phoneCount = $this->Users->find()->where(['Users.phone' => $email])->count();
        if ($phoneCount) {
            echo json_encode(['status' => 'error', 'msg' => 'Phone no not availavle. Please use another phone no.']);
            exit;
        }
        $user = $this->Users->newEntity();
        $user->uniq_id = $this->Custom->generateUniqNumber();
        $user->name = $data['user']['name'];
        $user->email = $email;
        $user->password = $data['user']['password'];
        $user->phone = $phone;
        $user->created_by = $this->Auth->user('id');
        $user->type = 3;
        $user->is_active = 1;
        $user->access = !empty($data['user']['access']) ? $data['user']['access'] : 1;
        if ($this->Users->save($user)) {
            $this->_sendEmailToUser($user->id, $data['user']['password']);
            echo json_encode(['status' => 'success', 'msg' => 'User Added Successfully!!.']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }
        exit;
    }

    public function _sendEmailToUser($userId, $password) {
        $user = $this->Users->get($userId);
        $this->loadModel('MailTemplates');
        $this->loadModel('AdminSettings');
        $emailTemplate = $this->MailTemplates->find()->where(['MailTemplates.name' => 'WELCOME_EMAIL_TO_USER'])->first();
        $adminSetting = $this->AdminSettings->find()->where(['id' => '1'])->first();
        $to = $user->email;
        $from = $adminSetting->from_email;
        $subject = $emailTemplate->subject;
        $message = $this->Custom->formatEmail($emailTemplate->content, ['NAME' => $user->name, 'USERNAME' => $user->email, 'EMAIL' => $user->email, 'PASSWORD' => $password, 'SUPPORT_EMAIL' => $adminSetting->support_email]);
        $this->Custom->sendEmail($to, $from, $subject, $message, $adminSetting->bcc_email);
        return TRUE;
    }

    public function ajaxFetchUsers() {
        $query = $this->Users->find()->where(['Users.id !=' => $this->Auth->user('id'), 'Users.created_by' => $this->Auth->user('id')])->order(['Users.id' => 'DESC']);
        if ($query->count() > 0) {
            echo json_encode(['status' => 'success', 'data' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxGetEditUser($id = NULL) {
        $query = $this->Users->find()->where(['Users.id' => $id])->first();
        if (!empty($query)) {
            echo json_encode(['status' => 'success', 'data' => $query]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxEditUser($id = NULL) {
        $data = $this->request->data;
        $user = $this->Users->newEntity();
        $user->id = $id;
        $user->name = $data['user']['name'];
        $user->email = $data['user']['email'];
        $user->phone = $data['user']['phone'];
        $user->access = $data['user']['access'];
        if ($this->Users->save($user)) {
            echo json_encode(['status' => 'success', 'msg' => 'User Updated Successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Some error occured,try later.']);
        }
        exit;
    }

    public function ajaxDeleteUser($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error']);
            exit;
        }
        $userEntity = $this->Users->get($query->first()->id);
        if ($this->Users->delete($userEntity)) {
            echo json_encode(['status' => 'success', 'msg' => 'User deleted successfully']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxInActivateUser($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'User id is not present']);
            exit;
        } else {
            $this->Users->query()->update()->set(['is_active' => 0])->where(['id' => $id])->execute();
            $users = $this->Users->find()->where(['Users.id !=' => $this->Auth->user('id'), 'Users.created_by' => $this->Auth->user('id')])->order(['Users.id' => 'DESC']);
            echo json_encode(['status' => 'success', 'msg' => 'Users inactivated successfully.', 'users' => $users]);
        }
        exit;
    }

    public function ajaxActivateUser($id = NULL) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Users->find()->where(['Users.id' => $id]);
        if ($query->count() <= 0) {
            echo json_encode(['status' => 'error', 'msg' => 'User id is not present']);
            exit;
        } else {
            $this->Users->query()->update()->set(['is_active' => 1])->where(['id' => $id])->execute();
            $users = $this->Users->find()->where(['Users.id !=' => $this->Auth->user('id'), 'Users.created_by' => $this->Auth->user('id')])->order(['Users.id' => 'DESC']);
            echo json_encode(['status' => 'success', 'msg' => 'User activated successfully.', 'users' => $users]);
        }
        exit;
    }

// ********   Users Add Section by Merchant Ends here********
////////////////////////Prakash Code Ends Here\\\\\\\\\\\\\\\\\\\\\\\\
}
