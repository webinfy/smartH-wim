<?php

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\Log\Log;
use Cake\Event\EventListener;

class PostListener implements EventListenerInterface {

    public function implementedEvents() {
        return array(
            'Model.Post.created' => 'updatePostLog',
        );
    }

    public function updatePostLog($event, $entity, $options = null) {
        $paymentShell = new \App\Shell\PaymentShell;
        $paymentShell->importPayments($entity->id);
        return TRUE;
//        Log::write('info', 'A new post was published with id: ' . $event->data['id']);
    }

}
