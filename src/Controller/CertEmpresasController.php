<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CertEmpresas Controller
 *
 * @property \App\Model\Table\CertEmpresasTable $CertEmpresas
 *
 * @method \App\Model\Entity\CertEmpresa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CertEmpresasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $certEmpresas = $this->paginate($this->CertEmpresas);

        $this->set(compact('certEmpresas'));
    }

    /**
     * View method
     *
     * @param string|null $id Cert Empresa id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $certEmpresa = $this->CertEmpresas->get($id, [
            'contain' => ['CertEmpresasSetPruebas']
        ]);

        $this->set('certEmpresa', $certEmpresa);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $certEmpresa = $this->CertEmpresas->newEntity();
        if ($this->request->is('post')) {
            $certEmpresa = $this->CertEmpresas->patchEntity($certEmpresa, $this->request->getData());
            if ($this->CertEmpresas->save($certEmpresa)) {
                $this->Flash->success(__('The cert empresa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert empresa could not be saved. Please, try again.'));
        }
        $this->set(compact('certEmpresa'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cert Empresa id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $certEmpresa = $this->CertEmpresas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $certEmpresa = $this->CertEmpresas->patchEntity($certEmpresa, $this->request->getData());
            if ($this->CertEmpresas->save($certEmpresa)) {
                $this->Flash->success(__('The cert empresa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert empresa could not be saved. Please, try again.'));
        }
        $this->set(compact('certEmpresa'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cert Empresa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $certEmpresa = $this->CertEmpresas->get($id);
        if ($this->CertEmpresas->delete($certEmpresa)) {
            $this->Flash->success(__('The cert empresa has been deleted.'));
        } else {
            $this->Flash->error(__('The cert empresa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
