<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle Posición</h2>
  </div>
</div>
<div class="container">
	<div align="center" id="alert" style="display:none">
		<div class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg"></label>
		</div>
	</div>
	<div align="center" id="alert_success" style="display:none">
		<div class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<span class="sr-only">Success:</span>
			<label id="msg_success"></label>
		</div>
	</div>
	<div align="center"><a href="<?= base_url('track');?>">&laquo;Regresar</a></div>
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
		<input type="hidden" id="id" value="<?= $posicion->id;?>">
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
				<label></label>
				<button type="submit" class="btn btn-lg btn-primary btn-block" 
					style="max-width:200px; text-align:center;">Actualizar Nombre</button>
			</div>
		</div>
	</form>
	<div class="row" align="center">
	  <div class="col-md-5">
	  	<div class="panel panel-primary">
	  	  <div class="panel-heading">Track(s) Asignados</div>
		  <select id="quitar" multiple name="track[]" style="overflow-y:auto;overflow-x:auto;min-height:100px;max-height:200px" 
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
		  <select id="agregar" multiple name="track[]" style="overflow-y:auto;overflow-x:auto;min-height:100px;max-height:200px" 
		  	class="form-control">
		  	<?php foreach ($tracks_no_agregados as $track) : ?>
		  		<option value="<?= $track->id;?>"><?= $track->nombre;?></option>
		  	<?php endforeach; ?>
		  </select>
	  	</div>
	  </div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#update').submit(function(event){
				$('#alert').prop('display',false);
				$('#alert_success').prop('display',false);
				id = $('#id').val();
				nombre = $('#nombre').val();
				$.ajax({
					url: '<?= base_url("posicion/update");?>',
					type: 'post',
					data: {'id':id,'nombre':nombre},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok"){
							$('#alert_success').prop('display',true).show();
							$('#msg_success').html(returnedData['alert']);
						}else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnedData['msg']);
						}
					}
				});

				event.preventDefault();
			});
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
							window.location.reload();
						}
					});
				}
			});
		});
	</script>