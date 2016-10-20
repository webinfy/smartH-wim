<?php

namespace App\Controller\Admin;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('admin');
        $this->Auth->allow(['login']);
        $action = $this->request->params['action'];
        if (!in_array($action, ['login'])) {
            if (!$this->Auth->user('id')) {
                return $this->redirect(HTTP_ROOT);
            } else if ($this->Auth->user('type') != 1) {
                throw new UnauthorizedException;
            }
        }
    }

    public function login() {
        if ($this->Auth->user('id')) {
            $this->redirect($this->referer());
        } else {
            $this->redirect(HTTP_ROOT);
        }
    }

    public function ajaxGetProfileData() {
        $query = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')])->contain(['Admins']);
        if ($query->count() > 0) {
            echo json_encode($query->first()->toArray());
        }
        exit;
    }

    public function ajaxUpdateProfile() {

        $data = $this->request->data;

        $this->Admins = $this->Users->Admins;
        $admin = $this->Admins->newEntity($data['user']['admin']);

        unset($data['user']['admin']);
        $user = $this->Users->newEntity($data['user']);
        $user->id = $this->Auth->user('id');

        if ($this->Users->save($user)) {
            $query = $this->Admins->find()->where(['Admins.user_id' => $this->Auth->user('id')]);
            if ($query->count() > 0) {
                $admin->id = $query->select('id')->first()->id;
            } else {
                $admin->created = date('Y-m-d H:i:s');
            }
            $admin->user_id = $this->Auth->user('id');
            $this->Admins->save($admin);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
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

    public function dashboard() {
        
    }

    public function changePassword() {
        
    }

    public function addBranchAdmin() {
        
    }

    public function branchAdminListing() {
        
    }

    public function viewMerchants() {
        
    }

    public function viewCustomers() {
        
    }

    public function profileSetting() {
        
    }

    public function transactions() {
        
    }

    public function ajaxAddCustomer() {
        
        echo"sdf";exit;   
    }
}
