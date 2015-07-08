<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Agregar Área</h2>
  </div>
</div>
<div class="container">
  <div align="center">
	<form role="form" method="post" action="<?= base_url('area/create');?>" class="form-signin">
	  <div class="form-group">
	    <label for="nombre">Área:</label>
	    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
	    id="nombre" required value="" placeholder="Nombre">
	    <label for="tipo">Estatus:</label>
	    <select class="form-control" style="max-width:300px; text-align:center;" name="estatus">
	    	<option value="1">Habilitado</option>
	    	<option value="0">Deshabilitado</option>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Registrar</button>
	  <a href="<?= base_url('area');?>">&laquo;Regresar</a>
	</form>

	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif; ?>
  </div>