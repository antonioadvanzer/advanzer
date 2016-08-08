<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
        $this->valida_sesion();
    	$this->load->model('user_model');
    	$this->load->model('area_model');
        $this->load->model('track_model');
        $this->load->model('posicion_model');
        $this->load->model('requisicion_model');
		$this->load->model('solicitudes_model');
    }

    public function index($flag=null){
        $this->valida_acceso();
        $data['users'] = $this->user_model->getPagination($flag);
        $this->layout->title('Advanzer - Perfiles');
        $this->layout->view('user/index',$data);
    }

    public function ver($id,$err_msg=null,$msg=null) {
        $this->valida_acceso();
    	$data=array();
    	if (!empty($err_msg))
    		$data['err_msg'] = $err_msg;
    	if (!empty($msg))
    		$data['msg'] = $msg;
    	
        $data['user'] = $this->user_model->searchById($id);
        $data['tracks'] = $this->track_model->getAll();
    	$data['areas'] = $this->area_model->getAll();
        $data['posiciones'] = $this->posicion_model->getByTrack($this->user_model->getTrackByUser($id));
        $data['jefes'] = $this->user_model->getJefes($id);
        $data['tipo_acceso'] = $this->user_model->getPermisos($data['user']->area);
		
		// Calular vacaciones en base a solicitudes existentes
		$data['yo'] = $this->calculaVacaciones($id);

        // datos de vacaciones acumulados
            //echo $data['yo']->de_solicitud;exit;
            //echo $data['yo']->disp;exit;
        $vs = array(
            "proximo_vencimiento" => 0,
            "recien_generadas" => 0,
            "proporcionales" => $data['yo']->disp,
            "vencimiento_uno" => "",
            "vencimiento_dos" => "",
            "dias_acumulados" => ""
        );

        if($vans = $data['user']->vacaciones){
            $vs['proximo_vencimiento'] = $vans->dias_uno;
            $vs['recien_generadas'] = $vans->dias_dos;
            $vs['vencimiento_uno'] = $vans->vencimiento_uno;
            $vs['vencimiento_dos'] = $vans->vencimiento_dos;
            $vs['dias_acumulados'] = $vans->dias_acumulados;

            // Calcular dias en base a solicitudes realizadas y aprobadas
            if($data['yo']->de_solicitud != 0){

                $diasSolicitados = $data['yo']->de_solicitud;

                /*while(true){

                    if($vs['proximo_vencimiento'] > 0){
                        $vs['proximo_vencimiento'] = $vs['proximo_vencimiento'] + $data['yo']->de_solicitud;
                        if($vs['proximo_vencimiento'] >= 0){
                            break;
                        }
                    }elseif($vs['recien_generadas'] > 0){
                        $vs['recien_generadas'] = $vs['recien_generadas'] + $vs['proximo_vencimiento'];
                        $vs['proximo_vencimiento'] = 0;
                        $vs['vencimiento_uno'] = "";
                        if($vs['recien_generadas'] >= 0){
                            break;
                        }
                    }elseif($vs['proporcionales'] > 0){
                        $vs['proporcionales'] = $vs['proporcionales'] + $vs['recien_generadas'];
                        $vs['recien_generadas'] = 0;
                        $vs['vencimiento_dos'] = "";
                            break;
                    }else{break;}

                }*/

                while(true){

                    if($vs['proximo_vencimiento'] > 0){
                        $vs['proximo_vencimiento'] = $vs['proximo_vencimiento'] + $diasSolicitados;
                        if($vs['proximo_vencimiento'] >= 0){
                            break;
                        }
                        $diasSolicitados = $vs['proximo_vencimiento'];
                    }elseif($vs['recien_generadas'] > 0){
                        $vs['recien_generadas'] = $vs['recien_generadas'] + $diasSolicitados;
                        $vs['proximo_vencimiento'] = 0;
                        if($vs['recien_generadas'] >= 0){
                            break;
                        }
                        $diasSolicitados = $vs['recien_generadas'];
                    }elseif($vs['proporcionales'] > 0){
                        $vs['proporcionales'] = $vs['proporcionales'] + $diasSolicitados;
                        $vs['proximo_vencimiento'] = 0;
                        $vs['recien_generadas'] = 0;
                        break;
                    }else{break;}

                }
                $vs['vencimiento_uno'] = ($vs['proximo_vencimiento']  == 0) ? "" : $vs['vencimiento_uno'];
                $vs['vencimiento_dos'] = ($vs['recien_generadas']  == 0) ? "" : $vs['vencimiento_dos'];
            }


        }

        $data['vs'] = $vs;
		
    	$this->layout->title('Capital Humano - Detalle Perfil');
    	$this->layout->view('user/detalle',$data);
    }

    public function upload_photo() {
        $this->valida_acceso();
        $id=$this->input->post('id');
        $nomina=$this->user_model->searchById($id)->nomina;
    	//set preferences
    	$config['upload_path'] = './assets/images/fotos/';
        $config['allowed_types'] = '*';
        $ext = explode(".", $_FILES['foto']['name']);
        $config['file_name'] = $nomina.'.'.end($ext);
        $config['overwrite'] = TRUE;

        //load upload class library
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            // case - failure
            $msg = $this->upload->display_errors();
            echo "$msg <a href='ver/$id'>Regresar</a>";exit();
            redirect('administrar_usuarios');
        }else {
            // case - success
        	//update info in DB
        	$this->user_model->update_foto($id,$config['file_name']);
            $upload_data = $this->upload->data();
            chgrp($upload_data['file_path'], 'apache');
            redirect("user/ver/$id");
        }
    }

    public function actualiza_vacaciones() {
        $this->valida_acceso();
        $array=array(
            'dias_uno' => $this->input->post('diasUno'),
            'dias_dos' => $this->input->post('diasDos'),
            'vencimiento_uno' => $this->input->post('vencimientoUno'),
            'vencimiento_dos' => $this->input->post('vencimientoDos')
        );
        $id=$this->input->post('id');
        if($this->user_model->actualiza_vacaciones($id,$array))
            $response['msg'] = "ok";
        else
            $response['msg'] = "Error al actualizar usuario. Intenta nuevamente";
        echo json_encode($response);
    }

    public function update() {
        $this->valida_acceso();
        $array=array(
        	'nombre' => $this->input->post('nombre'),
        	'email' => $this->input->post('email'),
        	'empresa' => $this->input->post('empresa'),
            'jefe' => $this->input->post('jefe'),
            'plaza' => $this->input->post('plaza'),
        	'area' => $this->input->post('area'),
        	'fecha_ingreso' => $this->input->post('ingreso'),
            'nomina' => $this->input->post('nomina'),
            'categoria' => $this->input->post('categoria'),
            'tipo' => $this->input->post('tipo')
        );

        $id=$this->input->post('id');
        $track = $this->input->post('track');
        $posicion = $this->input->post('posicion');
        $array['posicion_track']=$this->posicion_model->getPosicionTrack($posicion,$track);
    	if($this->user_model->update($id,$array))
    		$response['msg'] = "ok";
    	else
    		$response['msg'] = "Error al actualizar usuario. Intenta nuevamente";
        echo json_encode($response);
    }

    public function load_posiciones() {
        $track=$this->input->post('track');
        $posiciones = $this->posicion_model->getByTrack($track);
        foreach ($posiciones as $posicion) : ?>
            <option value="<?= $posicion->id;?>"><?= $posicion->nombre;?></option>
        <?php endforeach;?>
        <option value="" disabled selected>-- Selecciona una posición --</option>
    <?php }

    public function nuevo($reqId=0) {
        $this->valida_acceso();
    	$data=array();
        if($reqId != 0)
            $data['requisicion']=$this->requisicion_model->getById($reqId);
        $data['tracks'] = $this->track_model->getAll();
        $data['posiciones'] = $this->posicion_model->getAll();
    	$data['areas'] = $this->area_model->getAll();
        $data['jefes'] = $this->user_model->getAll();
        $data['tipo_acceso'] = $this->user_model->getAllPermisos();
        
    	$this->layout->title('Capital Humano - Nuevo Perfil');
    	$this->layout->view('user/nuevo',$data);
    }

    public function create() {
        $array=array(
        	'nombre' => $this->input->post('nombre'),
        	'email' => $this->input->post('email'),
        	'empresa' => $this->input->post('empresa'),
            'jefe' => $this->input->post('jefe'),
        	'plaza' => $this->input->post('plaza'),
        	'area' => $this->input->post('area'),
            'fecha_ingreso' => $this->input->post('ingreso'),
            'nomina' => $this->input->post('nomina'),
            'categoria' => $this->input->post('categoria'),
            'tipo' => $this->input->post('tipo')
        );
        $requisicion=$this->input->post('requisicion');
        $temp=explode('@',$this->input->post('email'));
        $temp=explode('.',$temp[0]);
        $array['password'] = md5('password');
        $posicion=$this->input->post('posicion');
        $track=$this->input->post('track');
        $array['posicion_track'] = $this->posicion_model->getPosicionTrack($posicion,$track);

    	if($id = $this->user_model->create($array)){
    		$response['msg']="ok";
    		$response['id']=$id;
            if($requisicion > 0)
                $this->db->where('id',$requisicion)->update('Requisiciones',array('colaborador_contratado'=>$id));
    	}else
    		$response['msg']="Error al intentar registrar perfil.Revisa los datos e intenta de nuevo";
        echo json_encode($response);
    }

    public function recision() {
        $this->valida_acceso();
        $this->db->trans_begin();
    	$id = $this->input->post('id');
        $datos = array(
            'fecha_baja'=>$this->input->post('fecha_baja'),
            'tipo_baja'=>$this->input->post('tipo_baja'),
            'motivo'=>$this->input->post('motivo'),
            'estatus'=>0
        );
    	$this->user_model->enable_disable($id,$datos);
        $this->user_model->cleanUser($id);
        if($this->db->trans_status() === FALSE):
            $this->db->trans_rollback();
            $response['msg'] = "Error al dar de baja al colaborador. Intenta de nuevo";
        else:
            $this->db->trans_commit();
            $response['msg']="ok";
        endif;

    	echo json_encode($response);
    }

    public function rehab() {
        $this->valida_acceso();
        $id = $this->input->post('id');
        $datos = array(
            'fecha_ingreso'=>$this->input->post('reingreso'),
            'estatus'=>1
        );
        if($this->user_model->enable_disable($id,$datos))
            $response['msg']="ok";
        else
            $response['msg'] = "Error al reactivar colaborador. Intenta de nuevo";
        echo json_encode($response);
    }

    public function load_historial($user) {
        $anio=$this->input->post('anio');
        $info=$this->user_model->getHistorialByIdAnio($user,$anio);
        ?>
            <label for="baja">Rating:</label>
            <select id="rating_historial" class="form-control" style="max-width:160px;" required>
                <option value="" disabled selected>-- Selecciona un valor --</option>
                <option value="A" <?php if($info->rating == "A") echo"selected";?>>A</option>
                <option value="B" <?php if($info->rating == "B") echo"selected";?>>B</option>
                <option value="C" <?php if($info->rating == "C") echo"selected";?>>C</option>
                <option value="D" <?php if($info->rating == "D") echo"selected";?>>D</option>
                <option value="E" <?php if($info->rating == "E") echo"selected";?>>E</option>
            </select>
        <?php
    }

    public function change_historial() {
        $where=array(
            'colaborador'=>$this->input->post('id'),
            'anio'=>$this->input->post('anio')
        );
        $datos=array(
            'rating'=>$this->input->post('rating')
        );
        if($this->user_model->change_historial($where,$datos))
            $response['msg']="ok";
        else
            $response['msg']="Error al actualizar rating de <b>$anio</b>";
        echo json_encode($response);
    }

    private function valida_sesion() {
        if($this->session->userdata('id') == "")
            redirect('login');
    }

    private function valida_acceso() {
        if($this->session->userdata('tipo') < 3)
        redirect();
    }
	
	public function calculaVacaciones($colaborador){
		$data=array();
		$result=$this->user_model->searchById($colaborador);
		$ingreso=new DateTime($result->fecha_ingreso);
		$hoy=new DateTime(date('Y-m-d'));
        $diff = $ingreso->diff($hoy);
        /*var_dump($diff);exit;
        echo $result->fecha_ingreso;
        var_dump($diff);*/
        switch($diff->y){
			case 0:
				$dias=0;
				$dias2=6;
				//$disponibles=floor(($diff->days-($diff->y*365))*6/365);
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

		//$result->disponibles=floor(($diff->days-($diff->y*365))*$dias2/365);
		$result->disponibles = floor(($dias2/12) * $diff->m);

		$result->disp = $result->disponibles;
		$result->extra=$dias2-$result->disponibles;
		$result->de_solicitud=0;
		if($dias_disponibles=$this->solicitudes_model->getDiasDisponibles($result->id)){
			$result->de_solicitud=$dias_disponibles;
			$result->disponibles += (int)$dias_disponibles;
		}
		
		$result->acumulados=$this->solicitudes_model->getAcumulados($result->id);
		
		return $result;
	}
}