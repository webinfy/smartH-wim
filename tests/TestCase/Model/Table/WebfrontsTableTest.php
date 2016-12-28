<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WebfrontsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WebfrontsTable Test Case
 */
class WebfrontsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WebfrontsTable
     */
    public $Webfronts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.webfronts',
        'app.merchants',
        'app.payments',
        'app.webfront_fields',
        'app.webfront_images'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Webfronts') ? [] : ['className' => 'App\Model\Table\WebfrontsTable'];
        $this->Webfronts = TableRegistry::get('Webfronts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Webfronts);

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
