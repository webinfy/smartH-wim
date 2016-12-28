<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SplitSettlementMapping Entity
 *
 * @property int $id
 * @property int $split_settlement_id
 * @property int $webfront_field_id
 * @property int $sub_merchant_id
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\SplitSettlement $split_settlement
 * @property \App\Model\Entity\WebfrontField $webfront_field
 * @property \App\Model\Entity\SubMerchant $sub_merchant
 */
class SplitSettlementMapping extends Entity
{

}
