<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Validation\Validation;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Users');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('customer');
        $this->Auth->allow(['login', 'logout', 'ajaxCheckLogin']);
    }

    public function ajaxCheckLogin() {
        $this->viewBuilder()->layout('ajax');
        if ($this->Auth->user('id')) {
            echo json_encode(['status' => 'loggedin', 'user' => $this->Auth->user()]);
        } else {
            echo json_encode(['status' => 'loggedout']);
        }
        exit;
    }

    public function login() {
        $this->viewBuilder()->layout('');
        //Redirect if Alreday Login
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
        //Login and Redirect to appropriate user dashboard
        if ($this->request->is('post')) {
            $data = $this->request->data;

            if (Validation::email($this->request->data['email'])) {
                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email']
                    ]
                ]);
                $this->Auth->constructAuthenticate();
//                $this->request->data['email'] = $this->request->data['email'];
//                unset($this->request->data['username']);
            } else {
                $this->Flash->error(__('Please enter valid email.'));
                return $this->redirect($this->referer());
            }
            $user = $this->Auth->identify();
            if ($user) {

                if (!empty($data['rememberme'])) {
                    $rememberme = urlencode(base64_encode($user['id'] . '-' . $user['uniq_id']));
                    setcookie('rememberme', $rememberme, time() + (86400 * 30), "/"); //For 30 day setting cookie
                }

                $this->Auth->setUser($user);
                $this->Flash->success(__('Logged in successfully.'));
                $ip = $this->Custom->getRealIpAddress();
                $this->Users->query()->update()->set(['last_login_date' => date('Y-m-d H:i:s'), 'last_login_ip' => $ip])->where(['id' => $this->Auth->user('id')])->execute(); //

                if ($this->Auth->user('type') == 1) {
                    return $this->redirect(HTTP_ROOT . 'admin/#/dashboard');
                } else if ($this->Auth->user('type') == 2) {
                    return $this->redirect(HTTP_ROOT . 'branchadmin/#/dashboard');
                } else if ($this->Auth->user('type') == 3) {
                    return $this->redirect(HTTP_ROOT . 'merchant/#/dashboard');
                } else {
                    return $this->redirect(HTTP_ROOT . 'customer/#/payment-and-bills');
                }
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
                $this->redirect($this->referer());
            }
        }
    }

    public function logout() {
        if (isset($_COOKIE['rememberme'])) {
            setcookie("rememberme", $_COOKIE['rememberme'], time() - (86400 * 30), "/"); //Removing cookie
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        session_destroy();
        $this->Auth->logout();
        $this->redirect(HTTP_ROOT);
    }

    public function ajaxChangePasssword() {
        $data = $this->request->data;
        if (empty($data['old_password'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter current password.']);
        } else if (empty($data['password1'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter new password']);
        } else if (strlen($data['password1']) < 6) {
            echo json_encode(['status' => 'error', 'msg' => 'Password length must be greated that 5 character.']);
        } else if ($data['password1'] != $data['password2']) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
        } else {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, ['old_password' => $data['old_password'], 'password' => $data['password1'], 'password1' => $data['password1'], 'password2' => $data['password2']], ['validate' => 'password']);
            if ($this->Users->save($user)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Current password is not correct.']);
            }
        }
        exit;
    }

    public function ajaxGetProfileData($id = null) {
        $this->viewBuilder()->layout('ajax');
        $user = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')])->contain([]);
        if ($user->count() > 0) {
            $user = $user->first()->toArray();
            echo json_encode($user);
        }
        exit;
    }

    public function ajaxUpdateProfile() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;
        $email = filter_var($data['user']['email'], FILTER_SANITIZE_EMAIL);
        $user = $this->Users->newEntity();
        $user->id = $this->Auth->user('id');
        $user->name = $data['user']['name'];
        $user->email = $email;
        $user->phone = $data['user']['phone'];
        $user->address = $data['user']['address'];
        if ($this->Users->save($user)) {
            if (!empty($data['file']['name'])) {
                $logo = $this->Custom->uploadImage($data['file']['tmp_name'], $data['file']['name'], MERCHANT_LOGO, 300);
                if ($logo) {
                    $this->loadModel('MerchantProfiles');
                    $query = $this->MerchantProfiles->find()->where(['MerchantProfiles.user_id' => $this->Auth->user('id')]);
                    if ($query->count() > 0) {
                        $id = $query->first()->id;
                        $this->MerchantProfiles->query()->update()->set(['logo' => $logo])->where(['id' => $id])->execute(); //
                    } else {
                        $merchantProfile = $this->MerchantProfiles->newEntity();
                        $merchantProfile->user_id = $this->Auth->user('id');
                        $merchantProfile->logo = $logo;
                        $this->MerchantProfiles->save($merchantProfile);
                    }
                    echo json_encode(['status' => 'success', 'logo' => MERCHANT_LOGO . $logo]);
                    exit;
                }
            }
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

}
