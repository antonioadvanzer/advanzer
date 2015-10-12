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
    		endforeach;
    		$this->evaluacion_model->setPeriodoEdicion();
    		$msg = date("Y-m-d H:i:s")." - Succesfully executed with activity:\n\t".$msg."\n\n";
    	}else
    		$msg = date("Y-m-d H:i:s")." - Succesfully executed with no activity.\n\n";

    	$this->evaluacion_model->check_PeriodoEdicion();

    	echo $msg;
    }
}