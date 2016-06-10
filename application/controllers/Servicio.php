<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicio extends CI_Controller {
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->valida_sesion();
		$this->load->model('area_model');
		$this->load->model('track_model');
		$this->load->model('posicion_model');
		$this->load->model('user_model');
		$this->load->model('solicitudes_model');
	}

	//validaciones
	private function valida_sesion() {
		if($this->session->userdata('id') == "")
			redirect('login');
	}
	
	// change alert to activate or deactivate
	public function setAlert($solicitud, $alert){
		$this->solicitudes_model->setAlert($solicitud, $alert);
	}

	// change alert Jefe
	public function notificarJefe($solicitud, $alert){
		$this->solicitudes_model->notificarJefe($solicitud, $alert);
	}
	
	// change alert Capital Humano
	public function notificarCh($solicitud, $alert){
		$this->solicitudes_model->notificarCh($solicitud, $alert);
	}
	
	// básicas
	public function historial($tipo,$colaborador) {
		$data['colaborador']=$this->user_model->searchById($colaborador)->nombre;
		$data['solicitudes']=$this->solicitudes_model->getSolicitudByTipoColaborador($tipo,$colaborador);
		switch ($tipo) :
			case 1: $tipo='VACACIONES';						break;
			case 2: case 3:	$tipo='PERMISO DE AUSENCIA';	break;
			case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
			default: $tipo='';								break;
		endswitch;
		$data['tipo']=$tipo;
		$this->load->view('servicio/historial_solicitud',$data);
	}
	
	// Propia
	public function ver($solicitud) {
		//echo "aaa";exit;
		
		$solicitud = $this->solicitudes_model->getSolicitudById($solicitud);
		
		if(($solicitud->estatus == 3) || ($solicitud->estatus == 4)){
			$this->setAlert($solicitud->id,0);
		}
		
		$data['solicitud'] = $solicitud;
		$data['colaboradores'] = $this->user_model->getAll();
		$data['title_for_layout'] = "Advanzer - Detalle Solicitud";
		$this->load->view('servicio/detalle_solicitud',$data);
	}
	
	// Por autorizar
	public function resolver($solicitud) {
		//echo "bbb";exit;
		
		$solicitud = $this->solicitudes_model->getSolicitudById($solicitud);
		
		if((($solicitud->estatus == 1) && ($this->session->userdata('id') == $solicitud->autorizador)) 
		|| (($this->session->userdata('permisos')['administrator']) && ($solicitud->estatus == 2)) ){
			$this->setAlert($solicitud->id,0);
		}elseif(($this->session->userdata('id') == $solicitud->autorizador) && ($solicitud->not_jefe == 1)){
			$this->notificarJefe($solicitud->id,0);
		}elseif(($this->session->userdata('permisos')['administrator']) && ($solicitud->not_ch == 1)){
			$this->notificarCh($solicitud->id,0);
		}
		//var_dump($this->solicitudes_model->getDiasDisponibles($solicitud->colaborador));exit;
		
		$data['yo'] = $this->calculaVacaciones($solicitud->colaborador);
		
		$data['solicitud'] = $solicitud;
		$data['colaboradores']=$this->user_model->getAll();//var_dump($this->solicitudes_model->getAcumulados($solicitud->colaborador));exit;
		$this->load->view('servicio/resolver',$data);
	}
	
	public function formato_comprobacion() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$data['colaboradores']=$this->user_model->getAll();
		$this->layout->title('Advanzer - Comprobación de Gastos');
		$this->layout->view('servicio/formato_comprobacion',$data);
	}
	public function getViaticosInfo() {
		$datos=array(
			'colaborador'=>$this->input->post('colaborador'),
			'tipo'=>$this->input->post('tipo'),
			'centro_costo'=>$this->input->post('centro_costo')
		);
		$response['viaticos']=$this->solicitudes_model->getViaticosInfo($datos);
		echo json_encode($response);
	}
	public function viaticos_gastos() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$this->layout->title('Advanzer - Viáticos y Gastos de Viaje');
		$this->layout->view('servicio/viaticos_gastos',$data);
	}
	public function formato_viaticos_gastos() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$data['colaboradores']=$this->user_model->getAll();
		$this->layout->title('Advanzer - Solicita Viáticos');
		$this->layout->view('servicio/formato_viaticos',$data);
	}
	public function formato_gastos() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$data['colaboradores']=$this->user_model->getAll();
		$this->layout->title('Advanzer - Solicita Gastos de Viaje');
		$this->layout->view('servicio/formato_gastos',$data);
	}
	public function permiso() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$this->layout->title('Advanzer - Permiso');
		$this->layout->view('servicio/permiso',$data);
	}
	
	public function formato_permiso() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$data['colaboradores']=$this->user_model->getAll();
		$this->layout->title('Advanzer - Solicita Permiso');
		$this->layout->view('servicio/formato_permiso',$data);
	}
	
	// Relación de solicitudes propias
	public function solicitudes() {
		
		$tipo = $this->input->get("tipo");
		
		switch($tipo){

			case 'vacaciones':
				$data['propias'] = $this->user_model->getSolicitudesVacaciones($this->session->userdata('id'));
				$data['option'] = 1;
			break;
			case 'permiso':
				$data['propias'] = $this->user_model->getSolicitudesPermisosAusencia($this->session->userdata('id'));
				$data['option'] = 2;
			break;
			default:
				$data['propias'] = $this->user_model->solicitudesByColaborador($this->session->userdata('id'));
				$data['option'] = 3;
			break;
		}
		
		if(count($data['propias']) == 0)
			redirect();
		
		$this->layout->title('Advanzer - Solicitudes');
		$this->layout->view('servicio/solicitudes',$data);
	}
	
	
	
	// Relación de solicitudes por autorizar, si eres jefe o perteneces a capital humano
	public function solicitudes_pendientes() {
		
		$data['solicitudes'] = $this->user_model->solicitudes_pendientes($this->session->userdata('id'));
		
		if($this->session->userdata('permisos')['administrator']){
			$data['solicitudes'] = array_merge($data['solicitudes'],$this->user_model->solicitudes_autorizar_ch());
		}
		
		if(count($data['solicitudes']) == 0)
			redirect();
		
		$this->layout->title('Advanzer - Solicitudes');
		$this->layout->view('servicio/solicitudes_pendientes',$data);
	}
	
	public function calculaVacaciones($colaborador){
		$data=array();
		$result=$this->user_model->searchById($colaborador);
		$ingreso=new DateTime($result->fecha_ingreso);
		$hoy=new DateTime(date('Y-m-d'));
		$diff = $ingreso->diff($hoy);
		switch($diff->y){
			case 0:
				$dias=0;
				$dias2=6;
				$disponibles=floor(($diff->days-($diff->y*365))*6/365);
				break;
			case 1:
				$dias=6;
				$dias2=8;
				break;
			case 2:
				$dias=8;
				$dias2=10;
				break;
			case 3:
				$dias=10;
				$dias2=12;
				break;
			case 4:case 5:case 6:case 7:case 8:
				$dias=10;
				$dias2=14;
				break;
			case 9:case 10:case 11:case 12:case 13:
				$dias=14;
				$dias2=16;
				break;
			case 14:case 15:case 16:case 17:case 18:
				$dias=16;
				$dias2=18;
				break;
			case 19:case 20:case 21:case 22:case 23:
				$dias=18;
				$dias2=20;
				break;
			default:
				$dias=20;
				$dias2=22;
				break;
		}
		$result->disponibles=floor(($diff->days-($diff->y*365))*$dias2/365);
		$result->extra=$dias2-$result->disponibles;
		$result->de_solicitud=0;
		if($dias_disponibles=$this->solicitudes_model->getDiasDisponibles($result->id)){
			$result->de_solicitud=$dias_disponibles;
			$result->disponibles += (int)$dias_disponibles;
		}
		
		$result->acumulados=$this->solicitudes_model->getAcumulados($result->id);
		
		return $result;
	}
	
	public function vacaciones() {
		
		$data['yo'] = $this->calculaVacaciones($this->session->userdata('id'));
		$this->layout->title('Advanzer - Vacaciones');
		$this->layout->view('servicio/vacaciones',$data);
	}
	
	public function formato_vacaciones() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$data['colaboradores']=$this->user_model->getAll();
		$this->layout->title('Advanzer - Solicita Vacaciones');
		$this->layout->view('servicio/formato_vacaciones',$data);
	}

	public function cambia_estatus_comprobante() {
		$solicitud = $this->input->post('solicitud');
		$id = $this->input->post('comprobante');
		$datos['estatus'] = $this->input->post('estatus');
		if($this->solicitudes_model->update_comprobante($id,$datos)){
			$response['msg']="ok";
			$solicitud=$this->solicitudes_model->getSolicitudById($solicitud);
			$pendientes=$this->solicitudes_model->getComprobantesPendientes($solicitud->id);
			if(count($pendientes)==0)
				$this->solicitudes_model->update_solicitud($solicitud->id,array('estatus'=>3));
		}else
			$response['msg']="Error";
		echo json_encode($response);
	}
	public function getColabInfo() {
		$tipo=$this->input->post('tipo');
		$dias_disponibles=0;
		$result = $this->user_model->searchById($this->input->post('colaborador'));
		$result->solicitud = $this->solicitudes_model->getByColaborador($result->id,$tipo);
		$ingreso=new DateTime($result->fecha_ingreso);
		$hoy=new DateTime(date('Y-m-d'));
		$result->diff = $ingreso->diff($hoy);
		switch($result->diff->y){
			case 0:
				$dias=0;
				$dias2=6;
				$disponibles=floor(($result->diff->days-($result->diff->y*365))*6/365);
				break;
			case 1:
				$dias=6;
				$dias2=8;
				break;
			case 2:
				$dias=8;
				$dias2=10;
				break;
			case 3:
				$dias=10;
				$dias2=12;
				break;
			case 4:case 5:case 6:case 7:case 8:
				$dias=10;
				$dias2=14;
				break;
			case 9:case 10:case 11:case 12:case 13:
				$dias=14;
				$dias2=16;
				break;
			case 14:case 15:case 16:case 17:case 18:
				$dias=16;
				$dias2=18;
				break;
			case 19:case 20:case 21:case 22:case 23:
				$dias=18;
				$dias2=20;
				break;
			default:
				$dias=20;
				$dias2=22;
				break;
		}
		$fecha_minima = strtotime('+9 month',strtotime($result->fecha_ingreso));
		$fecha_minima = date('Y-m-d',$fecha_minima);
		$f_m = new DateTime($fecha_minima);
		if($hoy->diff($f_m)->format('%r'))
			$result->fecha_minima = date('Y-m-d');
		else
			$result->fecha_minima = $fecha_minima;
		$ochoMeses = strtotime ( '+8 month' , strtotime ( $result->fecha_ingreso ) ) ;
		$ochoMeses = date ( 'Y-m-d' , $ochoMeses );
		$ochoMeses = new DateTime($ochoMeses);
		$result->disponibles=floor(($result->diff->days-($result->diff->y*365))*$dias2/365);
		$result->extra=$dias2-$result->disponibles;
		if($dias_disponibles=$this->solicitudes_model->getDiasDisponibles($result->id))
			$result->disponibles += (int)$dias_disponibles;
		$result->acumulados=$this->solicitudes_model->getAcumulados($result->id);
		if($hoy->diff($ochoMeses)->format('%r'))
			$result->ochoMeses=1;
		else
			$result->ochoMeses=0;
		echo json_encode($result,JSON_NUMERIC_CHECK);
	}
	public function registra_solicitud() {
		$datos=array(
			'colaborador'=>$this->input->post('colaborador'),
			'autorizador'=>$this->input->post('autorizador'),
			'dias'=>$this->input->post('dias'),
			'desde'=>$this->input->post('desde'),
			'hasta'=>$this->input->post('hasta'),
			'regresa'=>$this->input->post('regresa'),
			'observaciones'=>$this->input->post('observaciones'),
			'tipo'=>$this->input->post('tipo'),
			'motivo'=>$this->input->post('motivo'),
			'fecha_solicitud'=>date('Y-m-d'),
			'usuario_modificacion'=>$this->session->userdata('id'),
			'alerta' => 1
		);
		
		$not = false;
		
		if(in_array($datos['motivo'],array("ENFERMEDAD","MATRIMONIO","NACIMIENTO DE HIJOS","FALLECIMIENTO DE CÓNYUGE","FALLECIMIENTO DE HERMANOS","FALLECIMIENTO DE HIJOS","FALLECIMIENTO DE PADRES","FALLECIMIENTO DE PADRES POLÍTICOS"))){
			$datos['estatus']=4;
			$not=true;
		}
		$this->db->trans_begin();
		$solicitud=$this->solicitudes_model->registra_solicitud($datos);
		$solicitud=$this->solicitudes_model->getSolicitudById($solicitud);
		
		if($not){
			$this->notificarJefe($solicitud->id,1);
			$this->notificarCh($solicitud->id,1);
		}
		
		if($datos['tipo']==4):
			$data=array(
				'centro_costo'=>$this->input->post('centro'),
				'origen'=>$this->input->post('origen'),
				'destino'=>$this->input->post('destino'),
				'hotel_flag'=>$this->input->post('hotel_flag'),
				'autobus_flag'=>$this->input->post('autobus_flag'),
				'vuelo_flag'=>$this->input->post('vuelo_flag'),
				'comida_flag'=>$this->input->post('comida_flag'),
				'renta_flag'=>$this->input->post('renta_flag'),
				'gasolina_flag'=>$this->input->post('gasolina_flag'),
				'taxi_flag'=>$this->input->post('taxi_flag'),
				'mensajeria_flag'=>$this->input->post('mensajeria_flag'),
				'taxi_aero_flag'=>$this->input->post('taxi_aero_flag'),
				'tipo_vuelo'=>$this->input->post('tipo_vuelo'),
				'hora_salida'=>$this->input->post('hora_salida'),
				'fecha_salida'=>$this->input->post('fecha_salida'),
				'ruta_salida'=>$this->input->post('ruta_salida'),
				'hora_regreso'=>$this->input->post('hora_regreso'),
				'fecha_regreso'=>$this->input->post('fecha_regreso'),
				'ruta_regreso'=>$this->input->post('ruta_regreso'),
				'hospedaje'=>$this->input->post('hospedaje'),
				'num_recompensa'=>$this->input->post('recompensas')
			);
			$this->solicitudes_model->update_detalle_viaticos($solicitud->id,$data);
		endif;
		if(in_array($datos['tipo'],array(2,3)) && !empty($_FILES)):
			$config['upload_path'] = './assets/docs/permisos/';
			$config['file_name'] = 'permiso_'.$solicitud->id;
			$config['overwrite'] = TRUE;
			$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
			$this->upload->do_upload('file');
		endif;
		if($datos['tipo']==5):
			$datos=array(
				'solicitud'=>$solicitud->id,
				'centro_costo'=>$this->input->post('centro_costo'),
				'fecha'=>$this->input->post('fecha')[0],
				'concepto'=>$this->input->post('concepto')[0],
				'prestador'=>$this->input->post('prestador')[0],
				'importe'=>$this->input->post('importe')[0],
				'iva'=>$this->input->post('iva')[0],
				'total'=>$this->input->post('total')[0]
			);
			$comprobante=$this->solicitudes_model->registra_comprobante($datos);
			if($_FILES['factura']['tmp_name']!=""):
				$config['upload_path'] = './assets/docs/facturas/';
				$config['allowed_types'] = 'xml';
				$config['file_name'] = $comprobante.'.xml';
				$config['overwrite'] = TRUE;
				//load upload class library
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('factura'))
					$response['msg'] = $this->upload->display_errors();
			endif;
			$solicitud=$this->solicitudes_model->getSolicitudById($solicitud->id);
		endif;
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Ha habido un error al registrar solicitud. Revisa los datos e intenta de nuevo o contacta al administrador";
		}
		else{
			//enviar mail de aviso al autorizador
			$data['solicitud']=$solicitud;
			if(in_array($datos['motivo'],array("ENFERMEDAD","MATRIMONIO","NACIMIENTO DE HIJOS","FALLECIMIENTO DE CÓNYUGE","FALLECIMIENTO DE HERMANOS","FALLECIMIENTO DE HIJOS","FALLECIMIENTO DE PADRES","FALLECIMIENTO DE PADRES POLÍTICOS"))){
				$destinatario=array($this->user_model->searchById($solicitud->autorizador)->email,'micaela.llano@advanzer.com');
				$mensaje=$this->load->view("layout/solicitud/notificacion",$data,true);
			}elseif($solicitud->tipo==5){
				$destinatario='viaticos@advanzer.com';
				$mensaje=$this->load->view("layout/solicitud/comprobantes",$data,true);
			}else{
				$destinatario=$this->user_model->searchById($solicitud->autorizador)->email;
				$mensaje=$this->load->view("layout/solicitud/create",$data,true);
			}
			if(!$this->sendMail($destinatario,$mensaje)){
				$this->db->trans_commit();
				$response['msg']="ok";
			}
			else{
				$this->db->trans_rollback();
				$response['msg']="No se pudo enviar correo de notificación. Intenta de nuevo";
			}
		} $this->setAlert($solicitud->id,1);
		echo json_encode($response);
	}
	
	public function autorizar_solicitud() {
	
		$id = $this->input->post('solicitud');
		$datos['estatus']=$this->input->post('estatus');
		$datos['razon']=$this->input->post('comentarios');
		$datos['auth_uno']=1;
		$datos['usuario_modificacion']=$this->session->userdata('id');
		$this->db->trans_begin();
		$this->solicitudes_model->update_solicitud($id,$datos);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error actualizando estatus de la solicitud. Intenta de nuevo";
		}else{
			$solicitud = $this->solicitudes_model->getSolicitudById($id);
			$data['solicitud']=$solicitud;
			if($solicitud->estatus == 2){
				$destinatario='micaela.llano@advanzer.com';
				$mensaje=$this->load->view("layout/solicitud/rh",$data,true);
			}else{
				$destinatario=$this->user_model->searchById($solicitud->colaborador)->email;
				$mensaje=$this->load->view("layout/solicitud/auth",$data,true);
				if($solicitud->tipo == 4){
					$this->genera_excel($solicitud);
					$dest=array('viaticos@advanzer.com','recepcion@advanzer.com');
					$msj=$this->load->view('layout/solicitud/viaticos',$data,true);
					$this->sendMail($dest,$msj);
				}
			}
			
			/*$this->setAlert($solicitud->id,1);
			$this->db->trans_commit();$response['msg']="ok";*/
			if(!$this->sendMail($destinatario,$mensaje)){
				$this->db->trans_commit();
				$response['msg']="ok";
			}
			else{
				$this->db->trans_rollback();
				$response['msg']="No se pudo enviar correo de notificación. Intenta de nuevo";
			}
		}
		$this->setAlert($solicitud->id,1);
		echo json_encode($response);
	}
	
	public function confirmar_anticipo() {
		$datos['anticipo']=$this->input->post('anticipo');
		$id=$this->input->post('solicitud');
		$this->db->trans_begin();
		$this->solicitudes_model->update_detalle_viaticos($id,$datos);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error aplicando el anticipo de viáticos. Intenta de nuevo";
		}else{
			$solicitud=$this->solicitudes_model->getSolicitudById($id);
			$data['solicitud']=$solicitud;
			$data['anticipo']=$datos['anticipo'];
			$destinatario=$this->user_model->searchById($solicitud->colaborador)->email;
			$mensaje=$this->load->view("layout/solicitud/anticipo",$data,true);
			if(!$this->sendMail($destinatario,$mensaje)){
				$this->db->trans_commit();
				$response['msg']="ok";
			}
			else{
				$this->db->trans_rollback();
				$response['msg']="No se pudo enviar correo de notificación. Intenta de nuevo";
			}
		}
		echo json_encode($response);
	}
	public function rechazar_solicitud() {
		$datos=array(
			'razon'=>$this->input->post('razon'),
			'estatus'=>($estado = $this->input->post('estatus')),
			'usuario_modificacion'=>$this->session->userdata('id')
		);
		
		$id=$this->input->post('solicitud');
		$this->db->trans_begin();
		$estatus=$this->solicitudes_model->getSolicitudById($id)->estatus;
		$this->solicitudes_model->update_solicitud($id,$datos);
		
		if($estado == 0){
			$this->notificarJefe($id,1);
			$this->notificarCh($id,1);
		}
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error actualizando estatus de la solicitud. Intenta de nuevo";
		}else{
			$solicitud=$this->solicitudes_model->getSolicitudById($id);
			$data['solicitud']=$solicitud;
			$destinatario=$this->user_model->searchById($solicitud->colaborador)->email;
			$mensaje=$this->load->view("layout/solicitud/no_auth",$data,true);
			//if(!in_array($solicitud->tipo,array(4,5)))
				
				if($estado == 0){
					$dest=array($this->user_model->searchById($solicitud->autorizador)->email,'micaela.llano@advanzer.com');
					$msj=$this->load->view("layout/solicitud/cancela",$data,true);
					$this->sendMail($dest,$msj);
				}
				
				if($estatus == 2){
				
					//$this->setAlert($solicitud->id,1);
					$dest=$this->user_model->searchById($solicitud->autorizador)->email;
					$msj=$this->load->view("layout/solicitud/cancela",$data,true);
					$this->sendMail($dest,$msj);
				
				}elseif($estatus == 3){
					//$this->setAlert($solicitud->id,1);
					$dest=array($this->user_model->searchById($solicitud->autorizador)->email,'micaela.llano@advanzer.com');
					$msj=$this->load->view("layout/solicitud/cancela",$data,true);
					$this->sendMail($dest,$msj);
				}
				/*$this->db->trans_commit();
				$response['msg']="ok";*/
			if(!$this->sendMail($destinatario,$mensaje)){
				$this->db->trans_commit();
				$response['msg']="ok";
			}
			else{
				$this->db->trans_rollback();
				$response['msg']="No se pudo enviar correo de notificación. Intenta de nuevo";
			}
		}
		$this->setAlert($solicitud->id,1);
		echo json_encode($response);
	}

	public function sendMail($destinatario,$mensaje){
		$this->load->library("email");

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'notificaciones.ch@advanzer.com',
			'smtp_pass' => 'CapitalAdv1',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
		);

		$this->email->initialize($config);
		$this->email->clear(TRUE);

		$this->email->from('notificaciones.ch@advanzer.com','Solicitudes - Portal Personal');
		//$this->email->to($destinatario);
		$this->email->to('antonio.baez@advanzer.com');
		//$this->email->to('jesus.salas@advanzer.com');//,'perla.valdez@advanzer.com','micaela.llano@advanzer.com'));
		$this->email->subject('Aviso de Solicitud');
		$this->email->message($mensaje);

		if(!$this->email->send())
			return var_dump($this->email->print_debugger());
		else
			return false;
	}

	private function actualiza_dias_disponibles($solicitud) {
		$acumulados=$this->solicitudes_model->getAcumulados($solicitud->colaborador);
		$colaborador = $this->user_model->searchById($solicitud->colaborador);
		if($acumulados){
			$dias_acumulados=(int)$acumulados->dias_dos+(int)$acumulados->dias_uno-$solicitud->dias;
			if($solicitud->dias > $acumulados->dias_uno){
				$datos['dias_uno']=null;
				$datos['vencimiento_uno']=null;
				$dias_acumulados=$acumulados->dias_uno - $solicitud->dias;
				if($acumulados->dias_dos){
					$dias_acumulados=($acumulados->dias_uno+$acumulados->dias_dos) - $solicitud->dias;
					if($solicitud->dias > $acumulados->dias_dos+$acumulados->dias_uno){
						$datos['dias_dos']=null;
						$datos['vencimiento_dos']=null;
					}else{
						$datos['dias_uno']=$dias_acumulados;
						$datos['vencimiento_uno']=$acumulados->vencimiento_dos;
						$datos['dias_dos']=null;
						$datos['vencimiento_dos']=null;
					}
				}
			}else{
				$datos['dias_uno']=$dias_acumulados;
			}
		}else{
			$dias_acumulados=$solicitud->dias * -1;
		}
		$datos['dias_acumulados']=$dias_acumulados;
		$this->solicitudes_model->actualiza_dias_vacaciones($colaborador->id,$datos);
	}

	private function genera_excel($solicitud) {
		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Portal Personal - Solicitudes - Advanzer de México")
			->setLastModifiedBy("Portal Personal")
			->setTitle("Detalle de Solicitud")
			->setSubject("Detalle de Solicitud")
			->setDescription("Detallado de nueva solicitud de Viáticos y Gastos de Viaje");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		//Style head
			$objSheet = $objPHPExcel->getActiveSheet(0);
			$objSheet->setTitle('Detalle Solicitud');
			$objSheet->getStyle('A1:V1')->getFont()->setBold(true)->setName('Calibri')->setSize(12)->getColor()->setRGB('FFFFFF');
			$objSheet->getStyle('A1:V1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle('A1:V1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A1:V1')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'5FC16F')));
			$objSheet->getRowDimension(1)->setRowHeight(35);

		// write header
			$objSheet->getCell('A1')->setValue('AÑO');
			$objSheet->getCell('B1')->setValue('MES');
			$objSheet->getCell('C1')->setValue('F.COMPRA');
			$objSheet->getCell('D1')->setValue('NOMBRE');
			$objSheet->getCell('E1')->setValue('RUTA');
			$objSheet->getCell('F1')->setValue('CENTRO DE COSTO');
			$objSheet->getCell('G1')->setValue('FECHA SALIDA');
			$objSheet->getCell('H1')->setValue('FECHA REGRESO');
			$objSheet->getCell('I1')->setValue('HORARIO SALIDA');
			$objSheet->getCell('J1')->setValue('HORARIO REGRESO');
			$objSheet->getCell('K1')->setValue('AEROLINEA');
			$objSheet->getCell('L1')->setValue('COSTO');
			$objSheet->getCell('M1')->setValue('CLAVE');
			$objSheet->getCell('N1')->setValue('CARGO X SERVICIO');
			$objSheet->getCell('O1')->setValue('AGENCIA');
			$objSheet->getCell('P1')->setValue('CARGO');
			$objSheet->getCell('Q1')->setValue('FACTURA CXS');
			$objSheet->getCell('R1')->setValue('CLAVE AGENCIA');
			$objSheet->getCell('S1')->setValue('FACTURA AEROLINEA');
			$objSheet->getCell('T1')->setValue('TARIIFA NORMAL');
			$objSheet->getCell('U1')->setValue('EJECUTIVO');
			$objSheet->getCell('V1')->setValue('F VIATICO');

		//write content
			$fecha=strtotime($solicitud->fecha_solicitud);
			$hora_salida=strtotime($solicitud->detalle->hora_salida);
			$hora_regreso=strtotime($solicitud->detalle->hora_regreso);
			$objSheet->getCell('A2')->setValue(date('Y',$fecha));
			$objSheet->getCell('B2')->setValue(strftime('%B',$fecha));
			$objSheet->getCell('C2')->setValue('');
			$objSheet->getCell('D2')->setValue($solicitud->nombre_solicita);
			$objSheet->getCell('E2')->setValue($solicitud->detalle->origen.' - '.$solicitud->detalle->destino);
			$objSheet->getCell('F2')->setValue($solicitud->detalle->centro_costo);
			$objSheet->getCell('G2')->setValue($solicitud->detalle->fecha_salida);
			$objSheet->getCell('H2')->setValue($solicitud->detalle->fecha_regreso);
			$objSheet->getCell('I2')->setValue(strftime('%H:%M',$hora_salida));
			$objSheet->getCell('J2')->setValue(strftime('%H:%M',$hora_regreso));
			$objSheet->getCell('K2')->setValue('');
			$objSheet->getCell('L2')->setValue('');
			$objSheet->getCell('M2')->setValue('');
			$objSheet->getCell('N2')->setValue('');
			$objSheet->getCell('O2')->setValue('');
			$objSheet->getCell('P2')->setValue('');
			$objSheet->getCell('Q2')->setValue('');
			$objSheet->getCell('R2')->setValue('');
			$objSheet->getCell('S2')->setValue('');
			$objSheet->getCell('T2')->setValue('');
			$objSheet->getCell('U2')->setValue('');
			$objSheet->getCell('V2')->setValue($solicitud->id);
			$objSheet->getStyle('A2:AD2')->getAlignment()->setWrapText(true);
			$objSheet->getRowDimension(2)->setRowHeight(-1);

		//style content
			$objSheet->getStyle('G2')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
			$objSheet->getStyle('H2')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

		$file_name = "solicitud_".$solicitud->id.".xlsx";

		$objWriter->save(getcwd()."/assets/docs/$file_name");
	}

	public function leeXML() {
		if($_FILES['factura']['tmp_name']!=""):
			$this->load->helper('xml');
			$xml = simplexml_load_file($_FILES['factura']['tmp_name']);
			foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante):
				$response['fecha'] = substr($cfdiComprobante['fecha'],0,10);
				$response['subTotal'] = $cfdiComprobante['subTotal'];
				$response['total'] = $cfdiComprobante['total'];
			endforeach;
			foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor)
					$response['prestador'] = $Emisor['nombre'];
			foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos') as $Traslado)
				$response['iva'] = $Traslado['totalImpuestosTrasladados'][0];
			echo json_encode($response);
		endif;
	}
}