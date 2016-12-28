<?php

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Friends cell
 */
class MerchantsCell extends Cell {

    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display() {
        
    }

    public function header($merchantId = NULL) {
        $this->loadModel('Users');
        $query = $this->Users->find()->where(['Users.id' => $merchantId])->contain(['MerchantProfiles']);
        if ($query->count() > 0) {
            $merchant = $query->first();
        } else {
            $merchant = NULL;
        }
        $this->set(compact('merchant'));
    }

}
