<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Agregar Área de Responsabilidad</h2>
  </div>
</div>
<div class="container">
  <div align="center">
	<a href="<?= base_url('area');?>">&laquo;Regresar</a>
	<div id="alert" style="display:none" class="alert alert-danger" role="alert" style="max-width:400px;">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      <label id="msg"></label>
    </div>
	<form id="create" role="form" method="post" action="javascript:" class="form-signin">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="nombre">Área:</label>
					<input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
						id="nombre" required value="" placeholder="Nombre">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="direccion">Dirección:</label>
					<select class="form-control" style="max-width:300px; text-align:center;" id="direccion" required>
						<?php foreach ($direcciones as $direccion) : ?>
							<option value="<?= $direccion->id;?>"><?= $direccion->nombre;?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<label for="tipo">Estatus:</label>
				<select class="form-control" style="max-width:300px; text-align:center;" id="estatus">
					<option value="1">Habilitado</option>
					<option value="0">Deshabilitado</option>
				</select>
			</div>
		</div>
		<div class="row">
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
				Registrar</button>
		</div>
	</form>
  </div>
  <script>
	$(document).ready(function() {
		$('#create').submit(function(event){
			nombre = $('#nombre').val();
			$("#direccion option:selected").each(function() {
				direccion = $('#direccion').val();
			});
			$("#estatus option:selected").each(function() {
				estatus = $('#estatus').val();
			});
			console.log(direccion)
			if(direccion != null)
				$.ajax({
					url: '<?= base_url("area/create");?>',
					type: 'post',
					data: {'nombre':nombre,'estatus':estatus,'direccion':direccion},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok")
							window.document.location='<?= base_url("area");?>';
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnedData['msg']);
						}
					}
				});
			else
				alert('Elige una dirección');
			event.preventDefault();
		});
	});
  </script>