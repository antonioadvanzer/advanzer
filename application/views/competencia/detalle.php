<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle de la competencia</h2>
  </div>
</div>
<div class="container">
  <div align="center">
	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif;
	if(isset($msg)): ?>
		<div id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $msg;?>
		</div>
	<?php endif; ?>
  </div>
  <form role="form" method="post" action="<?= base_url('competencia/update');?>" class="form-signin">
  	<input type="hidden" name="id" value="<?= $competencia->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-4">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="<?= $competencia->nombre; ?>">
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		  <label for="indicador">Indicador:</label>
		  <select name="indicador" class="form-control" style="max-width:300px; text-align:center">
		  	<?php foreach ($indicadores as $indicador) : ?>
			  <option value="<?= $indicador->id;?>" <?php if($indicador->id == $competencia->indicador) echo"selected";?>>
				<?= $indicador->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		  <label for="descripcion">Descripción:</label>
		  <textarea name="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="3" 
		  	required><?= $competencia->descripcion;?></textarea>
		</div>
	  </div>
	</div>
	<div style="height:60px" class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Actualizar Datos</button>
	  </div>
	</div>
  </form>
  <hr>
  <div class="row" align="center">
	<div class="col-md-12">
	  <label>Comportamientos</label>
	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-5">
  	  <div class="panel panel-primary">
		<div class="panel-heading">Comportamientos Asignados</div>
		<div class="row">
		  <select id="quitar" name="quitar" class="form-control" style="max-width:450px">
		  	<option selected disabled>-- Selecciona un comportamiento --</option>
			<?php foreach($competencia->comportamientos as $comportamiento) : ?>
			  <option value="<?= $comportamiento->id;?>"><?= $comportamiento->descripcion;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
		<div align="center"><div id="cargando" style="display:none; color: green;">
		  <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
		<div class="row" id="result"></div>
	  </div>
  	</div>
  	<div class="col-md-2">
	  <div class="form-group">&nbsp;</div>
	  <div class="form-group">
		<button id="btnQuitar" class="form-control" style="max-width:100px;" disabled>Quitar&raquo;</button>
	  </div>
	  <div class="form-group">
		<button id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
	  </div>
	  <div class="form-group">&nbsp;</div>
  	</div>
  	<div class="col-md-5">
  	  <div class="panel panel-primary" style="min-height:200px">
		<div class="panel-heading">Asignar Comportamiento</div>
		<div class="input-group" style="min-height:70px">
			<span class="input-group-addon">Comportamiento</span>
		</div>
			<input id="comportamiento" type="text" class="form-control" value="" placeholder="Descripción">
			<select id="posicion" name="posicion" multiple class="form-control" 
				style="overflow-y:auto;overflow-x:auto;min-height:130px;max-height:300px">
				<option value="8">Nivel 8 o Superior (Analista)</option>
				<option value="7">Nivel 7 (Consultor / Especialista)</option>
				<option value="6">Nivel 6 (Consultor Sr / Especialista Sr)</option>
				<option value="5">Nivel 5 (Gerente / Master)</option>
				<option value="4">Nivel 4 (Gerente Sr / Experto)</option>
				<option value="3">Nivel 3 o Inferior (Director)</option>
			</select>
	  </div>
  	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-12">
	  <a href="<?= base_url('administrar_indicadores');?>">&laquo;Regresar</a>
  	</div>
  </div>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnAgregar').click(function() {
				if($('#comportamiento').val().length > 0 && $('#posicion :selected').length > 0){
					var comportamiento = $('#comportamiento').val();
					var competencia = <?= $competencia->id;?>;
					var selected = [];
					$('#posicion :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("competencia/add_comportamiento");?>',
						data:{'competencia':competencia,'comportamiento':comportamiento,'selected':selected},
						type:'POST',
						success:function(data) {
							$('body').html(data);
							alert('Se ha agregado!');
							window.location.reload();
						}
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					var selected = [];
					$('#quitar :selected').each(function(i,select) {
						selected = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("competencia/del_comportamiento");?>',
						data:{'selected':selected},
						type:'POST',
						success:function(data) {
							$('body').html(data);
							alert('Se ha eliminado!');
							window.location.reload();
						}
					});
				}
			});
			$("#quitar").change(function() {
				$('#btnQuitar').prop('disabled',false);
				$("#quitar option:selected").each(function() {
					comportamiento = $('#quitar').val();
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('competencia/load_posiciones_comportamiento');?>",
					data: {comportamiento : comportamiento},
					beforeSend: function (xhr) {
						$('#result').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$("#result").show().html(data);
						$('#cargando').hide();
					}
				});
			});
		});
	</script>