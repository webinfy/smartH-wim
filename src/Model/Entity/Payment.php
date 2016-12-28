<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property string $uniq_id
 * @property int $webfront_id
 * @property int $customer_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $payee_custom_fields
 * @property float $convenience_fee_amount
 * @property float $late_fee_amount
 * @property float $fee
 * @property string $payment_custom_fields
 * @property int $status
 * @property \Cake\I18n\Time $payment_date
 * @property int $followup_counter
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Uniq $uniq
 * @property \App\Model\Entity\Webfront $webfront
 * @property \App\Model\Entity\Customer $customer
 */
class Payment extends Entity
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
