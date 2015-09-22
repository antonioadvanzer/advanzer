<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Perfil de <?= $user->nombre;?></h2>
  </div>
</div>
<div class="container">
  <div align="center" class="row">
  	<a href="<?= base_url('administrar_usuarios');?>">&laquo;Regresar</a>
	<form id="update_foto" role="form" method="post" enctype="multipart/form-data" action="<?= base_url('user/upload_photo');?>" class="form-signin">
		<input type="hidden" id="id" name="id" value="<?= $user->id;?>">
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
		  	<input class="form-control" id="foto" type="file" name="foto" size="40" style="max-width:300px; text-align:center;" 
		  		accept="image/jpg,image/jpeg,image/png,image/gif" required/>
		  </div>
		  <div class="form-group">
		  	<p style="font-size:smaller;">
		  		En formato "jpg", "png", "jpeg" o "gif" de 2 MB como máximo de tamaño</p>
			<button class="btn btn-primary" type="submit">
				<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Subir Foto</button>
		  </div>
	  </div>
	</form>
  </div>
  <input id="id" type="hidden" value="<?= $user->id;?>">
  <form id="update" role="form" method="post" action="javascript:" class="form-signin">
  	<div class="row" align="center">
	  <div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required value="<?= $user->nombre; ?>">
		  </div>
		  <div class="form-group">
		    <label for="email">E-Mail:</label>
		    <input id="email" name="email" type="email" class="form-control" style="max-width:300px; text-align:center;" 
		    	required value="<?= $user->email; ?>">
		  </div>
		  <div class="form-group">
		    <label for="empresa">Empresa:</label>
		    <select id="empresa" class="form-control" style="max-width:300px; text-align:center;" name="empresa">
		    	<option value="0" <?php if($user->empresa == 0) echo "selected"; ?>>--</option>
		    	<option value="1" <?php if($user->empresa == 1) echo "selected"; ?>>Advanzer</option>
		    	<option value="2" <?php if($user->empresa == 2) echo "selected"; ?>>Entuizer</option>
		    </select>
		</div>
		<div class="form-group">
		  <label for="jefe">Jefe Directo:</label>
		  <select class="selectpicker" data-header="Selecciona al Jefe Directo" data-live-search="true" data-width="300px" style="max-width:300px; text-align:center;" name="jefe" id="jefe">
		  	<?php foreach($jefes as $jefe): ?>
			  <option value="<?= $jefe->id;?>" <?php if($user->jefe == $jefe->id) echo "selected"; ?>>
				<?= $jefe->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>  
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		    <label for="plaza">Plaza:</label>
		    <input id="plaza" type="text" class="form-control" style="max-width:300px; text-align:center;" 
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
		  <label for="ingreso">Fecha de Ingreso:</label>
		  <input data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" type="text" 
		  	style="max-width:300px; text-align:center;background-color:white" name="ingreso" id="ingreso" 
		  	value="<?= $user->fecha_ingreso;?>" readonly required>
		</div>
	  	<div class="form-group">
		  <label for="nomina"># Nómina:</label>
		  <input pattern="[0-9]+" class="form-control" style="max-width:300px;text-align:center" name="nomina" 
		  	required value="<?= $user->nomina;?>" id="nomina">
		</div>
		<div class="form-group">
		    <label for="categoria">Categoría:</label>
		    <input id="categoria" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    	value="<?= $user->categoria; ?>" required>
		</div>
		<div class="form-group">
			<label for="tipo">Tipo de Acceso:</label>
			<select class="form-control" style="max-width:300px; text-align:center;" id="tipo">
				<option value="0" <?php if($user->tipo == 0) echo "selected"; ?>>Colaborador</option>
				<option value="1" <?php if($user->tipo == 1) echo "selected"; ?>>Requisiciones</option>
				<option value="2" <?php if($user->tipo == 2) echo "selected"; ?>>Administrador</option>
				<option value="3" <?php if($user->tipo == 3) echo "selected"; ?>>Requisiciones y Administrador</option>
			</select>
		</div>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" 
		  	style="max-width:200px; text-align:center;">Actualizar</button>
		  <span style="float:right;">
		  	<?php if($user->estatus == 1): ?>
		  		<label onclick="$('#update_foto').hide('slow');$('#update').hide('slow');$('#recision').
		  			show('slow');" style="cursor:pointer;">Dar de baja al colaborador</label>
		  	<?php elseif($user->estatus == 0): ?>
		  		<label onclick="$('#update_foto').hide('slow');$('#update').hide('slow');$('#rehab').
		  			show('slow');" style="cursor:pointer;">Rehabilitar al colaborador</label>
		  	<?php endif; ?>
		  </span>
	  </div>
	</div>
  </form>
  <div class="col-md-12" align="center">
  	<div class="form-group">
	  <div align="center">
		<div id="alert" style="display:none" class="alert alert-danger" role="alert" style="max-width:400px;">
	      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	      <span class="sr-only">Error:</span>
	      <label id="msg"></label>
	    </div>
	  </div>
	</div>
  </div>
  <form id="recision" style="display:none" role="form" method="post" action="javascript:" class="form-signin">
	  <div class="row" align="center">
	  	<div class="col-md-4">
	  		<div class="form-group">
			  <label for="baja">Fecha de Baja:</label>
			  <input data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" type="text" 
			  	style="max-width:300px; text-align:center;background-color:white" name="baja" id="baja" 
			  	value="" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			  <label for="tipo_baja">Tipo de Baja:</label>
			  <select class="form-control" style="max-width:300px; text-align:center;background-color:white" 
			  	name="tipo_baja" id="tipo_baja" value="<?= $user->fecha_ingreso;?>">
			  	<option>Voluntaria</option>
			  	<option>Involuntaria</option>
			  </select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			  <label for="motivo">Motivo:</label>
			  <textarea rows="2" class="form-control" style="max-width:300px; text-align:center;" name="motivo" 
			  	id="motivo" required></textarea>
			</div>
		</div>
		<div class="col-md-12">
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center">
				Confirmar Baja</button>
			<span style="float:right;"><label 
			  	onclick="$('#recision').hide('slow');$('#update_foto').show('slow');$('#update').show('slow');" style="cursor:pointer;">
			  	Cancelar</label></span>
		</div>
	  </div>
  </form>
  <form id="rehab" style="display:none" role="form" method="post" action="javascript:" class="form-signin">
	  <div class="row" align="center">
	  	<div class="col-md-6">
	  		<div class="form-group">
			  <label for="baja">Fecha de Reingreso:</label>
			  <input data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" type="text" 
			  	style="max-width:300px; text-align:center;background-color:white" name="reingreso" id="reingreso" 
			  	value="<?= date('Y-m-d');?>" required>
			</div>
		</div>
		<div class="col-md-6">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center">
				Confirmar</button>
			<span style="float:right;"><label 
			  	onclick="$('#rehab').hide('slow');$('#update_foto').show('slow');$('#update').show('slow');" style="cursor:pointer;">
			  	Cancelar</label></span>
		</div>
	  </div>
  </form>
  <script type="text/javascript">

	$(document).ready(function() {
		$('.selectpicker').selectpicker();
		$('#update').submit(function(event){
			id = $('#id').val();
			nombre = $('#nombre').val();
			email = $('#email').val();
			$("#empresa option:selected").each(function() {
				empresa = $('#empresa').val();
			});
			$("#jefe option:selected").each(function() {
				jefe = $('#jefe').val();
			});
			plaza = $('#plaza').val();
			$("#track option:selected").each(function() {
				track = $('#track').val();
			});
			$("#posicion option:selected").each(function() {
				posicion = $('#posicion').val();
			});
			$("#area option:selected").each(function() {
				area = $('#area').val();
			});
			ingreso = $('#ingreso').val();
			nomina = $('#nomina').val();
			categoria = $('#categoria').val();
	  		$("#tipo option:selected").each(function() {
				tipo = $('#tipo').val();
			});
			$.ajax({
				url: '<?= base_url("user/update");?>',
				type: 'post',
				data: {'id':id,'nombre':nombre,'email':email,'empresa':empresa,'jefe':jefe,'plaza':plaza,
					'track':track,'posicion':posicion,'area':area,'ingreso':ingreso,'nomina':nomina,
					'categoria':categoria,'tipo':tipo},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#alert').prop('display',true).show();
						$('#msg').html(returnedData['msg']);
					}
				}
			});

			event.preventDefault();
		});

		$('#recision').submit(function(event){
			id = $('#id').val();
			fecha_baja = $('#fecha_baja').val();
			$("#tipo_baja option:selected").each(function() {
				tipo_baja = $('#tipo_baja').val();
			});
			motivo = $('#motivo').val();
			$.ajax({
				url: '<?= base_url("user/recision");?>',
				type: 'post',
				data: {'id':id,'fecha_baja':fecha_baja,'tipo_baja':tipo_baja,'motivo':motivo},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#alert').prop('display',true).show();
						$('#msg').html(returnedData['msg']);
					}
				}
			});

			event.preventDefault();
		});

		$('#rehab').submit(function(event){
			id = $('#id').val();
			reingreso = $('#reingreso').val();
			$.ajax({
				url: '<?= base_url("user/rehab");?>',
				type: 'post',
				data: {'id':id,'reingreso':reingreso},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#alert').prop('display',true).show();
						$('#msg').html(returnedData['msg']);
					}
				}
			});

			event.preventDefault();
		});

		$("#track").change(function() {
			$("#track option:selected").each(function() {
				track = $('#track').val();
				$.post("<?= base_url('user/load_posiciones');?>", {
					track : track
				}, function(data) {
					$("#posicion").html(data);
				});
			});
		});
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10)
			dd='0'+dd
		if(mm<10)
			mm='0'+mm
		today = yyyy+'-'+mm+'-'+dd;
		$('#ingreso').datepicker({
			dateFormat: 'yy-mm-dd'
		});
		$('#baja').datepicker({
			dateFormat: 'yy-mm-dd',
			maxDate: today
		});
	});
  </script>