<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CertSetPruebasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CertSetPruebasTable Test Case
 */
class CertSetPruebasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CertSetPruebasTable
     */
    public $CertSetPruebas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CertSetPruebas',
        'app.CertEmpresasSetPruebas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CertSetPruebas') ? [] : ['className' => CertSetPruebasTable::class];
        $this->CertSetPruebas = TableRegistry::getTableLocator()->get('CertSetPruebas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CertSetPruebas);

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
