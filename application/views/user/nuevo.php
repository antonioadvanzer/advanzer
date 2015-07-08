<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nuevo Perfil de Usuario</h2>
  </div>
</div>
<div class="container">
  <!--<div align="center">
	<form role="form" method="post" enctype="multipart/form-data" action="<?= base_url('user/upload_photo');?>/<?= $user->id;?>" class="form-signin">
	  <div class="form-group">
	  	<img height="200px" src="<?= base_url("assets/images/fotos/$user->foto");?>">
	  </div>
	  <div class="form-group">
	  	<label for="foto" class="control-label">Elige la foto</label>
	  	<input type="file" name="foto" size="40" required/>
		<input type="submit" value="Subir Foto" class="btn btn-primary"/>
	  </div>
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
	</form>
  </div>-->
  <form role="form" method="post" action="<?= base_url('user/create');?>" class="form">
  	<div class="row" align="center">
	  <div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required>
		  </div>
		  <div class="form-group">
		    <label for="nombre">E-Mail:</label>
		    <input name="email" type="email" class="form-control" style="max-width:300px; text-align:center;" required>
		  </div>
		  <div class="form-group">
		    <label for="tipo">Empresa:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="empresa">
		    	<option value="0">--</option>
		    	<option value="1">Advanzer</option>
		    	<option value="2">Entuizer</option>
		    </select>
		  </div>
	  </div>
	  <div class="col-md-4">
	  	  <div class="form-group">
		    <label for="posicion">Posición:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="posicion">
		    	<option>Analista</option>
		    	<option>Consultor / Especialista</option>
		    	<option>Consultor Sr / Especialista Sr</option>
		    	<option>Gerente / Master</option>
		    	<option>Gerente Sr / Experto</option>
		    	<option>Director</option>
		    </select>
		  </div>
	  	  <div class="form-group">
		    <label for="tipo">Tipo:</label>
		    <select id="tipo" class="form-control" style="max-width:300px; text-align:center;" name="tipo">
		    	<option>Consultoría</option>
		    	<option>Soporte de Negocio</option>
		    	<option>Telecomunicaciones</option>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="area">Área:</label>
		    <select id="area" class="form-control" style="max-width:300px; text-align:center;" name="area">
		    	<?php foreach ($areas as $area) : ?>
		    		<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
		    	<?php endforeach; ?>
		    </select>
		  </div>
	  </div>
	  <div class="col-md-4">
		  <div class="form-group">
		    <label for="requisicion">Requisiciones:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="requisicion">
		    	<option value="0">No</option>
		    	<option value="1">Si</option>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="admin">Administrador:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="admin">
		    	<option value="0">No</option>
		    	<option value="1">Si</option>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="estatus">Estatus:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" name="estatus">
		    	<option value="1">Habilitado</option>
		    	<option value="0">Deshabilitado</option>
		    </select>
		  </div>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Registrar</button>
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
			$("#tipo").change(function() {
				$("#tipo option:selected").each(function() {
					tipo = $('#tipo').val();
					$.post("<?= base_url('user/load_areas');?>", {
						tipo : tipo
					}, function(data) {
						$("#area").html(data);
					});
				});
			})
		});
	</script>