<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Perfil de <?= $user->nombre;?></h2>
  </div>
</div>
<div class="container">
  <div align="center" class="row">
  	<a href="<?= base_url('administrar_usuarios');?>">&laquo;Regresar</a>
  	<div id="alert" style="display:none" class="alert alert-danger" role="alert" style="max-width:400px;">
		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		<label id="msg"></label>
	</div>
  </div>
  <hr>
  <div class="row" align="center">
  	<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
  		<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <nav class="navbar">
		<div class="navbar-collapse" aria-expanded="true">
			<ul class="nav navbar-nav">
				<li onclick="pestañeo(1);"><a href="#">General</a></li>
				<?php if($user->estatus == 1): ?>
					<li onclick="pestañeo(2);"><a href="#">Dar de baja al colaborador</a></li>
					<li onclick="pestañeo(3);"><a href="#">Historial de desempeño</a></li>
				<?php elseif($user->estatus == 0): ?>
					<li onclick="pestañeo(4);"><a href="#">Rehabilitar al colaborador</a></li>
				<?php endif;
				if(isset($user->bitacora)): ?>
					<li onclick="pestañeo(5);"><a href="#">Historial de Vacaciones/Permisos</a></li>
				<?php endif; ?>
				<li onclick="pestañeo(6);"><a href="#">Consultar días de Vacaciones</a></li>
			</ul>
		</div>
	</nav>
	<hr>
	<form id="vacaciones" style="display:none" role="form" method="post" action="javascript:" class="form-signin">
	  <div class="row" align="center">
	  	<div class="col-md-12">
	  		<div class="form-group">
			  <table class="table" style="width:60%">
			  	<thead>
			  		<tr>
			  			<th></th>
			  			<th>Días</th>
			  			<th>Fecha de Vencimiento</th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<tr>
			  			<th>Próximo Vencimiento</th>
			  			<td><input class="form-control" type="text" value="<?= $vs['proximo_vencimiento'] ?>" id="diasUno"></td>
			  			<td><input style="background-color:white" class="form-control" type="text" value="<?= $vs['vencimiento_uno'] ?>" id="vencimientoUno" readonly></td>
			  		</tr>
			  		<tr>
			  			<th>Recién Generadas</th>
			  			<td><input class="form-control" type="text" value="<?= $vs['recien_generadas'] ?>" id="diasDos"></td>
			  			<td><input style="background-color:white" class="form-control" type="text" value="<?= $vs['vencimiento_dos'] ?>" id="vencimientoDos" readonly></td>
			  		</tr>
			  		<tr>
			  			<th>Proporcionales</th>
			  			<td><input class="form-control" type="text" value="<?= $vs['proporcionales']?>" id="diasProporcionalea"></td>
			  		</tr>
			  	</tbody>
			  </table>
			</div>
		</div>
		<div class="col-md-12" align="center">
			<button type="submit" class="btn btn-lg btn-primary" style="text-align:center">Guardar</button>
		</div>
		<div class="col-md-12">
			<span style="float:right;"><label 
			  	onclick="$('#vacaciones').hide('slow');$('#update_foto').show('slow');$('#update').show('slow');" style="cursor:pointer;">
			  	Cancelar</label></span>
		</div>
	  </div>
	</form>
  <div class="row" align="center">
  	<form id="update_foto" role="form" method="post" enctype="multipart/form-data" action="<?= base_url('user/upload_photo');?>" class="form-signin">
		<input type="hidden" id="id" name="id" value="<?= $user->id;?>">
	  <div class="col-md-6">
		  <div class="form-group">
		  	<img class="img-circle avatar avatar-original" height="200px" src="<?= base_url("assets/images/fotos/$user->foto");?>?">
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
		  <label for="jefe">Jefe Directo:</label><br>
		  <select class="selectpicker" data-header="Selecciona al Jefe Directo" data-live-search="true" data-width="300px" 
		  	style="max-width:300px; text-align:center;" name="jefe" id="jefe" title="Selecciona al Jefe Directo">
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
				<!--<option value="0" <?php if($user->tipo == 0) echo "selected"; ?>>Colaborador</option>
				<option value="1" <?php if($user->tipo == 1) echo "selected"; ?>>Capturista (Gastos de Viaje)</option>
				<option value="2" <?php if($user->tipo == 2) echo "selected"; ?>>Capturista (Harvest)</option>
				<option value="3" <?php if($user->tipo == 3) echo "selected"; ?>>Requisiciones</option>
				<option value="4" <?php if($user->tipo == 4) echo "selected"; ?>>Administrador</option>
				<option value="5" <?php if($user->tipo == 5) echo "selected"; ?>>Requisiciones y Administrador</option>
				<option value="6" <?php if($user->tipo == 6) echo "selected"; ?>>Soporte Técnico</option>-->
                
                <?php 
                    foreach($tipo_acceso as $tp){
                ?>
                    
                        <option value="<?php echo $tp->access; ?>" <?php if($user->tipo == $tp->access) echo "selected"; ?>><?php echo $tp->nombre; ?></option>
                        
                <?php
                    }
                
                ?>
			</select>
		</div>
	  </div>
	</div>
	<hr>
	<div class="row" align="center">
		<div class="col-md-12">
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Actualizar</button>
		</div>
	</div>
  </form>
  <form id="historial" style="display:none" role="form" method="post" action="javascript:" class="form-signin">
	  <div class="row" align="center">
	  	<div class="col-md-4">
	  		<div class="form-group">
			  <label for="baja">Selecciona un año:</label>
			  <select class="form-control" style="max-width:160px;" id="anio_historial" name="anio_historial">
				<option selected disabled>- Selecciona año -</option>
				<?php foreach($user->historial as $evaluacion): ?>
					<option><?= $evaluacion->anio;?></option>
				<?php endforeach; ?>
			  </select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group" id="result_historial">
			</div>
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;display:none" id="modificar">
				Modificar</button>
		</div>
		<div class="col-md-12">
			<span style="float:right;"><label 
			  	onclick="$('#historial').hide('slow');$('#update_foto').show('slow');$('#update').show('slow');" style="cursor:pointer;">
			  	Cancelar</label></span>
		</div>
	  </div>
  </form>
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
  <div class="row" align="center" id="bitacora" style="display:none;">
	<table id="tbl" class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
		<thead>
			<tr>
				<th style="text-align:center;">Folio</th>
				<th style="text-align:center;">Tipo</th>
				<th style="text-align:center;">Fecha de Solicitud</th>
				<th style="text-align:center;">Autorizador</th>
				<th style="text-align:center;">Días</th>
				<th style="text-align:center;">Desde</th>
				<th style="text-align:center;">Hasta</th>
				<th style="text-align:center;">Estatus</th>
			</tr>
		</thead>
		<tbody data-link="row" class="rowlink">
			<?php foreach ($user->bitacora as $solicitud):
				switch ($solicitud->estatus) {
				 	case 0: $estatus="CANCELADA";$razon=$solicitud->razon;							break;
				 	case 1: $estatus="ENVIADA";$razon=$solicitud->motivo;							break;
				 	case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';$razon=$solicitud->motivo;	break;
					case 3: $estatus='RECHAZADA';$razon=$solicitud->razon;							break;
					case 4: $estatus='AUTORIZADA';$razon=$solicitud->motivo;						break;
					
				}
				switch ($solicitud->tipo) {
				 	case 1: $tipo='VACACIONES';						break;
					case 2:	$tipo='PERMISO DE AUSENCIA CON GOCE';	break;
					case 3:	$tipo='PERMISO DE AUSENCIA SIN GOCE';	break;
					case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
					case 5: $tipo='COMPROBACIÓN DE GASTOS DE VIAJE';break;
					default: $tipo='';								break;
				} ?>
				<tr onmouseover="this.style.background=color;" onmouseout="this.style.background='transparent';">
					<td align="center"><a class="view-pdf" href="<?= base_url("servicio/ver/$solicitud->id");?>"><small><?= $solicitud->id;?></small></a></td>
					<td align="center"><small><?= $tipo;?></small></td>
					<td align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
					<td align="center"><small><?= $solicitud->nombre;?></small></td>
					<td align="center"><small><?= $solicitud->dias;?></small></td>
					<td align="center"><small><?= $solicitud->desde;?></small></td>
					<td align="center"><small><?= $solicitud->hasta;?></small></td>
					<td align="center"><small><?= $estatus;?></small></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<span style="float:right;"><label 
	  	onclick="$('#bitacora').hide('slow');$('#update_foto').show('slow');$('#update').show('slow');" style="cursor:pointer;">
	  	Ver Perfil</label></span>
  </div>

  <script type="text/javascript">
  
  	function pestañeo(option){
  		
  		switch(option){
  			
  			case 1:
  				$('#update_foto').show('slow');
  				$('#update').show('slow');
  				$('#recision').hide('slow');
  				$('#historial').hide('slow');
  				$('#rehab').hide('slow');
  				$('#bitacora').hide('slow');
  				$('#vacaciones').hide('slow');
  			break;
  			case 2:
  				$('#update_foto').hide('slow');
  				$('#update').hide('slow');
  				$('#recision').show('slow');
  				$('#historial').hide('slow');
  				$('#rehab').hide('slow');
  				$('#bitacora').hide('slow');
  				$('#vacaciones').hide('slow');
  			break;
  			case 3:
  				$('#update_foto').hide('slow');
  				$('#update').hide('slow');
  				$('#recision').hide('slow');
  				$('#historial').show('slow');
  				$('#rehab').hide('slow');
  				$('#bitacora').hide('slow');
  				$('#vacaciones').hide('slow');
  			break;
  			case 4:
  				$('#update_foto').hide('slow');
  				$('#update').hide('slow');
  				$('#recision').hide('slow');
  				$('#historial').hide('slow');
  				$('#rehab').show('slow');
  				$('#bitacora').hide('slow');
  				$('#vacaciones').hide('slow');
  			break;
  			case 5:
  				$('#update_foto').hide('slow');
  				$('#update').hide('slow');
  				$('#recision').hide('slow');
  				$('#historial').hide('slow');
  				$('#rehab').hide('slow');
  				$('#bitacora').show('slow');
  				$('#vacaciones').hide('slow');
  			break;
  			case 6:
  				$('#update_foto').hide('slow');
  				$('#update').hide('slow');
  				$('#recision').hide('slow');
  				$('#historial').hide('slow');
  				$('#rehab').hide('slow');
  				$('#bitacora').hide('slow');
  				$('#vacaciones').show('slow');
  			break;
  		}
  	}

	$(document).ready(function() {
		$('#tbl').DataTable({responsive: true,info: false,order: [[ 2, "desc" ]]});
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
				beforeSend: function() {
					$('#update').hide('slow');
					$('#update_foto').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#cargando').hide('slow');
						$('#update_foto').show('slow');
						$('#update').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html(returnedData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr);
					$('#cargando').hide('slow');
					$('#update_foto').show('slow');
					$('#update').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});

			event.preventDefault();
		});

		$('#recision').submit(function(event){
			id = $('#id').val();
			fecha_baja = $('#baja').val();
			$("#tipo_baja option:selected").each(function() {
				tipo_baja = $('#tipo_baja').val();
			});
			motivo = $('#motivo').val();
			$.ajax({
				url: '<?= base_url("user/recision");?>',
				type: 'post',
				data: {'id':id,'fecha_baja':fecha_baja,'tipo_baja':tipo_baja,'motivo':motivo},
				beforeSend: function() {
					$('#recision').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#cargando').hide('slow');
						$('#recision').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html(returnedData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr);
					$('#cargando').hide('slow');
					$('#recision').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
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
				beforeSend: function() {
					$('#rehab').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#cargando').hide('slow');
						$('#rehab').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html(returnedData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr);
					$('#cargando').hide('slow');
					$('#rehab').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});

			event.preventDefault();
		});

		$('#historial').submit(function(event){
			id = $('#id').val();
			$("#anio_historial option:selected").each(function() {
				anio = $('#anio_historial').val();
			});
			$("#rating_historial option:selected").each(function() {
				rating = $('#rating_historial').val();
			});
			$.ajax({
				url: '<?= base_url("user/change_historial");?>',
				type: 'post',
				data: {'id':id,'rating':rating,'anio':anio},
				beforeSend: function() {
					$('#historial').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#cargando').hide('slow');
						$('#historial').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html(returnedData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr.responseText);
					$('#cargando').hide('slow');
					$('#historial').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});

			event.preventDefault();
		});

		$('#vacaciones').submit(function(event){
			id = $('#id').val();
			diasUno = $('#diasUno').val();
			diasDos = $('#diasDos').val();
			vencimientoUno = $('#vencimientoUno').val();
			vencimientoDos = $('#vencimientoDos').val();
			$.ajax({
				url: '<?= base_url("user/actualiza_vacaciones");?>',
				type: 'post',
				async: true,
				data: {'id':id,'diasUno':diasUno,'diasDos':diasDos,'vencimientoUno':vencimientoUno,'vencimientoDos':vencimientoDos},
				beforeSend: function() {
					$('#vacaciones').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok")
						window.document.location='<?= base_url("administrar_usuarios");?>';
					else{
						$('#cargando').hide('slow');
						$('#vacaciones').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html(returnedData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr);
					$('#cargando').hide('slow');
					$('#vacaciones').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});

			event.preventDefault();
		});

		$("#anio_historial").change(function() {
			$("#anio_historial option:selected").each(function() {
				anio = $('#anio_historial').val();
			});
			$.ajax({
				type: 'post',
				url: "<?= base_url('user/load_historial');?>"+"/"+"<?= $user->id;?>",
				data: {anio : anio},
				beforeSend: function (xhr) {
					$('#result_historial').hide('slow');
					$('#cargando').show();
				},
				success: function(data) {
					$('#cargando').hide();
					$("#result_historial").show('slow').html(data);
					$("#modificar").show('slow');
				},
				error: function(data) {
					console.log(data.responseText);
				}
			});
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
		$('#vencimientoUno').datepicker({
			dateFormat: 'yy-mm-dd'
		});
		$('#vencimientoDos').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
  </script>