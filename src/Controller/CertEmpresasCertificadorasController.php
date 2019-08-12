<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CertEmpresasCertificadoras Controller
 *
 * @property \App\Model\Table\CertEmpresasCertificadorasTable $CertEmpresasCertificadoras
 *
 * @method \App\Model\Entity\CertEmpresasCertificadora[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CertEmpresasCertificadorasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $certEmpresasCertificadoras = $this->paginate($this->CertEmpresasCertificadoras);

        $this->set(compact('certEmpresasCertificadoras'));
    }

    /**
     * View method
     *
     * @param string|null $id Cert Empresas Certificadora id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $certEmpresasCertificadora = $this->CertEmpresasCertificadoras->get($id, [
            'contain' => []
        ]);

        $this->set('certEmpresasCertificadora', $certEmpresasCertificadora);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $certEmpresasCertificadora = $this->CertEmpresasCertificadoras->newEntity();
        if ($this->request->is('post')) {
            $certEmpresasCertificadora = $this->CertEmpresasCertificadoras->patchEntity($certEmpresasCertificadora, $this->request->getData());
            if ($this->CertEmpresasCertificadoras->save($certEmpresasCertificadora)) {
                $this->Flash->success(__('The cert empresas certificadora has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert empresas certificadora could not be saved. Please, try again.'));
        }
        $this->set(compact('certEmpresasCertificadora'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cert Empresas Certificadora id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $certEmpresasCertificadora = $this->CertEmpresasCertificadoras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $certEmpresasCertificadora = $this->CertEmpresasCertificadoras->patchEntity($certEmpresasCertificadora, $this->request->getData());
            if ($this->CertEmpresasCertificadoras->save($certEmpresasCertificadora)) {
                $this->Flash->success(__('The cert empresas certificadora has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert empresas certificadora could not be saved. Please, try again.'));
        }
        $this->set(compact('certEmpresasCertificadora'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cert Empresas Certificadora id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $certEmpresasCertificadora = $this->CertEmpresasCertificadoras->get($id);
        if ($this->CertEmpresasCertificadoras->delete($certEmpresasCertificadora)) {
            $this->Flash->success(__('The cert empresas certificadora has been deleted.'));
        } else {
            $this->Flash->error(__('The cert empresas certificadora could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
