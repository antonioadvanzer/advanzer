<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('user_model');
    }
 
    public function index() {
    	// Include two files from google-php-client library in controller
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/autoload.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

		// Store values in variables from project created in Google Developer Console
		$client_id = '577890901025-gathucvdkhl9tbg8878skn7ae5i3rguk.apps.googleusercontent.com';
		$client_secret = 'ZkPs2AbhoY3llDEQRb4nW23R';
		$redirect_uri = 'http://localhost:8080/advanzer/auth';
		$simple_api_key = 'AIzaSyDR_DGouvoZkW4v4lt54yMIReQeYKXy6A4';

		// Create Client Request to access Google API
		$client = new Google_Client();
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo");

		// Send Client Request
		$objOAuthService = new Google_Service_OAuth2($client);
		$idU=$this->session->userdata('id');
    	if(empty($idU)){
			// Add Access Token to Session
			if (isset($_GET['code'])) {
				$client->authenticate($_GET['code']);
				$_SESSION['access_token'] = $client->getAccessToken();
				header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
			}

			// Set Access Token to make Request
			if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
				$client->setAccessToken($_SESSION['access_token']);
			} else {
				$authUrl = $client->createAuthUrl();
			}
		}

		$data = array();
		// Get User Data from Google and store them in $data
		if ($client->getAccessToken()) {
			$userData = $objOAuthService->userinfo->get();
			$email = $userData->email;
			$result=$this->user_model->do_login($email,'google');
			if ($result) {
				$_SESSION['access_token'] = $client->getAccessToken();
				$sess_array = array(
					'id'=>$result->id,
					'nombre'=>$result->nombre,
    				'email'=>$result->email,
    				'foto' =>$result->foto,
    				'empresa'=>$result->empresa
				);
    			$data['email'] = $result->email;
    			$this->session->set_userdata($sess_array);
			}
			$this->layout->title('Advanzer - Bienvenido');
			$re="main/index";
		} else {
			$authUrl = $client->createAuthUrl();
			$data['authUrl'] = $authUrl;
			$this->layout->title('Advanzer - Login');
		}

		$this->layout->title('Advanzer - Inicio');
		$this->layout->view('main/index', $data);     // Render view and layout
	}

    public function login() {
    	$this->verify_session();
		// Include two files from google-php-client library in controller
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/autoload.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
		include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

		// Store values in variables from project created in Google Developer Console
		$client_id = '577890901025-gathucvdkhl9tbg8878skn7ae5i3rguk.apps.googleusercontent.com';
		$client_secret = 'ZkPs2AbhoY3llDEQRb4nW23R';
		$redirect_uri = 'http://localhost:8080/advanzer/auth';
		$simple_api_key = 'AIzaSyDR_DGouvoZkW4v4lt54yMIReQeYKXy6A4';

		// Create Client Request to access Google API
		$client = new Google_Client();
		$client->setApplicationName("PHP Google OAuth Login Example");
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
			$result=$this->user_model->do_login($email,'google');
			if ($result) {
				$_SESSION['access_token'] = $client->getAccessToken();
				$sess_array = array(
					'id'=>$result->id,
					'nombre'=>$result->nombre,
    				'email'=>$result->email,
    				'foto' =>$result->foto,
    				'empresa' =>$result->empresa
				);
    			$data['email'] = $result->email;
    			$this->session->set_userdata($sess_array);
			}
			$this->layout->title('Advanzer - Bienvenido');
			$re="main/index";
		} else {
			$authUrl = $client->createAuthUrl();
			$data['authUrl'] = $authUrl;
			$this->layout->title('Advanzer - Login');
			$re="main/login";
		}
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
    				'empresa'=>$result->empresa
    			);
    			$data['email'] = $result->email;
    			$this->session->set_userdata($sess_array);
    			$re="main/index";
    		}else
    			$data['err_msg'] = "No es posible iniciar sesión, verifica las credenciales";
    	}
		// Load view and send values stored in $data
		//$this->load->view('google_authentication', $data);
    	$this->layout->view($re, $data);
    }

    private function verify_session(){
    	$idU=$this->session->userdata('id');
    	if (!empty($idU))
    		redirect(base_url('main'));
    	/*if (empty($this->session->userdata('id')))
    		redirect(base_url('main/login'));*/
    }

    // Unset session and logout
	public function logout() {
		unset($_SESSION['access_token']);
		$this->session->userdata=array();
		redirect(base_url('login'));
	}
}