<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Asignar Evaluadores a <?= $colaborador->nombre;?></h2>
  </div>
</div>
<div class="container">
  <div class="row" align="center">
  	<div class="col-md-12">
	  <a href="<?= base_url('evaluaciones');?>">&laquo;Regresar</a>
  	</div>
  </div>
  <hr>
  	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
	  <input type="hidden" id="colaborador" value="<?= $colaborador->id;?>">
	  <div class="row" align="center" id>
	  	<div class="col-md-5">
	  	  <div class="panel panel-primary">
	  	  <div class="panel-heading">Evaluadores Asignados</div>
			<select id="quitar" name="quitar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
			  <?php foreach($evaluadores as $colaborador) : ?>
	            <option value="<?= $colaborador->id;?>">
	                <?= "$colaborador->nombre - $colaborador->posicion ($colaborador->track)";?>
	            </option>?>
			  <?php endforeach; ?>
			</select>
	  	  </div>
	  	</div>
	  	<div class="col-md-2">
		  <div class="form-group">&nbsp;</div>
		  <div class="form-group">
			<button type="button" id="btnQuitar" class="form-control" style="max-width:100px;">Quitar&raquo;</button>
		  </div>
		  <div class="form-group">
			<button type="button" id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
		  </div>
		  <div class="form-group">&nbsp;</div>
	  	</div>
	  	<div class="col-md-5">
	  	  <div class="panel panel-primary">
	  	  <div class="panel-heading">Colaboradores Disponibles</div>
			<select id="agregar" name="agregar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
	  	  	  <?php foreach($no_evaluadores as $colaborador) : ?>
	            <option value="<?= $colaborador->id;?>"><?= "$colaborador->nombre - $colaborador->posicion ($colaborador->track)";?></option>
	          <?php endforeach; ?>
	        </select>
	  	  </div>
	  	</div>
	  </div>
	  <div style="height:60px" class="row" align="center">
		<div class="col-md-12">
			<button type="submit" class="btn btn-lg btn-primary btn-block" 
				style="max-width:200px;text-align:center;">Guardar</button>
		  </div>
	  </div>
	</form>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnAgregar').click(function() {
				if($('#agregar :selected').length > 0){
					$('#agregar :selected').each(function(i,select) {
						$('#agregar').find($(select)).remove();
						$('#quitar').append($('<option>',{value:$(select).val()}).text($(select).text()));
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					$('#quitar :selected').each(function(i,select) {
						$('#quitar').find($(select)).remove();
						$('#agregar').append($('<option>',{value:$(select).val()}).text($(select).text()));
					});
				}
			});

			$('#update').submit(function(event){
				$('#alert').prop('display',false).hide();
				colaborador=$('#colaborador').val();
				var quitar = [];
				$('#agregar option').each(function(i,select) {
					quitar[i] = $(select).val();
				});
				var agregar = [];
				$('#quitar option').each(function(i,select) {
					agregar[i] = $(select).val();
				});
				$.ajax({
					url: '<?= base_url("evaluacion/guarda_evaluadores");?>',
					type: 'POST',
					data: {'colaborador':colaborador,'agregar':agregar,'quitar':quitar},
					success: function(data) {
						console.log(data);
						var returnData = JSON.parse(data);
						if(returnData['msg'] == "ok")
							window.document.location = '<?= base_url("evaluaciones");?>';
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnData['msg']);
						}
					}
				});
				event.preventDefault();
			});
		});
	</script>