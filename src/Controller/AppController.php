<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

ini_set('max_execution_time', 123456);
ini_set('memory_limit', '-1');
ignore_user_abort(true);
set_time_limit(0);

class AppController extends Controller {

    public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Auth');
        $this->loadComponent('Flash');

        $this->loadModel('Users');

        if (!$this->Auth->user('id') && isset($_COOKIE['rememberme'])) {
            $rememberme = base64_decode(urldecode($_COOKIE['rememberme']));
            $explodeCookieValue = explode('-', $rememberme);
            if (count($explodeCookieValue) >= 2) {
                $user = $this->Users->find()->where(['id' => $explodeCookieValue[0], 'uniq_id' => $explodeCookieValue[1]]);
                if ($user->count() > 0) {
                    $this->Auth->setUser($user->first()->toArray());
                }
            }
        }


//        $this->Auth->config('authenticate', [
//            'Form' => [
//                'fields' => ['username' => 'email']
//            ]
//        ]);
//        $this->loadComponent('Auth', [
//            'authenticate' => [
//                'Form' => [
//                    'fields' => ['username' => 'email', 'password' => 'password']
//                ]
//            ]
//        ]);

        if ($this->Auth->user('id')) {
            $userDetails = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')])->contain(['MerchantProfiles'])->first();
            $this->set(compact('userDetails'));
        }
    }

    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), ['application/json', 'application/xml'])) {
            $this->set('_serialize', true);
        }
    }

}
