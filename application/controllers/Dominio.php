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
      $data['areas'] = $this->area_model->getAll();
    	
      $this->layout->title('Capital Humano - Responsabilidades');
    	$this->layout->view('dominio/index',$data);
    }

    public function load_objetivos() {
    	if($this->input->post('dominio')) :
    		$dominio = $this->input->post('dominio');
    		$objetivos = $this->objetivo_model->getByDominio($dominio);
    		foreach ($objetivos as $obj):
    	?>
            <tr class="click-row">
              <td><a style="text-decoration:none" href='<?= base_url("objetivo/ver/").'/'.$obj->id;?>'><?= $obj->nombre;?></a></td>
              <td><?php foreach ($this->metrica_model->getByObjetivo($obj->id) as $metrica) : 
                  echo $metrica->valor ." - ". $metrica->descripcion ."<br>";
                endforeach; ?></td>
              <td><?= $obj->tipo;?></td>
              <td data-sortable="false" class="rowlink-skip">
                <table class="table table-bordered table-striped">
                  <thead>
                    <th class="col-sm-2"></th>
                    <th class="col-sm-1">Analista</th>
                    <th class="col-sm-1">Consultor</th>
                    <th class="col-sm-1">Consultor Sr</th>
                    <th class="col-sm-1">Gerente / Master</th>
                    <th class="col-sm-1">Gerente Sr / Experto</th>
                    <th class="col-sm-1">Director</th>
                  </thead>
                  <tbody>
                    <?php foreach ($this->area_model->getByObjetivo($obj->id) as $area) : ?>
                      <tr>
                        <td><?= $area->nombre;?></td>
                        <?php $porcentaje = $this->porcentaje_objetivo_model->getByObjetivoArea($obj->id,$area->id); ?>
                        <td><?php if(!empty($porcentaje->analista)) echo $porcentaje->analista->valor;?></td>
                        <td><?php if(!empty($porcentaje->consultor)) echo $porcentaje->consultor->valor;?></td>
                        <td><?php if(!empty($porcentaje->sr)) echo $porcentaje->sr->valor;?></td>
                        <td><?php if(!empty($porcentaje->gerente)) echo $porcentaje->gerente->valor;?></td>
                        <td><?php if(!empty($porcentaje->experto)) echo $porcentaje->experto->valor;?></td>
                        <td><?php if(!empty($porcentaje->director)) echo $porcentaje->director->valor;?></td>
                      </tr>
                    <?php endforeach; ?></ul>
                  </tbody>
                </table>
              </td>
              <td class="rowlink-skip" align="center"><span style="cursor:pointer;" onclick="
              if(confirm('Seguro que desea cambiar el estatus de la Responsabilidad: \n <?= $obj->nombre;?>'))
                location.href='<?= base_url('objetivo/ch_estatus/');?>/'+<?= $obj->id;?>;" class="glyphicon 
              <?php if($obj->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
            </tr>
          <?php endforeach;
    	else:?>
            <script type="text/javascript">document.location.href="<?= base_url('administrar_dominios');?>";</script>
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
      if($this->dominio_model->update($id,$nombre))
        $this->nuevo(null,"Se ha actualizado el dominio");
      else
        $this->ver($id,"Error al agregar dominio");
    }
}