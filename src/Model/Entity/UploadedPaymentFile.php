<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UploadedPaymentFile Entity
 *
 * @property int $id
 * @property int $merchant_id
 * @property string $title
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\Merchant $merchant
 * @property \App\Model\Entity\Payment[] $payments
 */
class UploadedPaymentFile extends Entity
{

}
