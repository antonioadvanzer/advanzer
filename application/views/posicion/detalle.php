<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle Posición</h2>
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
	<?php endif; ?>
  </div>
  <form role="form" method="post" action="<?= base_url('posicion/update');?>" class="form-signin">
	<input type="hidden" name="id" value="<?= $posicion->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-2"></div>
	  <div class="col-md-4">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="<?= $posicion->nombre;?>" placeholder="Nombre">
		</div>
	  </div>
	  <div class="col-md-4">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Actualizar Datos</button>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-5">
	  	<div class="panel panel-primary">
	  	  <div class="panel-heading">Track(s) Asignados</div>
		  <select id="quitar" multiple name="track[]" style="min-height:100px;max-height:200px" 
		  	class="form-control">
		  	<?php foreach ($posicion->tracks as $track) : ?>
		  		<option value="<?= $track->id;?>"><?= $track->nombre;?></option>
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
	  </div>
	  <div class="col-md-5">
		<div class="panel panel-primary">
	  	  <div class="panel-heading">Track(s) No asignados</div>
		  <select id="agregar" multiple name="track[]" style="min-height:100px;max-height:200px" 
		  	class="form-control">
		  	<?php foreach ($tracks_no_agregados as $track) : ?>
		  		<option value="<?= $track->id;?>"><?= $track->nombre;?></option>
		  	<?php endforeach; ?>
		  </select>
	  	</div>
	  </div>
	</div>
  </form>
  <div align="center"><a href="<?= base_url('track');?>">&laquo;Regresar</a></div>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnAgregar').click(function() {
				if($('#agregar :selected').length > 0){
					var selected = [];
					$('#agregar :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("posicion/add_tracks/$posicion->id");?>',
						data:{'selected':selected},
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
						url:'<?= base_url("posicion/del_tracks/$posicion->id");?>',
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