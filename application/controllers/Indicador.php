<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Indicador extends CI_Controller {
	// Layout used in this controller
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->valida_sesion();
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
    	if(!empty($indicador)):
    		foreach ($this->indicador_model->getCompetenciasByIndicador($indicador) as $competencia) : ?>
    			<tr class="click-row">
					<td><small><a href="<?= base_url('competencia/ver/').'/'.$competencia->id;?>"><?= $competencia->nombre;?></a></small></td>
					<td data-sortable="false" class="rowlink-skip"><small>
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
								<?php foreach ($this->indicador_model->getComportamientosByCompetencia($competencia->id) as $comportamiento) :?>
									<tr>
										<td><?= $comportamiento->descripcion;?></td>
										<?php //$porcentaje = $this->porcentaje_objetivo_model->getByObjetivoArea($obj->id,$area->id); //expected to be or not?>
										<td style="vertical-align:middle;text-align:center;"><?php if($comportamiento->analista):?>
											<span class='glyphicon glyphicon-ok'></span>
											<?php else: ?><span class='glyphicon glyphicon-remove'></span><?php endif;?></td>
										<td style="vertical-align:middle;text-align:center;"><?php if($comportamiento->consultor):?>
											<span class='glyphicon glyphicon-ok'></span>
											<?php else: ?><span class='glyphicon glyphicon-remove'></span><?php endif;?></td>
										<td style="vertical-align:middle;text-align:center;"><?php if($comportamiento->sr):?>
											<span class='glyphicon glyphicon-ok'></span>
											<?php else: ?><span class='glyphicon glyphicon-remove'></span><?php endif;?></td>
										<td style="vertical-align:middle;text-align:center;"><?php if($comportamiento->gerente):?>
											<span class='glyphicon glyphicon-ok'></span>
											<?php else: ?><span class='glyphicon glyphicon-remove'></span><?php endif;?></td>
										<td style="vertical-align:middle;text-align:center;"><?php if($comportamiento->experto):?>
											<span class='glyphicon glyphicon-ok'></span>
											<?php else: ?><span class='glyphicon glyphicon-remove'></span><?php endif;?></td>
										<td style="vertical-align:middle;text-align:center;"><?php if($comportamiento->director):?>
											<span class='glyphicon glyphicon-ok'></span>
											<?php else: ?><span class='glyphicon glyphicon-remove'></span><?php endif;?></td>
									</tr>
								<?php endforeach; ?></ul>
							</tbody>
						</table>
					</small></td>
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

	public function asignar_comportamientos() {
		$data['indicadores'] = $this->indicador_model->getAll();
		foreach ($data['indicadores'] as $indicador) :
			foreach ($indicador->competencias = $this->indicador_model->getCompetenciasByIndicador($indicador->id) as $competencia) {
				$competencia->comportamientos = $this->indicador_model->getComportamientosByCompetencia($competencia->id);
			}
		endforeach;

		$this->layout->title('Capital Humano - Comportamientos');
		$this->layout->view('indicador/asignar_comportamientos',$data);
	}

	function asigna_comportamiento() {
		$datos = array(
			'comportamiento'=>$this->input->post('comportamiento'),
			'nivel_posicion'=>$this->input->post('posicion')
		);
		$valor = $this->input->post('valor');
		if($valor == 'false')
			$resp=$this->indicador_model->delPosicionComportamiento($datos);
		else
			$resp=$this->indicador_model->addComportamientoPosicion($datos);
		if($resp)
			$response['msg']="ok";
		else
			$response['msg']="Error, intenta de nuevo";
		echo json_encode($response);
	}

	private function valida_sesion() {
        if($this->session->userdata('id') == "")
            redirect('login');
    }
}