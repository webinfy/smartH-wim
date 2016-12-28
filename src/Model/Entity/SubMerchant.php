<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubMerchant Entity
 *
 * @property int $id
 * @property string $name
 * @property string $pay_merchant_id
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\PayMerchant $pay_merchant
 */
class SubMerchant extends Entity
{

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
