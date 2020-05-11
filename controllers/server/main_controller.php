<?php	
	require_once("../../assets/libs/nusoap-0.9.5/lib/nusoap.php");
	require_once("../../class/Util.class.php");     $objUtil 	= new Util;
	require_once("../../class/Mensaje.class.php");  $objMensaje	= new Mensaje;
	
	$parametros  = $objUtil->getFormulario($_POST);
	//highlight_string(print_r($parametros), true);
	switch($_POST['accion']){
		case "integracionFonasa":		
			if( $parametros["frm_rut"] || $parametros["frm_rut"] != 0){
				$datosFonasa       = array();
				$beneficiario      = array();
				$afiliado          = array();
				$certificado       = array();
				$client            = new soapClient("../../assets/libs/WSDL/Produccion - SONDACertificadorPrevisionalSoap.wsdl",array('trace'=>TRUE));
				$parametros_fonasa = array("query" => 
										array("queryTO" => array("tipoEmisor"  => 10,"tipoUsuario" => 1),
										"entidad" => xxxxxxx, 
										"claveEntidad" => xxxxxx, 
										"rutBeneficiario" =>$parametros['frm_rut'],         
										"dgvBeneficiario" =>$parametros['frm_DigitoRut'],
										"canal" =>10)
									);

				$client->soap_defencoding = 'UTF-8';
				$result = $client->call("getCertificadoPrevisional", $parametros_fonasa, "http://ws.fonasa.cl:8080/Certificados/Previsional");
				//var_dump($result); //cuando trae false no conecta :c, del cotrario si c:
				if ($result === false){
					$result = array("status" => "noContetar");
				}else{
				//highlight_string(print_r($result));
				if($result["getCertificadoPrevisionalResult"]["replyTO"]["errorM"]==""){				

				// Inicio Beneficiario
					$beneficiario["nombres"]            = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['beneficiarioTO']['nombres']));					
					$beneficiario["apell1"]             = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['beneficiarioTO']['apell1']));					
					$beneficiario["apell2"]             = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['beneficiarioTO']['apell2']));					
					$beneficiario["direccion"]          = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['beneficiarioTO']['direccion']));					
					$estado                             = $result['getCertificadoPrevisionalResult']['replyTO']['estado'];
					$tramo                              = $result['getCertificadoPrevisionalResult']['afiliadoTO']['tramo'];
					$parametros['frm_fechaValidador']   = date("Y-m-d");
					$parametros['frm_horaValidador']    = date("G:i:s");
					$beneficiario["fechaNacimiento"]    = $result['getCertificadoPrevisionalResult']['beneficiarioTO']['fechaNacimiento'];

					if ($result['getCertificadoPrevisionalResult']['codigoprais']=='111') {
						$certificado["cerFonasa"] = $result['getCertificadoPrevisionalResult']['coddesc'].'  '.$result['getCertificadoPrevisionalResult']['desIsapre'].'  ('.$result['getCertificadoPrevisionalResult']['descprais'].')';
					}else{
						$certificado["cerFonasa"] = $result['getCertificadoPrevisionalResult']['coddesc'].'  '.$result['getCertificadoPrevisionalResult']['desIsapre'];	
					}

					$beneficiario["folio"]       = $result['getCertificadoPrevisionalResult']['folio'];
					$beneficiario["rut"]         = $result['getCertificadoPrevisionalResult']['beneficiarioTO']['rutbenef'].'-'.$result['getCertificadoPrevisionalResult']['beneficiarioTO']['dgvbenef'];
					$beneficiario["ben_rut_sdv"] = $result['getCertificadoPrevisionalResult']['beneficiarioTO']['rutbenef'];
					$beneficiario["sexo"]        = $result['getCertificadoPrevisionalResult']['beneficiarioTO']['generoDes'];
				//Fin Beneficiario

				//Inicio Afiliado
					$afiliado["nombres"] = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['afiliadoTO']['nombres']));					
					$afiliado["apell1"]  = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['afiliadoTO']['apell1']));					
					$afiliado["apell2"]  = trim($objUtil->limpiarCaracteresEspeciales($result['getCertificadoPrevisionalResult']['afiliadoTO']['apell2']));					
					$afiliado["rut"]     = $result['getCertificadoPrevisionalResult']['afiliadoTO']['rutafili'].'-'.$result['getCertificadoPrevisionalResult']['afiliadoTO']['dgvafili'];
					$afiliado["fecnac"]  = $result['getCertificadoPrevisionalResult']['afiliadoTO']['fecnac'];
					$afiliado["grupo"]   = $result['getCertificadoPrevisionalResult']['afiliadoTO']['tramo'];
					$afiliado["sexo"]    = $result['getCertificadoPrevisionalResult']['afiliadoTO']['generoDes'];
					$afiliado["estado"]  = $result['getCertificadoPrevisionalResult']['afiliadoTO']['desEstado'];
					$datosFonasa["beneficiario"] = $beneficiario;
					$datosFonasa["afiliado"]     = $afiliado;
					$datosFonasa["certificado"]  = $certificado;					
					//$ben_id_paciente=$_GET['id_paciente'];
				//Fin Afiliado					
					//echo json_encode($datosFonasa); //ver los datos que retorna c:
					$result  = array("status" => "success", "datosFonasa" => json_encode($datosFonasa));
				}else{
					$result = array("status" => "error");
				}
				//var_dump($result);
				
				// try{
					
				// }// }catch (PDOException $e){						
				// 	$result = array("status" => "error");
				// 	echo json_encode($result);
				// }
						
					//var_dump($datosFonasa);			
					
			}
			echo json_encode($result);
		}
		
		break;
	}
	
?>