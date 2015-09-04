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
	  <div class="form-group">
	    <label for="nombre">Área:</label>
	    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
	    id="nombre" required value="" placeholder="Nombre">
	    <label for="tipo">Estatus:</label>
	    <select class="form-control" style="max-width:300px; text-align:center;" id="estatus">
	    	<option value="1">Habilitado</option>
	    	<option value="0">Deshabilitado</option>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
	  	Registrar</button>
	</form>
  </div>
  <script>
	$(document).ready(function() {
		$('#create').submit(function(event){
			nombre = $('#nombre').val();
			$("#estatus option:selected").each(function() {
				estatus = $('#estatus').val();
			});
			$.ajax({
				url: '<?= base_url("area/create");?>',
				type: 'post',
				data: {'nombre':nombre,'estatus':estatus},
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