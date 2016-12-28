<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UploadedPaymentFile Entity
 *
 * @property int $id
 * @property int $webfront_id
 * @property \Cake\I18n\Time $payment_cycle_date
 * @property string $file
 * @property int $upload_count
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Webfront $webfront
 */
class UploadedPaymentFile extends Entity
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
