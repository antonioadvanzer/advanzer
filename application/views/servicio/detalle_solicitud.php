<?php
	if(isset($solicitud->detalle)):
		$detalle=$solicitud->detalle;
		$vuelos="";
		if($detalle->ruta_salida)
			$vuelos.=$detalle->fecha_salida." ".date_format(date_create($detalle->hora_salida),'H:i')." (".$detalle->ruta_salida.")\n";
		if($detalle->ruta_regreso)
			$vuelos.=$detalle->fecha_regreso." ".date_format(date_create($detalle->hora_regreso),'H:i')." (".$detalle->ruta_regreso.")";
		$conceptos=array();
		if($detalle->hotel_flag)
			array_push($conceptos, 'HOTEL');
		if($detalle->autobus_flag)
			array_push($conceptos,"AUTOBÚS");
		if($detalle->vuelo_flag)
			array_push($conceptos,"VUELO");
		if($detalle->comida_flag)
			array_push($conceptos,"COMIDA");
		if($detalle->renta_flag)
			array_push($conceptos,"RENTA DE AUTO");
		if($detalle->gasolina_flag)
			array_push($conceptos,"GASOLINA");
		if($detalle->taxi_flag)
			array_push($conceptos,"TAXI");
		if($detalle->mensajeria_flag)
			array_push($conceptos,"MENSAJERÍA");
		if($detalle->taxi_aero_flag)
			array_push($conceptos,"TAXI AEROPUERTO");
	endif;
	switch ($solicitud->tipo) :
	 	case 1: $tipo='VACACIONES';						break;
	 	case 2:case 3: $tipo='PERMISO DE AUSENCIA';		break;
	 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
	 	default: $tipo='';								break;
	endswitch; ?>
<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Detalle de Solicitud - <?= $tipo;?></b></h2>
	</div>
</div>
<div class="container">
	<div align="center"><a style="cursor:pointer;" onclick="window.history.back();">&laquo;Regresar</a></div>
	<div align="center" id="alert" style="display:none">
		<div class="alert alert-danger" role="alert" style="max-width:400px;">
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
	<div class="row">
		<div class="col-md-12">
			<input type="hidden" id="solicitud" value="<?= $solicitud->id;?>">
			<form id="razon" role="form" method="post" action="javascript:" class="form-signin" style="display:none">
				<input type="hidden" id="estatus" value="">
				<div class="input-group">
					<span class="input-group-addon" style="min-width:200px">Razón</span>
					<textarea class="form-control" required id="razon_txt" rows="4" placeholder="Razón por la que se descarta"></textarea>
				</div>
				<br>
				<div class="btn-group btn-group-lg" role="group" aria-label="..." style="float:right;">
					<button type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;">Confirmar Cancelación</button>
					<button onclick="$('#razon').hide('slow');$('#update').show('slow');$('#estatus').val('');" type="reset" class="btn" style="min-width:200px;text-align:center;">Regresar</button>
				</div>
			</form>
			<form id="update" role="form" method="post" action="javascript:" class="form-signin">
				<div class="row" align="center">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="input-group" style="display:<?php if($this->session->userdata('tipo')<4) echo"none";?>;">
							<span class="input-group-addon">Colaborador</span>
							<select class="selectpicker"style="text-align:center;" disabled>
								<option value="" disabled selected>-- Selecciona al Colaborador --</option>
								<?php foreach($colaboradores as $colaborador): ?>
									<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$solicitud->colaborador)echo"selected";?>><?= $colaborador->nombre;?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="input-group">
							<span class="input-group-addon required">Autorizador</span>
							<select class="selectpicker" data-header="Selecciona al autorizador" style="text-align:center;" disabled>
								<option value="" disabled selected>-- Selecciona al Jefe Directo / Líder --</option>
								<?php foreach($colaboradores as $colaborador)
									if($colaborador->id != $solicitud->colaborador): ?>
										<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$solicitud->autorizador)echo"selected";?>><?= $colaborador->nombre;?></option>
									<?php endif; ?>
							</select>
						</div>
					</div>
				</div>
				<hr>
				<div class="row" align="center">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<div id="generales">
							<h3>Detalle de Solicitud</h3>
							<div class="input-group">
								<span class="input-group-addon">Días Solicitados</span>
								<select class="form-control" style="cursor:default;" readonly>
									<option><?= $solicitud->dias;?></option>
								</select>
								<span class="input-group-addon">Desde</span>
								<input class="form-control" type="text" style="text-align:center;cursor:default" value="<?= $solicitud->desde;?>" readonly>
								<span class="input-group-addon">Hasta</span>
								<input class="form-control" type="text" style="text-align:center;cursor:default" 
									value="<?= $solicitud->hasta;?>" readonly>
							</div>
							<br>
							<?php if($solicitud->tipo < 4):
								if($solicitud->tipo==2 || $solicitud->tipo==3):
									$filename=base_url("assets/docs/permisos/permiso_$solicitud->id"); ?>
									<div class="input-group">
										<?php if(file_exists($filename)): ?>
											<span class="input-group-addon">Comprbante</span>
											<a href="<?= $filename;?>;?>" download><span class="glyphicon glyphicon-download-alt"></span> descargar</a>
										<?php endif; ?>
										<span class="input-group-addon">Motivo</span>
										<input value="<?=$solicitud->motivo;?>" type="text" class="form-control" readonly>
										<span class="input-group-addon">Tipo de Permiso</span>
										<input type="text" class="form-control" value="<?php if($solicitud->tipo==2) echo"Con Goce de Sueldo";else echo "Sin Goce de Sueldo?>";?>" readonly>
									</div><br>
								<?php endif; ?>
							<?php else: ?>
								<div class="input-group">
									<span class="input-group-addon">Centro de Costo</span>
									<input type="text" class="form-control" value="<?= $detalle->centro_costo;?>" readonly>
									<span class="input-group-addon">Motivo del Viaje</span>
									<input type="text" class="form-control" value="<?= $solicitud->motivo;?>" readonly>
									<span class="input-group-addon">Viaje</span>
									<input type="text" class="form-control" value="<?= $detalle->origen." - ".$detalle->destino;?>" readonly>
									<span class="input-group-addon">Anticipo $</span>
									<input class="form-control" style="max-width:100px" readonly value="<?= $detalle->anticipo;?>">
								</div><br>
								<div class="input-group">
									<span class="input-group-addon">Conceptos Solicitados</span>
									<ul type="square" align="left">
										<?php foreach ($conceptos as $concepto) : ?>
											<li style="width:33.33%;float:left;"><?= $concepto;?></li>
										<?php endforeach; ?>
									</ul>
									<span class="input-group-addon">Vuelos</span>
									<textarea style="min-height:110%" type="text" class="form-control" readonly><?= $vuelos;?></textarea>
								</div><br>
							<?php endif;
							if($solicitud->tipo<=3): ?>
								<div class="input-group">
									<span class="input-group-addon required" style="min-width:260px">Observaciones</span>
									<textarea class="form-control" rows="6" readonly><?= $solicitud->observaciones;?></textarea>
								</div>
								<br>
							<?php endif; ?>
							<h3>Autorizaciones</h3>
							<table class="table table-striped table-hover" style="width:90%">
								<thead>
									<tr>
										<th width="10%"></th>
										<th width="45%" style="text-align:center;">Jefe Inmediato/Líder de Proyecto</th>
										<th width="45%" style="text-align:center;">Capital Humano</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td style="text-align:center;cursor:text;">
											<?php if($solicitud->estatus==1): ?>
												<span class="glyphicon glyphicon-eye-open"></span> VALIDANDO
											<?php elseif($solicitud->estatus==2 || $solicitud->auth_uno==1): ?>
												<span class="glyphicon glyphicon-ok"></span> AUTORIZADO
											<?php elseif($solicitud->estatus==4 && $solicitud->auth_uno==0): ?>
												<span class="glyphicon glyphicon-remove"></span> RECHAZADO
											<?php elseif($solicitud->motivo=="ENFERMEDAD"): ?>
												<span class="glyphicon glyphicon-ok"></span> ENTERADO
											<?php endif; ?>
										</td>
										<?php if($solicitud->tipo < 4): ?>
											<td style="text-align:center;cursor:text;">
												<?php if($solicitud->estatus==2): ?>
													<span class="glyphicon glyphicon-eye-open"></span> VALIDANDO
												<?php elseif($solicitud->estatus==3 && $solicitud->auth_uno==1): ?>
													<span class="glyphicon glyphicon-ok"></span> AUTORIZADO
												<?php elseif($solicitud->estatus==4 && $solicitud->auth_uno==1): ?>
													<span class="glyphicon glyphicon-remove"></span> RECHAZADO
												<?php elseif($solicitud->estatus==1): ?>
													<span class="glyphicon glyphicon glyphicon-time"></span> PENDIENTE
												<?php elseif($solicitud->motivo=="ENFERMEDAD"): ?>
													<span class="glyphicon glyphicon-ok"></span> ENTERADO
												<?php endif; ?>
											</td>
										<?php endif;?>
									</tr>
									<?php if($solicitud->estatus==4): ?>
										<tr>
											<td style="text-align:right;cursor:default;">Motivo</td>
											<?php if($solicitud->auth_uno==0): ?>
												<td style="text-align:center;cursor:text;"><?= $solicitud->razon;?></td>
												<td></td>
											<?php elseif($solicitud->auth_uno==1): ?>
												<td></td>
												<td style="text-align:center;cursor:text;"><?= $solicitud->razon;?></td>
											<?php endif; ?>
										</tr>
									<?php elseif($solicitud->estatus==0): ?>
										<tr>
											<td style="text-align:right;cursor:text;">Motivo Cancelación</td>
											<td colspan="2" style="text-align:center;cursor:text;"><?= $solicitud->razon;?></td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
							<hr>
							<?php 
							$desde=new DateTime($solicitud->desde);
							$hoy=new DateTime(date('Y-m-d'));
							if($solicitud->estatus != 0)
								if(($solicitud->tipo==4 && $solicitud->estatus!=3) || $solicitud->tipo!=4 && $solicitud->estatus!=4 && $desde->diff($hoy)->format('%r')): ?>
									<div class="col-md-8">
									<label style="float:left;color:red">Puedes CANCELAR tu solicitud de <?= $tipo;?> hasta un día antes de que inicie el período que solicitaste dando click en:</label>
									</div>
									<div class="col-md-4" align="center" style="float:right;">
										<div align="center" class="btn-group btn-group-lg" role="group" aria-label="...">
											<button onclick="$('#update').hide('slow');$('#razon').show('slow');$('#estatus').val(0);" type="button" class="btn btn-primary" style="text-align:center;display:inline;">Cancelar Solicitud</button>
										</div>
									</div>
								<?php endif; ?>
						</div>
						<br>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script>
		$("#razon").submit(function(event) {
			razon = $("#razon_txt").val();
			estatus = $("#estatus").val();
			solicitud = $("#solicitud").val();
			if(!confirm("¿Seguro que deseas cancelar la solicitud?"))
				return false;
			$.ajax({
				url: '<?= base_url("servicio/rechazar_solicitud");?>',
				type: 'post',
				data: {'solicitud':solicitud,'estatus':estatus,'razon':razon},
				beforeSend: function() {
					$('#razon').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					console.log(returnedData['msg']);
					if(returnedData['msg']=="ok"){
						alert('Se ha recibido su respuesta');
						window.document.location.reload();
					}else{
						$('#razon_txt').val("");
						$('#cargando').hide('slow');
						$('#tbl').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html(returnedData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr.statusText);
					$('#cargando').hide('slow');
					$('#razon').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});

			event.preventDefault();
		});
	</script>