<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Perfil del Usuario</h2>
  </div>
</div>
<div class="container">
  <div align="center" class="row">
  <div class="col-md-12" align="center">
  	<div class="form-group">
	  <div align="center">
	  <?php if(isset($err_msg)): ?>
	    <div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
	      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	      <span class="sr-only">Error:</span>
	      <?= $err_msg;?>
	    </div>
	  <?php endif; ?>
	  <?php if(isset($msg)): ?>
	    <div id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
	      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
	      <span class="sr-only">Error:</span>
	      <?= $msg;?>
	    </div>
	  <?php endif; ?>
	  </div>
	</div>
  </div>
	<form role="form" method="post" enctype="multipart/form-data" action="<?= base_url('user/upload_photo');?>/<?= $user->id;?>" class="form-signin">
	  <div class="col-md-6">
		  <div class="form-group">
		  	<img height="200px" src="<?= base_url("assets/images/fotos/$user->foto");?>">
		  </div>
	  </div>
	  <div class="col-md-3" align="center">
		  <div class="form-group">
		  	<label for="foto" class="control-label">Elige la foto</label>
		  </div>
		  <div class="form-group">
		  	<input class="form-control" type="file" name="foto" size="40" style="max-width:300px; text-align:center;" required/>
		  </div>
		  <div class="form-group">
			<button class="btn btn-primary" type="submit">
				<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Subir Foto</button>
		  </div>
	  </div>
	</form>
  </div>
  <form role="form" method="post" action="<?= base_url('user/update');?>/<?= $user->id;?>" class="form-signin">
  	<div class="row" align="center">
	  <div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required value="<?= $user->nombre; ?>">
		  </div>
		  <div class="form-group">
		    <label for="email">E-Mail:</label>
		    <input name="email" type="email" class="form-control" style="max-width:300px; text-align:center;" 
		    	required value="<?= $user->email; ?>">
		  </div>
		  <div class="form-group">
		    <label for="tipo">Empresa:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="empresa">
		    	<option value="0" <?php if($user->empresa == 0) echo "selected"; ?>>--</option>
		    	<option value="1" <?php if($user->empresa == 1) echo "selected"; ?>>Advanzer</option>
		    	<option value="2" <?php if($user->empresa == 2) echo "selected"; ?>>Entuizer</option>
		    </select>
		</div>
		<div class="form-group">
		  <label for="nomina"># Nómina:</label>
		  <input class="form-control" style="max-width:300px;text-align:center" name="nomina" required 
		  	value="<?= $user->nomina;?>">
		</div>  
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		    <label for="plaza">Plaza:</label>
		    <input name="plaza" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    	required value="<?= $user->plaza; ?>">
		</div>
		<div class="form-group">
		  <label for="track">Track</label>
		  <select class="form-control" style="max-width:300px;text-align:center" name="track" id="track">
		  	<option disabled selected>-- Selecciona un track --</option>
		  	<?php foreach ($tracks as $track) : ?>
		  		<option value="<?= $track->id;?>" <?php if($user->track==$track->id) echo "selected" ?>><?= $track->nombre;?></option>
		  	<?php endforeach; ?>
		  </select>
		</div>
		<div class="form-group">
		  <label for="posicion">Posición:</label>
		  <select id="posicion" class="form-control" style="max-width:300px; text-align:center;" name="posicion">
		  	<?php foreach ($posiciones as $posicion) : ?>
		  		<option value="<?= $posicion->id;?>" <?php if($user->posicion==$posicion->id) echo "selected" ?>><?= $posicion->nombre;?></option>
		  	<?php endforeach; ?>
		  </select>
		</div>
		<div class="form-group">
		  <label for="area">Área:</label>
		  <select id="area" class="form-control" style="max-width:300px; text-align:center;" name="area">
			<?php foreach ($areas as $area) : ?>
			  <option value="<?= $area->id;?>" <?php if($area->id == $user->area) echo "selected"; ?>><?= $area->nombre;?></option>
			<?php endforeach; ?>
		</select>
		</div>
	  </div>
	  <div class="col-md-4">
		  <div class="form-group">
		    <label for="categoria">Categoría:</label>
		    <input name="categoria" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    	value="<?= $user->categoria; ?>">
		  </div>
		  <div class="form-group">
		    <label for="requisicion">Requisiciones:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="requisicion">
		    	<option value="0" <?php if($user->requisicion == 0) echo "selected"; ?>>No</option>
		    	<option value="1" <?php if($user->requisicion == 1) echo "selected"; ?>>Si</option>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="admin">Administrador:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="admin">
		    	<option value="0" <?php if($user->admin == 0) echo "selected"; ?>>No</option>
		    	<option value="1" <?php if($user->admin == 1) echo "selected"; ?>>Si</option>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="estatus">Estatus:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="estatus">
		    	<option value="1" <?php if($user->estatus == 1) echo "selected"; ?>>Habilitado</option>
		    	<option value="0" <?php if($user->estatus == 0) echo "selected"; ?>>Deshabilitado</option>
		    </select>
		  </div>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Actualizar</button>
		  <a href="<?= base_url('administrar_usuarios');?>">&laquo;Regresar</a>
	  </div>
	</div>
  </form>
  <div align="center">
	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif; ?>
  </div>
  <script type="text/javascript">
	$(document).ready(function() {
		$("#track").change(function() {
			$("#track option:selected").each(function() {
				track = $('#track').val();
				$.post("<?= base_url('user/load_posiciones');?>", {
					track : track
				}, function(data) {
					$("#posicion").html(data);
				});
			});
		})
	});
  </script>