<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CertEmpresasSetPruebasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CertEmpresasSetPruebasTable Test Case
 */
class CertEmpresasSetPruebasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CertEmpresasSetPruebasTable
     */
    public $CertEmpresasSetPruebas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CertEmpresasSetPruebas',
        'app.CertEmpresas',
        'app.CertSetPruebas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CertEmpresasSetPruebas') ? [] : ['className' => CertEmpresasSetPruebasTable::class];
        $this->CertEmpresasSetPruebas = TableRegistry::getTableLocator()->get('CertEmpresasSetPruebas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CertEmpresasSetPruebas);

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
