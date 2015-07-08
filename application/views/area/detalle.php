<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle del Área</h2>
  </div>
</div>
<div class="container">
  <div align="center">
	<form role="form" method="post" action="<?= base_url('area/update');?>/<?= $area->id;?>" class="form-signin">
	  <div class="form-group">
	    <label for="nombre">Nombre:</label>
	    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
	    id="nombre" required value="<?= $area->nombre; ?>">
	    <!--<label for="dominio">Tipo:</label>
	    <select class="form-control" style="max-width:300px; text-align:center;" name="dominio">
	    	<option <?php if($area->dominio == "Consultoría") echo "selected"; ?>>Consultoría</option>
	    	<option <?php if($area->dominio == "Soporte de Negocio") echo "selected"; ?>>Soporte de Negocio</option>
	    	<option <?php if($area->dominio == "Telecomunicaciones") echo "selected"; ?>>Telecomunicaciones</option>
	    </select>-->
	    <label for="estatus">Estatus:</label>
	    <select class="form-control" style="max-width:300px; text-align:center;" name="estatus">
	    	<option value="1" <?php if($area->estatus == 1) echo "selected"; ?>>Habilitado</option>
	    	<option value="0" <?php if($area->estatus == 0) echo "selected"; ?>>Deshabilitado</option>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Actualizar</button>
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