<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisicion extends CI_Controller {
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->load->model('area_model');
		$this->load->model('track_model');
		$this->load->model('posicion_model');
		$this->load->model('user_model');
		$this->load->model('requisicion_model');
	}

	//validaciones
	private function valida_sesion() {
		if($this->session->userdata('id') == "")
			redirect('login');
	}

	//basicas
	public function index(){
		$this->valida_sesion();
		$colaborador=$this->user_model->searchById($this->session->userdata('id'));
		$data=array();
		
		// actualizamos las requisiciones que han espirado
		$this->updateRequisicionExpire();
		
		// get data form url 
		//var_dump($this->input->get("status"));exit;
		$status =  $this->input->get("status");
		//echo $flag;exit;
		//var_dump($colaborador->id);exit;
		//echo $colaborador->nivel_posicion;exit;
		//echo $colaborador->tipo;exit;
		//echo $colaborador->area; exit;
		
		$option = 0;
		
		// Evaluamos primero el puesto despues el area, y al final los permisos especiales (tipo de acceso)
		if((($colaborador->nivel_posicion <= 5) || ($colaborador->tipo == 3) || ($colaborador->tipo == 4)) && ($status == "own")){
			$option = 1;
		}elseif((($colaborador->tipo == 4) && ($colaborador->area == 4)) && ($status == "all" || $status == 0 || $status == 1 || $status == 2 || $status == 3 || $status == 4 || $status == 5 || $status == 6 || $status == 7 || $status == 8)){
			$option = 2;
		}/*elseif(((($tipo = $colaborador->tipo) == 5) || ($tipo == 3)) && ($status == "own")){
			$option = 1;
		}elseif(((($tipo = $colaborador->tipo) == 5) || ($tipo == 4)) && ($status == "all" || $status == 0 || $status == 1 || $status == 2 || $status == 3 || $status == 4 || $status == 5 || $status == 6 || $status == 7)){
			$option = 2;
		}else{
			
		}*/
		
		// Dependiendo del caso presentado se elige una funcion, si no tiene permisos se regresa a la vista principal
		switch($option){
			case 0:
				redirect('/', 'refresh');
			break;
			case 1:
				$data['requisiciones']=$this->requisicion_model->getOwnRequisiciones($colaborador->id);
			break;
			case 2:
				if(($status == 0) && ($status != "all")){
					$data['requisiciones'] = array_merge($this->requisicion_model->getRequisiciones(0),$this->requisicion_model->getRequisiciones(5));
				}else{
					$data['requisiciones'] = $this->requisicion_model->getRequisiciones($status);
				}
			break;
		}
		
		//echo count($data['requisiciones']);exit;
		/*if(($status == "own" && $option) || (true)):
			$data['requisiciones']=$this->requisicion_model->getOwnRequisiciones($colaborador);
		elseif($status == "all" || $status == 0 || $status == 1 || $status == 2 || $status == 3 || $status == 4 || $status == 5 || $status == 6 || $status == 7):
			$data['requisiciones']=$this->requisicion_model->getRequisiciones($status);
		endif;*/
						
		$data['pr'] = in_array($colaborador->tipo,array(5,3)) || ($colaborador->posicion <=5);
		
		$this->layout->title('Advanzer - Requisiciones');
		$this->layout->view('requisicion/index',$data);
	}
	
	// Verificar las requisiciones actuales, en general
	private function updateRequisicionExpire(){
		$this->requisicion_model->expireRequisicion(30);
	}
	
	public function ver($id){
		$this->valida_sesion();
		$this->layout->title('Advanzer - Detalle Requisición');
		$data=array();
		$data['requisicion'] = $this->requisicion_model->getById($id);
		
		// Necesary to get info about position, area and permission
		$colaborador=$this->user_model->searchById($this->session->userdata('id'));
		
		if($data['requisicion']->tipo_requisicion==1):
			$data['areas'] = $this->area_model->getAll();
			$data['tracks'] = $this->track_model->getAll();
			$data['posiciones'] = $this->posicion_model->getByTrack($data['requisicion']->track);
			$data['directores'] = $this->user_model->getDirectores();		
			$data['colaboradores'] = $this->user_model->getPagination(1);
			
			// Set permission to use tools

			$tools = array();
			
			$rs = $data['requisicion']->estatus;
			$ct = $colaborador->tipo;
			$ca = $colaborador->area;
			$solicitante = $data['requisicion']->solicita;
			$director = $data['requisicion']->director;
			$autorizador = $data['requisicion']->autorizador;
			
			if((($ct == 4) && ($ca == 4)) && ($rs == 3) && ( $solicitante == $colaborador->id)){
				
				$tools[] = 4;
				$tools[] = 5;
				$tools[] = 7;
				$tools[] = 9;
				
				$this->requisicion_model->setAlert($id,0);
				
			}elseif((($ct == 4) && ($ca == 4)) && ($rs == 7) && ( $solicitante == $colaborador->id)){
				
				$tools[] = 4;
				$tools[] = 5;
				$tools[] = 8;
				
				$this->requisicion_model->setAlert($id,0);
				
			}elseif((($ct == 4) && ($ca == 4)) && ($rs == 8) && ( $solicitante == $colaborador->id)){
				
				$tools[] = 4;
				$tools[] = 5;
				$tools[] = 10;
				
				$this->requisicion_model->setAlert($id,0);
				
			}elseif((($ct == 4) && ($ca == 4)) && ($rs == 3)){
			
				$tools[] = 4;
				$tools[] = 5;
				$tools[] = 7;
				$tools[] = 9;
			
			}elseif((($ct == 4) && ($ca == 4)) &&  ($rs == 7)){
			
				$tools[] = 4;
				$tools[] = 5;
				$tools[] = 8;
			
			}elseif((($ct == 4) && ($ca == 4)) &&  ($rs == 8)){
			
				$tools[] = 4;
				$tools[] = 5;
				$tools[] = 10;
			
			}elseif(($rs == 0) && ( $solicitante == $colaborador->id)){	
			
				// Cambiar a "visto" la Requisición si esta se ha leido
				$this->requisicion_model->setAlert($id,0);
			
			}elseif(($rs == 1) && ( $solicitante == $colaborador->id)){
			
				$tools[] = 4;
				$tools[] = 5;
			
			}elseif(($rs == 2) && ( $solicitante == $colaborador->id)){
			
				$tools[] = 4;
				$tools[] = 5;
			
			}elseif(($rs == 3) && ( $solicitante == $colaborador->id)){
			
				$tools[] = 4;
				$tools[] = 5;
				//$tools[] = 7;
				//$tools[] = 9;
				
				// Cambiar a "visto" la Requisición si esta se ha leido
				$this->requisicion_model->setAlert($id,0);
				
			}elseif(($rs == 4) && ( $solicitante == $colaborador->id)){
			
				// Cambiar a "visto" la Requisición si esta se ha leido
				$this->requisicion_model->setAlert($id,0);
				
			}elseif(($rs == 5) && ( $solicitante == $colaborador->id)){
				
				$tools[] = 6;
				
				$this->requisicion_model->setAlert($id,0);
				
			}/*elseif(($data['requisicion']->estatus == 7) && ( $data['requisicion']->solicita == $colaborador->id)){
				$tools[] = 8;
			}*/elseif((($rs == 1) || ($rs == 2)) && (($director == $colaborador->id) && ($autorizador == $colaborador->id))){
				
				$tools[] = 2;
				$tools[] = 3;
				$tools[] = 5;
				
				$this->requisicion_model->setAlert($id,0);
				
			}elseif(($rs == 1) && ( $director == $colaborador->id)){
				
				$tools[] = 1;
				$tools[] = 2;
				$tools[] = 4;
				$tools[] = 5;
				
				$this->requisicion_model->setAlert($id,0);
				
			}elseif(($rs == 2) && ( $autorizador == $colaborador->id)){
				
				$tools[] = 2;
				$tools[] = 3;
				$tools[] = 5;
				
				$this->requisicion_model->setAlert($id,0);
				
			}/*elseif(($rs == 2) && ( $data['requisicion']->autorizador == $colaborador->id)){
			
				$tools[] = 2;
				$tools[] = 3;
				$tools[] = 5;
				
				$this->requisicion_model->setAlert($id,0);
			
			}elseif(((($colaborador->tipo == 4)) || ($colaborador->area == 4)) && (($rs != 0) && ($rs != 4) && ($rs != 5) && ($rs != 6) && ($rs != 7) )){
				$tools[] = 4;
				$tools[] = 5;
			}*/
			
			// Recargamos las requisiciones pendientes
			$permisos = $this->session->userdata('permisos');
			$permisos['requisicion_pendiente'] = count($this->requisicion_model->getRequisicionesPendenting($this->session->userdata('id')));
			$this->session->set_userdata('permisos', $permisos);
			
			$data['tools'] = $tools;			
			
			$this->layout->view('requisicion/detalle',$data);
		else:
			$this->layout->view('requisicion/detalle_externa',$data);
		endif;
	}
	public function choose(){
		$this->layout->title('Advanzer - Elegir Requisición');
		$this->layout->view('requisicion/choose');
	}
	public function nueva(){
		$this->valida_sesion();
		$data=array();
		$data['areas'] = $this->area_model->getAll();
		$data['tracks'] = $this->track_model->getAll();
		$data['directores'] = $this->user_model->getDirectores();
		$data['colaboradores'] = $this->user_model->getPagination(1);
		$this->layout->title('Advanzer - Requisición de Personal');
		$this->layout->view('requisicion/nueva',$data);
	}
	
	public function nueva_externa() {
		$this->valida_sesion();
		$data=array();
		$this->layout->title('Advanzer - Requisición de Personal - Colocación Externa');
		$this->layout->view('requisicion/nueva_externa',$data);
	}

	//función guardar --guardar los datos enviados por POST a la Base de Datos
	//abc
	public function guardar(){
		$this->valida_sesion();
		if($this->input->post('tipo_requisicion')){
			$datos = array(
				'director'=>$this->input->post('director_area'),
				'autorizador'=>$this->input->post('autorizador'),
				'fecha_solicitud'=>$this->input->post('solicitud'),
				'fecha_estimada'=>$this->input->post('fecha_estimada'),
				'empresa'=>$this->input->post('empresa'),
				'domicilio_cte'=>$this->input->post('domicilio_cte'),
				'contacto'=>$this->input->post('contacto'),
				'telefono_contacto'=>$this->input->post('telefono_contacto'),
				'celular_contacto'=>$this->input->post('celular_contacto'),
				'email_contacto'=>$this->input->post('email_contacto'),
				'posicion'=>$this->input->post('posicion'),
				'expertise'=>$this->input->post('expertise'),
				'contratacion'=>$this->input->post('contratacion'),
				'costo_cliente'=>$this->input->post('costo_maximo_cliente'),
				'tipo_requisicion'=>$this->input->post('tipo_requisicion'),
				'solicita'=>$this->session->userdata('id')
			);
		}else{
			$datos = array(
				'director'=>$this->input->post('director_area'),
				'autorizador'=>$this->input->post('autorizador'),
				'fecha_solicitud'=>$this->input->post('solicitud'),
				'fecha_estimada'=>$this->input->post('fecha_estimada'),
				'area'=>$this->input->post('area'),
				'track'=>$this->input->post('track'),
				'posicion'=>$this->input->post('posicion'),
				'empresa'=>$this->input->post('empresa'),
				'tipo'=>$this->input->post('tipo'),
				'sustituye_a'=>$this->input->post('sustituye_a'),
				'proyecto'=>$this->input->post('proyecto'),
				'clave'=>$this->input->post('clave'),
				'costo'=>$this->input->post('costo'),
				'residencia'=>$this->input->post('residencia'),
				'lugar_trabajo'=>$this->input->post('lugar_trabajo'),
				'domicilio_cte'=>$this->input->post('domicilio_cte'),
				'contratacion'=>$this->input->post('contratacion'),
				'entrevista'=>$this->input->post('entrevista'),
				'disp_viajar'=>$this->input->post('disp_viajar'),
				'edad_uno'=>$this->input->post('edad_uno'),
				'edad_dos'=>$this->input->post('edad_dos'),
				'sexo'=>$this->input->post('sexo'),
				'nivel'=>$this->input->post('nivel'),
				'carrera'=>$this->input->post('carrera'),
				'ingles_hablado'=>$this->input->post('ingles_hablado'),
				'ingles_lectura'=>$this->input->post('ingles_lectura'),
				'ingles_escritura'=>$this->input->post('ingles_escritura'),
				'experiencia'=>$this->input->post('experiencia'),
				'habilidades'=>$this->input->post('habilidades'),
				'funciones'=>$this->input->post('funciones'),
				'observaciones'=>$this->input->post('observaciones'),
				'solicita'=>$this->session->userdata('id')
			);
		}
		
		// comprobamos si el solicitante es el director o el autorizador
		if($datos['autorizador'] == $this->session->userdata('id')){
			$datos['estatus']=3;
			$datos['fecha_aceptacion'] = date('Y-m-d');
			$datos['fecha_autorizacion'] = date('Y-m-d');
		}elseif($datos['director'] == $this->session->userdata('id')){
			$datos['estatus']=2;
			$datos['fecha_aceptacion'] = date('Y-m-d');
		}	

			
		if($requisicion = $this->requisicion_model->guardar($datos)){
			
			$requisicion = $this->requisicion_model->getById($requisicion);
			$data['requisicion']=$requisicion;
			
			// Id de la requisición
			$id = $requisicion->id;
			
			switch ($requisicion->estatus) {
				
				// 
				case 1:
				
					$destinatario1 = $this->user_model->searchById($requisicion->director)->email;
					
					if($requisicion->tipo_requisicion == 1){
						$mensaje1 = $this->load->view("layout/requisicion/create",$data,true);
					}else{
						$mensaje1 =$this->load->view("layout/requisicion/create_externa",$data,true);
					}
					
					// Alerta de nueva requisición para ser aceptada
					$this->requisicion_model->setAlert($id,1);
					
				break;
				
				case 2:
				
					$destinatario1 = $this->user_model->searchById($requisicion->autorizador)->email;
					$mensaje1 = $this->load->view("layout/requisicion/auth",$data,true);
					
					// Alerta de nueva requisición para ser autorizada
					$this->requisicion_model->setAlert($id,1);
				
				break;
				
				case 3:
					
					// Alerta de nueva requisición para ser atendida
					$this->requisicion_model->setAlert($id,1);
					
					//$destinatario='perla.valdezadvanzer.com';
					## harcodeado, por el momento, no existen atributos para diferenciar a la unica persona que recibira el correo
					$destinatario1 = 'perla.valdez@advanzer.com';					
					
					$mensaje1 = $this->load->view("layout/requisicion/rh",$data,true);
					
					$destinatario2 = $this->user_model->searchById($requisicion->solicita)->email;
					$mensaje2 = $this->load->view("layout/requisicion/aut",$data,true);
					
					
					$this->sendMail($destinatario2,$mensaje2);
				
				break;
			}
			
			/*if(!$this->sendMail($destinatario1,$mensaje1))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";*/
			
			$this->sendMail($destinatario1,$mensaje1);	
				
			$response['msg']="ok";
			
		}else
			$response['msg']="Ha habido un error al agregar la requisición";

		echo json_encode($response);
	}

	public function update(){
		$this->valida_sesion();
		$datos = array(
			'fecha_solicitud'=>$this->input->post('solicitud'),
			'fecha_estimada'=>$this->input->post('fecha_estimada'),
			'area'=>$this->input->post('area'),
			'track'=>$this->input->post('track'),
			'posicion'=>$this->input->post('posicion'),
			'empresa'=>$this->input->post('empresa'),
			'tipo'=>$this->input->post('tipo'),
			'sustituye_a'=>$this->input->post('sustituye_a'),
			'proyecto'=>$this->input->post('proyecto'),
			'clave'=>$this->input->post('clave'),
			'costo'=>$this->input->post('costo'),
			'costo_cliente'=>$this->input->post('costo_maximo_cliente'),
			'residencia'=>$this->input->post('residencia'),
			'lugar_trabajo'=>$this->input->post('lugar_trabajo'),
			'domicilio_cte'=>$this->input->post('domicilio_cte'),
			'contratacion'=>$this->input->post('contratacion'),
			'entrevista'=>$this->input->post('entrevista'),
			'disp_viajar'=>$this->input->post('disp_viajar'),
			'edad_uno'=>$this->input->post('edad_uno'),
			'edad_dos'=>$this->input->post('edad_dos'),
			'sexo'=>$this->input->post('sexo'),
			'nivel'=>$this->input->post('nivel'),
			'carrera'=>$this->input->post('carrera'),
			'ingles_hablado'=>$this->input->post('ingles_hablado'),
			'ingles_lectura'=>$this->input->post('ingles_lectura'),
			'ingles_escritura'=>$this->input->post('ingles_escritura'),
			'experiencia'=>$this->input->post('experiencia'),
			'habilidades'=>$this->input->post('habilidades'),
			'funciones'=>$this->input->post('funciones'),
			'observaciones'=>$this->input->post('observaciones'),
			'estatus'=>1,
			'razon'=>''
		);
		/*if($this->input->post('director_area')){
			$datos['director']=$this->input->post('director_area');
			if($datos['director'] == $this->session->userdata('id'))
				$datos['estatus']=2;
		}*/
		/*if($this->input->post('autorizador')){
			$datos['autorizador']=$this->input->post('autorizador');
			if($datos['autorizador'] == $this->session->userdata('id'))
				$datos['estatus']=3;
		}*/
		
		$id=$this->input->post('id');
		$requisicion=$this->requisicion_model->getById($id);
		
		/*if($requisicion->tipo_requisicion==2)
			if($requisicion->estatus==2)
				$datos['estatus']=3;*/
				
		$requisicion = $this->requisicion_model->update($id,$datos);
		/*if(isset($requisicion)){
			$requisicion = $this->requisicion_model->getById($requisicion);
			$data['requisicion']=$requisicion;
			switch ($requisicion->estatus) {
				case 1:
					if($requisicion->tipo_requisicion==1)
						$mensaje=$this->load->view("layout/requisicion/create",$data,true);
					else
						$mensaje=$this->load->view("layout/requisicion/create_externa",$data,true);
					break;
				case 2:
					$destinatario=$this->user_model->searchById($requisicion->autorizador)->email;
					$mensaje=$this->load->view("layout/requisicion/auth",$data,true);
					break;
				case 3:
					$destinatario='perla.valdezadvanzer.com';
					$mensaje=$this->load->view("layout/requisicion/rh",$data,true);
					break;
			}
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";*/

		echo json_encode($response);
	}

	// Permite reactivar una requisicion que esta acelada, modificando sus datos
	public function reactivate_update(){
		
		$this->valida_sesion();
		$datos = array(
			'id' => $this->input->post('id'),
			'fecha_solicitud'=>$this->input->post('solicitud'),
			'fecha_estimada'=>$this->input->post('fecha_estimada'),
			'area'=>$this->input->post('area'),
			'track'=>$this->input->post('track'),
			'posicion'=>$this->input->post('posicion'),
			'empresa'=>$this->input->post('empresa'),
			'tipo'=>$this->input->post('tipo'),
			'sustituye_a'=>$this->input->post('sustituye_a'),
			'proyecto'=>$this->input->post('proyecto'),
			'clave'=>$this->input->post('clave'),
			'costo'=>$this->input->post('costo'),
			'costo_cliente'=>$this->input->post('costo_maximo_cliente'),
			'residencia'=>$this->input->post('residencia'),
			'lugar_trabajo'=>$this->input->post('lugar_trabajo'),
			'domicilio_cte'=>$this->input->post('domicilio_cte'),
			'contratacion'=>$this->input->post('contratacion'),
			'entrevista'=>$this->input->post('entrevista'),
			'disp_viajar'=>$this->input->post('disp_viajar'),
			'edad_uno'=>$this->input->post('edad_uno'),
			'edad_dos'=>$this->input->post('edad_dos'),
			'sexo'=>$this->input->post('sexo'),
			'nivel'=>$this->input->post('nivel'),
			'carrera'=>$this->input->post('carrera'),
			'ingles_hablado'=>$this->input->post('ingles_hablado'),
			'ingles_lectura'=>$this->input->post('ingles_lectura'),
			'ingles_escritura'=>$this->input->post('ingles_escritura'),
			'experiencia'=>$this->input->post('experiencia'),
			'habilidades'=>$this->input->post('habilidades'),
			'funciones'=>$this->input->post('funciones'),
			'observaciones'=>$this->input->post('observaciones'),
			'estatus'=>1,
			//'razon'=>''
		);
		
		$id=$this->input->post('id');
		$requisicion=$this->requisicion_model->getById($id);

		$response['msg'] = "null";

		if($this->requisicion_model->update($id,$datos)){
			
			$data['requisicion'] = $requisicion;
			
			$destinatario=$this->user_model->searchById($requisicion->director)->email;
			$mensaje=$this->load->view("layout/requisicion/create",$data,true);
			
			/*if(!$this->sendMail($destinatario,$mensaje)){
				$response['msg']="ok";
			}*/
			
			$this->sendMail($destinatario,$mensaje);
			
			$response['msg']="ok";
			
		}
		
		//echo $destinatario;
		
		echo json_encode($response);
		
	}

	public function react(){
		$this->valida_sesion();
		$datos['estatus']=$this->input->post('estatus');
		$id=$this->input->post('id');
		if($this->requisicion_model->update($id,$datos)){
			$requisicion=$this->requisicion_model->getById($id);
			if($requisicion->usuario_modificacion == $requisicion->solicita) //el mismo solicitante reactiva
				$destinatario='perla.valdez@advanzer.com';
			else
				$destinatario=$this->user_model->searchById($requisicion->autorizador)->email;
			$data['requisicion']=$requisicion;
			$mensaje=$this->load->view("layout/requisicion/react",$data,true);
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
			$response['msg']="ok";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";

		echo json_encode($response);
	}
	
	// Cuando una requisición esta en Stand By esta regresara a Completada
	public function reanudar(){
		$this->valida_sesion();
		$id=$this->input->post('id');
		$datos['estatus'] = 3;
		if($this->requisicion_model->update($id,$datos)){
			$response['msg'] = "ok";
		}else{
			$response['msg']="Ha habido un error al reanudar la requisicion";
		}
		echo json_encode($response);
	}
	
	public function set_costo(){
		$this->valida_sesion();
		$datos['estatus']=$this->input->post('estatus');
		$datos['costo']=$this->input->post('costo');
		$id=$this->input->post('id');
		if($this->requisicion_model->update($id,$datos)){
			$requisicion=$this->requisicion_model->getById($id);
			switch ($datos['estatus']) {
				case '2': //para autorizador
					$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/auth",$data,true);
					break;
				case '3': //para capital humano
					$destinatario='perla.valdez@advanzer.com';
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/rh",$data,true);
					
					$destinatarioC = $this->user_model->searchById($requisicion->solicita)->email;
					$mensajeC = $this->load->view("layout/requisicion/aut",$data,true);
					
					break;
				case '7': //stand by
					if($requisicion->usuario_modificacion == $requisicion->solicita) //el mismo solicitante cambió a stand by
						$destinatario='perla.valdez@advanzer.com';
					else
						$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/stand_by",$data,true);
				default: # code...
					break;
			}
			if(!$this->sendMail($destinatario,$mensaje)){
				$this->sendMail($destinatarioC,$mensajeC);
				$response['msg']="ok";
			}else{
				$response['msg']="No se pudo enviar correo de notificación";
			}
			$response['msg']="ok";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";

		echo json_encode($response);
	}

	public function ch_estatus(){
		$this->valida_sesion();
		$datos['estatus']=$this->input->post('estatus');
		
		if($this->input->post('estatus') == 2){
			$datos['fecha_aceptacion'] = date('Y-m-d');
		}elseif($this->input->post('estatus') == 3){
			$datos['fecha_autorizacion'] = date('Y-m-d');
		}
		
		$id=$this->input->post('id');
		if($this->requisicion_model->update($id,$datos)){
			$requisicion=$this->requisicion_model->getById($id);
			switch ($datos['estatus']) {
				
				case '2': //para autorizador
					$destinatario=$this->user_model->searchById($requisicion->autorizador)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/auth",$data,true);
					$this->requisicion_model->setAlert($id,1);
				break;
				
				case '3': //para capital humano
					
					$destinatario='perla.valdez@advanzer.com';
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/rh",$data,true);
					$this->requisicion_model->setAlert($id,1);
					
					$destinatario2 = $this->user_model->searchById($requisicion->solicita)->email;
					$mensaje2 = $this->load->view("layout/requisicion/aut",$data,true);
					$this->sendMail($destinatario2,$mensaje2);
				
				break;
				
				case '7': //stand by
					if($requisicion->usuario_modificacion == $requisicion->solicita) //el mismo solicitante cambió a stand by
						$destinatario='perla.valdez@advanzer.com';
					else
						$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/stand_by",$data,true);
				default: # code...
					break;
			}
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
			$response['msg']="ok";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";

		echo json_encode($response);
	}
	
	// Si la requisición esta autorizada esta se turnara a Stand By
	public function pausar(){
		
		$this->valida_sesion();
		$datos['estatus'] = 7;
		$id=$this->input->post('id');
		
		if($this->requisicion_model->update($id,$datos)){
			
			$requisicion = $this->requisicion_model->getById($id);
			
			if($requisicion->usuario_modificacion == $requisicion->solicita){ //el mismo solicitante cambió a stand by
				$destinatario='perla.valdez@advanzer.com';
			}else{
				$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
			}
			
			$data['requisicion']=$requisicion;
			$mensaje=$this->load->view("layout/requisicion/stand_by",$data,true);

			$this->sendMail($destinatario,$mensaje);
				
			$response['msg']="ok";
			
		}else{
			$response['msg']="Ha habido un error al turnar a Stand By la requisición";
		}
		
		echo json_encode($response);	
	}
	
	// Se gestiona la requisicion rechazada o cancelada (en ambos casos no se podra reactivar), si es declinada se podra reactivar solo una vez mas
	public function rechazar_cancelar(){
		$this->valida_sesion();

		// Obtención de la requisicion en proceso actual
		$requisicion=$this->requisicion_model->getById($id = $this->input->post('id'));
		//echo ($requisicion->razon == "") ? 5 : $this->input->post('estatus'); 
		
		// Recuperamos el valor de el estado de la requisición
		$status_actual = $this->input->post('estatus');
		
		// Comprobamos que es la primera vez que se elimina
		if(($requisicion->razon == "") && ($status_actual != 4)){
			$status_actual = 5;
		}
		
		$datos=array(
			// Si es la primer vez que se cancela, se guarda de manera que se pueda reactivar de nuevo
			'estatus'=>$status_actual,
			'razon'=>$this->input->post('razon')
		);
						
		if($requisicion->estatus==2)
			$data['quien']='AUTORIZADOR';
		else
			$data['quien']='DIRECTOR DE ÁREA';
		
		if($this->requisicion_model->update($id,$datos)){
			
			$requisicion=$this->requisicion_model->getById($id);
			$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
			$mensaje = "";
			
			$this->requisicion_model->setAlert($id,1);
			
			switch ($status_actual) {
				
				case '0':case '5': // Aviso de cancelación
					//$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/cancelled",$data,true);
					$this->requisicion_model->setAlert($id,1);
				break;
					
				case '4': // Aviso de rechazo
					//$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/correct",$data,true);
					$this->requisicion_model->setAlert($id,1);
				break;
					
				//para solicitante de no autorizada
				/*case '5': 
					$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/no_auth",$data,true);
					break;*/
			}
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";

		echo json_encode($response);
	}
	
	// La requisición esta siendo atendida
	public function atender(){
		
		$this->valida_sesion();
		$datos['estatus'] = 8;
		$id=$this->input->post('id');
		$requisicion=$this->requisicion_model->getById($id);
		
		if($this->requisicion_model->update($id,$datos)){
		
			$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
			$data['requisicion']=$requisicion;
			$mensaje=$this->load->view("layout/requisicion/process",$data,true);
			
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		
		}else
			$response['msg']="Ha habido un error al atender la requisicion";

		echo json_encode($response);
	}

	// Se completa la requisicion, es decir, que la vacante se ha cubierto
	public function cerrar(){
		
		$this->valida_sesion();
		$datos['estatus']=$this->input->post('estatus');
		$datos['razon']=$this->input->post('razon');
		$id=$this->input->post('id');
		$requisicion=$this->requisicion_model->getById($id);
		
		if($this->requisicion_model->update($id,$datos)){
		
			$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
			$data['requisicion']=$requisicion;
			$mensaje=$this->load->view("layout/requisicion/closed",$data,true);
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		
		}else
			$response['msg']="Ha habido un error al cerrar la requisicion";

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

		$this->email->from('notificaciones.ch@advanzer.com','Requisición de Personal - Portal Personal');
		$this->email->to($destinatario);
		//$this->email->to('antonio.baez@advanzer.com');
		$this->email->subject('Aviso de Requisición');
		$this->email->message($mensaje);

		if(!$this->email->send())
			return var_dump($this->email->print_debugger());
		else
			return false;
	}

	public function check_to_cancel(){
		$requisiciones = $this->requisicion_model->getRequisiciones(true,true);
		foreach ($requisiciones as $requisicion) :
			$plazo = strtotime('+30 days',strtotime($requisicion->fecha_ultima_modificacion));
			$plazo=date('Y-m-d H:i',$plazo);
			$plazo=new DateTime($plazo);
			$hoy = new DateTime(date('Y-m-d H:i'));
			$diff=$plazo->diff($hoy);
			if($diff->format('%r') != '-'):
				$datos['estatus']=0;
				$datos['razon']='Se cancela por falta de seguimiento al día '.date('Y-m-d');
				$datos['usuario_modificacion']=null;
				$this->requisicion_model->update($requisicion->id,$datos);
			endif;
		endforeach;
	}
	public function exportar($requisicion){
		$requisicion = $this->requisicion_model->getById($requisicion);
		if($requisicion->tipo_requisicion==1)
			$this->genera_excel($requisicion);
		else
			$this->genera_excel_externa($requisicion);
	}

	private function genera_excel_externa($requisicion) {
		$this->load->library('excel');

		$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel->setReadDataOnly(true);
		$objPHPExcel = $objPHPExcel->load($_SERVER['DOCUMENT_ROOT'].'/assets/docs/requisicion_externa.xlsx');

		$objSheet=$objPHPExcel->setActiveSheetIndex(0);
		//Merge
			$objSheet->mergeCells('C1:G1');
			$objSheet->mergeCells('B2:G2');
			$objSheet->mergeCells('A3:G3');
			$objSheet->mergeCells('B4:G4');
			$objSheet->mergeCells('B5:G5');
			$objSheet->mergeCells('B6:G6');
			$objSheet->mergeCells('A7:G7');
			$objSheet->mergeCells('B8:G8');
			$objSheet->mergeCells('B9:G9');
			$objSheet->mergeCells('B10:G10');
			$objSheet->mergeCells('B11:G11');
			$objSheet->mergeCells('B12:G12');
			$objSheet->mergeCells('A13:G13');
			$objSheet->mergeCells('B14:G14');
			$objSheet->mergeCells('A15:G15');
			$objSheet->mergeCells('B16:G16');
			$objSheet->mergeCells('A17:G17');
			$objSheet->mergeCells('B18:G18');
			$objSheet->mergeCells('B19:G19');
			$objSheet->mergeCells('A20:G20');
			$objSheet->mergeCells('A21:G21');
			$objSheet->mergeCells('B22:G22');
			$objSheet->mergeCells('B23:G23');
			$objSheet->mergeCells('B24:G24');
			$objSheet->mergeCells('B25:G25');
			$objSheet->mergeCells('B26:G26');
			$objSheet->mergeCells('B27:G27');
			$objSheet->mergeCells('A28:G28');
			$objSheet->mergeCells('B29:G29');
			$objSheet->mergeCells('B30:G30');
			$objSheet->mergeCells('B31:G31');
			$objSheet->mergeCells('B32:G32');
			$objSheet->mergeCells('A33:G33');
			$objSheet->mergeCells('B34:G34');
		//Style head
			$objSheet->getStyle('A1:G34')->getAlignment()->setWrapText(true);
			$objSheet->getStyle('A1:G34')->getFont()->setName('Arial')->setSize(8);
			$objSheet->getStyle('A1:A34')->getFont()->setBold(true);
			$objSheet->getColumnDimension('A')->setWidth(15);
			$objSheet->getColumnDimension('B')->setWidth(14.1);
			$objSheet->getColumnDimension('C')->setWidth(14.4);
			$objSheet->getStyle('E2')->getFont()->setBold(true);
			$objSheet->getStyle('A1:G34')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle('A1:G34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objSheet->getStyle('A1:G34')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'FFFFFF')));
			$objSheet->getStyle('A1:A34')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'C0C0C0')));
			$objSheet->getStyle('A3')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A7')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A13')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A15')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A17')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A20:A21')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A20:A21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A28')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A28')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A33')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A33')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getRowDimension(2)->setRowHeight(-1);
			$objSheet->getStyle('A1:G34')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// write
			$objSheet->setCellValue('B1',$requisicion->id)
			->setCellValue('B2',$requisicion->nombre_solicita)
			->setCellValue('B4',$requisicion->fecha_solicitud)
			->setCellValue('B5',$requisicion->posicion)
			->setCellValue('B6',$requisicion->expertise)
			->setCellValue('B8',$requisicion->empresa)
			->setCellValue('B9',$requisicion->domicilio_cte)
			->setCellValue('B10',$requisicion->contacto)
			->setCellValue('B11',$requisicion->telefono_contacto. ' - '.$requisicion->celular_contacto)
			->setCellValue('B12',$requisicion->email_contacto)
			->setCellValue('B14',$requisicion->costo)
			->setCellValue('B16',$requisicion->contratacion)
			->setCellValue('B18',$requisicion->lugar_trabajo)
			->setCellValue('B19',$requisicion->fecha_estimada)
			->setCellValue('B22',$requisicion->nivel.' -'.$requisicion->carrera)
			->setCellValue('B23',$requisicion->sexo)
			->setCellValue('B24',$requisicion->edad_uno.' - '.$requisicion->edad_dos)
			->setCellValue('B25',"Hablado: $requisicion->ingles_hablado. Escrito: $requisicion->ingles_escritura. Leído: $requisicion->ingles_lectura")
			->setCellValue('B26',$requisicion->disp_viajar)
			->setCellValue('B27',$requisicion->residencia)
			->setCellValue('B29',$requisicion->experiencia)
			->setCellValue('B30',$requisicion->habilidades)
			->setCellValue('B31',$requisicion->funciones)
			->setCellValue('B32',$requisicion->observaciones)
			->setCellValue('B34',$requisicion->entrevista);
		$file_name = "requisicion_".$requisicion->id.".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		header('Cache-Control: max-age=0');		

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');
	}

	private function genera_excel($requisicion) {
		$this->load->library('excel');

		$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel->setReadDataOnly(true);
		$objPHPExcel = $objPHPExcel->load($_SERVER['DOCUMENT_ROOT'].'/assets/docs/requisicion_personal.xlsx');

		$objSheet=$objPHPExcel->setActiveSheetIndex(0);
		//Merge
			$objSheet->mergeCells('C1:G1');
			$objSheet->mergeCells('B2:G2');
			$objSheet->mergeCells('A3:G3');
			$objSheet->mergeCells('B4:G4');
			$objSheet->mergeCells('B5:G5');
			$objSheet->mergeCells('B6:G6');
			$objSheet->mergeCells('A7:G7');
			$objSheet->mergeCells('B8:G8');
			$objSheet->mergeCells('B9:G9');
			$objSheet->mergeCells('B10:G10');
			$objSheet->mergeCells('B11:G11');
			$objSheet->mergeCells('B12:G12');
			$objSheet->mergeCells('A13:G13');
			$objSheet->mergeCells('B14:G14');
			$objSheet->mergeCells('A15:G15');
			$objSheet->mergeCells('B16:G16');
			$objSheet->mergeCells('A17:G17');
			$objSheet->mergeCells('B18:G18');
			$objSheet->mergeCells('B19:G19');
			$objSheet->mergeCells('A20:G20');
			$objSheet->mergeCells('A21:G21');
			$objSheet->mergeCells('B22:G22');
			$objSheet->mergeCells('B23:G23');
			$objSheet->mergeCells('B24:G24');
			$objSheet->mergeCells('B25:G25');
			$objSheet->mergeCells('B26:G26');
			$objSheet->mergeCells('B27:G27');
			$objSheet->mergeCells('A28:G28');
			$objSheet->mergeCells('B29:G29');
			$objSheet->mergeCells('B30:G30');
			$objSheet->mergeCells('B31:G31');
			$objSheet->mergeCells('B32:G32');
			$objSheet->mergeCells('A33:G33');
			$objSheet->mergeCells('B34:G34');
			
		//Style head
			$objSheet->getStyle('A1:G34')->getAlignment()->setWrapText(true);
			$objSheet->getStyle('A1:G34')->getFont()->setName('Arial')->setSize(8);
			$objSheet->getStyle('A1:A34')->getFont()->setBold(true);
			$objSheet->getColumnDimension('A')->setWidth(15);
			$objSheet->getColumnDimension('B')->setWidth(14.1);
			$objSheet->getColumnDimension('C')->setWidth(14.4);
			$objSheet->getStyle('E2')->getFont()->setBold(true);
			$objSheet->getStyle('A1:G34')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle('A1:G34')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objSheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objSheet->getStyle('A1:G34')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'FFFFFF')));
			$objSheet->getStyle('A1:A34')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'C0C0C0')));
			$objSheet->getStyle('A3')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A7')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A13')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A15')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A17')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A20:A21')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A20:A21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A28')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A28')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A33')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'969696')));
			$objSheet->getStyle('A33')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getRowDimension(2)->setRowHeight(-1);
			$objSheet->getStyle('A1:G34')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// write
			if($requisicion->empresa=='1')
				$empresa="ADVANZER";
			elseif($requisicion->empresa=='2')
				$empresa="ENTUIZER";
			else
				$empresa=$requisicion->empresa;
			if($requisicion->tipo==1)
				$tipo='Posición Nueva';
			else
				$tipo='Sustitución';

			$objSheet->setCellValue('B1',$requisicion->id)
			->setCellValue('B2',$requisicion->nombre_solicita)
			->setCellValue('B4',$requisicion->fecha_solicitud)
			->setCellValue('B5',$requisicion->nombre_posicion)
			->setCellValue('B6',1)
			->setCellValue('B8',$empresa)
			->setCellValue('B9',$requisicion->nombre_area)
			->setCellValue('B10',$requisicion->proyecto.' / '.$requisicion->clave)
			->setCellValue('B11',$tipo)
			->setCellValue('B12',$requisicion->sustituye_a)
			->setCellValue('B14',$requisicion->costo)
			->setCellValue('B16',$requisicion->contratacion)
			->setCellValue('B18',"$requisicion->lugar_trabajo\n$requisicion->domicilio_cte")
			->setCellValue('B19',$requisicion->fecha_estimada)
			->setCellValue('B22',$requisicion->nivel.' -'.$requisicion->carrera)
			->setCellValue('B23',$requisicion->sexo)
			->setCellValue('B24',$requisicion->edad_uno.' - '.$requisicion->edad_dos)
			->setCellValue('B25',"Hablado: $requisicion->ingles_hablado. Escrito: $requisicion->ingles_escritura. Leído: $requisicion->ingles_lectura")
			->setCellValue('B26',$requisicion->disp_viajar)
			->setCellValue('B27',$requisicion->residencia)
			->setCellValue('B29',$requisicion->experiencia)
			->setCellValue('B30',$requisicion->habilidades)
			->setCellValue('B31',$requisicion->funciones)
			->setCellValue('B32',$requisicion->observaciones)
			->setCellValue('B34',$requisicion->entrevista);

		$file_name = "requisicion_".$requisicion->id.".xlsx";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		header('Cache-Control: max-age=0');		

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');

	}
}