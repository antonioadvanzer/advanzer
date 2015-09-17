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

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg']="Error al agregar comportamiento";
		}else{
			$this->db->trans_commit();
			$response['msg']="ok";
			$response['msg_success']="Agregado correctamente";
			$response['id']=$comportamiento;
		}
		echo json_encode($response);
	}

	function del_comportamiento() {
		$comportamiento=$this->input->post('selected');

		$this->db->trans_begin();
		$this->competencia_model->delComportamiento($comportamiento);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error al eliminar comportamiento";
		}else{
			$this->db->trans_commit();
			$response['msg'] = "ok";
			$response['msg_success'] = "Se ha eliminado el comportamiento";
		}
		echo json_encode($response);
	}

	function del_posicion_comportamiento() {
		$comportamiento = $this->input->post('comportamiento');
		$niveles = $this->input->post('selected');
		$this->db->trans_begin();
		foreach ($niveles as $nivel) :
			$this->competencia_model->delNivelFromComportamiento($nivel,$comportamiento);
		endforeach;
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg']="Error al desasociar posiciones";
		}else{
			$this->db->trans_commit();
			$response['msg']="ok";
			$response['msg_success'] = "Se ha desasociado la posición";
		}
		echo json_encode($response);
	}

	function add_posicion_comportamiento() {
		$comportamiento = $this->input->post('comportamiento');
		$niveles = $this->input->post('selected');
		$this->db->trans_begin();
		foreach ($niveles as $nivel) :
			$this->competencia_model->addNivelToComportamiento($nivel,$comportamiento);
		endforeach;
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$response['msg'] = "Error al asociar posiciones";
		}else{
			$this->db->trans_commit();
			$response['msg'] = "ok";
			$response['msg_success'] = "Se ha añadido la posición";
		}
		echo json_encode($response);
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
				foreach ($posiciones->result() as $posicion) : 
					switch ($posicion->nivel_posicion) {
						case 3: $nivel="Director"; break;
						case 4: $nivel="Gerente Sr / Experto"; break;
						case 5: $nivel="Gerente / Master"; break;
						case 6: $nivel="Consultor Sr"; break;
						case 7: $nivel="Consultor"; break;
						case 8: $nivel="Analista"; break;
					} ?>
					<option value="<?= $posicion->nivel_posicion; ?>"><?= $nivel;?></option>
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
			  <option value="8">Analista</option>
			  <option value="7">Consultor</option>
			  <option value="6">Consultor Sr</option>
			  <option value="5">Gerente / Master</option>
			  <option value="4">Gerente Sr / Experto</option>
			  <option value="3">Director</option>
			</select>
		  </div>
		</div>
		<script>
			$(document).ready(function() {
				$('#quitar_pos option').each(function(i,select) {
					$('#agregar_pos').find("option[value='"+ $(select).val() +"']").remove();
				});
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
								var returnData = JSON.parse(data);
								if(returnData['msg'] == "ok"){
									$('#quitar_pos :selected').each(function(i,select) {
										$('#quitar_pos').find(select).remove();
										$('#agregar_pos').append($('<option>',{value:$(select).val()}).text($(select).text()));
									});
									$('#alert_success').prop('display',true).show();
									$('#msg_success').html(returnData['msg_success']);
									setTimeout(function() {
										$("#alert_success").fadeOut(1500);
										},3000);
								}else{
									$('#alert').prop('display',true).show();
									$('#msg').html(returnData['msg']);
									setTimeout(function() {
										$("#alert").fadeOut(1500);
										},3000);
								}
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
								console.log(data);
								var returnData = JSON.parse(data);
								if(returnData['msg'] == "ok"){
									$('#agregar_pos :selected').each(function(i,select) {
										$('#agregar_pos').find(select).remove();
										$('#quitar_pos').append($('<option>',{value:$(select).val()}).text($(select).text()));
									});
									$('#alert_success').prop('display',true).show();
									$('#msg_success').html(returnData['msg_success']);
									setTimeout(function() {
										$("#alert_success").fadeOut(1500);
										},3000);
								}else{
									$('#alert').prop('display',true).show();
									$('#msg').html(returnData['msg']);
									setTimeout(function() {
										$("#alert").fadeOut(1500);
										},3000);
								}
							}
						});
					}
				});
			});
		</script>
	<?php }

	function update() {
		$id=$this->input->post('id');
		$datos = array(
			'nombre'=>$this->input->post('nombre'),
			'descripcion'=>$this->input->post('descripcion'),
			'indicador'=>$this->input->post('indicador')
		);
		if($this->competencia_model->update($id,$datos))
			$response['msg'] = "ok";
		else
			$response['msg'] = "Error al actualizar la competencia. Intente de nuevo";
		echo json_encode($response);
	}
}