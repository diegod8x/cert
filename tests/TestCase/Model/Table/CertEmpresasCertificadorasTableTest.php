<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CertEmpresasCertificadorasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CertEmpresasCertificadorasTable Test Case
 */
class CertEmpresasCertificadorasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CertEmpresasCertificadorasTable
     */
    public $CertEmpresasCertificadoras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CertEmpresasCertificadoras'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CertEmpresasCertificadoras') ? [] : ['className' => CertEmpresasCertificadorasTable::class];
        $this->CertEmpresasCertificadoras = TableRegistry::getTableLocator()->get('CertEmpresasCertificadoras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CertEmpresasCertificadoras);

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
