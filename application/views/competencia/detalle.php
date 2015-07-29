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
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="<?= $competencia->nombre; ?>">
		</div>
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
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="descripcion">Descripción:</label>
		  <textarea name="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="3" 
		  	required><?= $competencia->descripcion;?></textarea>
		  <label for="puntuacion">Puntuación</label>
		  <input type="text" class="form-control" style="mmax-width:300px;text-align:center" name="puntuacion"
		  	value="<?= $competencia->puntuacion;?>">
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
		<select id="quitar" name="quitar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:160px;max-height:300px">
		  <?php foreach($competencia->comportamientos as $comportamiento) : ?>
			<option value="<?= $comportamiento->id;?>"><?= $comportamiento->descripcion;?> ( |
				<?php foreach ($comportamiento->posiciones as $posicion) :
					echo "$posicion->posicion | ";
				endforeach; ?>
			)</option>
		  <?php endforeach; ?>
		</select>
  	  </div>
  	</div>
  	<div class="col-md-2">
	  <div class="form-group">&nbsp;</div>
	  <div class="form-group">
		<button id="btnQuitar" class="form-control" style="max-width:100px;">Quitar&raquo;</button>
	  </div>
	  <div class="form-group">
		<button id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
	  </div>
	  <div class="form-group">&nbsp;</div>
  	</div>
  	<div class="col-md-5">
  	  <div class="panel panel-primary">
		<div class="panel-heading">Asignar Comportamiento</div>
		<div class="input-group">
			<span class="input-group-addon">Comportamiento</span>
			<input id="comportamiento" type="text" class="form-control" value="" placeholder="Descripción">
			<select id="posicion" name="posicion" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:130px;max-height:300px">
				<option>Analista</option>
				<option>Consultor</option>
				<option>Consultor Sr</option>
				<option>Gerente / Master</option>
				<option>Gerente Sr / Experto</option>
				<option>Director</option>
			</select>
		</div>
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
							alert('Se han agregado!');
							window.location.reload();
						}
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					var selected = [];
					$('#quitar :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("competencia/del_comportamientos");?>',
						data:{'selected':selected},
						type:'POST',
						success:function(data) {
							$('body').html(data);
							alert('Se han eliminado!');
							window.location.reload();
						}
					});
				}
			});
		});
	</script>