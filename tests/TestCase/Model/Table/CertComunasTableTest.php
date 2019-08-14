<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CertComunasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CertComunasTable Test Case
 */
class CertComunasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CertComunasTable
     */
    public $CertComunas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CertComunas',
        'app.CertEmpresas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CertComunas') ? [] : ['className' => CertComunasTable::class];
        $this->CertComunas = TableRegistry::getTableLocator()->get('CertComunas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CertComunas);

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
}
