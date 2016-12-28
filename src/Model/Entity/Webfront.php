<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Webfront Entity
 *
 * @property int $id
 * @property int $merchant_id
 * @property string $url
 * @property string $email
 * @property string $phone
 * @property string $logo
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\Time $payment_cycle_date
 * @property string $customer_name_alias
 * @property string $customer_email_alias
 * @property string $customer_phone_alias
 * @property string $total_amount_alias
 * @property float $late_fee_amount
 * @property string $file
 * @property int $upload_completed
 * @property int $payee_count
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Merchant $merchant
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\WebfrontField[] $webfront_fields
 * @property \App\Model\Entity\WebfrontImage[] $webfront_images
 */
class Webfront extends Entity
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
