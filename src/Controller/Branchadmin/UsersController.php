<?php

namespace App\Controller\Branchadmin;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('branch_admin');
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

    public function login() {
        if ($this->Auth->user('id')) {
            $this->redirect(HTTP_ROOT . "branchadmin");
            //$this->redirect($this->referer());
        } else {
            $this->redirect(HTTP_ROOT);
        }
    }

    public function dashboard() {
        
    }

    public function profileSetting() {
        
    }

    public function changePassword() {
        
    }

    public function viewMerchants() {
        
    }

    public function viewCustomers() {
        
    }

}
