<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle del Dominio</h2>
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
	<form role="form" method="post" action="<?= base_url('dominio/update');?>/<?= $dominio->id;?>" class="form-signin">
	  <div align="center" class="row">
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required value="<?= $dominio->nombre; ?>">
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="estatus">Descripción:</label>
		    <textarea name="descripcion" class="form-control" style="max-width:300px;text-align:center;" required 
	            placeholder="Agrea una descripción del dominio"><?= $dominio->descripcion;?></textarea>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;">
			  Actualizar</button>
		  </div>
		</div>
	  </div>
	</form>
	<a href="<?= base_url('dominio');?>">&laquo;Regresar</a>
  </div>