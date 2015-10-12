<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dominio extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
      $this->valida_sesion();
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
    	if($this->input->post('area')) :
    		$dominio = $this->input->post('dominio');
        $area = $this->input->post('area');
        $tipo = $this->input->post('tipo');
    		$objetivos = $this->objetivo_model->getByDominio($dominio,$area,$tipo);
    		foreach ($objetivos as $obj):
    	?>
            <tr class="click-row">
              <td class="rowlink-skip"><small><?= $obj->dominio;?></a></small></td>
              <td><small><a style="text-decoration:none" href='<?= base_url("objetivo/ver/").'/'.$obj->id;?>'><?= $obj->nombre;?></a></small></td>
              <td><small><?php foreach ($this->metrica_model->getByObjetivo($obj->id) as $metrica) : 
                  echo $metrica->valor ." - ". $metrica->descripcion ."<br>";
                endforeach; ?></small></td>
              <td><small><?= $obj->tipo;?></small></td>
              <td data-sortable="false" class="rowlink-skip"><small>
                <table class="table table-bordered table-striped table-condensed">
                  <thead>
                    <th class="col-sm-1">Analista</th>
                    <th class="col-sm-1">Consultor</th>
                    <th class="col-sm-1">Consultor Sr</th>
                    <th class="col-sm-1">Gerente / Master</th>
                    <th class="col-sm-1">Gerente Sr / Experto</th>
                    <th class="col-sm-1">Director</th>
                  </thead>
                  <tbody>
                    <tr>
                      <?php $porcentaje = $this->porcentaje_objetivo_model->getByObjetivoArea($obj->id,$area); ?>
                      <td><small><?= !empty($porcentaje->analista) ? $porcentaje->analista->valor : 0;?></small></td>
                      <td><small><?= !empty($porcentaje->consultor) ? $porcentaje->consultor->valor : 0;?></small></td>
                      <td><small><?= !empty($porcentaje->sr) ? $porcentaje->sr->valor : 0;?></small></td>
                      <td><small><?= !empty($porcentaje->gerente) ? $porcentaje->gerente->valor : 0;?></small></td>
                      <td><small><?= !empty($porcentaje->experto) ? $porcentaje->experto->valor : 0;?></small></td>
                      <td><small><?= !empty($porcentaje->director) ? $porcentaje->director->valor : 0;?></small></td>
                    </tr>
                  </tbody>
                </table></small>
              </td>
              <td class="rowlink-skip" align="center"><small><span style="cursor:pointer;" onclick="
              if(confirm('Seguro que desea cambiar el estatus de la Responsabilidad: \n <?= $obj->nombre;?>'))
                location.href='<?= base_url('objetivo/ch_estatus/');?>/'+<?= $obj->id;?>;" class="glyphicon 
              <?php if($obj->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></small></td>
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
        $datos = array(
          'nombre'=>$this->input->post('nombre'),
          'descripcion'=>$this->input->post('descripcion')
        );
        if($id = $this->dominio_model->create($datos))
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
      $datos=array(
        'nombre'=>$this->input->post('nombre'),
        'descripcion'=>$this->input->post('descripcion')
      );
      if($this->dominio_model->update($id,$datos))
        $this->nuevo(null,"Se ha actualizado el dominio");
      else
        $this->ver($id,"Error al agregar dominio");
    }

    private function valida_sesion() {
      if($this->session->userdata('id') == "")
        redirect('login');
    }
}