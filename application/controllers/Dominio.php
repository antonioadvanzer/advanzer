<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dominio extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('dominio_model');
    	$this->load->model('objetivo_model');
    	$this->load->model('metrica_model');
    	$this->load->model('porcentaje_objetivo_model');
      $this->load->model('area_model');
    }

    public function index($msg=null) {
      if($msg!=null)
        $data['msg']=$msg;
    	$data['dominios'] = $this->dominio_model->getAll();
    	
      $this->layout->title('Capital Humano - Objetivos');
    	$this->layout->view('dominio/index',$data);
    }

    public function load_objetivos() {
    	if($this->input->post('dominio')) :
    		$dominio = $this->input->post('dominio');
    		$objetivos = $this->objetivo_model->getByDominio($dominio);
    		foreach ($objetivos as $obj): 
          $area = $this->area_model->searchByObjetivo($obj->id);
    	?>
            <tr>
              <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
                location.href='<?= base_url('objetivo/ver/');?>/'+<?= $obj->id;?>"></span> 
                <span style="cursor:pointer" onclick="location.href='<?= base_url('objetivo/ver/');?>/'+
                <?= $obj->id;?>"><?= $obj->nombre;?></span></td>
              <td><span style="cursor:pointer" onclick="location.href='<?= base_url('objetivo/ver/');?>/'+
                <?= $obj->id;?>"><?= $obj->descripcion;?></span></td>
              <td><span style="cursor:pointer" onclick="location.href='<?= base_url('objetivo/ver/');?>/'+
                <?= $obj->id;?>">
                  <?php foreach ($this->metrica_model->getByObjetivo($obj->id) as $metrica) : 
                  	echo $metrica->valor ." - ". $metrica->descripcion ."<br>";
                  endforeach; ?>
                </span></td>
              <td><span style="cursor:pointer" onclick="location.href='<?= base_url('objetivo/ver/');?>/'+
                <?= $obj->id;?>"><?= $area->nombre;?></span></td>
              <td><span style="cursor:pointer" onclick="location.href='<?= base_url('objetivo/ver/');?>/'+
                <?= $obj->id;?>">
                  <?php foreach ($this->porcentaje_objetivo_model->getByObjetivo($obj->id) as $porc) : 
                  	echo $porc->posicion." - ". $porc->valor ."%<br>";
                  endforeach; ?>
                </span></td>
              <td align="right"><span style="cursor:pointer;" onclick="
	              if(confirm('Seguro que desea cambiar el estatus del objetivo: \n <?= $obj->nombre;?>'))location.href=
	              '<?= base_url('objetivo/del/');?>/'+<?= $obj->id;?>;" class="glyphicon 
	              <?php if($obj->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
            </tr>
          <?php endforeach;
    	else:?>
            <script type="text/javascript">document.location.href="<?= base_url('dominio');?>";</script>
    	<?php endif;
    }

    public function nuevo($err=null,$msg=null) {
      $data=array();
      if ($err != null)
        $data['err_msg'] = $err;
      if ($msg != null)
        $data['msg'] = $msg;
      $data['dominios']=$this->dominio_model->getAll(null);
      $this->layout->title('Advanzer - Nuevo Dominio');
      $this->layout->view('dominio/nuevo',$data);
    }

    public function create() {
        $nombre=$this->input->post('nombre');
        if($id = $this->dominio_model->create($nombre))
            $this->nuevo(null,"Dominio registrado satisfactoriamente");
        else
            $this->nuevo("Error al agregar objetivo. Intenta de nuevo");
    }

    public function ch_estatus($id) {
      switch($this->dominio_model->getEstatusById($id)){
        case 1:
          $estatus=0;
          break;
        case 0:
          $estatus=1;
          break;
      }
      if($this->dominio_model->ch_estatus($id,$estatus))
        $this->nuevo(null,"Se ha realizado el cambio de estatus");
      else
        $this->nuevo("Error al intentar hacer el cambio de estatus. Intenta de nuevo");
    }

    public function ver($id,$err=null) {
      if($err != null)
        $data['err_msg']=$err;
      $data['dominio']=$this->dominio_model->searchById($id);
      $this->layout->title('Advanzer - Detalle Dominio');
      $this->layout->view('dominio/detalle',$data);
    }

    public function update($id) {
      $nombre=$this->input->post('nombre');
      $descripcion=$this->input->post('descripcion');
      if($this->dominio_model->update($id,$nombre,$descripcion))
        $this->index("Se ha registrado un nuevo dominio");
      else
        $this->ver($id,"Error al agregar dominio");
    }
}