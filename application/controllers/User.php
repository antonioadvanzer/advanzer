<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('user_model');
    	$this->load->model('area_model');
    	$this->load->library('pagination');
    }

    public function index($msg=null){
    	//pagination settings
        $config['base_url'] = base_url('administrar_usuarios');
        $config['total_rows'] = $this->user_model->getCountUsers();
        $config['per_page'] = "25";
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        //call the model function to get the data
        $data['users'] = $this->user_model->getPagination($config["per_page"], $data['page']);

        $data['pagination'] = $this->pagination->create_links();

        if($msg!=null)
        	$data['msg']=$msg;
        $this->layout->title('Capital Humano - Perfiles');
        $this->layout->view('user/index',$data);
    }

    public function ver($id,$err_msg=null,$msg=null) {
    	$data=array();
    	if (!empty($err_msg))
    		$data['err_msg'] = $err_msg;
    	if (!empty($msg))
    		$data['msg'] = $msg;
    	$data['user'] = $this->user_model->searchById($id);
    	$data['areas'] = $this->area_model->getAll($data['user']->tipo);
    	$this->layout->title('Capital Humano - Detalle Perfil');
    	$this->layout->view('user/detalle',$data);
    }

    public function upload_photo($id) {
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
            $this->ver($id,$msg);
        }else {
            // case - success
        	//update info in DB
        	$this->user_model->update_foto($id,$config['file_name']);
            //$upload_data = $this->upload->data();
            $msg = 'La foto ha sido cargada!';
            $this->ver($id,null,$msg);
        }
    }

    public function update($id) {
    	$nombre = $this->input->post('nombre');
    	$email = $this->input->post('email');
    	$empresa = $this->input->post('empresa');
    	$tipo = $this->input->post('tipo');
    	$area = $this->input->post('area');
    	$posicion = $this->input->post('posicion');
    	$estatus = $this->input->post('estatus');
        $requisicion=$this->inout->post('requisicion');
        $admin=$this->input->post('admin');
    	if($this->user_model->update($id,$nombre,$email,$tipo,$area,$posicion,$estatus)){
    		$msg = "Perfil actualizado correctamente";
    		$this->index($msg);
    	}else{
    		$msg = "Error al actualizar usuario. Intenta nuevamente";	
    		$this->ver($id,$msg);
    	}
    }

    public function load_areas() {
    	$options="";
    	if($this->input->post('tipo')) {
    		$tipo = $this->input->post('tipo');
    		$areas = $this->area->getAll($tipo);
    		foreach ($areas as $area) { ?>
    			<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
    		<?php }
    	}
    }

    public function searchByText() {
    	if($this->input->post('valor')) :
    		$valor = $this->input->post('valor');
    		$resultados = $this->user_model->getByText($valor);
    		foreach ($resultados as $user) : ?>
    			<tr>
		          <td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$user->foto;?>"></td>
		          <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
		            location.href='<?= base_url('user/ver/');?>/'+<?= $user->id;?>"></span> 
		            <span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
		            <?= $user->id;?>"><?= $user->nombre;?></span></td>
		          <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
		            <?= $user->id;?>"><?= $user->email;?></span></td>
		          <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
		            <?= $user->id;?>"><?php if($user->empresa == 1) echo "Advanzer"; 
		            elseif($user->empresa == 2) echo "Entuizer";?></span></td>
		          <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
		            <?= $user->id;?>"><?= $user->tipo;?></span></td>
		          <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
		            <?= $user->id;?>"><?= $user->posicion;?></span></td>
		          <td align="right"><span style="cursor:pointer;" onclick="
		            if(confirm('Seguro que desea cambiar el estatus del usuario: \n <?= $user->nombre;?>'))location.href=
		            '<?= base_url('user/del/');?>/'+<?= $user->id;?>;" class="glyphicon 
		            <?php if($user->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
		        </tr>
		        <script type="text/javascript">$("#pagination").hide('slow');</script>
    		<?php endforeach;
    	else:?>
    		<script type="text/javascript">document.location.href="<?= base_url('administrar_usuarios');?>";</script>
    	<?php endif;
    }

    public function nuevo($msg=null) {
    	$data=array();
    	if($msg!=null)
    		$data['err_msg'] = $msg;
    	$data['areas'] = $this->area_model->getAll();
    	$this->layout->title('Capital Humano - Nuevo Perfil');
    	$this->layout->view('user/nuevo',$data);
    }

    public function create() {
    	$nombre = $this->input->post('nombre');
    	$email = $this->input->post('email');
    	$empresa = $this->input->post('empresa');
    	$tipo = $this->input->post('tipo');
    	$area = $this->input->post('area');
    	$posicion = $this->input->post('posicion');
    	$estatus = $this->input->post('estatus');
        $temp=explode('.',$email);
        $password=$temp[0];
        $requisicion=$this->input->post('requisicion');
        $admin=$this->input->post('admin');
    	if($id = $this->user_model->create($nombre,$email,$empresa,$tipo,$area,$posicion,$estatus,$password,$requisicion,$admin)){
    		$msg="Perfil: <b>$nombre</b> agregado correctamente";
    		$this->ver($id,null,$msg);
    	}else{
    		$msg="Error al intentar registrar perfil.Revisa los datos e intenta de nuevo";
    		$this->nuevo($msg);
    	}
    }

    public function del($id) {
    	$status = $this->user_model->getStatus($id);
    	switch ($status) {
    		case 1:
    			$status=0;
    			break;
    		case 0:
    			$status=1;
    			break;
    	}
    	if($this->user_model->change_status($id,$status))
    		$msg="Estatus ha cambiado";
    	else
    		$msg = "Error al actualizar estatus";
    	$this->index($msg);
    }
}