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

    public function getEmpresa($id = null)
    {
        $certEmpresa = $this->CertEmpresas->get($id, [
            'contain' => ['CertEmpresasSetPruebas']
        ]);

        return json_encode($certEmpresa);
    }

    public function getEmisor($rut = null)
    {
        $rut = isset($this->request->query["rut"])? $this->request->query["rut"] : $rut; 
        if (!empty($rut)){
            $certEmpresa = $this->CertEmpresas->find('all')->where(['rut' => $this->request->query["rut"] ])->first();            
            if(!empty($certEmpresa))
                $certEmpresa->toArray();

            $format = [
                "RUTEmisor" => $this->request->query["rut"],
                "id" => isset($certEmpresa["id"])?$certEmpresa["id"]:null,
                "RznSoc" => isset($certEmpresa["nombre"])?$certEmpresa["nombre"]:"",
                "GiroEmis" => isset($certEmpresa["giro"])?$certEmpresa["giro"]:"",
                "Acteco" => isset($certEmpresa["actividad"])?$certEmpresa["actividad"]:"",
                "DirOrigen" => isset($certEmpresa["direccion"])?$certEmpresa["direccion"]:"",
                "CmnaOrigen" => isset($certEmpresa["cert_comuna_id"])?$certEmpresa["cert_comuna_id"]:""
            ];            
            if ($this->request->is('get'))     
                echo json_encode($format);
            else 
                return $format;          
        }        
        exit;        
    }
    public function getReceptor($rut = null)
    {
        $rut = isset($this->request->query["rut"])? $this->request->query["rut"] : $rut; 
        if (!empty($rut)){
            $certEmpresa = $this->CertEmpresas->find('all')->where(['rut' => $rut ])->first();
            if(!empty($certEmpresa))
                $certEmpresa->toArray();
            $format = [
                "RUTRecep" => $rut,
                "id" => isset($certEmpresa["id"])?$certEmpresa["id"]:null,
                "RznSocRecep" =>isset($certEmpresa["nombre"])?$certEmpresa["nombre"]:"",
                "GiroRecep" => isset($certEmpresa["giro"])?$certEmpresa["giro"]:"",
                "DirRecep" => isset($certEmpresa["direccion"])?$certEmpresa["direccion"]:"",
                "CmnaRecep" => isset($certEmpresa["cert_comuna_id"])?$certEmpresa["cert_comuna_id"]:""
            ];       
            if ($this->request->is('get'))     
                echo json_encode($format);
            else 
                return $format;
        }
        exit;        
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
