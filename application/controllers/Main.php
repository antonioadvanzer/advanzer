<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('user_model');
    	$this->load->model('evaluacion_model');
    	$this->load->model('requisicion_model');
    	$this->load->model('solicitudes_model');
    }
 
    public function index() {
    	$this->valida_sesion();
    	$data=array();
    	$data['colaborador'] = $this->user_model->searchById($this->session->userdata('id'));
    	$data['evaluacion'] = $this->evaluacion_model->getEvaluacionAnual();
    	$data['auth_pendientes'] = $this->user_model->solicitudes_pendientes($this->session->userdata('id'));
    	$cont=0;
    	foreach ($data['auth_pendientes'] as $solicitud)
    		if(!in_array($solicitud->estatus,array(0,3,4)))
    			$cont++;
    	$data['solicitudes_pendientes'] = $this->user_model->solicitudesByColaborador($this->session->userdata('id'));
    	$data['cont_pendientes']=$cont;
    	$cont=0;
    	foreach ($data['solicitudes_pendientes'] as $solicitud)
    		if(in_array($solicitud->estatus,array(1,2)))
    			$cont++;
    	$data['cont_solicitudes']=$cont;
    	$cont=0;
		foreach ($data['solicitudes_pendientes'] as $solicitud)
    		if(in_array($solicitud->estatus,array(1,2)))
				$cont++;
		$data['cont']=$cont;
    	$data['requisiciones'] = $this->requisicion_model->getByColaborador($this->session->userdata('id'));
    	$data['requisiciones_pendientes'] = $this->requisicion_model->getPendientesByColaborador($this->session->userdata('id'));
		$this->layout->title('Advanzer - Inicio');
		$this->layout->view('main/index', $data);
	}

    public function login($err=null) {
    	$data=array();
    	$periodo_edicion = $this->evaluacion_model->getPeriodoEdicion();
    	if($err!=null)
    		$data['err_msg']=$err;
    	$email = $this->input->post('email');
		if (!empty($email)) {
    		$password = $this->input->post('password');
    		$result = $this->user_model->do_login($email,$password);
    		if ($result) {
    			//$_SESSION['access_token'] = 1;
    			$sess_array = array(
    				'id'=>$result->id,
    				'nombre'=>$result->nombre,
    				'email'=>$result->email,
    				'foto' =>$result->foto,
    				'empresa'=>$result->empresa,
    				'posicion' =>$result->nivel_posicion,
    				'area' =>$result->area,
    				'direccion'=>$result->direccion,
    				'tipo'=>$result->tipo,
    				'periodo_edicion'=>$periodo_edicion
    			);
    			$data['email'] = $result->email;
    			$this->session->set_userdata($sess_array);
    			$re="main/index";
    		}else
    			$data['err_msg'] = "No es posible iniciar sesión, verifica las credenciales";
    	}
		// Include two files from google-php-client library in controller
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/autoload.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

		// Store values in variables from project created in Google Developer Console
		$client_id = '904111204763-9c015hanptq9jehs8nj57at4joqfroe1.apps.googleusercontent.com';
		$client_secret = '49DbvsMqY6-8dTCnlXJrIp-C';
		$redirect_uri = base_url('auth');
		$simple_api_key = 'AIzaSyBhG2aM8BVUvRNXRypylxu4XJBIYLWtdyQ';

		// Create Client Request to access Google API
		$client = new Google_Client();
		$client->setApplicationName("Auth");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");
		$client->setIncludeGrantedScopes(true);
		$client->setAccessType("offline");

		// Send Client Request
		$objOAuthService = new Google_Service_OAuth2($client);

		// Add Access Token to Session
		if (isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		}

		// Set Access Token to make Request
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			$client->setAccessToken($_SESSION['access_token']);
		} else {
			$authUrl = $client->createAuthUrl();
		}

		// Get User Data from Google and store them in $data
		if ($client->getAccessToken()) {
			if($client->isAccessTokenExpired()) {
				$authUrl = $client->createAuthUrl();
				header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
			}
			/*$NewAccessToken = json_decode($_SESSION['access_token']);
			$client->refreshToken($NewAccessToken->access_token);*/
			$userData = $objOAuthService->userinfo->get();
			$email = $userData->email;
			$result=$this->user_model->do_login($email);
			if ($result) {
				$_SESSION['access_token'] = $client->getAccessToken();
				$sess_array = array(
    				'id'=>$result->id,
    				'nombre'=>$result->nombre,
    				'email'=>$result->email,
    				'foto' =>$result->foto,
    				'empresa'=>$result->empresa,
    				'posicion' =>$result->nivel_posicion,
    				'area' =>$result->area,
    				'direccion'=>$result->direccion,
    				'tipo'=>$result->tipo,
    				'periodo_edicion'=>$periodo_edicion
    			);
    			$data['email'] = $result->email;
    			$this->session->set_userdata($sess_array);
			}else{
				echo"<script>alert('Credenciales Inválidas');</script>";
				unset($_SESSION['access_token']);
			}
			$this->layout->title('Advanzer - Bienvenido');
			$re="main/index";
		} else {
			$authUrl = $client->createAuthUrl();
			$data['authUrl'] = $authUrl;
			$this->layout->title('Advanzer - Login');
			$re="main/login";
		}
		$this->verify_session();
		// Load view and send values stored in $data
		//$this->load->view('google_authentication', $data);
    	$this->layout->view($re, $data);
    }

    public function historial() {
    	$this->valida_sesion();
    	$id=$this->session->userdata('id');
    	$data['colaborador'] = $this->user_model->searchById($this->session->userdata('id'));
    	$data['info'] = $this->user_model->getHistorialById($id);
    	$this->layout->title('Advanzer - Mi Historial de Desempeño');
    	$this->layout->view('main/historial',$data);
    }

    public function load_historial() {
    	$id=$this->session->userdata('id');
    	$anio=$this->input->post('anio');
    	$info=$this->user_model->getHistorialByIdAnio($id,$anio);
    	if(isset($info->rating)):
    	?>
    		<span class="text-muted">Rating Obtenido: </span><?= $info->rating;?>
    	<?php endif;
    }
    public function load_graph() {
    	$resumen=new stdClass();
    	$id=$this->session->userdata('id');
		$anio=$this->input->post('anio');
    	if($this->evaluacion_model->hasFeedback($anio,$id)):
    		$resumen=$this->evaluacion_model->getResumen($anio,$id);
    	endif;
    	echo json_encode($resumen, JSON_NUMERIC_CHECK);
    }

    // Unset session and logout
	public function logout($err=null) {
		unset($_SESSION['access_token']);
		if($this->user_model->logout($this->session->userdata('id'),$this->session->userdata('email'))){
			$this->session->userdata=array();
			$this->login($err);
		}
		//redirect("https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=".base_url('login'),"refresh");
	}

	private function verify_session(){
		$idU=$this->session->userdata('id');
		if (!empty($idU))
			redirect(base_url('main'));
	}

	private function valida_sesion() {
        if($this->session->userdata('id') == "")
            redirect('login');
	}

	public function check_evaluation_period() {
    	$msg="";
    	if($response = $this->evaluacion_model->check_for_evaluations()){
    		foreach ($response as $evaluacion) :
    			$this->evaluacion_model->finaliza_periodo($evaluacion->id);
    			$msg .= "Evaluation: '".$evaluacion->nombre."' with id: ".$evaluacion->id." has been closed with no errors\n\t";
    			if($evaluacion->tipo == 1)
    				$anual=true;
    		endforeach;
    		$this->evaluacion_model->setPeriodoEdicion();
    		if(isset($anual) && $anual==true)
    			$msg.=$this->exportAnualFile();
    		$msg = date("Y-m-d H:i:s")." - Succesfully executed with activity:\n\t".$msg."\n\n";
    	}else
    		$msg = date("Y-m-d H:i:s")." - Succesfully executed with no activity.\n\n";

    	$this->evaluacion_model->check_PeriodoEdicion();

    	echo $msg;
	}

	public function sendMail($file) {
		$this->load->library("email");

		//configuracion para gmail
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'notificaciones.ch@advanzer.com',
			'smtp_pass' => 'CapitalAdv1',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

		$this->email->initialize($config);

		$this->email->clear(TRUE);

		$this->email->from('notificaciones.ch@advanzer.com','Portal de Evaluación Advanzer-Entuizer');
		/*$this->email->to("micaela.llano@advanzer.com");
		$this->email->bcc(array('jesus.salas@advanzer.com', 'enrique.bernal@advanzer.com'));
		*/$this->email->to("jesus.salas@advanzer.com");
		$this->email->subject('Captura de Compromisos Internos');
		$this->email->message('<h2>Se ha adjuntado el archivo de soporte de la captura de Compromisos Internos</h2><hr>');
		$this->email->attach(base_url("assets/docs/$file"));

		if(!$this->email->send())
			var_dump($this->email->print_debugger());
		else
			redirect();
	}

	public function exportAnualFile() {
		$this->load->library('excel');

		//get Info Evaluados
		$colaboradores = $this->evaluacion_model->getEvaluados();

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Portal de Evaluación Advanzer de México")
			->setLastModifiedBy("Portal de Evaluación")
			->setTitle("Reporte Anual de Evaluación")
			->setSubject("Reporte Anual de Evaluación")
			->setDescription("Concentrado de resultados de evaluación anual y proyectos durante el año en cuestión");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$objSheet = $objPHPExcel->getActiveSheet(0);
		$objSheet->setTitle('Junta_Anual');
		$objSheet->getStyle('A1:Q1')->getFont()->setBold(true)->setName('Verdana')->setSize(11)->getColor()->setRGB('FFFFFF');
		$objSheet->getStyle('A1:Q1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objSheet->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A1:Q1')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'000A75')));
		$objSheet->getRowDimension(1)->setRowHeight(50);

		// write header
			$objSheet->getCell('A1')->setValue('No.');
			$objSheet->getCell('B1')->setValue('Colaborador');
			$objSheet->getCell('C1')->setValue('Fecha de Ingreso');
			$objSheet->getCell('D1')->setValue('Track');
			$objSheet->getCell('E1')->setValue('Posición');
			$objSheet->getCell('F1')->setValue('Evaluadores');
			$objSheet->getCell('G1')->setValue('Competencias');
			$objSheet->getCell('H1')->setValue('Responsabilidades');
			$objSheet->getCell('I1')->setValue('Promedio');
			$objSheet->getCell('J1')->setValue('Rating 2012');
			$objSheet->getCell('K1')->setValue('Rating 2013');
			$objSheet->getCell('L1')->setValue('Rating 2014');
			$objSheet->getCell('M1')->setValue('Rating 2015');
			$objSheet->getCell('N1')->setValue('Encargado de Feedback');
			$objSheet->getCell('O1')->setValue('Comentarios de Desempeño');
			$objSheet->getCell('P1')->setValue('Observaciones de la Junta');
			$objSheet->getCell('Q1')->setValue('Acciones a Tomar');

		$column=1;
		foreach ($colaboradores as $colaborador) :
			$column++;

			$total_c=0;
			$total_r=0;
			if($colaborador->nivel_posicion<=5)
				$total_c= ($colaborador->autoevaluacion + $colaborador->tres60 + $colaborador->competencias)/3;
			else
				$total_c= ($colaborador->autoevaluacion + $colaborador->competencias)/2;
			if(isset($colaborador->proyectos))
				$total_r=($colaborador->responsabilidades+$colaborador->proyectos)/2;
			else
				$total_r=$colaborador->responsabilidades;

			($res=$this->user_model->getHistorialByIdAnio($colaborador->id,'2012')) ? $colaborador->rating_2012=$res->rating : $colaborador->rating_2012=null;;
			($res=$this->user_model->getHistorialByIdAnio($colaborador->id,'2013')) ? $colaborador->rating_2013=$res->rating : $colaborador->rating_2013=null;;
			($res=$this->user_model->getHistorialByIdAnio($colaborador->id,'2014')) ? $colaborador->rating_2014=$res->rating : $colaborador->rating_2014=null;;
			$evaluadores="";
			$comentarios="";
			foreach ($colaborador->evaluadores as $evaluador) :
				$evaluadores .= $evaluador->nombre."\n";
				$comentarios .= $evaluador->comentarios."\n";
			endforeach;
			if(isset($colaborador->evaluadoresProyecto)):
				foreach ($colaborador->evaluadoresProyecto as $evaluador) :
					$evaluadores .= $evaluador->nombre."\n";
					$comentarios .= $evaluador->comentarios."\n";
				endforeach;
			endif;
			if($colaborador->nivel_posicion <= 5):
				$cont=0;
				if(isset($colaborador->evaluadores360)):
					foreach ($colaborador->evaluadores360 as $evaluador) :
						$evaluadores .= $evaluador->nombre."\n";
						$comentarios .= $evaluador->comentarios."\n";
						$cont++;
					endforeach;
				endif;
			endif;
			
			$objSheet->getCell('A'.$column)->setValue($colaborador->nomina);
			$objSheet->getCell('B'.$column)->setValue($colaborador->nombre);
			$objSheet->getCell('C'.$column)->setValue($colaborador->fecha_ingreso);
			$objSheet->getCell('D'.$column)->setValue($colaborador->track);
			$objSheet->getCell('E'.$column)->setValue($colaborador->posicion);
			$objSheet->getCell('F'.$column)->setValue($evaluadores);
			$objSheet->getCell('G'.$column)->setValue(number_format(floor($total_c*100)/100,2));
			$objSheet->getCell('H'.$column)->setValue(number_format(floor($total_r*100)/100,2));
			$objSheet->getCell('I'.$column)->setValue(number_format(floor($colaborador->total*100)/100,2));
			$objSheet->getCell('J'.$column)->setValue($colaborador->rating_2012);
			$objSheet->getCell('K'.$column)->setValue($colaborador->rating_2013);
			$objSheet->getCell('L'.$column)->setValue($colaborador->rating_2014);
			$objSheet->getCell('O'.$column)->setValue($comentarios);
			$objSheet->getStyle('A'.$column.':'.'Q'.$column)->getAlignment()->setWrapText(true);
			$objSheet->getRowDimension($column)->setRowHeight(-1);
		endforeach;

		$objSheet->getStyle('C2:C'.$column)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
		$objSheet->getStyle('A2:Q'.$column)->getFont()->setSize(12);
		$objSheet->getStyle('G2:H'.$column)->getFont()->setSize(16);
		$objSheet->getStyle('I2:I'.$column)->getFont()->setSize(18);
		$objSheet->getStyle('M2:M'.$column)->getFont()->setSize(24);
		$objSheet->getStyle('A2:Q'.$column)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		// create some borders
			// first, create the whole grid around the table
			$objSheet->getStyle('A1:Q'.$column)->getBorders()->
			getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			// create medium border around the table
			$objSheet->getStyle('A1:Q'.$column)->getBorders()->
			getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
			// create a medium border on the header line
			$objSheet->getStyle('A1:Q1')->getBorders()->
			getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

		// autosize the columns
			$objSheet->getColumnDimension('A')->setAutoSize(true);
			$objSheet->getColumnDimension('B')->setAutoSize(true);
			$objSheet->getColumnDimension('C')->setAutoSize(true);
			$objSheet->getColumnDimension('D')->setAutoSize(true);
			$objSheet->getColumnDimension('E')->setAutoSize(true);
			$objSheet->getColumnDimension('F')->setWidth(40);
			$objSheet->getColumnDimension('G')->setAutoSize(true);
			$objSheet->getColumnDimension('H')->setAutoSize(true);
			$objSheet->getColumnDimension('I')->setAutoSize(true);
			$objSheet->getColumnDimension('J')->setAutoSize(true);
			$objSheet->getColumnDimension('K')->setAutoSize(true);
			$objSheet->getColumnDimension('L')->setAutoSize(true);
			$objSheet->getColumnDimension('M')->setAutoSize(true);
			$objSheet->getColumnDimension('N')->setWidth(20);
			$objSheet->getColumnDimension('O')->setWidth(40);
			$objSheet->getColumnDimension('P')->setWidth(40);
			$objSheet->getColumnDimension('Q')->setWidth(40);


		//tabla de resumen en hoja principal
			$column+=5;
			$objSheet->getStyle('G'.$column.':J'.($column+5))->getBorders()->
			getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			// create medium border around the table
			$objSheet->getStyle('G'.$column.':J'.($column+5))->getBorders()->
			getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
			// create a medium border on the header line
			$objSheet->getStyle('G'.$column.':J'.$column)->getBorders()->
			getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);

			$objSheet->getStyle('G'.$column.':J'.($column+6))->getFont()->setBold(true)->setName('Verdana')->setSize(10);
			$objSheet->getStyle('I'.($column+1).':I'.($column+6))->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('FF0000');

			$objSheet->getCell('G'.$column)->setValue('Rating');
			$objSheet->getCell('H'.$column)->setValue('Conteo');
			$objSheet->getCell('I'.$column)->setValue('% Real');
			$objSheet->getCell('J'.$column)->setValue('% Requerida');

			$objSheet->getStyle('I'.($column+1).':J'.($column+6))->getNumberFormat()->applyFromArray(array( 
				'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00)
				);

			$letras=array('A','B','C','D','E','.05','.15','.65','.10','.05');
			for ($i=1; $i <= 5; $i++) :
				$objSheet->getCell('G'.($column+$i))->setValue($letras[$i-1]);
				$objSheet->getCell('H'.($column+$i))->setValue('=COUNTIF($M$2:$M$'.($column-5).',"'.$letras[$i-1].'")');
				$objSheet->getCell('I'.($column+$i))->setValue('=H'.($column+$i).'/$H$'.($column+6));
				$objSheet->getCell('J'.($column+$i))->setValue($letras[$i+4]);
			endfor;
			$column+=6;
			$objSheet->getCell('H'.$column)->setValue('=SUM(H'.($column-5).':H'.($column-1).')');
			$objSheet->getCell('I'.$column)->setValue('=SUBTOTAL(9,I'.($column-5).':I'.($column-1).')');
			$objSheet->getCell('J'.$column)->setValue('=SUBTOTAL(9,J'.($column-5).':J'.($column-1).')');

		
		//line chart
			$objSheet = $objPHPExcel->createSheet(1);
			$objSheet->setTitle('Resumen');
			//data series label
			$dsl = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Junta_Anual!I'.($column-6), null, 1),
				new PHPExcel_Chart_DataSeriesValues('String', 'Junta_Anual!J'.($column-6), null, 1)
			);
			//X axis value label
			$xal=array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Junta_Anual!$G$'.($column-5).':$G$'.($column-1), NULL, 5),
			);
			//data series values
			$dsv=array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Junta_Anual!$I$'.($column-5).':$I$'.($column-1), NULL, 5),
				new PHPExcel_Chart_DataSeriesValues('Number', 'Junta_Anual!$J$'.($column-5).':$J$'.($column-1), NULL, 5),
			);
			//data series values
			$ds=new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_LINECHART,
				PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
				range(0, count($dsv)-1),
				$dsl,
				$xal,
				$dsv,
				PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
			);
			$layout = new PHPExcel_Chart_Layout();
			$ds->setSmoothLine(PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER);
			$layout->setShowPercent(TRUE);

			//plot area & legend
			$pa=new PHPExcel_Chart_PlotArea($layout, array($ds));
			$legend=new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
			//title of chart
			$title=new PHPExcel_Chart_Title('Curva de Desempeño');
			//chart
			$chart= new PHPExcel_Chart(
				'chart1',
				$title,
				$legend,
				$pa,
				null,
				0,
				NULL,
				NULL
			);

			$chart->setTopLeftPosition('B3');
			$chart->setBottomRightPosition('K25');
			$objSheet->addChart($chart);

		$file_name = "Reporte_Anual.xlsx";

		$objWriter->setPreCalculateFormulas(true);
		$objWriter->setIncludeCharts(true);
		
		/*//output to browser
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');*/
		
		//output to server
		$objWriter->save(getcwd()."/assets/docs/$file_name");

		$this->load->library("email");

		//configuracion para gmail
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'notificaciones.ch@advanzer.com',
			'smtp_pass' => 'CapitalAdv1',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

		$this->email->initialize($config);

		$this->email->clear(TRUE);

		$this->email->from('notificaciones.ch@advanzer.com','Portal de Evaluación Advanzer-Entuizer');
		/*$this->email->to("micaela.llano@advanzer.com");
		$this->email->bcc(array('jesus.salas@advanzer.com', 'enrique.bernal@advanzer.com'));
		*/$this->email->to("jesus.salas@advanzer.com");
		$this->email->subject('Reporte de Evaluación para Junta Anual');
		$this->email->message('<h2>Se ha generado el archivo de Reporte de Evaluación para la Junta Anual</h2><hr>');
		$this->email->attach(base_url("assets/docs/$file_name"));

		if(!$this->email->send())
			var_dump($this->email->print_debugger());
		else
			return "Se ha enviado reporte anual";
	}

	public function recordatorioEvProyecto() {
		$msg="";
		$proyectos = $this->evaluacion_model->getEvaluacionesProyecto();
		if($proyectos)
			foreach ($proyectos as $proyecto) :
				if($proyecto->inicio <= date('Y-m-d') && $proyecto->fin >= date('Y-m-d')):
					$msg2 = "Evaluation: '".$proyecto->nombre."' with id: ".$proyecto->id."\n";
					$info = $this->evaluacion_model->getEvaluadoresPendientesByEvaluacion($proyecto->id);
					$mensaje="<a style='text-decoration:none;' href='http://intranet.advanzer.com:3000/evaluar'><img align='center' width='100%' 
						src='http://drive.google.com/uc?export=view&id=0B7vcCZhlhZiOeERTQk1MR1g5ZUU'/></a>";
					if($response = $this->enviaRecordatorio($info[0]->email,$mensaje))
						$msg .= date("Y-m-d H:i:s")." - Succesfully executed with errors:\n $msg2\t$response";
					else
						$msg .= date("Y-m-d H:i:s")." - Succesfully executed with activity:\n$msg2\tMail sent to project leader";
					$msg .= "\n\n";
				endif;
			endforeach;
		if($msg == "")
			$msg = date("Y-m-d H:i:s")." - Succesfully executed with no activity.";

		echo "$msg\n\n";
	}

	public function recordatorioEvAnual() {
		$msg="";
		$evaluacion = $this->evaluacion_model->getEvaluacionById($this->evaluacion_model->getEvaluacionAnualVigente()->id);
		if($evaluacion):
			if($evaluacion->inicio < date('Y-m-d') && $evaluacion->fin > date('Y-m-d')):
				$msg2 = "Evaluation: '".$evaluacion->nombre."' with id: ".$evaluacion->id."\n";
				$info = $this->evaluacion_model->getEvaluadoresPendientesByEvaluacion($evaluacion->id);
				$response=false;
				foreach ($info as $evaluador) :
					$mensaje="<a style='text-decoration:none;' href='http://intranet.advanzer.com:3000/evaluar'><img align='center' width='100%' 
						src='http://drive.google.com/uc?export=view&id=0B7vcCZhlhZiOZFBzZTFvVnhPSk0'/></a>";
					if($evaluador->email)
						$response .= $this->enviaRecordatorio($evaluador->email,$mensaje);
				endforeach;
				if($response)
					$msg = date("Y-m-d H:i:s")." - Succesfully executed with errors:\n $msg2\t$response";
				else
					$msg = date("Y-m-d H:i:s")." - Succesfully executed with activity:\n$msg2";
			endif;
		endif;
		if($msg == "")
			$msg = date("Y-m-d H:i:s")." - Succesfully executed with no activity.";

		echo "$msg\n\n";
	}

	public function recordatorioDiario() {
		$msg="";
		$evaluacion = $this->evaluacion_model->getEvaluacionById($this->evaluacion_model->getEvaluacionAnualVigente()->id);
		if($evaluacion)
			if($evaluacion->inicio == date('Y-m-d') || $evaluacion->fin == date('Y-m-d')):
				if($evaluacion->fin == date('Y-m-d'))
				$mensaje="<a style='text-decoration:none;' href='http://intranet.advanzer.com:3000/evaluar'><img align='center' width='100%' 
						src='http://drive.google.com/uc?export=view&id=0B7vcCZhlhZiObmcwSl9jM2QzVDg'/></a>";
				else
					$mensaje="<a style='text-decoration:none;' href='http://intranet.advanzer.com:3000/evaluar'><img align='center' width='100%' 
						src='http://drive.google.com/uc?export=view&id=0B7vcCZhlhZiOSGRscFU2Uy1zUEk'/></a>";
				$response="";
				$msg2 = "\n\nEvaluation: '".$evaluacion->nombre."' with id: ".$evaluacion->id."\n";
				$evaluadores = $this->evaluacion_model->getEvaluadoresPendientesByEvaluacion($evaluacion->id);
				foreach ($evaluadores as $info) :
					$response .= $this->enviaRecordatorio($info->email,$mensaje);
				endforeach;
				if($response != "")
					$msg .= date("Y-m-d H:i:s")." - Succesfully executed with errors:\n $msg2\t$response";
				else
					$msg .= date("Y-m-d H:i:s")." - Succesfully executed with activity:\n$msg2";
			endif;
		if($msg == "")
			$msg = date("Y-m-d H:i:s")." - Succesfully executed with no activity.";

		echo "$msg\n\n\n\n";
	}

	private function enviaRecordatorio($destinatario,$mensaje) {
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

		$this->email->from('notificaciones.ch@advanzer.com','Portal de Evaluación');
		/*$this->email->to("micaela.llano@advanzer.com");
		$this->email->bcc(array('enrique.bernal@advanzer.com','jesus.salas@advanzer.com'));
		$this->email->reply_to('micaela.llano@advanzer.com');
		*/$this->email->to("jesus.salas@advanzer.com"); //$this->email->to($destinatario);
		$this->email->subject('Aviso de Evaluación');
		$this->email->message($mensaje);

		if(!$this->email->send())
			return $this->email->print_debugger();
		return false;
	}

	public function solicitudes() {
		$data['solicitudes'] = $this->user_model->getSolicitudes();
		$this->layout->title('Advanzer - Solicitudes');
		$this->layout->view('servicio/admin_solicitudes',$data);
	}

	public function vacation_expired() {
		$vacaciones=$this->solicitudes_model->getVacacionesExpired();
		foreach ($vacaciones as $registro) :
			$datos=array(
				'dias_acumulados'=>(int)$registro->dias_acumulados-(int)$registro->dias_uno,
				'dias_uno'=>$registro->dias_dos,
				'vencimiento_uno'=>$registro->vencimiento_dos,
				'dias_dos'=>null,
				'vencimiento_dos'=>null,
			);
			$this->solicitudes_model->actualiza_dias_vacaciones($registro->colaborador,$datos);
		endforeach;
	}

	public function vacation_register() {
		$colaboradores=$this->user_model->getPagination(null);
		foreach ($colaboradores as $colaborador):
			$aniversario=date('m-d',strtotime($colaborador->fecha_ingreso));
			if($aniversario == date('m-d')):
				$ingreso=new DateTime($colaborador->fecha_ingreso);
				$hoy=new DateTime(date('Y-m-d'));
				$diff = $ingreso->diff($hoy);
				switch ($diff->y):
					case 1: $dias=6;										break;
					case 2: $dias=8;										break;
					case 3: $dias=10;										break;
					case 4: $dias=12;										break;
					case 5:case 6:case 7:case 8:case 9: $dias=14;			break;
					case 10:case 11:case 12:case 13:case 14: $dias=16;		break;
					case 15:case 16:case 17:case 18:case 19: $dias=18;		break;
					case 20:case 21:case 22:case 23:case 24: $dias=20;		break;
					default: $dias=22;										break;
				endswitch;
				if($acumulados = $this->solicitudes_model->getAcumulados($colaborador->id)):
					$datos['dias_dos']=$dias;
					$datos['vencimiento_dos'] = strtotime('+18 month',strtotime($colaborador->fecha_ingreso));
					$datos['dias_acumulados'] = (int)$acumulados->dias_acumulados + (int)$dias;
				else:
					$datos['dias_uno']=$dias;
					$datos['vencimiento_uno'] = strtotime('+18 month',strtotime($colaborador->fecha_ingreso));
					$datos['dias_acumulados'] = $dias;
				endif;
				$this->solicitudes_model->actualiza_dias_vacaciones($colaborador->id,$datos);
			endif;
		endforeach;
	}

	public function solicitud_expired() {
		$solicitudes = $this->solicitudes_model->getAll();
		foreach ($solicitudes as $solicitud):
			//identificar las solicitudes que no han sido canceladas o cerradas
			if(!in_array($solicitud->estatus,array(0,3,4))):
				$cancelacion = strtotime('+30 days',strtotime($solicitud->fecha_ultima_modificacion));
				$cancelacion = date('Y-m-d',$cancelacion);
				$cancelacion = new DateTime($cancelacion);
				$hoy=new DateTime(date('Y-m-d'));
				if($hoy->diff($cancelacion)->d == 0):
					$datos['estatus']=0;
					$datos['razon']='Se cancela por falta de seguimiento al día '.date('Y-m-d');
					$this->solicitudes_model->update_solicitud($solicitud->id,$datos);
				endif;
			endif;
		endforeach;
	}

	public function inicia_vacaciones() {
		$vacaciones=$this->solicitudes_model->getVacaciones();
		foreach ($vacaciones as $registro) :
			$solicitud=$this->solicitudes_model->getSolicitudById($registro->id);
			$this->actualiza_dias_disponibles($solicitud);
		endforeach;
	}
}