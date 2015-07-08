<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('area_model');
    }
 
    public function index($msg=null) {
    	$data = array();
    	if (!empty($msg))
    		$data['msg'] = $msg;
    	$data['areaes'] = $this->area_model->getAll();
    	$data['areas'] = $this->area_model->getAll();
    	$this->layout->title('Capital Humano - Áreas');
    	$this->layout->view('area/index',$data);
    }

    public function ver($id,$msg=null) {
    	$data=array();
    	if (!empty($msg))
    		$data['err_msg'] = $msg;
    	$data['area'] = $this->area_model->searchById($id);
    	$this->layout->title('Capital Humano - Info Área');
    	$this->layout->view('area/detalle',$data);
    }

    public function update($id) {
    	$nombre = $this->input->post('nombre');
    	$estatus = $this->input->post('estatus');
    	if($this->area_model->update($id,$nombre,$estatus)){
    		$msg = "Área actualizada correctamente";
    		$this->index($msg);
    	}else{
    		$msg = "Error al actualizar area. Intenta nuevamente";	
    		$this->ver($id,$msg);
    	}
    }

    public function del($id) {
    	$status = $this->area_model->getStatus($id);
    	switch ($status) {
    		case 1:
    			$status=0;
    			break;
    		case 0:
    			$status=1;
    			break;
    	}
    	if($this->area_model->change_status($id,$status))
    		$msg="Estatus ha cambiado";
    	else
    		$msg = "Error al actualizar estatus";
    	$this->index($msg);
    }

    public function nueva($msg=null) {
    	$data = array();
    	if (!empty($msg))
    		$data['err_msg'] = $msg;
    	$this->layout->title('Capital Humano - Nueva Área');
    	$this->layout->view('area/nueva',$data);
    }

    public function create(){
    	$nombre = $this->input->post('nombre');
    	$estatus = $this->input->post('estatus');
    	if($this->area_model->create($nombre,$estatus)){
    		$msg="Área: <b>$nombre</b> agregada correctamente";
    		$this->index($msg);
    	}else{
    		$msg="Error al intentar registrar.Revisa los datos e intenta de nuevo";
    		$this->nueva($msg);
    	}
    }

    public function searchByText() {
        if($this->input->post('valor')) :
            $valor = $this->input->post('valor');
            $resultados = $this->area_model->getByText($valor);
            foreach ($resultados as $resp) : ?>
                <tr>
                  <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
                    location.href='<?= base_url('area/ver/');?>/'+<?= $resp->id;?>"></span> 
                    <span style="cursor:pointer" onclick="location.href='<?= base_url('area/ver/');?>/'+
                    <?= $resp->id;?>"><?= $resp->nombre;?></span></td>
                  <td align="right"><span style="cursor:pointer;" onclick="
                    if(confirm('Seguro que desea cambiar el estatus de la area: \n <?= $resp->nombre;?>'))location.href=
                    '<?= base_url('area/del/');?>/'+<?= $resp->id;?>;" class="glyphicon 
                    <?php if($resp->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
                </tr>
            <?php endforeach;
        else:?>
            <script type="text/javascript">document.location.href="<?= base_url('area');?>";</script>
        <?php endif;
    }
}