<?php

namespace App\Controller\Merchant;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Custom');
        $this->loadModel('Customers');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->viewBuilder()->layout('merchant');
        $this->Auth->allow(['login']);
        $action = $this->request->params['action'];
        if (!in_array($action, ['login'])) {
            if (!$this->Auth->user('id')) {
                return $this->redirect(HTTP_ROOT);
            } else if ($this->Auth->user('type') != 3) {
                throw new UnauthorizedException;
            }
        }
    }

    public function dashboard() {
        
    }

    public function ajaxUpdateLogo() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data;
        pr($data['data']);exit;

//        $filteredProfData = explode(',', $data);
        $unencoded = $this->request->data;//base64_decode($filteredProfData[1]);

//        $img = "dfghdfghgf";
//        $img = str_replace('data:image/png;base64,', '', $img);
//        $img = str_replace(' ', '+', $img);
//        $data = base64_decode($img);
//        $file = MERCHANT_LOGO . "image_name.png";
//        $success = file_put_contents($file, $data);

//        $unencoded = base64_decode($data['data']);

        $randomName = $this->Custom->generateUniqNumber();
        $fp1 = fopen(MERCHANT_LOGO . $randomName . '.png', 'w');
        fwrite($fp1, $unencoded);
        fclose($fp1);



        exit;
    }

    public function login() {
        if ($this->Auth->user('id')) {
            $this->redirect($this->referer());
        } else {
            $this->redirect(HTTP_ROOT);
        }
    }

}
