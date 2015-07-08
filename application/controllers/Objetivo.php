<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Objetivo extends CI_Controller {
    // Layout used in this controller
    public $layout_view = 'layout/default';

    function __construct(){
    	parent::__construct();
    	$this->load->model('objetivo_model');
    	$this->load->model('metrica_model');
    	$this->load->model('dominio_model');
    	$this->load->model('area_model');
    }

    function ver($id,$msg=null) {
    	$data=array();
    	if (!empty($msg))
    		$data['err_msg'] = $msg;
    	$data['objetivo'] = $this->objetivo_model->searchById($id);
    	$data['dominios'] = $this->dominio_model->getAll();
    	$data['areas_asignadas'] = $this->area_model->getByObjetivo($data['objetivo']->id);
        $data['areas_no_asignadas'] = $this->area_model->getNotObjetivo($data['areas_asignadas']);
    	$this->layout->title('Capital Humano - Info Objetivo');
    	$this->layout->view('objetivo/detalle',$data);
    }

    function load_metricas($objetivo) {
    	$valor = $this->input->post('valor');
    	$metrica = $this->metrica_model->getValorByObjetivo($valor,$objetivo);
    	?>
        <textarea name="descripcion" class="form-control" rows="2" style="max-width:300px;text-align:center;" required 
            placeholder="Agrega una descripción"><?php if(!empty($metrica)) echo $metrica->descripcion;?></textarea>
    	<?php 
    }

    function load_pesos($objetivo) {
        $posicion = $this->input->post('posicion');
        $peso = $this->objetivo_model->getPesoByPosicion($objetivo,$posicion);
        ?>
        <input class="form-control" name="valor" style="max-width:300px;text-align:center;" required 
            placeholder="Agrega un porcentaje" value="<?php if(!empty($peso)) echo $peso->valor;?>">
        <?php
    }

    function add_area() {
    	$area = $this->input->post('area');
    	$objetivo = $this->input->post('objetivo');
    	if($this->objetivo_model->add_area($objetivo,$area))
    		redirect("objetivo/ver/$objetivo");
    	else
    		$this->ver($objetivo,'Error al agregar area. Intenta de nuevo');
    }

    function del_area() {
        $area = $this->input->post('area');
        $objetivo = $this->input->post('objetivo');
        if($this->objetivo_model->del_area($objetivo,$area))
            redirect("objetivo/ver/$objetivo");
        else
            $this->ver($objetivo,'Error al eliminar area. Intenta de nuevo');
    }

    function update() {
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $dominio = $this->input->post('dominio');
        $descripcion = $this->input->post('descripcion');
        if($this->objetivo_model->update($id,$nombre,$dominio,$descripcion))
            redirect("objetivo/ver/$id");
        else
            $this->ver($id,'Error al actualizar datos del objetivo. Intenta de nuevo');
    }

    function nuevo($msg=null) {
        if ($msg != null)
            $data['err_msg'] = $msg;
        $data['dominios'] = $this->dominio_model->getAll();
        $this->layout->title('Capital Humano - Nuevo Objetivo');
        $this->layout->view('objetivo/nuevo',$data);
    }

    function create() {
        $nombre=$this->input->post('nombre');
        $dominio=$this->input->post('dominio');
        $descripcion=$this->input->post('descripcion');
        if($id = $this->objetivo_model->create($nombre,$dominio,$descripcion))
            redirect("objetivo/ver/$id");
        else
            $this->nuevo("Error al agregar objetivo. Intenta de nuevo");
    }

    function update_metrica() {
        $objetivo = $this->input->post('objetivo');
        $metrica = $this->input->post('valor');
        $descripcion = $this->input->post('descripcion');
        if($this->metrica_model->update($metrica,$objetivo,$descripcion))
            redirect("objetivo/ver/$objetivo");
        else
            $this->ver($objetivo,"Error al actualizar métrica. Intenta de nuevo");
    }

    function update_peso() {
        $objetivo = $this->input->post('objetivo');
        $posicion = $this->input->post('posicion');
        $valor = $this->input->post('valor');
        if($this->objetivo_model->update_peso($objetivo,$posicion,$valor))
            redirect("objetivo/ver/$objetivo");
        else
            $this->ver($objetivo,"Error al actualizar Peso Relativo. Intenta de nuevo");
    }
}