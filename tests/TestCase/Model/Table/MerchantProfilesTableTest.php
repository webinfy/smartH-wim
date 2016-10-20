<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MerchantProfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MerchantProfilesTable Test Case
 */
class MerchantProfilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MerchantProfilesTable
     */
    public $MerchantProfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.merchant_profiles',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MerchantProfiles') ? [] : ['className' => 'App\Model\Table\MerchantProfilesTable'];
        $this->MerchantProfiles = TableRegistry::get('MerchantProfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MerchantProfiles);

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
