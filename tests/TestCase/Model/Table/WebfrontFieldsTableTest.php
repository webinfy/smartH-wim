<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WebfrontFieldsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WebfrontFieldsTable Test Case
 */
class WebfrontFieldsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WebfrontFieldsTable
     */
    public $WebfrontFields;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.webfront_fields',
        'app.webfronts',
        'app.users',
        'app.merchant_profiles',
        'app.payments',
        'app.validations',
        'app.webfront_field_values'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WebfrontFields') ? [] : ['className' => 'App\Model\Table\WebfrontFieldsTable'];
        $this->WebfrontFields = TableRegistry::get('WebfrontFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WebfrontFields);

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
