<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubMerchantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubMerchantsTable Test Case
 */
class SubMerchantsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SubMerchantsTable
     */
    public $SubMerchants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sub_merchants',
        'app.pay_merchants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SubMerchants') ? [] : ['className' => 'App\Model\Table\SubMerchantsTable'];
        $this->SubMerchants = TableRegistry::get('SubMerchants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SubMerchants);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
