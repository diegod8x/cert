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

        
        $this->loadModel('CertComunas');
        $config = AppController::config();
        $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->newEntity();
        if ($this->request->is('post')) {
            $accion = $this->request->data["accion"];
            //set prueba
            $rutEmisor = $this->request->data["emisor"]["RUTEmisor"];
            if (!file_exists(CERT_EMP .$rutEmisor )) mkdir(CERT_EMP . $rutEmisor, 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'set_pruebas')) mkdir(CERT_EMP . $rutEmisor. DS . 'set_pruebas', 0777, true);

            $set_pruebasFile = $this->request->data["set_de_pruebas"];
            $pathSETS = CERT_EMP . $rutEmisor . DS . 'set_pruebas' . DS . basename($set_pruebasFile["name"]);
            move_uploaded_file($set_pruebasFile['tmp_name'], $pathSETS);

            //emisor receptor
            $Emisor = $this->request->data["emisor"];
            $Receptor = $this->request->data["receptor"];
            $caratula = $this->request->data["caratula"];
            $caratula["RutEnvia"] = $rutEmisor;
            $caratula["RutReceptor"] = "60803000-K"; // sii revisar en produccion

            //cafs
            $cafs = $this->request->data["cafs"];
            $folios = [];
            if (!empty($cafs)){
                foreach($cafs as $caf){
                    $folios[$caf["nro_documento"]] = $caf["folio_desde"];
                    $cafFile = $caf["caf"];

                    $pathCAF = CERT_EMP . $rutEmisor . DS . 'folios' . DS . basename($cafFile["name"]);
                    move_uploaded_file($cafFile['tmp_name'], $pathCAF);
                }                    
            }

            // obtener JSON del set de pruebas
            $set_pruebasJSON = \sasco\LibreDTE\Sii\Certificacion\SetPruebas::getJSON(
                file_get_contents($pathSETS), $folios
            );
            $documentos = json_decode($set_pruebasJSON, true);      

            // asigna empresas
            $documentosDTE = [];
            foreach ($documentos as $documento){          
                if (!isset($documento["Encabezado"]["Emisor"]))
                    $documento["Encabezado"]["Emisor"] = $Emisor;
                if (!isset($documento["Encabezado"]["Receptor"]))
                    $documento["Encabezado"]["Receptor"] = $Receptor; 
                $documentosDTE[] = $documento;
            }
            $documentos = $documentosDTE;
            
            //certificado               
            //if (!file_exists(CERT_EMP .$rutEmisor ))  mkdir(CERT_EMP . $rutEmisor, 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'certificado')) mkdir(CERT_EMP . $rutEmisor. DS . 'certificado', 0777, true);   

            $certificadoFile = $this->request->data["certificado"]["firma"];
            $pathCERT = CERT_EMP . $rutEmisor . DS . 'certificado' . DS . basename($certificadoFile["name"]);
            move_uploaded_file($certificadoFile['tmp_name'], $pathCERT); 
            //firma
            $firma = [
                'file' => $pathCERT,
                'pass' => $this->request->data["certificado"]["pass"],
            ];
            $Firma = new \sasco\LibreDTE\FirmaElectronica($firma);
            $Folios = [];
            $pathXML = CERT_EMP . $rutEmisor . DS . 'folios' . DS;
            if (!file_exists($pathXML)) mkdir($pathXML, 0777, true);
            foreach ($folios as $tipo => $cantidad)
                $Folios[$tipo] = new \sasco\LibreDTE\Sii\Folios(file_get_contents($pathXML.$tipo.'.xml'));
            $EnvioDTE = new \sasco\LibreDTE\Sii\EnvioDte();

            // generar cada DTE, timbrar, firmar y agregar al sobre de EnvioDTE
            foreach ($documentos as $documento) {
                $DTE = new \sasco\LibreDTE\Sii\Dte($documento);
                if (!$DTE->timbrar($Folios[$DTE->getTipo()]))
                    break;
                if (!$DTE->firmar($Firma))
                    break;
                $EnvioDTE->agregar($DTE);
            }
            // enviar dtes y mostrar resultado del envío: track id o bien =false si hubo error
            $EnvioDTE->setCaratula($caratula);
            $EnvioDTE->setFirma($Firma);
            
            if($accion=='generate') {
              
                $dom = new \DOMDocument;
                $dom->preserveWhiteSpace = TRUE;
                $dom->loadXML(trim($EnvioDTE->generar()));
                $dom->save($pathXML);

                header('Content-type: text/xml');
                header('Content-Disposition: attachment; filename='.FILE_BOLETAS.'.xml');

                echo $dom->saveXML() . "\n";
                //file_put_contents('xml/EnvioDTE.xml', $EnvioDTE->generar()); // guardar XML en sistema de archivos
            } else if($accion=='send') {
                $track_id = $EnvioDTE->enviar();
            }

            pr($documentos);exit;

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
        $certComunas = $this->CertComunas->find('all')->select(['id','nombre'])->hydrate(false)->toArray();
        $comunas = [];
        foreach($certComunas as $comuna)
            $comunas[$comuna["id"]] = $comuna["nombre"];
       
        $certEmpresas = $this->CertEmpresasSetPruebas->CertEmpresas->find('list', ['limit' => 200]);
        $certSetPruebas = $this->CertEmpresasSetPruebas->CertSetPruebas->find('list', ['limit' => 200]);
        $this->set('comunas', $comunas);
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
