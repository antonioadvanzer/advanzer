<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('user_model');
    	$this->load->model('area_model');
        $this->load->model('track_model');
        $this->load->model('posicion_model');
    }

    public function index($msg=null){
        $data['users'] = $this->user_model->getPagination();

        if($msg!=null && $msg!='(:num)')
        	$data['msg']=$msg;
        $this->layout->title('Advanzer - Perfiles');
        $this->layout->view('user/index',$data);
    }

    public function ver($id,$err_msg=null,$msg=null) {
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
    	$this->layout->title('Capital Humano - Detalle Perfil');
    	$this->layout->view('user/detalle',$data);
    }

    public function upload_photo() {
        $id=$this->input->post('id');
    	//set preferences
    	$config['upload_path'] = './assets/images/fotos/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $ext = explode(".", $_FILES['foto']['name']);
        $config['file_name'] = $id.'.'.end($ext);
        $config['overwrite'] = TRUE;

        //load upload class library
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            // case - failure
            $msg = $this->upload->display_errors();
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

    public function update() {
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
        <?php endforeach;
    }

    public function searchByText() {
        $estatus = $this->input->post('estatus');
		$valor = $this->input->post('valor');
        $orden = $this->input->post('orden');
		$resultados = $this->user_model->getByText($valor,$estatus,$orden);
		foreach ($resultados as $user) : ?>
			<tr>
                <td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$user->foto;?>"></td>
                <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
                  location.href='<?= base_url('user/ver/');?>/'+<?= $user->id;?>"></span> 
                  <span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
                  <?= $user->id;?>"><?= $user->nomina;?></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
                  <?= $user->id;?>"><?= $user->nombre;?></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
                  <?= $user->id;?>"><?= $user->email;?></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
          <?= $user->id;?>"><img width="60px"src="<?= base_url('assets/images').'/'.$user->empresa.'.png';?>"></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver');?>/'+
                  <?= $user->id;?>"><?= $user->track;?></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
                  <?= $user->id;?>"><?= $user->posicion;?></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
                  <?= $user->id;?>"><?= $user->area;?></span></td>
                <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
                  <?= $user->id;?>"><?= $user->plaza;?></span></td>
                <td align="right"><span style="cursor:pointer;" onclick="
                  if(confirm('Seguro que desea cambiar el estatus del usuario: \n <?= $user->nombre;?>'))location.href=
                  '<?= base_url('user/del/');?>/'+<?= $user->id;?>;" class="glyphicon 
                  <?php if($user->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
            </tr>
	        <script type="text/javascript">$("#pagination").hide('slow');</script>
		<?php endforeach;
    }

    public function nuevo($msg=null) {
    	$data=array();
    	if($msg!=null)
    		$data['err_msg'] = $msg;
        $data['tracks'] = $this->track_model->getAll();
    	$data['areas'] = $this->area_model->getAll();
        $data['jefes'] = $this->user_model->getAll();
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
        $temp=explode('@',$this->input->post('email'));
        $temp=explode('.',$temp[0]);
        $array['password'] = md5($temp[0]);
        $posicion=$this->input->post('posicion');
        $track=$this->input->post('track');
        $array['posicion_track'] = $this->posicion_model->getPosicionTrack($posicion,$track);

    	if($id = $this->user_model->create($array)){
    		$response['msg']="ok";
    		$response['id']=$id;
    	}else
    		$response['msg']="Error al intentar registrar perfil.Revisa los datos e intenta de nuevo";
        echo json_encode($response);
    }

    public function recision() {
    	$id = $this->input->post('id');
        $datos = array(
            'fecha_baja'=>$this->input->post('fecha_baja'),
            'tipo_baja'=>$this->input->post('tipo_baja'),
            'motivo'=>$this->input->post('motivo'),
            'estatus'=>0
        );
    	if($this->user_model->enable_disable($id,$datos))
    		$response['msg']="ok";
    	else
    		$response['msg'] = "Error al dar de baja al colaborador. Intenta de nuevo";
    	echo json_encode($response);
    }

    public function rehab() {
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
}