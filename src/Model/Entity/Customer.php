<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $uniq_id
 * @property int $merchant_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property float $fee
 * @property int $payment_status
 * @property string $custom_field1
 * @property string $custom_field2
 * @property string $custom_field3
 * @property string $custom_field4
 * @property string $custom_field5
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Uniq $uniq
 * @property \App\Model\Entity\Merchant $merchant
 */
class Customer extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

}
