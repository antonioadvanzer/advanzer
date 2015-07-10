<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle del Objetivo</h2>
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
  <form role="form" method="post" action="<?= base_url('objetivo/create');?>" class="form-signin">
  	<div class="row" align="center">
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="" placeholder="Nombre">
		</div>
		<div class="form-group">
		  <label for="dominio">Dominio:</label>
		  <select name="dominio" class="form-control" style="max-width:300px; text-align:center">
		  	<?php foreach ($dominios as $dominio) : ?>
			  <option value="<?= $dominio->id;?>"><?= $dominio->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Descripción:</label>
		  <textarea name="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="5" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	</div>
	<div style="height:60px" class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Registrar Datos</button>
	  </div>
	</div>
  </form>