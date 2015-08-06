<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nueva Posición</h2>
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
  <form role="form" method="post" action="<?= base_url('posicion/create');?>" class="form-signin">
  	<div class="row" align="center">
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="" placeholder="Nombre">
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="track">Track(s):</label>
		  <select multiple name="track[]" id="track" style="max-width:300px;min-height:100px;max-height:200px" 
		  	class="form-control">
		  	<option disabled>--Selecciona al menos un track --</option>
		  	<?php foreach ($tracks as $track) : ?>
		  		<option value="<?= $track->id;?>"><?= $track->nombre;?></option>
		  	<?php endforeach; ?>
		  </select>
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
  <div align="center"><a href="<?= base_url('track');?>">&laquo;Regresar</a></div>