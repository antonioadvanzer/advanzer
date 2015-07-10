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
    }

    public function index() {
    	$data['dominios'] = $this->dominio_model->getAll();
    	
      $this->layout->title('Capital Humano - Objetivos');
    	$this->layout->view('dominio/index',$data);
    }

    public function load_objetivos() {
    	if($this->input->post('dominio')) :
    		$dominio = $this->input->post('dominio');
    		$objetivos = $this->objetivo_model->getByDominio($dominio);
    		foreach ($objetivos as $obj): 
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
                <?= $obj->id;?>">
                  <?php foreach ($this->porcentaje_objetivo_model->getByObjetivo($obj->id) as $porc) : 
                  	echo $porc->valor ."% - ". $porc->posicion ."<br>";
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
}