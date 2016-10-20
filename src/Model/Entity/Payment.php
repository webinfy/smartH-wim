<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $uploaded_payment_file_id
 * @property int $user_id
 * @property int $customerid
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $custom_fields
 * @property float $total_fee
 * @property int $status
 * @property \Cake\I18n\Time $due_date
 * @property \Cake\I18n\Time $payment_date
 *
 * @property \App\Model\Entity\UploadedPaymentFile $uploaded_payment_file
 * @property \App\Model\Entity\User $user
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
