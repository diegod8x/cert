<?php
namespace App\Controller;

use App\Controller\AppController;
\sasco\LibreDTE\Sii::setAmbiente(\sasco\LibreDTE\Sii::CERTIFICACION);
define("CERT_EMP", ROOT . DS . 'files' . DS . 'certificacion' . DS);
define("FILE_DTE", 'EnvioDTE');

/**
 * CertEmpresasSetPruebas Controller
 *
 * @property \App\Model\Table\CertEmpresasSetPruebasTable $CertEmpresasSetPruebas
 *
 * @method \App\Model\Entity\CertEmpresasSetPrueba[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CertEmpresasSetPruebasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CertEmpresas', 'CertSetPruebas']
        ];
        $certEmpresasSetPruebas = $this->paginate($this->CertEmpresasSetPruebas);

        $this->set(compact('certEmpresasSetPruebas'));
    }

    /**
     * View method
     *
     * @param string|null $id Cert Empresas Set Prueba id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->get($id, [
            'contain' => ['CertEmpresas', 'CertSetPruebas']
        ]);

        $this->set('certEmpresasSetPrueba', $certEmpresasSetPrueba);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        

        $config = AppController::config();
        $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->newEntity();
        if ($this->request->is('post')) {
            pr($this->request->file);
            pr($this->request->data);exit;
            

            if (!empty($this->request->data["data"]) && !empty($this->request->data["33"]) && !empty($this->request->data["61"]) && !empty($this->request->data["56"]) ) {
                $this->request->data["data"] = json_decode($this->request->data["data"], true);
            }
            else {
                echo json_encode(["message" => "Debe completar todos los campos antes de enviar la solicitud", "data" => []]); 
                exit;
            }




            $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->patchEntity($certEmpresasSetPrueba, $this->request->getData());
            if ($this->CertEmpresasSetPruebas->save($certEmpresasSetPrueba)) {
                $this->Flash->success(__('The cert empresas set prueba has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert empresas set prueba could not be saved. Please, try again.'));
        }
        $certEmpresas = $this->CertEmpresasSetPruebas->CertEmpresas->find('list', ['limit' => 200]);
        $certSetPruebas = $this->CertEmpresasSetPruebas->CertSetPruebas->find('list', ['limit' => 200]);
        $this->set(compact('certEmpresasSetPrueba', 'certEmpresas', 'certSetPruebas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cert Empresas Set Prueba id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->patchEntity($certEmpresasSetPrueba, $this->request->getData());
            if ($this->CertEmpresasSetPruebas->save($certEmpresasSetPrueba)) {
                $this->Flash->success(__('The cert empresas set prueba has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cert empresas set prueba could not be saved. Please, try again.'));
        }
        $certEmpresas = $this->CertEmpresasSetPruebas->CertEmpresas->find('list', ['limit' => 200]);
        $certSetPruebas = $this->CertEmpresasSetPruebas->CertSetPruebas->find('list', ['limit' => 200]);
        $this->set(compact('certEmpresasSetPrueba', 'certEmpresas', 'certSetPruebas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cert Empresas Set Prueba id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->get($id);
        if ($this->CertEmpresasSetPruebas->delete($certEmpresasSetPrueba)) {
            $this->Flash->success(__('The cert empresas set prueba has been deleted.'));
        } else {
            $this->Flash->error(__('The cert empresas set prueba could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
