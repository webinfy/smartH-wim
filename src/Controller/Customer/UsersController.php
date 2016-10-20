<?php

namespace App\Controller\Customer;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadModel('Payments');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('customer');
        $this->Auth->allow(['login', 'register']);
        $action = $this->request->params['action'];
        if (!in_array($action, ['login', 'register'])) {
            if (!$this->Auth->user('id')) {
                return $this->redirect(HTTP_ROOT);
            } else if ($this->Auth->user('type') != 4) {
                return $this->redirect(HTTP_ROOT); //throw new UnauthorizedException;
            }
        }
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

    public function login() {
        if ($this->Auth->user('id')) {
            $this->redirect($this->referer());
        } else {
            $this->redirect(HTTP_ROOT);
        }
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
