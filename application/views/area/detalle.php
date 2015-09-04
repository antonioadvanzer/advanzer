<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle del Área</h2>
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
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
	  <input type="hidden" id="id" value="<?= $area->id;?>">
	  <div class="row">
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required value="<?= $area->nombre; ?>">
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="direccion">Dirección:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" id="direccion">
		    	<?php foreach ($direcciones as $direccion) : ?>
		    		<option value="<?= $direccion->id;?>" <?php if($area->direccion == $direccion->id) echo "selected"; ?>>
		    			<?= $direccion->nombre;?></option>
		    	<?php endforeach; ?>
		    </select>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="estatus">Estatus:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" id="estatus">
		    	<option value="1" <?php if($area->estatus == 1) echo "selected"; ?>>Habilitado</option>
		    	<option value="0" <?php if($area->estatus == 0) echo "selected"; ?>>Deshabilitado</option>
		    </select>
		  </div>
		</div>
	  </div>
	  <div class="row">
	  	<div class="form-group">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Actualizar</button>
		</div>
	  </div>
	</form>
  </div>
  <script>
	$(document).ready(function() {
		$('#update').submit(function(event){
			id = $('#id').val();
			nombre = $('#nombre').val();
			$("#estatus option:selected").each(function() {
				estatus = $('#estatus').val();
			});
			$("#direccion option:selected").each(function() {
				direccion = $('#direccion').val();
			});
			$("#tipo option:selected").each(function() {
				tipo = $('#tipo').val();
			});
			$.ajax({
				url: '<?= base_url("area/update");?>',
				type: 'post',
				data: {'id':id,'nombre':nombre,'estatus':estatus,'tipo':tipo,'direccion':direccion},
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

			event.preventDefault();
		});
	});
  </script>