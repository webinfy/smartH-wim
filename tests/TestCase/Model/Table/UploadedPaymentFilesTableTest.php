<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UploadedPaymentFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UploadedPaymentFilesTable Test Case
 */
class UploadedPaymentFilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UploadedPaymentFilesTable
     */
    public $UploadedPaymentFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.uploaded_payment_files',
        'app.merchants',
        'app.payments',
        'app.users',
        'app.admins',
        'app.branchadmins',
        'app.customers',
        'app.customer_groups'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UploadedPaymentFiles') ? [] : ['className' => 'App\Model\Table\UploadedPaymentFilesTable'];
        $this->UploadedPaymentFiles = TableRegistry::get('UploadedPaymentFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UploadedPaymentFiles);

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
