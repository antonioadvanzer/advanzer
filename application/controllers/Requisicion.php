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
		if($datos['director'] == $this->session->userdata('id'))
			$datos['estatus']=2;
		if($datos['autorizador'] == $this->session->userdata('id'))
			$datos['estatus']=3;
		if($requisicion = $this->requisicion_model->guardar($datos)){
			$requisicion = $this->requisicion_model->getById($requisicion);
			$data['requisicion']=$requisicion;
			switch ($requisicion->estatus) {
				case 1:
					$destinatario=$this->user_model->searchById($requisicion->director)->email;
					$mensaje=$this->load->view("layout/requisicion/create",$data,true);
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
		if($datos['director'] == $this->session->userdata('id'))
			$datos['estatus']=2;
		if($datos['autorizador'] == $this->session->userdata('id'))
			$datos['estatus']=3;
		if($requisicion = $this->requisicion_model->update($id,$datos)){
			$requisicion = $this->requisicion_model->getById($requisicion);
			$data['requisicion']=$requisicion;
			switch ($requisicion->estatus) {
				case 1:
					$destinatario=$this->user_model->searchById($requisicion->director)->email;
					$mensaje=$this->load->view("layout/requisicion/create",$data,true);
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
			$response['msg']="Ha habido un error al actualizar la requisicion";

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

	public function ch_estatus(){
		$this->valida_sesion();
		$datos['estatus']=$this->input->post('estatus');
		$id=$this->input->post('id');
		if($this->requisicion_model->update($id,$datos)){
			$requisicion=$this->requisicion_model->getById($id);
			switch ($datos['estatus']) {
				case '2': //para autorizador
					$destinatario=$this->user_model->searchById($requisicion->autorizador)->email;
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/auth",$data,true);
					break;
				case '3': //para capital humano
					$destinatario='perla.valdez@advanzer.com';
					$data['requisicion']=$requisicion;
					$mensaje=$this->load->view("layout/requisicion/rh",$data,true);
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
		$this->email->to('jesus.salas@advanzer.com');
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
		$this->genera_excel($requisicion);
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
			if($requisicion->empresa==1)
				$empresa="ADVANZER";
			elseif($requisicion->empresa==2)
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
			->setCellValue('D2',$requisicion->nombre_posicion)
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

		$file_name = "requisicion_".$requisicion->id;
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		header('Cache-Control: max-age=0');		

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objWriter->save('php://output');

	}
}