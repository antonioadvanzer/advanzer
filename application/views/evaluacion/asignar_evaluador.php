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
	  <input type="hidden" id="posicion" value="<?= $colaborador->nivel_posicion;?>">
	  <?php $ocupado=0; if($colaborador->nivel_posicion <= 5) :?>
	  	<div class="row" align="center">
	  		<div class="col-md-6">
	  			<p>Por su nivel de posición en la empresa debes elegir al colaborador que fungirá como <i>Evaluador Anual</i>, 
	  				por default el resto de los evaluadores asignados serán <i>360</i></p>
	  		</div>
	  		<div class="col-md-6">
	  			<div class="form-group">
		  			<label for="anual">Evaluador anual</label>
		  			<select class="form-control" style="max-width:300px;text-align:center" id="anual">
		  				<option value="" selected disabled>-- Evaluador Anual --</option>
		  				<?php foreach($evaluadores as $evaluador) : ?>
							<option value="<?= $evaluador->id;?>" <?php if($evaluador->estatus != 0){ echo "disabled";$ocupado=1;} 
							if($evaluador->anual == 1) echo" selected";?>>
								<?= "$evaluador->nombre - $evaluador->posicion ($evaluador->track)";?></option>
						<?php endforeach; ?>
		  			</select>
		  		</div>
	  		</div>
	  	</div>
	  <?php endif;?>
	  <div class="row" align="center">
	  	<div class="col-md-5">
	  	  <div class="panel panel-primary">
	  	  <div class="panel-heading">Evaluadores Asignados</div>
			<select id="quitar" name="quitar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
			  <?php foreach($evaluadores as $colab) : ?>
	            <option value="<?= $colab->id;?>" <?php if($colab->estatus != 0){ echo "disabled";$ocupado=1;} ?>>
	                <?= "$colab->nombre - $colab->posicion ($colab->track)";?>
	            </option>
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
	  	  	  <?php foreach($no_evaluadores as $colab)
	  	  	  	if(in_array($colab->id, array(1,2,40,85,21,14,17,22,33,61,51,52,74)) || $colaborador->empresa == $colab->empresa): ?>
	            	<option value="<?= $colab->id;?>"><?= "$colab->nombre - $colab->posicion ($colab->track)";?></option>
	          	<?php endif; ?>
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
			var ocupado=<?= $ocupado;?>;
			if(ocupado)
				$('#anual').prop('disabled','disabled');
			var flag = $('#posicion').val();
			if(flag>5 && ocupado == 1)
				$('#agregar').prop('disabled','disabled');
			$('#btnAgregar').click(function() {
				if($('#agregar :selected').length > 0){
					$('#agregar :selected').each(function(i,select) {
						$('#agregar').find($(select)).remove();
						$('#quitar').append($('<option>',{value:$(select).val()}).text($(select).text()));
						if(flag <= 5)
							$('#anual').append($('<option>',{value:$(select).val()}).text($(select).text()));
						else{
							$('#quitar').each(function(i,select) {
								$('#agregar').append($('<option>',{value:$(select).val()}).text($(select).text()));
							});
							$('#quitar').empty().append($('<option>',{value:$(select).val()}).text($(select).text()));
						}
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					$('#quitar :selected').each(function(i,select) {
						$('#quitar').find($(select)).remove();
						if(flag <= 5)
							$('#anual').find("option[value='"+$(select).val()+"']").remove();
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
				if(flag<=5)
					$('#anual option:selected').each(function(i,select) {
						anual = $(select).val();
					});
				else
					$('#quitar option').each(function(i,select) {
						anual = $(select).val();
					});
				var agregar = [];
				$('#quitar option').each(function(i,select) {
					agregar[i] = $(select).val();
				});
				console.log(agregar,quitar,colaborador,anual);
				$.ajax({
					url: '<?= base_url("evaluacion/guarda_evaluadores");?>',
					type: 'POST',
					data: {'colaborador':colaborador,'agregar':agregar,'quitar':quitar,'anual':anual},
					success: function(data) {
						console.log(data);
						var returnData = JSON.parse(data);
						if(returnData['msg'] == "ok")
							window.document.location = '<?= base_url("evaluaciones");?>';
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnData['msg']);
						}
					},
					error: function(xhr) {
						console.log(xhr.responseText);
					}
				});
				event.preventDefault();
			});
		});
	</script>