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
	public function index($flag=false){
		$this->valida_sesion();
		$colaborador=$this->user_model->searchById($this->session->userdata('id'));
		$data=array();
		$data['requisiciones']=$this->requisicion_model->getRequisiciones($colaborador,$flag);
		$this->layout->title('Advanzer - Requisiciones');
		$this->layout->view('requisicion/index',$data);
	}
	public function ver($id){
		$this->valida_sesion();
		$data=array();
		$data['requisicion'] = $this->requisicion_model->getById($id);
		$data['areas'] = $this->area_model->getAll();
		$data['tracks'] = $this->track_model->getAll();
		$data['posiciones'] = $this->posicion_model->getByTrack($data['requisicion']->track);
		$data['directores'] = $this->user_model->getDirectores();		
		$data['colaboradores'] = $this->user_model->getPagination(1);
		$this->layout->title('Advanzer - Detalle Requisición');
		$this->layout->view('requisicion/detalle',$data);
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

	//función guardar --guardar los datos enviados por POST a la Base de Datos
	//abc
	public function guardar(){
		$this->valida_sesion();
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
		if($requisicion = $this->requisicion_model->guardar($datos)){
			$director=$this->user_model->searchById($datos['director']);
			$data['requisicion']=$this->requisicion_model->getById($requisicion);
			$mensaje=$this->load->view("layout/requisicion/create",$data,true);
			if(!$this->sendMail($director->email,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		}else
			$response['msg']="Ha habido un error al agregar la requisición";

		echo json_encode($response);
	}

	public function update(){
		$this->valida_sesion();
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
			'estatus'=>1,
			'razon'=>''
		);
		$id=$this->input->post('id');
		if($this->requisicion_model->update($id,$datos)){
			$director=$this->user_model->searchById($datos['director']);
			$data['requisicion']=$this->requisicion_model->getById($id);
			$mensaje=$this->load->view("layout/requisicion/create",$data,true);
			if(!$this->sendMail($director->email,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";

		echo json_encode($response);
	}

	public function ch_estatus(){
		$this->valida_sesion();
		$datos['estatus']=$this->input->post('estatus');
		$id=$this->input->post('id');
		$requisicion=$this->requisicion_model->getById($id);
		if($this->requisicion_model->update($id,$datos)){
			switch ($datos['estatus']) {
				case '2': //para autorizador
					$destinatario=$this->user_model->searchById($requisicion->autorizador)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/auth",$data,true);
					break;
				case '3': //para capital humano
					$destinatario=array('perla.valdez@advanzer.com','micaela.llano@advanzer.com');
					$data['requisicion']=$requisicion;
					$this->genera_excel($requisicion);
					$mensaje=$this->load->view("layout/requisicion/rh",$data,true);
					break;
				default:
					# code...
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

	public function rechazar(){
		$this->valida_sesion();
		$datos=array(
			'estatus'=>$this->input->post('estatus'),
			'razon'=>$this->input->post('razon')
		);
		$id=$this->input->post('id');
		$requisicion=$this->requisicion_model->getById($id);
		if($requisicion->estatus==2)
			$data['quien']='AUTORIZADOR';
		else
			$data['quien']='DIRECTOR DE ÁREA';
		if($this->requisicion_model->update($id,$datos)){
			$requisicion=$this->requisicion_model->getById($id);
			switch ($datos['estatus']) {
				case '4': //para solicitante correcciones
					$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/correct",$data,true);
					break;
				case '5': //para solicitante de no autorizada
					$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/no_auth",$data,true);
					break;
				case '0': //para solicitante de cancelación
					$destinatario=$this->user_model->searchById($requisicion->solicita)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/cancelled",$data,true);
					break;
				default:
					break;
			}
			if(!$this->sendMail($destinatario,$mensaje))
				$response['msg']="ok";
			else
				$response['msg']="No se pudo enviar correo de notificación";
		}else
			$response['msg']="Ha habido un error al actualizar la requisicion";

		echo json_encode($response);
	}

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
		$this->email->to(array('jesus.salas@advanzer.com'));//,'perla.valdez@advanzer.com','micaela.llano@advanzer.com')); //$this->email->to($destinatario);
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
			$plazo = strtotime('+30 days',strtotime($requisicion->fecha_modificacion));
		endforeach;
	}

	private function genera_excel($requisicion) {
		$this->load->library('excel');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Portal Personal - Requisiciones - Advanzer de México")
			->setLastModifiedBy("Portal Personal")
			->setTitle("Detalle de Requisición Autorizada")
			->setSubject("Detalle de Requisición Autorizada")
			->setDescription("Detallado de la captura de una nueva requisición de personal");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		//Style head
			$objSheet = $objPHPExcel->getActiveSheet(0);
			$objSheet->setTitle('Detalle Requisición');
			$objSheet->getStyle('A1:AD1')->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('FFFFFF');
			$objSheet->getStyle('A1:AD1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objSheet->getStyle('A1:AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A1:AD1')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'000A75')));
			$objSheet->getRowDimension(1)->setRowHeight(30);

		// write header
			$objSheet->getCell('A1')->setValue('FOLIO.');
			$objSheet->getCell('B1')->setValue('FECHA SOLICITUD');
			$objSheet->getCell('C1')->setValue('SOLICITA');
			$objSheet->getCell('D1')->setValue('ACEPTA');
			$objSheet->getCell('E1')->setValue('AUTORIZA');
			$objSheet->getCell('F1')->setValue('FECHA ESTIMADA DE INGRESO');
			$objSheet->getCell('G1')->setValue('ÁREA');
			$objSheet->getCell('H1')->setValue('TRACK');
			$objSheet->getCell('I1')->setValue('POSICIÓN');
			$objSheet->getCell('J1')->setValue('EMPRESA');
			$objSheet->getCell('K1')->setValue('TIPO');
			$objSheet->getCell('L1')->setValue('SUSTITUYE A');
			$objSheet->getCell('M1')->setValue('PROYECTO');
			$objSheet->getCell('N1')->setValue('CVE PROYECTO');
			$objSheet->getCell('O1')->setValue('COSTO');
			$objSheet->getCell('P1')->setValue('RESIDENCIA');
			$objSheet->getCell('Q1')->setValue('LUGAR DE TRABAJO');
			$objSheet->getCell('R1')->setValue('DOMICILIO DEL CLIENTE');
			$objSheet->getCell('S1')->setValue('TIEMPO DE CONTRATACIÓN');
			$objSheet->getCell('T1')->setValue('QUIEN ENTREVISTA');
			$objSheet->getCell('U1')->setValue('DISP PARA VIAJAR');
			$objSheet->getCell('V1')->setValue('RANGO DE EDAD');
			$objSheet->getCell('W1')->setValue('SEXO');
			$objSheet->getCell('X1')->setValue('NIVEL DE ESTUDIOS');
			$objSheet->getCell('Y1')->setValue('CARRERA');
			$objSheet->getCell('Z1')->setValue('NIVEL DE INGLÉS');
			$objSheet->getCell('AA1')->setValue('EXPERIENCIA/CONOCIMIENTOS');
			$objSheet->getCell('AB1')->setValue('CARACTERÍSTICAS HABILIDADES');
			$objSheet->getCell('AC1')->setValue('FUNCIONES');
			$objSheet->getCell('AD1')->setValue('OBSERVACIONES');

		//write content
			if($requisicion->empresa==1)
				$empresa="ADVANZER";
			else
				$empresa="ENTUIZER";
			if($requisicion->tipo==1)
				$tipo='Posición Nueva';
			else
				$tipo='Sustitución';
			$objSheet->getCell('A2')->setValue($requisicion->id);
			$objSheet->getCell('B2')->setValue($requisicion->fecha_solicitud);
			$objSheet->getCell('C2')->setValue($requisicion->nombre_solicita);
			$objSheet->getCell('D2')->setValue($requisicion->nombre_director);
			$objSheet->getCell('E2')->setValue($requisicion->nombre_autorizador);
			$objSheet->getCell('F2')->setValue($requisicion->fecha_estimada);
			$objSheet->getCell('G2')->setValue($requisicion->nombre_area);
			$objSheet->getCell('H2')->setValue($requisicion->nombre_track);
			$objSheet->getCell('I2')->setValue($requisicion->nombre_posicion);
			$objSheet->getCell('J2')->setValue($empresa);
			$objSheet->getCell('K2')->setValue($tipo);
			$objSheet->getCell('L2')->setValue($requisicion->sustituye_a);
			$objSheet->getCell('M2')->setValue($requisicion->proyecto);
			$objSheet->getCell('N2')->setValue($requisicion->clave);
			$objSheet->getCell('O2')->setValue($requisicion->costo);
			$objSheet->getCell('P2')->setValue($requisicion->residencia);
			$objSheet->getCell('Q2')->setValue($requisicion->lugar_trabajo);
			$objSheet->getCell('R2')->setValue($requisicion->domicilio_cte);
			$objSheet->getCell('S2')->setValue($requisicion->contratacion);
			$objSheet->getCell('T2')->setValue($requisicion->entrevista);
			$objSheet->getCell('U2')->setValue($requisicion->disp_viajar);
			$objSheet->getCell('V2')->setValue($requisicion->edad_uno.' - '.$requisicion->edad_dos);
			$objSheet->getCell('W2')->setValue($requisicion->sexo);
			$objSheet->getCell('X2')->setValue($requisicion->nivel);
			$objSheet->getCell('Y2')->setValue($requisicion->carrera);
			$objSheet->getCell('Z2')->setValue("Hablado: $requisicion->ingles_hablado\nEscrito: $requisicion->ingles_escritura\nLEÍDO: $requisicion->ingles_lectura");
			$objSheet->getCell('AA2')->setValue($requisicion->experiencia);
			$objSheet->getCell('AB2')->setValue($requisicion->habilidades);
			$objSheet->getCell('AC2')->setValue($requisicion->funciones);
			$objSheet->getCell('AD2')->setValue($requisicion->observaciones);
			$objSheet->getStyle('A2:AD2')->getAlignment()->setWrapText(true);
			$objSheet->getRowDimension(2)->setRowHeight(-1);

		//style content
			$objSheet->getStyle('B2')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
			$objSheet->getStyle('F2')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

		$file_name = "requisicion_".$requisicion->id.".xlsx";

		$objWriter->save(getcwd()."/assets/docs/$file_name");

	}
}