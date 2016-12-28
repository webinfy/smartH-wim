<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

class PagesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('ajax');
        $this->Auth->allow(['termAndConditions', 'curlTest']);
    }

    public function termAndConditions() {
        $this->viewBuilder()->layout('');
    }

    public function curlTest() {
        $this->viewBuilder()->layout('');
        echo json_encode(['god' => 'Jay Jagannath']);
        exit;
    }

    public function curlTest2() {
        $this->viewBuilder()->layout('');
        echo "Hii Testing the Curl to own server.<br/>";
        $url = "https://www.testsmarthub.payu.in:5005/pages/curl-test";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        var_dump(json_decode($result, true));
        echo "<br/>exit;";
        var_dump(json_decode(file_get_contents($url), true));
        exit;
    }

    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

}
