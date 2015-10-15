<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('user_model');
    	$this->load->model('evaluacion_model');
    }
 
    public function index() {
    	$this->valida_sesion();
    	$data=array();
    	$data['colaborador'] = $this->user_model->searchById($this->session->userdata('id'));
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

    // Unset session and logout
	public function logout($err=null) {
		unset($_SESSION['access_token']);
		$this->session->userdata=array();
		$this->login($err);
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
    			$this->exportAnualFile();
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
			'smtp_user' => 'jesus.salas@advanzer.com',
			'smtp_pass' => 'yaucjurn',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

		$this->email->initialize($config);

		$this->email->clear(TRUE);

		$this->email->from('jesus.salas@advanzer.com','Portal de Evaluación Advanzer-Entuizer');
		$this->email->to("jesus_js92@outlook.com");
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
		$objSheet->getStyle('A1:R1')->getFont()->setBold(true)->setName('Verdana')->setSize(11)->getColor()->setRGB('FFFFFF');
		$objSheet->getStyle('A1:R1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objSheet->getStyle('A1:R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A1:R1')->getFill('')->applyFromArray(array('type'=>PHPExcel_Style_Fill::FILL_SOLID, 'startcolor'=>array('rgb'=>'000A75')));
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
			$objSheet->getCell('I1')->setValue('360°');
			$objSheet->getCell('J1')->setValue('Promedio');
			$objSheet->getCell('K1')->setValue('Rating 2012');
			$objSheet->getCell('L1')->setValue('Rating 2013');
			$objSheet->getCell('M1')->setValue('Rating 2014');
			$objSheet->getCell('N1')->setValue('Rating 2015');
			$objSheet->getCell('O1')->setValue('Encargado de Feedback');
			$objSheet->getCell('P1')->setValue('Comentarios de Desempeño');
			$objSheet->getCell('Q1')->setValue('Observaciones de la Junta');
			$objSheet->getCell('R1')->setValue('Acciones a Tomar');

		$column=1;
		foreach ($colaboradores as $colaborador) :
			$column++;
			$total_competencias=null;
			$total_responsabilidades=null;
			$total_proyectos=null;
			$total_360=null;
			$colaborador->total_360=null;
			$colaborador->rating_2012=null;
			$colaborador->rating_2013=null;
			$colaborador->rating_2014=null;
			$evaluadores="";
			$comentarios="";
			foreach ($colaborador->evaluadores as $evaluador) :
				$evaluadores .= $evaluador->nombre." / ";
				$comentarios .= $evaluador->comentarios." / ";
				$total_responsabilidades = $evaluador->responsabilidad;
				$total_competencias = $evaluador->competencia;
			endforeach;
			if(isset($colaborador->evaluadoresProyecto)):
				$dias_total=0;
				foreach ($colaborador->evaluadoresProyecto as $evaluador) :
					$evaluadores .= $evaluador->nombre." / ";
					$comentarios .= $evaluador->comentarios." / ";
					$diferencia=date_diff(date_create($evaluador->inicio_periodo),date_create($evaluador->fin_periodo));
					$dias=(int)$diferencia->format("%a");
					$dias_total+=$dias;
				endforeach;
				foreach ($colaborador->evaluadoresProyecto as $evaluador) :
					$total_proyectos += $evaluador->responsabilidad*($dias/$dias_total);
				endforeach;
			endif;
			if($colaborador->nivel_posicion <= 5):
				$cont=0;
				foreach ($colaborador->evaluadores360 as $evaluador) :
					$evaluadores .= $evaluador->nombre." / ";
					$comentarios .= $evaluador->comentarios." / ";
					$total_360 += $evaluador->competencia;
					$cont++;
				endforeach;
				($total_360) ? $total_360 = $total_360/$cont : $total_360 = null;
				(double)$total_competencias = ($total_competencias + $total_360 + $colaborador->autoevaluacion)/3;
			else:
				(double)$total_competencias = ($total_competencias + $colaborador->autoevaluacion)/2;
			endif;
			(isset($total_proyectos)) ? (double)$total_responsabilidades = (($total_responsabilidades + $total_proyectos)/2) : 
				(double)$total_responsabilidades = $total_responsabilidades;
			
			$objSheet->getCell('A'.$column)->setValue($colaborador->nomina);
			$objSheet->getCell('B'.$column)->setValue($colaborador->nombre);
			$objSheet->getCell('C'.$column)->setValue($colaborador->fecha_ingreso);
			$objSheet->getCell('D'.$column)->setValue($colaborador->track);
			$objSheet->getCell('E'.$column)->setValue($colaborador->posicion);
			$objSheet->getCell('F'.$column)->setValue($evaluadores);
			if($total_competencias)
				$objSheet->getCell('G'.$column)->setValue(number_format($total_competencias,2));
			if($total_responsabilidades)
				$objSheet->getCell('H'.$column)->setValue(number_format($total_responsabilidades,2));
			if($total_360)
				$objSheet->getCell('I'.$column)->setValue(number_format($total_360,2));
			if($colaborador->total)
				$objSheet->getCell('J'.$column)->setValue(number_format($colaborador->total,2));
			$objSheet->getCell('K'.$column)->setValue($colaborador->rating_2012);
			$objSheet->getCell('L'.$column)->setValue($colaborador->rating_2013);
			$objSheet->getCell('M'.$column)->setValue($colaborador->rating_2014);
			$objSheet->getCell('P'.$column)->setValue($comentarios);
			$objSheet->getStyle('A'.$column.':'.'R'.$column)->getAlignment()->setWrapText(true);
			$objSheet->getRowDimension($column)->setRowHeight(-1);
		endforeach;

		$objSheet->getStyle('A2:R'.$column)->getFont()->setSize(12);
		$objSheet->getStyle('G2:I'.$column)->getFont()->setSize(16);
		$objSheet->getStyle('J2:J'.$column)->getFont()->setSize(18);
		$objSheet->getStyle('M2:M'.$column)->getFont()->setSize(24);
		$objSheet->getStyle('A2:R'.$column)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		// create some borders
			// first, create the whole grid around the table
			$objSheet->getStyle('A1:R'.$column)->getBorders()->
			getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			// create medium border around the table
			$objSheet->getStyle('A1:R'.$column)->getBorders()->
			getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
			// create a medium border on the header line
			$objSheet->getStyle('A1:R1')->getBorders()->
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
			$objSheet->getColumnDimension('N')->setAutoSize(true);
			$objSheet->getColumnDimension('O')->setWidth(20);
			$objSheet->getColumnDimension('P')->setWidth(40);
			$objSheet->getColumnDimension('Q')->setWidth(40);
			$objSheet->getColumnDimension('R')->setWidth(40);


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
				$objSheet->getCell('H'.($column+$i))->setValue('=COUNTIF($N$2:$N$'.($column-5).',"'.$letras[$i-1].'")');
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
				$dsv
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

		$file_name = "Reporte_Anual_".(date('Y')-1).".xlsx";

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
			'smtp_user' => 'jesus.salas@advanzer.com',
			'smtp_pass' => 'yaucjurn',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

		$this->email->initialize($config);

		$this->email->clear(TRUE);

		$this->email->from('jesus.salas@advanzer.com','Portal de Evaluación Advanzer-Entuizer');
		$this->email->to("jesus_js92@outlook.com");
		$this->email->subject('Reporte de Evaluación para Junta Anual');
		$this->email->message('<h2>Se ha generado el archivo de Reporte de Evaluación para la Junta Anual</h2><hr>');
		$this->email->attach(base_url("assets/docs/$file_name"));

		if(!$this->email->send())
			var_dump($this->email->print_debugger());
	}
}