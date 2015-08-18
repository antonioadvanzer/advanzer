<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competencia extends CI_Controller {
	// Layout used in this controller
	public $layout_view = 'layout/default';

	function __construct(){
		parent::__construct();
		$this->load->model('competencia_model');
		$this->load->model('indicador_model');
	}

	function nuevo($msg=null,$err=null) {
		$data=array();
		if($msg!=null)
			$data['msg']=$msg;
		if($err!=null)
			$data['err_msg']=$err;
		$data['indicadores'] = $this->indicador_model->getAll();
		$this->layout->title('Advanzer - Registro Competencia');
		$this->layout->view('competencia/nuevo',$data);
	}

	function create() {
		$nombre=$this->input->post('nombre');
		$indicador=$this->input->post('indicador');
		$descripcion=$this->input->post('descripcion');
		$competencia=$this->competencia_model->create($nombre,$indicador,$descripcion);
		if($competencia)
			$this->ver($competencia);
		else
			$this->nuevo(null,"Error al agregar nueva competencia. Intenta de nuevo");
	}

	function ver($id,$msg=null,$err=null) {
		if($err!=null)
			$data['err_msg']=$err;
		if($msg!=null)
			$data['msg']=$msg;
		$data['indicadores']=$this->indicador_model->getAll();
		$data['competencia']=$this->competencia_model->searchById($id);
		$this->layout->title('Advanzer - Detalle Competencia');
		$this->layout->view('competencia/detalle',$data);
	}

	function add_comportamiento() {
		$competencia = $this->input->post('competencia');
		$descripcion=$this->input->post('comportamiento');
		$posiciones=$this->input->post('selected');

		$this->db->trans_begin();
		
		$comportamiento=$this->competencia_model->addComportamiento($competencia,$descripcion);
		if($comportamiento):
			foreach ($posiciones as $posicion) :
				$this->competencia_model->addPosicionToComportamiento($comportamiento,$posicion);
			endforeach;
		endif;

		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function del_comportamiento() {
		$comportamiento=$this->input->post('selected');

		$this->db->trans_begin();
		$this->competencia_model->delComportamiento($comportamiento);
		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function del_posicion_comportamiento() {
		$comportamiento = $this->input->post('comportamiento');
		$niveles = $this->input->post('selected');
		$this->db->trans_begin();
		foreach ($niveles as $nivel) :
			$this->competencia_model->delNivelFromComportamiento($nivel,$comportamiento);
		endforeach;
		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function add_posicion_comportamiento() {
		$comportamiento = $this->input->post('comportamiento');
		$niveles = $this->input->post('selected');
		$this->db->trans_begin();
		foreach ($niveles as $nivel) :
			$this->competencia_model->addNivelToComportamiento($nivel,$comportamiento);
		endforeach;
		if($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
	}

	function load_posiciones_comportamiento() {
		$comportamiento = $this->input->post('comportamiento');
		?>
		<div class="col-md-5">
			<div class="panel panel-primary">
			  <div class="panel-heading">Posiciones asignadas</div>
			  <select id="quitar_pos" name="quitar_pos" class="form-control" multiple 
				style="min-height:135px;max-height:250px;overflow-y:auto;overflow-x:auto;">
				<?php $posiciones=$this->competencia_model->getPosicionesByComportamiento($comportamiento);
				foreach ($posiciones->result() as $posicion) : ?>
					<option value="<?= $posicion->nivel; ?>">Nivel <?= $posicion->nivel;?></option>
				<?php endforeach; ?>
			  </select>
			</div>
		</div>
		<div class="col-md-2">
		  <div class="form-group">&nbsp;</div>
		  <div class="form-group">
			<button id="btnQuitarPos" class="form-control" style="min-width:55px;max-width:130px;">DEL&raquo;</button>
		  </div>
		  <div class="form-group">
			<button id="btnAgregarPos" class="form-control" style="min-width:55px;max-width:130px;">&laquo;ADD</button>
		  </div>
		</div>
		<div class="col-md-5">
		<div class="panel panel-primary">
		  <div class="panel-heading">Posiciones sin asignar</div>
			<select id="agregar_pos" name="agregar_pos" class="form-control" multiple 
			  style="min-height:135px;max-height:250px;overflow-y:auto;overflow-x:auto;">
			  <?php foreach ($this->competencia_model->getPosicionesByComportamiento($comportamiento,$posiciones->result_array())->result() as $posicion) : ?>
				<option value="<?= $posicion->nivel; ?>">Nivel <?= $posicion->nivel;?></option>
			  <?php endforeach; ?>
			</select>
		  </div>
		</div>
		<script>
			$(document).ready(function() {
				$('#btnQuitarPos').click(function() {
					if($('#quitar_pos :selected').length > 0){
						var selected = [];
						$('#quitar_pos :selected').each(function(i,select) {
							selected[i] = $(select).val();
						});
						$("#quitar option:selected").each(function() {
							comportamiento = $('#quitar').val();
						});
						$.ajax({
							url:'<?= base_url("competencia/del_posicion_comportamiento");?>',
							data:{'selected':selected,'comportamiento':comportamiento},
							type:'POST',
							success:function(data) {
								$('body').html(data);
								alert('Se ha(n) eliminado!');
								window.location.reload();
							}
						});
					}
				});
				$('#btnAgregarPos').click(function() {
					if($('#agregar_pos :selected').length > 0){
						var selected = [];
						$('#agregar_pos :selected').each(function(i,select) {
							selected[i] = $(select).val();
						});
						$("#quitar option:selected").each(function() {
							comportamiento = $('#quitar').val();
						});
						$.ajax({
							url:'<?= base_url("competencia/add_posicion_comportamiento");?>',
							data:{'selected':selected,'comportamiento':comportamiento},
							type:'POST',
							success:function(data) {
								$('body').html(data);
								alert('Se ha(n) agregado!');
								window.location.reload();
							}
						});
					}
				});
			});
		</script>
	<?php }

	function update() {
		$id=$this->input->post('id');
		$nombre=$this->input->post('nombre');
		$descripcion=$this->input->post('descripcion');
		$indicador=$this->input->post('indicador');
		if($this->competencia_model->update($id,$nombre,$descripcion,$indicador))
			$this->ver($id,"Se ha actualizado la competencia");
		else
			$this->ver($id,null,"Error al actualizar la competencia. Intente de nuevo");
	}
}