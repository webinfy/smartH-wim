<?php

namespace App\Controller\Customer;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');

        $this->loadModel('Users');
        $this->loadModel('Payments');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('customer');
        $this->Auth->allow(['login', 'logout', 'register', 'termAndConditions']);
//        $action = $this->request->params['action'];
//        if (!in_array($action, ['login', 'register'])) {
//            if (!$this->Auth->user('id')) {
//                return $this->redirect(HTTP_ROOT);
//            } else if ($this->Auth->user('type') != 4) {
//                return $this->redirect(HTTP_ROOT); //throw new UnauthorizedException;
//            }
//        }
    }

    public function dashboard() {

    }  

    public function register($uniq) {
        $this->viewBuilder()->layout('');
        //Chek if Bill exist or not
        $query = $this->Payments->find()->where(['Payments.uniq_id' => $uniq]);
        if ($query->count() <= 0) {
            return $this->redirect(HTTP_ROOT);
        }

        //Chek if email exist or not
        $userQuery = $this->Users->find()->where(['Users.email' => $query->first()->email, 'Users.password' => '']);
        if ($userQuery->count() <= 0) {
            return $this->redirect(HTTP_ROOT);
        }

        //If already logged in       
        if ($this->Auth->user('id')) {
            return $this->redirect(HTTP_ROOT);
        }

        $user = $this->Users->get($userQuery->first()->id);

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->data;
            if (strlen($data['password']) < 6) {
                $this->Flash->error(__('Password length must not be less that 6 character.'));
            } else if ($data['password'] != $data['confirm_password']) {
                $this->Flash->error(__("Password & Confirm password does't match."));
            } else {
                $this->Users->patchEntity($user, $data);
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user->toArray());
                    $this->Flash->success(__("Registered successfully."));
                    return $this->redirect(HTTP_ROOT . 'customer/#/dashboard');
                } else {
                    $this->Flash->error(__("Some error occured. Please try again."));
                }
            }
            return $this->redirect($this->referer());
        }

        $this->set(compact('user'));
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
        $query = $this->Users->find()->where(['Users.uniq_id' => $uniqId])->contain(['MerchantProfiles']);
        if ($query->count() <= 0) {
            throw new \Exception;
            exit;
        }

        $merchant = $query->first();
        $this->set(compact('merchant'));

        //Login and Redirect to appropriate user dashboard
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $phone = $data['phone'];
            $password = $data['password'];

            $this->Auth->config('authenticate', [
                'Form' => [
                    'fields' => ['username' => 'phone'],
                    'scope' => ['type' => 4]
                ]
            ]);
            $this->Auth->constructAuthenticate();
            $user = $this->Auth->identify();

            if (!$user) {
                $this->Flash->error(__('Invalid Phone No. or Password, try again'));
                return $this->redirect($this->referer());
                exit;
            }

            $this->Auth->setUser($user);
            $this->request->session()->write('merchant', $merchant);

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
            return $this->redirect(HTTP_ROOT . 'customer/#/payment-and-bills');
        }
    }

    public function logout($merchantUniqId = NULL) {
        $this->Auth->logout();
        $this->redirect(HTTP_ROOT . "customer/login/{$merchantUniqId}");
    }

    public function ajaxGetProfileData() {
        $query = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            echo json_encode($query->first()->toArray());
            $user = $query->first()->toArray();
            $this->set('_serialize', ['user']);
        }
        exit;
    }

}
