<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\CertEmpresasController;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use OzdemirBurak\JsonCsv\File\Csv;

\sasco\LibreDTE\Sii::setAmbiente(\sasco\LibreDTE\Sii::CERTIFICACION);
define("CERT_EMP", WWW_ROOT . 'files' . DS . 'certificacion' . DS);
define("FILE_DTE", 'EnvioDTE');
define("FILE_BOLETA", 'EnvioBOLETA');
define("FILE_CONSUMO", 'EnvioCONSUMO');

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
        $certEmpresasSetPruebas = $this->paginate($this->CertEmpresasSetPruebas->find('all')->where(['estado !=' => 'eliminado']));

        $this->set(compact('certEmpresasSetPruebas'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function emisionDte($id = null)
    {

        $this->loadModel('CertComunas');
        $this->loadModel('CertSetPruebas');

        $comunas = $this->CertComunas->find('list',['idField' => 'id', 'valueField' => 'nombre'])->toArray();       
        $setPruebas = $this->CertSetPruebas->find('list', ['idField' => 'id', 'valueField' => 'nombre'])
                                            ->where(function (QueryExpression $exp, Query $q) {
                                                return $exp->in('id', [1,2,3,7]);
                                            })->toArray();
             
        $obs = '';

        $resultSetEmpresa = $this->CertEmpresasSetPruebas->find()->where(["id"=>$id])->first();
        if(empty($resultSetEmpresa)){
            $entitySetEmpresa = $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->newEntity();
        } else { 
            $entitySetEmpresa = $certEmpresasSetPrueba = $resultSetEmpresa;            
        }

        if ($this->request->is('post') && is_null($id)) {
            
            if (
                empty($this->request->data["emisor"]["RUTEmisor"]) || 
                empty($this->request->data["receptor"]["RUTRecep"]) || 
                empty($this->request->data["set_de_pruebas"]["name"]) || 
                empty($this->request->data["cafs"]) || 
                empty($this->request->data["certificado"]["firma"]) || 
                empty($this->request->data["caratula"]["FchResol"]) 
            ) {
                $this->Flash->error(__('Falta información para completar la acción. Por favor, intente nuevamente.'));
                return $this->redirect(['action' => 'index']);
            }
            
            $accion = $this->request->data["accion"];
            //carpetas set prueba
            $rutEmisor = $this->request->data["emisor"]["RUTEmisor"];
            $pruebaId = $this->request->data["cert_set_prueba_id"];
            if (!file_exists(CERT_EMP .$rutEmisor )) mkdir(CERT_EMP . $rutEmisor, 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'set_pruebas')) mkdir(CERT_EMP . $rutEmisor. DS . 'set_pruebas', 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'folios')) mkdir(CERT_EMP . $rutEmisor. DS . 'folios', 0777, true);            
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'certificado')) mkdir(CERT_EMP . $rutEmisor. DS . 'certificado', 0777, true);   
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'xml')) mkdir(CERT_EMP . $rutEmisor. DS . 'xml', 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'xml' . DS . $pruebaId)) mkdir(CERT_EMP . $rutEmisor. DS . 'xml' . DS . $pruebaId, 0777, true);            

            $set_pruebasFile = $this->request->data["set_de_pruebas"];
            $pathSETS = CERT_EMP . $rutEmisor . DS . 'set_pruebas' . DS . basename($set_pruebasFile["name"]);
            move_uploaded_file($set_pruebasFile['tmp_name'], $pathSETS);

            //emisor receptor
            $Emisor = $this->request->data["emisor"];
            $Receptor = $this->request->data["receptor"];
            $Emisor["CmnaOrigen"] = $comunas[$Emisor["CmnaOrigen"]];
            $Receptor["CmnaRecep"] = $comunas[$Receptor["CmnaRecep"]];

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
                    $pathCAF = CERT_EMP . $rutEmisor . DS . 'folios' . DS . basename($caf["nro_documento"].'.xml');
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
            foreach ($folios as $tipo => $cantidad){
                $Folios[$tipo] = new \sasco\LibreDTE\Sii\Folios(file_get_contents($pathXML.$tipo.'.xml'));
            }
                
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

            $dom = new \DOMDocument;
            $dom->preserveWhiteSpace = TRUE;
            $dom->loadXML(trim($EnvioDTE->generar()));

            // xml
            $pathXMLEnvio = CERT_EMP . $rutEmisor . DS . 'xml' . DS . $pruebaId . DS . FILE_DTE . '.xml';
            $dom->save($pathXMLEnvio); //guarda local

            if($accion=='generate') {

                header('Content-type: text/xml');
                header('Content-Disposition: attachment; filename='.FILE_DTE.'.xml');
                echo $dom->saveXML() . "\n";

            } else if($accion=='send') {

                $track_id = $EnvioDTE->enviar();
                //$track_id = '7778890';

                //data almacenamiento                
                $empresaReceptor = [
                    "id" => isset($Receptor["id"])? $Receptor["id"] : null, 
                    "rut" => $Receptor["RUTRecep"],
                    "nombre" => $Receptor["RznSocRecep"],
                    "giro" => $Receptor["GiroRecep"],
                    "direccion" => $Receptor["DirRecep"],
                    "cert_comuna_id" => $Receptor["CmnaRecep"],
                    "actividad" => null
                ];                
                // data empresas ingresadas
                $empresasTable = TableRegistry::get('CertEmpresas');

                $resultReceptor = $empresasTable->find()->where(["id"=>$empresaReceptor['id']])->first();
                $entityReceptor = isset($resultReceptor)? $resultReceptor : $empresasTable->newEntity();                
                $entityReceptor = $empresasTable->patchEntity($entityReceptor, $empresaReceptor);
                $savedReceptor = $empresasTable->save($entityReceptor);
                if(!$savedReceptor)
                    $obs .= 'No se pudo guardar/actualizar empresas receptor.'.'<br />';                
                
                // data empresa a certificar                
                $empresaEmisor = [
                    "id" => isset($Emisor["id"])? $Emisor["id"] : null, 
                    "rut" => $Emisor["RUTEmisor"],
                    "nombre" => $Emisor["RznSoc"],
                    "giro" => $Emisor["GiroEmis"],
                    "direccion" => $Emisor["DirOrigen"],
                    "cert_comuna_id" => $Emisor["CmnaOrigen"],
                    "actividad" => $Emisor["Acteco"],
                    "certificado" => str_replace(WWW_ROOT, '', $pathCERT),
                    "pass_firma" => $this->request->data["certificado"]["pass"],
                    "fecha_resolucion" => $this->request->data["caratula"]["FchResol"],
                    "numero_resolucion" => $this->request->data["caratula"]["NroResol"]
                ];

                $resultEmisor = $empresasTable->find()->where(["id"=>$empresaEmisor['id']])->first();
                $entityEmisor = isset($resultEmisor)? $resultEmisor : $empresasTable->newEntity();
                $entityEmisor = $empresasTable->patchEntity($entityEmisor, $empresaEmisor);
                $savedEmisor = $empresasTable->save($entityEmisor);

                if(!$savedEmisor)
                    $obs .= 'No se pudo guardar/actualizar empresas emisor. '; 
                
                foreach (\sasco\LibreDTE\Log::readAll() as $error)
                    $obs .= $error;

                // data set prueba de empresas
                $setPruebaEmpresa = [
                    "id" => $id, 
                    "cert_set_prueba_id" => $pruebaId,
                    "cert_empresa_id" => $savedEmisor->id,
                    "estado" => 'enviado',
                    "set_prueba_envio" => str_replace(WWW_ROOT, '', $pathSETS), 
                    "xml_envio" => str_replace(WWW_ROOT, '', $pathXMLEnvio),
                    "trackid_envio" => $track_id,
                    "observaciones_envio" => $obs
                ];
            
                $entitySetEmpresa = $this->CertEmpresasSetPruebas->patchEntity($entitySetEmpresa, $setPruebaEmpresa);
                $savedSetEmpresa = $this->CertEmpresasSetPruebas->save($entitySetEmpresa);

                if(!$savedSetEmpresa){                    
                    $this->Flash->error(__('No se pudo guardar/actualizar set prueba empresas. Por favor, intente nuevamente.'));

                } else {
                    $this->Flash->success(__('El set de prueba ha sido guardado correctamente.'));
                }
                return $this->redirect(['action' => 'index']);
                
            }
            exit;

        } /*else if($this->request->is(['patch', 'post', 'put']) && !is_null($id)) {
            $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->patchEntity($certEmpresasSetPrueba, $this->request->getData());
        }*/

        $this->set(compact('certEmpresasSetPrueba','comunas', 'setPruebas'));
    }

    public function emisionBoletas($id = null){
        
        //data form
        $this->loadModel('CertComunas');
        $this->loadModel('CertSetPruebas');

        $comunas = $this->CertComunas->find('list',['idField' => 'id', 'valueField' => 'nombre'])->toArray();       
        $setPruebas = $this->CertSetPruebas->find('list', ['idField' => 'id', 'valueField' => 'nombre'])
                                            ->where(function (QueryExpression $exp, Query $q) {
                                                return $exp->in('id', [1,2,3,7]);
                                            })->toArray();

        $empresas = new CertEmpresasController();

        $resultSetEmpresa = $this->CertEmpresasSetPruebas->find()->where(["id"=>$id])->first();
        if(empty($resultSetEmpresa)){
            $entitySetEmpresa = $certEmpresasSetPrueba = $this->CertEmpresasSetPruebas->newEntity();
        } else { 
            $entitySetEmpresa = $certEmpresasSetPrueba = $resultSetEmpresa;            
        }

        if ($this->request->is('post') && is_null($id)) {
                        
            $pruebaId = 'boletas';
            //carpetas set prueba
            $rutEmisor = $this->request->data["emisor"]["RUTEmisor"];
            if (!file_exists(CERT_EMP . $rutEmisor )) mkdir(CERT_EMP . $rutEmisor, 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'set_pruebas')) mkdir(CERT_EMP . $rutEmisor. DS . 'set_pruebas', 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'folios')) mkdir(CERT_EMP . $rutEmisor. DS . 'folios', 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'certificado')) mkdir(CERT_EMP . $rutEmisor. DS . 'certificado', 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'xml')) mkdir(CERT_EMP . $rutEmisor. DS . 'xml', 0777, true);
            if (!file_exists(CERT_EMP . $rutEmisor. DS . 'xml' . DS . $pruebaId)) mkdir(CERT_EMP . $rutEmisor. DS . 'xml' . DS . $pruebaId, 0777, true);

            //genera boleta data cabecera
            $Emisor = $this->request->data["emisor"];
            $Receptor = (isset($this->request->data["receptor"]))? $this->request->data["receptor"] : $empresas->getReceptor('15394719-8'); 
            $Emisor["CmnaOrigen"] = $comunas[$Emisor["CmnaOrigen"]];
            $Receptor["CmnaRecep"] = $comunas[$Receptor["CmnaRecep"]];
            $caratula = $this->request->data["caratula"];           
            $caratula["RutEnvia"] = $caratula["RutEmisor"] = $rutEmisor;
            $caratula["RutReceptor"] = "60803000-K"; // sii revisar en produccion            
            $set_pruebasFile = $this->request->data["set_de_pruebas"];
            $pathSETS = CERT_EMP . $rutEmisor . DS . 'set_pruebas' . DS . basename($set_pruebasFile["name"]);
            move_uploaded_file($set_pruebasFile['tmp_name'], $pathSETS);
            //cafs
            $cafs = $this->request->data["cafs"];
            $folios = [];
            if (!empty($cafs)){
                foreach($cafs as $caf){
                    $folios[$caf["nro_documento"]] = $caf["folio_desde"];
                    $cafFile = $caf["caf"];     
                    $pathCAF = CERT_EMP . $rutEmisor . DS . 'folios' . DS . basename($caf["nro_documento"].'.xml');
                    move_uploaded_file($cafFile['tmp_name'], $pathCAF);
                }                    
            }
            // obtener JSON del set de pruebas
            $documentos = $this->setBoletaJSON($pathSETS, $folios);     
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
            $Folios = [];
            $rutaXml = CERT_EMP . $rutEmisor . DS . 'folios' . DS;
            foreach ($folios as $tipo => $cantidad)
                $Folios[$tipo] = new \sasco\LibreDTE\Sii\Folios(file_get_contents($rutaXml.$tipo.'.xml'));           
            //certificado
            $certificadoFile = $this->request->data["certificado"]["firma"];
            $pathCERT = CERT_EMP . $rutEmisor . DS . 'certificado' . DS . basename($certificadoFile["name"]);
            move_uploaded_file($certificadoFile['tmp_name'], $pathCERT); 
            //firma
            $firma = [
                'file' => $pathCERT,
                'pass' => $this->request->data["certificado"]["pass"],
            ];
            $Firma = new \sasco\LibreDTE\FirmaElectronica($firma);

            //--------------------------------------------------------------------------------------
            // generar cada DTE, timbrar, firmar y agregar al sobre de EnvioBOLETA   
            $EnvioBOLETA = new \sasco\LibreDTE\Sii\EnvioDte();                                   
            foreach ($documentos as $documento) {
                $DTE = new \sasco\LibreDTE\Sii\Dte($documento);                        
                if (!$DTE->timbrar($Folios[$DTE->getTipo()]))
                    break;
                if (!$DTE->firmar($Firma))
                    break;
                $EnvioBOLETA->agregar($DTE);
            }
            $EnvioBOLETA->setCaratula($caratula);
            $EnvioBOLETA->setFirma($Firma);
            // xml
            $dom = new \DOMDocument;
            $dom->preserveWhiteSpace = TRUE;
            $dom->loadXML(trim($EnvioBOLETA->generar()));            
            $pathXMLBoletas = CERT_EMP . $rutEmisor . DS . 'xml' . DS . $pruebaId . DS . FILE_BOLETA . '.xml';
            $dom->save($pathXMLBoletas); //guarda local
            $EnvioBOLETA->loadXML(file_get_contents($pathXMLBoletas));
            //--------------------------------------------------------------------------------------
            // consumo folios: agregar detalle de boletas
            $ConsumoFolio = new \sasco\LibreDTE\Sii\ConsumoFolio();
            $ConsumoFolio->setFirma(new \sasco\LibreDTE\FirmaElectronica($firma));
            $ConsumoFolio->setDocumentos(array_keys($folios)); // [39, 61] si es sólo afecto, [41, 61] si es sólo exento    
            foreach ($EnvioBOLETA->getDocumentos() as $Dte) {
                $ConsumoFolio->agregar($Dte->getResumen());
            }
            $CaratulaEnvioBOLETA = $EnvioBOLETA->getCaratula();            
            $ConsumoFolio->setCaratula([
                'RutEmisor' => $CaratulaEnvioBOLETA['RutEmisor'],
                'FchResol' => $CaratulaEnvioBOLETA['FchResol'],
                'NroResol' => $CaratulaEnvioBOLETA['NroResol'],
            ]);            
            $ConsumoFolio->generar();
            if ($ConsumoFolio->schemaValidate()) {
                $dom = new \DOMDocument;
                $dom->preserveWhiteSpace = TRUE;
                $dom->loadXML(trim($ConsumoFolio->generar()));
                $pathXMLConsumo = CERT_EMP . $rutEmisor . DS . 'xml' . DS . $pruebaId . DS . FILE_CONSUMO . '.xml';
                $dom->save($pathXMLConsumo); //guarda local

                $accion='completo';
                if($accion=='consumo') {
                    header('Content-type: text/xml');
                    header('Content-Disposition: attachment; filename='.FILE_CONSUMO.'.xml');
                    echo $dom->saveXML() . "\n";    
                } else if($accion=='boletas') {
                    header('Content-type: text/xml');
                    header('Content-Disposition: attachment; filename='.FILE_BOLETA.'.xml');
                    $dom->save($pathXMLBoletas); //guarda local
                    echo $dom->saveXML() . "\n";
                } else if($accion=='completo') {

                    //$track_id = $ConsumoFolio->enviar();
                    $track_id = '789456123';

                    $Caratula = $EnvioBOLETA->getCaratula();
                    $Documentos = $EnvioBOLETA->getDocumentos();

                    // directorio temporal para guardar los PDF
                    $dir = sys_get_temp_dir().'/dte_'.$Caratula['RutEmisor'].'_'.str_replace(['-', ':', 'T'], '', $Caratula['TmstFirmaEnv']);
                    if (is_dir($dir))
                        \sasco\LibreDTE\File::rmdir($dir);
                    if (!mkdir($dir))
                        die('No fue posible crear directorio temporal para DTEs');

                    // procesar cada DTEs e ir agregándolo al PDF
                    foreach ($Documentos as $DTE) {
                        if (!$DTE->getDatos())
                            die('No se pudieron obtener los datos del DTE');
                        $pdf = new \sasco\LibreDTE\Sii\Dte\PDF\Dte(false); // =false hoja carta, =true papel contínuo (false por defecto si no se pasa)
                        $footer = [
                            'left' => 'Valparaíso: Pjse Azalea oriente 2768 Villa Alemana. WhatsApp +56 9 6589 9508',
                            'right' => 'http://www.neonet.cl',
                        ];
                        $pdf->setFooterText($footer);
                        $pdf->setLogo(CERT_EMP . $rutEmisor . DS . 'logo.png'); // debe ser PNG!
                        $pdf->setResolucion(['FchResol'=>$Caratula['FchResol'], 'NroResol'=>$Caratula['NroResol']]);
                        //$pdf->setCedible(true);
                        $pdf->agregar($DTE->getDatos(), $DTE->getTED());
                        $id = str_replace('LibreDTE_', '', $DTE->getID());                    
                        $pdf->Output(CERT_EMP . $rutEmisor. DS . 'xml' . DS . $pruebaId . DS . 'dte_'.$Caratula['RutEmisor'].'_'.$id.'.pdf', 'F');
                    }
                    // entregar archivo comprimido que incluirá cada uno de los DTEs
                    \sasco\LibreDTE\File::compress(CERT_EMP . $rutEmisor. DS . 'xml' . DS . $pruebaId, ['format'=>'zip', 'delete'=>false]);

                    $this->Flash->success(__('El set de prueba ha sido guardado correctamente.'));                
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                foreach (\sasco\LibreDTE\Log::readAll() as $error)
                    echo $error,"\n";
            }        
            exit;          
        }

        $this->set(compact('certEmpresasSetPrueba','comunas', 'setPruebas'));

    }

    /**
     * Consultar envio method
     *
     * @param string|null $id Cert Empresas Set Prueba id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function consultaEnvio($id = null){

        $observaciones = '';
        $certEmpresasSetPruebas = $this->CertEmpresasSetPruebas->get($id, [
            'contain' => ['CertEmpresas']
        ]);
        // solicitar token
        $config = [
            'firma' => [
                'file' => WWW_ROOT . $certEmpresasSetPruebas->cert_empresa->certificado,
                'pass' => $certEmpresasSetPruebas->cert_empresa->pass_firma,
            ],
        ];

        // trabajar en ambiente de certificación
        // solicitar token
        $token = \sasco\LibreDTE\Sii\Autenticacion::getToken($config['firma']);
        if (!$token) {
            foreach (\sasco\LibreDTE\Log::readAll() as $error)
                $observaciones .= $error.'. ';
            
        } else {

            // consultar estado enviado
            $rutDv = explode("-",$certEmpresasSetPruebas->cert_empresa->rut);
            $rut = $rutDv[0];
            $dv = $rutDv[1];
            $trackID = $certEmpresasSetPruebas->trackid_envio;

            $estado = \sasco\LibreDTE\Sii::request('QueryEstUp', 'getEstUp', [$rut, $dv, $trackID, $token]);
            
            // si el estado se pudo recuperar se muestra estado y glosa
            if ($estado!==false) {
                $certEmpresasSetPruebas->respuesta_envio = (string)$estado->xpath('/SII:RESPUESTA/SII:RESP_HDR/ESTADO')[0] . ': '. (string)$estado->xpath('/SII:RESPUESTA/SII:RESP_HDR/GLOSA')[0];            
            }
            
            // mostrar error si hubo
            foreach (\sasco\LibreDTE\Log::readAll() as $error)
                $observaciones .= $error.'. ';
                
        }

        $certEmpresasSetPruebas->observaciones_envio = $observaciones;
        if ($this->CertEmpresasSetPruebas->save($certEmpresasSetPruebas)) {
            $this->Flash->success(__('Registro actualizado'));
        } else {
            $this->Flash->error(__('Información no pudo ser actualizada. Por favor, intente nuevamente.'));
        }
        return $this->redirect(['action' => 'index']);
    
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
        $certEmpresasSetPrueba->estado = 'eliminado';
        if ($this->CertEmpresasSetPruebas->save($certEmpresasSetPrueba)) {
            $this->Flash->success(__('El set empresa ha sido eliminado.'));
        } else {
            $this->Flash->error(__('El set empresa no pudo ser elminado. Por favor, intente nuevamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function setBoletaJSON($file, $folios){
        $csvToArray = $this->transformCSV($file,';');
        $documentos = [];
        foreach($folios as $tipoDoc => $desde){
            switch($tipoDoc) {            
                case 39: {  
                    $tipo = $tipoDoc; 
                    $nroFolio = $desde - 1;
                    $formato = [
                            'Encabezado' => [
                                'IdDoc' => [
                                    'TipoDTE' => 39,
                                    'Folio' => 0,
                                ],
                                //'Emisor' => "",
                               // 'Receptor' => ""
                            ]
                        ];
                }
                default;
            }

            foreach($csvToArray as $caso){
                if ($caso["Folio"] != '') {
                    $index = $caso["Folio"];
                    unset($caso["Folio"]);
                    $detalles[$index][] = array_filter($caso);
                } else {                
                    unset($caso["Folio"]);
                    $detalles[$index][] = array_filter($caso);                
                }
            }
            foreach($detalles as $caso => $detalle) {
                $formato['Encabezado']['IdDoc']['Folio'] = $nroFolio + $caso;
                $formato['Detalle'] = $detalles[$caso];
                $documentos[] = $formato;
            }
        }
        return $documentos;
    }


    public function transformCSV($path, $delimiter = ';', $tipo = 'array' ){
        if (($handle = fopen($path, "r")) === false) die("can't open the file.");
        $csv_headers = fgetcsv($handle, 4000, $delimiter);
        $csv_json = array();
        while ($row = fgetcsv($handle, 4000, $delimiter))
        {    
            $csv_json[] = array_combine($csv_headers, $row);
        }
        fclose($handle);
        return ($tipo == 'array') ? $csv_json : json_encode($csv_json,JSON_PARTIAL_OUTPUT_ON_ERROR);
    }
}