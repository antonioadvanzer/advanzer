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

	//básicas
	public function formato_comprobacion() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
		$data['colaboradores']=$this->user_model->getAll();
		$this->layout->title('Advanzer - Comprobación de Gastos');
		$this->layout->view('servicio/formato_comprobacion',$data);
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
		$this->layout->title('Advanzer - Solicita Vacaciones');
		$this->layout->view('servicio/formato_permiso',$data);
	}
	public function solicitudes() {
		$data['solicitudes'] = $this->user_model->solicitudes_pendientes($this->session->userdata('id'));
		$data['propias'] = $this->user_model->solicitudesByColaborador($this->session->userdata('id'));
		if(count($data['solicitudes']) + count($data['propias']) == 0)
			redirect();
		$this->layout->title('Advanzer - Solicitudes');
		$this->layout->view('servicio/solicitudes',$data);
	}
	public function vacaciones() {
		$data=array();
		$data['yo']=$this->user_model->searchById($this->session->userdata('id'));
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
			'motivo'=>$this->input->post('motivo')
		);
		if(!in_array($datos['motivo'],array('MATRIMONIO','NACIMIENTO DE HIJOS','FALLECIMIENTO DE CÓNYUGE','FALLECIMIENTO DE HERMANOS','FALLECIMIENTO DE HIJOS','FALLECIMIENTO DE PADRES','FALLECIMIENTO DE PADRES POLÍTICOS')))
			$datos['auth_ch']=1;
		elseif($this->input->post('un_anio')==1)
			$datos['auth_ch']=1;
		//validación de fecha de  ingreso
		if($ochoMeses=$this->input->post('ochoMeses')):
			$colaborador=$this->user_model->searchById($datos['colaborador']);
			$disponibles=$this->input->post('acumulados')+$this->input->post('disponibles');
			$desde=new DateTime($datos['desde']);
			$nueveMeses = strtotime ( '+9 month' , strtotime ( $colaborador->fecha_ingreso ) ) ;
			$nueveMeses = date ( 'Y-m-d' , $nueveMeses );
			$nueveMeses = new DateTime($nueveMeses);
			if($nueveMeses->diff($desde)->format('%r'))
				$datos['auth_ch']=1;
			//validación de días disponibles
			if($datos['dias'] > $disponibles)
			$datos['auth_ch']=1;
		endif;
		$this->db->trans_begin();
		$solicitud=$this->solicitudes_model->registra_solicitud($datos);
		$solicitud=$this->solicitudes_model->getSolicitudById($solicitud);
		if($datos['tipo']==3):
			$datos=array(
				'centro_costo'=>$this->input->post('centro'),
				'motivo_viaje'=>$this->input->post('motivo'),
				'origen'=>$this->input->post('origen'),
				'destino'=>$this->input->post('destino'),
				'hotel_flag'=>$this->input->post('hotel_flag'),
				'autobus_flag'=>$this->input->post('autobus_flag'),
				'vuelo_flag'=>$this->input->post('vuelo_flag'),
				'renta_flag'=>$this->input->post('renta_flag'),
				'gasolina_flag'=>$this->input->post('gasolina_flag'),
				'taxi_flag'=>$this->input->post('taxi_flag'),
				'mensajeria_flag'=>$this->input->post('mensajeria_flag'),
				'taxi_aero_flag'=>$this->input->post('taxi_aero_flag'),
				'tipo_vuelo'=>$this->input->post('tipo_vuelo'),
				'hotel'=>$this->input->post('hotel'),
				'ubicacion'=>$this->input->post('ubicacion'),
				'hora_salida_uno'=>$this->input->post('hora_salida_uno'),
				'fecha_salida_uno'=>$this->input->post('fecha_salida_uno'),
				'ruta_salida_uno'=>$this->input->post('ruta_salida_uno'),
				'hora_salida_dos'=>$this->input->post('hora_salida_dos'),
				'fecha_salida_dos'=>$this->input->post('fecha_salida_dos'),
				'ruta_salida_dos'=>$this->input->post('ruta_salida_dos'),
				'hora_regreso_uno'=>$this->input->post('hora_regreso_uno'),
				'fecha_regreso_uno'=>$this->input->post('fecha_regreso_uno'),
				'ruta_regreso_uno'=>$this->input->post('ruta_regreso_uno'),
				'hora_regreso_dos'=>$this->input->post('hora_regreso_dos'),
				'fecha_regreso_dos'=>$this->input->post('fecha_regreso_dos'),
				'ruta_regreso_dos'=>$this->input->post('ruta_regreso_dos')
			);
			$this->solicitudes_model->update_detalle_viaticos($solicitud,$datos);
		endif;
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Ha habido un error al registrar solicitud. Revisa los datos e intenta de nuevo o contacta al administrador";
		}
		else{
			//enviar mail de aviso al autorizador
			$destinatario=$this->user_model->searchById($solicitud->autorizador)->email;
			$data['solicitud']=$solicitud;
			$mensaje=$this->load->view("layout/solicitud/create",$data,true);
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
	public function autorizar_vacaciones() {
		$id = $this->input->post('solicitud');
		$datos['estatus']=$this->input->post('estatus');
		$this->db->trans_begin();
		$this->solicitudes_model->update_solicitud($id,$datos);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error actualizando estatus de la solicitud. Intenta de nuevo";
		}else{
			$solicitud = $this->solicitudes_model->getSolicitudById($id);
			$data['solicitud']=$solicitud;
			if($solicitud->auth_ch==1 && $solicitud->estatus == 2){
				$destinatario=array('perla.valdez@advanzer.com','micaela.llano@advanzer.com');
				$mensaje=$this->load->view("layout/solicitud/rh",$data,true);
			}else{
				$destinatario=$this->user_model->searchById($solicitud->colaborador)->email;
				$mensaje=$this->load->view("layout/solicitud/auth",$data,true);
				$this->actualiza_dias_disponibles($solicitud);
			}
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
			'estatus'=>$this->input->post('estatus'),
		);
		$id=$this->input->post('solicitud');
		$this->db->trans_begin();
		$this->solicitudes_model->update_solicitud($id,$datos);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error actualizando estatus de la solicitud. Intenta de nuevo";
		}else{
			$solicitud=$this->solicitudes_model->getSolicitudById($id);
			$data['solicitud']=$solicitud;
			$destinatario=$this->user_model->searchById($solicitud->colaborador)->email;
			$mensaje=$this->load->view("layout/solicitud/no_auth",$data,true);
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

		$this->email->from('notificaciones.ch@advanzer.com','Servicios - Portal Personal');
		$this->email->to(array('jesus.salas@advanzer.com','perla.valdez@advanzer.com','micaela.llano@advanzer.com'));//$this->email->to($destinatario);
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
}