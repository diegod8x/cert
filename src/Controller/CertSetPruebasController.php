<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CertSetPruebas Controller
 *
 * @property \App\Model\Table\CertSetPruebasTable $CertSetPruebas
 *
 * @method \App\Model\Entity\CertSetPrueba[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CertSetPruebasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $certSetPruebas = $this->paginate($this->CertSetPruebas);

        $this->set(compact('certSetPruebas'));
    }

    /**
     * View method
     *
     * @param string|null $id Cert Set Prueba id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $certSetPrueba = $this->CertSetPruebas->get($id, [
            'contain' => ['CertEmpresasSetPruebas']
        ]);

        $this->set('certSetPrueba', $certSetPrueba);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $certSetPrueba = $this->CertSetPruebas->newEntity();
        if ($this->request->is('post')) {
            $certSetPrueba = $this->CertSetPruebas->patchEntity($certSetPrueba, $this->request->getData());
            if ($this->CertSetPruebas->save($certSetPrueba)) {
                $this->Flash->success(__('The cert set prueba has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert set prueba could not be saved. Please, try again.'));
        }
        $this->set(compact('certSetPrueba'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cert Set Prueba id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $certSetPrueba = $this->CertSetPruebas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $certSetPrueba = $this->CertSetPruebas->patchEntity($certSetPrueba, $this->request->getData());
            if ($this->CertSetPruebas->save($certSetPrueba)) {
                $this->Flash->success(__('The cert set prueba has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert set prueba could not be saved. Please, try again.'));
        }
        $this->set(compact('certSetPrueba'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cert Set Prueba id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $certSetPrueba = $this->CertSetPruebas->get($id);
        if ($this->CertSetPruebas->delete($certSetPrueba)) {
            $this->Flash->success(__('The cert set prueba has been deleted.'));
        } else {
            $this->Flash->error(__('The cert set prueba could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
