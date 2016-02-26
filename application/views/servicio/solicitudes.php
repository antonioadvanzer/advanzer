<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Solicitudes</b></h2>
	</div>
</div>
<div class="container">
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php if(!empty($solicitudes)): ?>
				<h3>Pendientes de Revisar</h3>
				<form id="razon" role="form" method="post" action="javascript:" class="form-signin" style="display:none">
					<input type="hidden" id="estatus" value="">
					<input type="hidden" id="solicitud" value="">
					<div class="input-group">
						<span class="input-group-addon" style="min-width:200px">Razón</span>
						<textarea class="form-control" required id="razon_txt" rows="4" placeholder="Razón por la que se descarta"></textarea>
					</div>
					<br>
					<div class="btn-group btn-group-lg" role="group" aria-label="...">
						<button type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Confirmar</button>
						<button onclick="$('#razon').hide('slow');$('#tbl').show('slow');$('#estatus').val('');" type="reset" class="btn" style="min-width:200px;text-align:center;display:inline;">Regresar</button>
					</div>
				</form>
				<table id="tbl" class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
					<thead>
						<tr>
							<th data-halign="center">Tipo</th>
							<th data-halign="center">Fecha de Solicitud</th>
							<th data-halign="center">Colaborador</th>
							<th data-halign="center">Días</th>
							<th data-halign="center">Desde</th>
							<th data-halign="center">Hasta</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($solicitudes as $solicitud):
							if($solicitud->auth_ch && $this->session->userdata('area') != 4)
								$solicitud->observaciones.="<br><i>Requiere Autorización de Capital Humano</i>";
							if(isset($solicitud->detalle)):
								$detalle=$solicitud->detalle;
								$vuelos="";
								if($detalle->ruta_salida_uno)
									$vuelos.=$detalle->fecha_salida_uno." ".$detalle->hora_salida_uno ." (".$detalle->ruta_salida_uno.") <br>";
								if($detalle->ruta_salida_dos)
									$vuelos.=$detalle->fecha_salida_dos." ".$detalle->hora_salida_dos ." (".$detalle->ruta_salida_dos.") <br>";
								if($detalle->ruta_regreso_uno)
									$vuelos.=$detalle->fecha_regreso_uno." ".$detalle->hora_regreso_uno ." (".$detalle->ruta_regreso_uno.") <br>";
								if($detalle->ruta_regreso_dos)
									$vuelos.=$detalle->fecha_regreso_dos." ".$detalle->hora_regreso_dos ." (".$detalle->ruta_regreso_dos.") <br>";
								$conceptos=array();
								if($detalle->hotel_flag)
									array_push($conceptos, 'HOTEL');
								if($detalle->autobus_flag)
									array_push($conceptos,"AUTOBÚS");
								if($detalle->vuelo_flag)
									array_push($conceptos,"VUELO");
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
							switch ($solicitud->tipo) {
							 	case 1: $tipo='VACACIONES';						break;
							 	case 2: $tipo='PERMISO DE AUSENCIA';				break;
							 	case 3: $tipo='PERMISO SIN GOCE';				break;
							 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
							 	default: $tipo='';								break;
							} ?>
							<tr data-target="#collapse<?= $solicitud->id;?>" class="highlighted" data-toggle="collapse">
								<td><small><?= $tipo;?></small></td>
								<td><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
								<td><small><?=$solicitud->nombre; ?></small></td>
								<td><small><?= $solicitud->dias;?></small></td>
								<td><small><?= $solicitud->desde;?></small></td>
								<td><small><?= $solicitud->hasta;?></small></td>
							</tr>
							<tr id="collapse<?= $solicitud->id;?>" class="collapse out">
								<td height="100px" style="cursor:default;" colspan="8"><small>
									<?php if($solicitud->tipo < 3):
										if($solicitud->tipo==2): ?>
											<div class="col-md-2">
												<h5 align="center">MOTIVO</h5><br>
												<p align="center"><?=$solicitud->motivo; ?></p>
											</div>
										<?php endif; ?>
										<div class="col-md-7">
											<h5 align="center">OBSERVACIONES</h5><br>
											<p align="center"><?=$solicitud->observaciones; ?></p>
										</div>
									<?php else: ?>
										<div class="col-md-1">
											<h5 align="center">Centro de Costo</h5>
											<p align="center"><?= $detalle->centro_costo;?></p>
										</div>
										<div class="col-md-2">
											<h5 align="center">Motivo del Viaje</h5>
											<p align="center"><?= $detalle->motivo_viaje;?></p>
										</div>
										<div class="col-md-1">
											<h5 align="center">Viaje</h5>
											<p align="center"><?= $detalle->origen." - ".$detalle->destino;?></p>
										</div>
										<div class="col-md-2">
											<h5 align="center">Conceptos</h5>
											<ul type="square">
												<?php foreach ($conceptos as $concepto) : ?>
													<li><?= $concepto;?></li>
												<?php endforeach; ?>
											</ul>
										</div>
										<div class="col-md-1">
											<h5 align="center">Tipo de Vuelo</h5>
											<p align="center"><?= $detalle->tipo_vuelo;?></p>
										</div>
										<div class="col-md-2">
											<h5 align="center">Vuelos</h5>
											<p align="center"><?= $vuelos;?></p>
										</div>
									<?php endif; ?>
									<div class="col-md-3">
										<h5>&nbsp;</h5>
										<div align="center" class="btn-group btn-group-lg" role="group" aria-label="...">
											<?php if($this->session->userdata('area')==4): ?>
												<button onclick="actualizar(<?= $solicitud->id;?>,4);" type="button" class="btn btn-primary" 
													style="text-align:center;display:inline;">Autorizar</button>
											<?php else: ?>
												<button onclick="actualizar(<?= $solicitud->id;?>,2);" type="button" class="btn btn-primary" 
													style="text-align:center;display:inline;">Autorizar</button>
											<?php endif; ?>
											<button onclick="$('#tbl').hide('slow');$('#razon').show('slow');$('#estatus').val(3);$('#solicitud').val(<?= $solicitud->id;?>);" type="button" class="btn" style="text-align:center;display:inline;">Rechazar</button>
										</div>
									</div>
								</small></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif;
			if(!empty($propias)): ?>
				<h3>Tus Solicitudes</h3>
				<table id="tbl2" class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
					<thead>
						<tr>
							<th data-halign="center">Tipo</th>
							<th data-halign="center">Fecha de Solicitud</th>
							<th data-halign="center">Autorizador</th>
							<th data-halign="center">Días</th>
							<th data-halign="center">Desde</th>
							<th data-halign="center">Hasta</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($propias as $solicitud):
							if($solicitud->auth_ch && $solicitud->estatus==1)
								$solicitud->observaciones.="<br><i>Requiere Autorización de Capital Humano</i>";
							if(isset($solicitud->detalle)):
								$detalle=$solicitud->detalle;
								$vuelos="";
									if($detalle->ruta_salida_uno)
										$vuelos.=$detalle->fecha_salida_uno." ".$detalle->hora_salida_uno ." (".$detalle->ruta_salida_uno.") <br>";
									if($detalle->ruta_salida_dos)
										$vuelos.=$detalle->fecha_salida_dos." ".$detalle->hora_salida_dos ." (".$detalle->ruta_salida_dos.") <br>";
									if($detalle->ruta_regreso_uno)
										$vuelos.=$detalle->fecha_regreso_uno." ".$detalle->hora_regreso_uno ." (".$detalle->ruta_regreso_uno.") <br>";
									if($detalle->ruta_regreso_dos)
										$vuelos.=$detalle->fecha_regreso_dos." ".$detalle->hora_regreso_dos ." (".$detalle->ruta_regreso_dos.") <br>";
								$conceptos=array();
								if($detalle->hotel_flag)
									array_push($conceptos, 'HOTEL');
								if($detalle->autobus_flag)
									array_push($conceptos,"AUTOBÚS");
								if($detalle->vuelo_flag)
									array_push($conceptos,"VUELO");
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
							switch ($solicitud->estatus) {
								case 0: $estatus='CANCELADA';						break;
								case 1: $estatus='ENVIADA';							break;
								case 2: $estatus='AUTORIZADA';						break;
								case 3: $estatus='RECHAZADA';						break;
								case 4: $estatus='AUTORIZADA POR CAPITAL HUMANO';	break;
							}
							switch ($solicitud->tipo) {
							 	case 1: $tipo='VACACIONES';						break;
							 	case 2: $tipo='PERMISO CON GOCE';				break;
							 	case 3: $tipo='PERMISO SIN GOCE';				break;
							 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
							 	default: $tipo='';								break;
							 } ?>
							<tr data-target="#collapse<?= $solicitud->id;?>" class="highlighted" data-toggle="collapse">
								<td><small><?= $tipo;?></small></td>
								<td><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
								<td><small><?= $solicitud->nombre;?></small></td>
								<td><small><?= $solicitud->dias;?></small></td>
								<td><small><?= $solicitud->desde;?></small></td>
								<td><small><?= $solicitud->hasta;?></small></td>
							</tr>
							<tr id="collapse<?= $solicitud->id;?>" class="collapse out">
								<td height="100px" style="cursor:default;" colspan="6"><small>
									<?php if($solicitud->tipo != 4):
										if($solicitud->tipo==2): ?>
											<div class="col-md-2">
												<h5 align="center">MOTIVO</h5><br>
												<p align="center"><?=$solicitud->motivo; ?></p>
											</div>
										<?php endif; ?>
										<div class="col-md-8">
											<h5 align="center">OBSERVACIONES</h5><br>
											<p align="center"><?=$solicitud->observaciones; ?></p>
										</div>
									<?php else: ?>
										<div class="col-md-1">
											<h5 align="center">Centro de Costo</h5>
											<p align="center"><?= $detalle->centro_costo;?></p>
										</div>
										<div class="col-md-2">
											<h5 align="center">Motivo del Viaje</h5>
											<p align="center"><?= $detalle->motivo_viaje;?></p>
										</div>
										<div class="col-md-1">
											<h5 align="center">Viaje</h5>
											<p align="center"><?= $detalle->origen." - ".$detalle->destino;?></p>
										</div>
										<div class="col-md-2">
											<h5 align="center">Conceptos</h5>
											<ul type="square">
												<?php foreach ($conceptos as $concepto) : ?>
													<li><?= $concepto;?></li>
												<?php endforeach; ?>
											</ul>
										</div>
										<div class="col-md-1">
											<h5 align="center">Tipo de Vuelo</h5>
											<p align="center"><?= $detalle->tipo_vuelo;?></p>
										</div>
										<div class="col-md-2">
											<h5 align="center">Vuelos</h5>
											<p align="center"><?= $vuelos;?></p>
										</div>
									<?php endif; ?>
									<div class="col-md-2">
										<h5 align="center">Estatus</h5>
										<p align="center"><?php 
											if($solicitud->auth_ch && $solicitud->estatus==2)
												echo "<i>Requiere Autorización de Capital Humano</i>";
											else
												echo $estatus;?></p>
									</div>
									<?php if($solicitud->estatus == 3): ?>
										<div class="col-md-2">
											<h5 align="center">Razón de Rechazo</h5>
											<p align="center"><?=$solicitud->razon; ?></p>
										</div>
									<?php endif; ?>
								</small></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
		});
		document.write('\
			<style>\
				.highlighted {\
					background: '+color+'\
				}\
				table>tbody>tr>td>small>div>h5{\
					height:30px;\
				}\
			</style>\
		');

		function actualizar(solicitud,estatus) {
			$.ajax({
				url: '<?= base_url("servicio/autorizar_vacaciones");?>',
				type: 'post',
				data: {'solicitud':solicitud,'estatus':estatus},
				beforeSend: function() {
					$('#tbl').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					console.log(data);
					var returnedData = JSON.parse(data);
					if(returnedData['msg']=="ok")
						window.document.location.reload();
					else{
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
					console.log(xhr);
					$('#cargando').hide('slow');
					$('#tbl').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});
		}
		$("#razon").submit(function(event) {
			razon = $("#razon_txt").val();
			estatus = $("#estatus").val();
			solicitud = $("#solicitud").val();
			if(!confirm("¿Seguro que desea rechazar la solicitud?"))
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
					if(returnedData['msg']=="ok")
						window.document.location.reload();
					else{
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