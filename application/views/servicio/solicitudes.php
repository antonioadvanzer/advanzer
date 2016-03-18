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
			<form id="razon" role="form" method="post" action="javascript:" class="form-signin" style="display:none">
				<input type="hidden" id="estatus" value="">
				<input type="hidden" id="solicitud" value="">
				<div class="input-group">
					<span class="input-group-addon" style="min-width:200px">Razón</span>
					<textarea class="form-control" required id="razon_txt" rows="4" placeholder="Razón por la que se descarta"></textarea>
				</div>
				<br>
				<div class="btn-group btn-group-lg" role="group" aria-label="..." style="float:right;">
					<button type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;">Confirmar</button>
					<button onclick="$('#razon').hide('slow');$('#tbl').show('slow');$('#estatus').val('');" type="reset" class="btn" style="min-width:200px;text-align:center;">Regresar</button>
				</div>
			</form>
			<div id="tbl">
				<?php if(!empty($solicitudes)): ?>
					<h3>Pendientes de Revisar</h3>
					<table class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
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
								if(isset($solicitud->detalle)):
									$detalle=$solicitud->detalle;
									if($detalle->anticipo != 0)
										break;
									$vuelos="";
									if($detalle->ruta_salida)
										$vuelos.=$detalle->fecha_salida." ".date_format(date_create($detalle->hora_salida),'H:i')." (".$detalle->ruta_salida.") <br>";
									if($detalle->ruta_regreso)
										$vuelos.=$detalle->fecha_regreso." ".date_format(date_create($detalle->hora_regreso),'H:i')." (".$detalle->ruta_regreso.") <br>";
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
								switch ($solicitud->tipo) {
								 	case 1: $tipo='VACACIONES';						break;
								 	case 2:case 3: $tipo='PERMISO DE AUSENCIA';		break;
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
									<td height="100px" style="cursor:default;" colspan="7"><small>
										<?php if($solicitud->tipo < 4):
											if($solicitud->tipo==2 || $solicitud->tipo==3):
												$filename=base_url("assets/docs/permisos/permiso_$solicitud->id");
												if(file_exists($filename)): ?>
													<div class="col-md-2">
														<h5 align="center">COMPROBANTE</h5><br>
														<p align="center"><a href="<?= $filename;?>;?>" download><span class="glyphicon glyphicon-download-alt"></span> descargar</a></p>
													</div>
												<?php endif; ?>
												<div class="col-md-2">
													<h5 align="center">MOTIVO</h5><br>
													<p align="center"><?=$solicitud->motivo; ?></p>
												</div>
												<?php if(!in_array($solicitud->motivo,array('MATRIMONIO','NACIMIENTO DE HIJOS','FALLECIMIENTO DE CÓNYUGE','FALLECIMIENTO DE HERMANOS','FALLECIMIENTO DE HIJOS','FALLECIMIENTO DE PADRES','FALLECIMIENTO DE PADRES POLÍTICOS'))): ?>
													<div class="col-md-3" align="center">
														<h5 align="center">TIPO DE PERMISO</h5><br>
														<label class="radio-inline">
															<input type="radio" name="tipo" id="con_goce" value="CON GOCE" <?php if($solicitud->tipo==2) echo"checked";?>> CON GOCE
														</label>
														<label class="radio-inline">
															<input type="radio" name="tipo" id="sin_goce" value="SIN GOCE" <?php if($solicitud->tipo==3) echo"checked";?>> SIN GOCE
														</label>
													</div>
												<?php endif;
											endif;
											if($solicitud->tipo==1 && count($solicitud->historial)>0): ?>
												<div class="col-md-3">
													<h5 align="center">HISTORIAL</h5>
													<div class="row" align="center">
														<div class="col-md-2"><b>Días</b></div>
														<div class="col-md-5"><b>Desde</b></div>
														<div class="col-md-5"><b>Estatus</b></div>
														<?php foreach ($solicitud->historial as $registro) :
															switch ($registro->estatus) {
																case 0: $estatus='CANCELADA';								break;
																case 1: $estatus='ENVIADA';									break;
																case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';			break;
																case 3: $estatus='AUTORIZADA';								break;
																case 4: $estatus='RECHAZADA';								break;
															} ?>
															<div class="col-md-2"><?= $registro->dias;?></div>
															<div class="col-md-5"><?= $registro->desde;?></div>
															<div class="col-md-5"><?= $estatus;?></div>
														<?php endforeach; ?>
													</div>
												</div>
											<?php endif; ?>
											<div class="col-md-4">
												<h5 align="center">OBSERVACIONES</h5><br>
												<p align="center"><?=$solicitud->observaciones; ?></p>
											</div>
										<?php else: ?>
											<div class="col-md-2">
												<h5 align="center">Centro de Costo</h5>
												<p align="center"><?= $detalle->centro_costo;?></p>
											</div>
											<div class="col-md-2">
												<h5 align="center">Motivo del Viaje</h5>
												<p align="center"><?= $solicitud->motivo;?></p>
											</div>
											<div class="col-md-1">
												<h5 align="center">Viaje</h5>
												<p align="center"><?= $detalle->origen." - ".$detalle->destino;?></p>
											</div>
											<div class="col-md-1">
												<h5 align="center">Conceptos</h5>
												<ul type="square">
													<?php foreach ($conceptos as $concepto) : ?>
														<li><?= $concepto;?></li>
													<?php endforeach; ?>
												</ul>
											</div>
											<div class="col-md-2">
												<h5 align="center">Vuelos</h5>
												<p align="center"><?= $vuelos;?></p>
											</div>
											<div class="col-md-1">
												<h5 align="center">Anticipo</h5>
												<?php if($this->session->userdata('area')==9 && $solicitud->autorizador!=$this->session->userdata('id')): ?>
													<input class="form-control" style="background-color:white;float:left;" required value="" id="anticipo">
												<?php endif; ?>
											</div>
										<?php endif; ?>
										<div class="col-md-3" align="center" style="float:right;">
											<h5>&nbsp;</h5>
											<div align="center" class="btn-group btn-group-lg" role="group" aria-label="...">
												<?php if($this->session->userdata('area')==4 || ($solicitud->tipo==4 && $solicitud->autorizador==$this->session->userdata('id'))): ?>
													<button onclick="actualizar(<?= $solicitud->id;?>,3);" type="button" class="btn btn-primary" 
														style="text-align:center;display:inline;">Autorizar</button>
												<?php elseif($this->session->userdata('area')==9 && $solicitud->autorizador!=$this->session->userdata('id')): ?>
													<button onclick="confirmar(<?= $solicitud->id;?>);" type="button" class="btn btn-primary" 
														style="text-align:center;display:inline;">Confirmar</button>
												<?php else: ?>
													<button onclick="actualizar(<?= $solicitud->id;?>,2);" type="button" class="btn btn-primary" 
														style="text-align:center;display:inline;">Autorizar</button>
												<?php endif;
												if($this->session->userdata('area')==4 || $solicitud->autorizador==$this->session->userdata('id')): ?>
													<button onclick="$('#tbl').hide('slow');$('#razon').show('slow');$('#estatus').val(4);$('#solicitud').val(<?= $solicitud->id;?>);" type="button" class="btn" style="text-align:center;display:inline;">Rechazar</button>
												<?php endif; ?>
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
					<table class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
						<thead>
							<tr>
								<th data-halign="center">Tipo</th>
								<th data-halign="center">Fecha de Solicitud</th>
								<th data-halign="center">Autorizador</th>
								<th data-halign="center">Días</th>
								<th data-halign="center">Desde</th>
								<th data-halign="center">Hasta</th>
								<th data-halign="center">Estatus</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($propias as $solicitud):
								if(isset($solicitud->detalle)):
									$detalle=$solicitud->detalle;
									$vuelos="";
										if($detalle->ruta_salida)
											$vuelos.=$detalle->fecha_salida." ".$detalle->hora_salida ." (".$detalle->ruta_salida.") <br>";
										if($detalle->ruta_regreso)
											$vuelos.=$detalle->fecha_regreso." ".$detalle->hora_regreso ." (".$detalle->ruta_regreso.") <br>";
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
								switch ($solicitud->estatus) {
									case 0: $estatus='CANCELADA';								break;
									case 1: $estatus='ENVIADA';									break;
									case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';			break;
									case 3: $estatus='AUTORIZADA';								break;
									case 4: $estatus='RECHAZADA';								break;
								}
								switch ($solicitud->tipo) {
								 	case 1: $tipo='VACACIONES';						break;
								 	case 2:
								 		$tipo='PERMISO DE AUSENCIA';
								 		if($solicitud->estatus==3)
								 			$tipo.=' CON GOCE';
								 		break;
								 	case 3:
								 		$tipo='PERMISO DE AUSENCIA';
								 		if($solicitud->estatus==3)
								 			$tipo.=' SIN GOCE';
								 		break;
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
									<td><small><?= $estatus;?></small></td>
								</tr>
								<tr id="collapse<?= $solicitud->id;?>" class="collapse out">
									<td height="100px" style="cursor:default;" colspan="7"><small>
										<?php if($solicitud->tipo < 4):
											if($solicitud->tipo==2 || $solicitud->tipo==3): ?>
												<?php $filename=base_url("assets/docs/permisos/permiso_$solicitud->id");
												$file_headers = @get_headers($filename);
												if($file_headers[0] != 'HTTP/1.1 404 Not Found' && $file_headers[0] != 'HTTP/1.0 404 Not Found'): ?>
													<div class="col-md-2">
														<h5 align="center">COMPROBANTE</h5><br>
														<p align="center"><a href="<?= $filename;?>" download><span class="glyphicon glyphicon-download-alt"></span> descargar</a></p>
													</div>
												<?php endif; ?>
												<div class="col-md-2">
													<h5 align="center">MOTIVO</h5><br>
													<p align="center"><?=$solicitud->motivo; ?></p>
												</div>
											<?php endif; ?>
											<div class="col-md-5">
												<h5 align="center">OBSERVACIONES</h5><br>
												<p align="center"><?=$solicitud->observaciones; ?></p>
											</div>
										<?php else: ?>
											<div class="col-md-2">
												<h5 align="center">Centro de Costo</h5>
												<p align="center"><?= $detalle->centro_costo;?></p>
											</div>
											<div class="col-md-2">
												<h5 align="center">Motivo del Viaje</h5>
												<p align="center"><?= $solicitud->motivo;?></p>
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
											<div class="col-md-3">
												<h5 align="center">Vuelos</h5>
												<p align="center"><?= $vuelos;?></p>
											</div>
										<?php endif; ?>
										<?php if($solicitud->estatus == 4): ?>
											<div class="col-md-2">
												<h5 align="center">Razón de Rechazo</h5>
												<p align="center"><?=$solicitud->razon; ?></p>
											</div>
										<?php endif;
										if(($solicitud->colaborador == $this->session->userdata('id') && ($solicitud->estatus == 1 || $solicitud->estatus==2)) || (($this->session->userdata('area')==4 || $this->session->userdata('tipo') >= 4) && $solicitud->estatus<4 && $solicitud->estatus>0)): ?>
											<div class="col-md-1" align="right" style="float:right;">
												<h5>&nbsp;</h5>
												<button onclick="$('#tbl').hide('slow');$('#razon').show('slow');$('#estatus').val(0);$('#solicitud').val(<?= $solicitud->id;?>);" type="button" class="btn" style="text-align:center;display:inline;">Cancelar</button>
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
	</div>

	<script>
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

		function confirmar(solicitud) {
			anticipo=$('#anticipo').val();
			if(anticipo==''){
				alert('Especifica el anticipo');
				$('#anticipo').focus();
				return false;
			}
			if(!confirm('¿Notificar el anticipo de $'+anticipo+'?'))
				return false;
			$.ajax({
				url: '<?= base_url("servicio/confirmar_anticipo");?>',
				type: 'post',
				data: {'solicitud':solicitud,'anticipo':anticipo},
				beforeSend: function() {
					$('#tbl').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					console.log(data);
					var returnedData = JSON.parse(data);
					if(returnedData['msg']=="ok"){
						alert('Se ha notificado el anticipo');
						window.document.location.reload();
					}else{
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
		function actualizar(solicitud,estatus) {
			if(!confirm('¿Seguro que desea autorizar la solicitud?'))
				return false;
			tipo=<?= $solicitud->tipo;?>;
			if($('#con_goce').is(':checked'))
				tipo=3;
			if($('#sin_goce').is(':checked'))
				tipo=2;
			$.ajax({
				url: '<?= base_url("servicio/autorizar_solicitud");?>',
				type: 'post',
				data: {'solicitud':solicitud,'estatus':estatus,'tipo':tipo},
				beforeSend: function() {
					$('#tbl').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					console.log(data);
					var returnedData = JSON.parse(data);
					if(returnedData['msg']=="ok"){
						alert('Se ha recibido su respuesta');
						window.document.location.reload();
					}else{
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