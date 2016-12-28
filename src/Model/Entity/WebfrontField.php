<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WebfrontField Entity
 *
 * @property int $id
 * @property int $webfront_id
 * @property string $name
 * @property int $is_mandatory
 * @property int $validation_id
 * @property int $input_type
 * @property int $input_for
 *
 * @property \App\Model\Entity\Webfront $webfront
 * @property \App\Model\Entity\Validation $validation
 * @property \App\Model\Entity\WebfrontFieldValue[] $webfront_field_values
 */
class WebfrontField extends Entity
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
