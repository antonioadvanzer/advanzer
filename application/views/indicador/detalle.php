<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle del Indicador</h2>
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
	<form role="form" method="post" action="<?= base_url('indicador/update');?>" class="form-signin">
	  <input type="hidden" name="id" value="<?= $indicador->id;?>">
	  <div align="center" class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required value="<?= $indicador->nombre; ?>">
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
		  <label for="boton">&nbsp;</label>
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;">
			  Actualizar</button>
		  </div>
		</div>
	  </div>
	</form>
	<a href="<?= base_url('indicador/nuevo');?>">&laquo;Regresar</a>
  </div>
 