<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indicador extends CI_Controller {
	// Layout used in this controller
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->load->model('indicador_model');
	}

	public function index($msg=null) {
		if($msg!=null)
			$data['msg']=$msg;
			$data['indicadores'] = $this->indicador_model->getAll();

		$this->layout->title('Capital Humano - Competencias');
		$this->layout->view('indicador/index',$data);
    }

    public function load_competencias() {
    	$indicador = $this->input->post('indicador');
    	$posicion = $this->input->post('posicion');
    	if(!empty($indicador) && !empty($posicion)):
    		foreach ($this->indicador_model->getCompetenciasByIndicadorPosicion($indicador,$posicion) as $competencia) : ?>
    			<tr>
					<td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
							location.href='<?= base_url('competencia/ver/');?>/'+<?= $competencia->id;?>"></span> 
						<span style="cursor:pointer" onclick="location.href='<?= base_url('competencia/ver/');?>/'+
							<?= $competencia->id;?>"><?= $competencia->nombre;?></span></td>
					<td><span style="cursor:pointer" onclick="location.href='<?= base_url('competencia/ver/');?>/'+
						<?= $competencia->id;?>"><?= $competencia->descripcion;?></span></td>
					<td><span style="cursor:pointer" onclick="location.href='<?= base_url('competencia/ver/');?>/'+
						<?= $competencia->id;?>">
						<ul>
						<?php foreach ($this->indicador_model->getComportamientosByCompetenciaPosicion($competencia->id,$posicion) as $comportamiento) : 
							echo "<li>$comportamiento->descripcion</li>";
						endforeach; ?>
						</ul>
					</span></td>
					<td><span style="cursor:pointer" onclick="location.href='<?= base_url('competencia/ver/');?>/'+
						<?= $competencia->id;?>"><?= $competencia->puntuacion;?></span></td>
				</tr>
    			<?php
    		endforeach;
    	endif;
    }

    public function nuevo($err=null,$msg=null) {
    	$data=array();
    	if($err!=null)
    		$data['err_msg']=$err;
    	if($msg!=null)
    		$data['msg']=$msg;
    	$data['indicadores']=$this->indicador_model->getAll();
    	$this->layout->title('Advanzer - Nuevo Indicador');
    	$this->layout->view('indicador/nuevo',$data);
    }

    public function create() {
    	$nombre=$this->input->post('nombre');
    	if($this->indicador_model->create($nombre))
    		$this->nuevo(null,"Indicador registrado");
    	else
    		$this->nuevo("Error al registrar nuevo indicador.Intenta nuevamente");
    }

    public function ver($id,$err=null) {
		if($err != null)
			$data['err_msg']=$err;
		$data['indicador']=$this->indicador_model->searchById($id);
		$this->layout->title('Advanzer - Detalle Indicador');
		$this->layout->view('indicador/detalle',$data);
	}

	public function update() {
		$id=$this->input->post('id');
		$nombre=$this->input->post('nombre');
		if($this->indicador_model->update($id,$nombre))
			$this->nuevo(null,"Indicador actualizado");
		else
			$this->ver($id,"Error al registrar indicador. Intenta de nuevo");
	}

	public function ch_estatus($id) {
		switch($this->indicador_model->searchById($id)->estatus){
			case 1:
				$estatus=0;
				break;
			case 0:
				$estatus=1;
				break;
		}
		if($this->indicador_model->ch_estatus($id,$estatus))
			$this->nuevo(null,"Se ha realizado el cambio de estatus");
		else
			$this->nuevo("Error al intentar hacer el cambio de estatus. Intenta de nuevo");
	}
}