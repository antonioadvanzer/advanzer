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
	 	case 2:	$tipo='NOTIFICACIÓN DE AUSENCIA';		break;
	 	case 3:	$tipo='PERMISO DE AUSENCIA';			break;
	 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
		case 5: $tipo='COMPROBACIÓN DE GASTOS DE VIAJE';break;
	 	default: $tipo='';								break;
	endswitch; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?= base_url('assets/images/favicon.ico');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-table.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-theme.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/datepicker/css/bootstrap-datepicker.css');?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.dataTables.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-select.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/easy-modal.css');?>">
	<script src="<?= base_url('assets/js/jquery.min.js');?>"></script>
	<!--<script src="<?= base_url('assets/js/bootstrap-table.js');?>"></script>-->
	<script src="<?= base_url('assets/js/docs.min.js');?>"></script>
	<script src="<?= base_url('assets/datepicker/js/bootstrap-datepicker.min.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="<?= base_url('assets/js/moment.min.js');?>"></script>
	<!--<script src="<?= base_url('assets/js/tableExport.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-table-export.js');?>"></script>-->
	<script src="<?= base_url('assets/js/jquery.dataTables.js');?>"></script>
	<script src="<?= base_url('assets/js/jquery.dataTables.columnFilter.js');?>"></script>
	<script src="<?= base_url('assets/js/jasny-bootstrap.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-select.js');?>"></script>
	<script src="<?= base_url('assets/js/highcharts/highcharts.js');?>"></script>
	<script src="<?= base_url('assets/js/circle-progress.js');?>"></script>
	<script src="<?= base_url('assets/js/easy-modal.js');?>"></script>
	<title><?=$title_for_layout?></title>
	<style type="text/css">
		body {
			padding-bottom: 20px;
		}
		.jumbotron {
			-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#628DC8, endColorstr=#ffffff)";
			filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#628DC8', endColorstr='#ffffff');
		}
		.navbar-inverse {
			background-image: -webkit-linear-gradient(top, #3c3c3c 0%, #222 100%);
			background-image: -o-linear-gradient(top, #3c3c3c 0%, #222 100%);
			background-image: -webkit-gradient(linear, left top, left bottom, from(#3c3c3c), to(#222));
			background-image: linear-gradient(to bottom, #3c3c3c 0%, #222 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3c3c3c', endColorstr='#ff222222', GradientType=0);
			filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
			background-repeat: repeat-x;
			/*border-radius: 4px;*/
		}
	</style>
	<script>
		var empresa = <?php if($this->session->userdata('empresa')) echo $this->session->userdata('empresa');else echo 0;?>;
		var color = "";
		switch(empresa){
			case 1:
				color = "#C0D339";
				font = "TitilliumText22L-400wt.otf";
				titleFont = "TitilliumText22L";
			break;
			case 2:
				color = "#628DC8";
				font = "corbel.ttf";
				titleFont = "Corbel";
			break;
			default:
				color= "#";
				font = "AvenirLTStd-Medium.otf";
				titleFont = "Avenir LT Std 65 Medium";
			break;
		}
		if(color != "#")
			document.write('\
				<style>\
					.jumbotron {\
						background: -webkit-linear-gradient('+color+',#fff); /* For Safari 5.1 to 6.0 */\
						background: -o-linear-gradient('+color+',#fff); /* For Opera 11.1 to 12.0 */\
						background: -moz-linear-gradient('+color+',#fff); /* For Firefox 3.6 to 15 */\
						background: linear-gradient('+color+',#fff); /* Standard syntax (must be last) */\
					}\
					html,body {\
						font-family: "'+titleFont+'";\
						src: url("<?= base_url("assets/fonts");?>/'+font+'");\
					}\
					.badge {\
						background-color: '+color+';\
					}\
				</style>\
			');
		else
			document.write('\
				<style>\
					.navbar-inverse {\
						background-image: -moz-linear-gradient(left, #C0D339, #628DC8);\
						background-image: -ms-linear-gradient(left, #C0D339, #628DC8);\
						background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#C0D339), to(#628DC8));\
						background-image: -webkit-linear-gradient(left, #C0D339, #628DC8);\
						background-image: -o-linear-gradient(left, #C0D339, #628DC8);\
						background-image: linear-gradient(left, #C0D339, #628DC8);\
						background-repeat: repeat-x;\
					}\
					html,body {\
						font-family: "'+titleFont+'";\
						src: url("<?= base_url("assets/fonts");?>/'+font+'");\
					}\
				</style>\
			');
	</script>
</head>
<body>
	<div class="jumbotron">
		<div class="container">
			<h2 align="left"><b>Detalle de <?= $tipo;?></b></h2>
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
					<?php if($solicitud->tipo != 5): ?>
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
					<?php endif;?>
					<div class="row" align="center">
						<?php if($solicitud->tipo != 5): ?>
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
										if($solicitud->tipo==2):
											$filename=base_url("assets/docs/permisos/permiso_$solicitud->id"); ?>
											<div class="input-group">
												<?php if(file_exists($filename)): ?>
													<span class="input-group-addon">Comprobante</span>
													<a href="<?= $filename;?>;?>" download><span class="glyphicon glyphicon-download-alt"></span> descargar</a>
												<?php endif; ?>
												<span class="input-group-addon">Motivo</span>
												<input value="<?=$solicitud->motivo;?>" type="text" class="form-control" readonly>
												<!--<span class="input-group-addon">Tipo de Permiso</span>
												<input type="text" class="form-control" value="<?php if($solicitud->tipo==2) echo"Con Goce de Sueldo";else echo "Sin Goce de Sueldo?>";?>" readonly>-->
											</div><br>
										<?php endif; ?>
									<?php elseif($solicitud->tipo==4): ?>
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
									<?php endif;
									$filename=base_url("assets/docs/permisos/permiso_$solicitud->id");
									$file_headers = @get_headers($filename);
									if($file_headers[0] !== 'HTTP/1.0 404 Not Found'): ?>
										<h3>Comprobante</h3>
										<div class="col-md-12">
											<a class="view-pdf" href="<?= $filename;?>"><span class="glyphicon glyphicon-eye-open"></span> Ver Comprobante</a>
										</div>
									<?php endif;
									if(!in_array($solicitud->motivo,array("ENFERMEDAD","MATRIMONIO","NACIMIENTO DE HIJOS","FALLECIMIENTO DE CÓNYUGE","FALLECIMIENTO DE HERMANOS","FALLECIMIENTO DE HIJOS","FALLECIMIENTO DE PADRES","FALLECIMIENTO DE PADRES POLÍTICOS")))
										if(($solicitud->estatus != 0) && ($solicitud->estatus != 3)): ?>
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
															<?php if($solicitud->estatus == 1): ?>
																<span class="glyphicon glyphicon-eye-open"></span> VALIDANDO
															<?php elseif($solicitud->estatus == 2 || $solicitud->auth_uno == 1): ?>
																<span class="glyphicon glyphicon-ok"></span> AUTORIZADO
															<?php elseif($solicitud->estatus == 3 && $solicitud->auth_uno == 0): ?>
																<span class="glyphicon glyphicon-remove"></span> RECHAZADO
															<?php elseif($solicitud->motivo=="ENFERMEDAD"): ?>
																<span class="glyphicon glyphicon-ok"></span> ENTERADO
															<?php endif; ?>
														</td>
														<?php if($solicitud->tipo < 4): ?>
															<td style="text-align:center;cursor:text;">
																<?php if($solicitud->estatus == 2): ?>
																	<span class="glyphicon glyphicon-eye-open"></span> VALIDANDO
																<?php elseif($solicitud->estatus == 4 && $solicitud->auth_uno == 1): ?>
																	<span class="glyphicon glyphicon-ok"></span> AUTORIZADO
																<?php elseif($solicitud->estatus == 3 && $solicitud->auth_uno == 1): ?>
																	<span class="glyphicon glyphicon-remove"></span> RECHAZADO
																<?php elseif($solicitud->estatus == 1): ?>
																	<span class="glyphicon glyphicon glyphicon-time"></span> PENDIENTE
																<?php elseif($solicitud->motivo=="ENFERMEDAD"): ?>
																	<span class="glyphicon glyphicon-ok"></span> ENTERADO
																<?php endif; ?>
															</td>
														<?php endif;?>
													</tr>
													<?php if($solicitud->estatus==3): ?>
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
													<?php endif; ?>
												</tbody>
											</table>
										<?php else: ?>
											<h3>Motivo Cancelación</h3>
											<p><?= $solicitud->razon;?></p>
										<?php endif;?>
									<hr>
									<?php 
									$desde=new DateTime($solicitud->desde);
									$hoy=new DateTime(date('Y-m-d'));
									
                                    if(($solicitud->estatus == 4) && ($solicitud->colaborador == $this->session->userdata('id'))
                                       && (($solicitud->tipo == 1) || ($solicitud->tipo == 3)) && ($desde->diff($hoy)->format('%r'))):
                                    
                                    //if($solicitud->estatus != 0 && $solicitud->colaborador == $this->session->userdata('id')):
										
                                        /*if(($solicitud->tipo==4 && $solicitud->estatus!=3) || !in_array($solicitud->tipo,array(4,5)) && $solicitud->estatus!=4 && $desde->diff($hoy)->format('%r')):*/ ?>
										
                                        <div class="col-md-8">
											<label style="float:left;color:red">Puedes CANCELAR tu solicitud de <?= $tipo;?> hasta un día antes de que inicie el período que solicitaste dando click en:</label>
                                        </div>
                                        <div class="col-md-4" align="center" style="float:right;">
                                            <div align="center" class="btn-group btn-group-lg" role="group" aria-label="...">
                                                <button onclick="$('#update').hide('slow');$('#razon').show('slow');$('#estatus').val(0);" type="button" class="btn btn-primary" style="text-align:center;display:inline;">Cancelar Solicitud</button>
                                            </div>
                                        </div>
										
                                        <?php //endif;
									endif; ?>
								</div>
								<br>
							</div>
						<?php else: ?>
							<div class="col-md-12">
								<table class="table table-striped table-hover table-condensed">
									<thead>
										<tr>
											<th style="text-align:center;">Factura</th>
											<th style="text-align:center;">Centro de Costo</th>
											<th style="text-align:center;">Fecha</th>
											<th style="text-align:center;">Concepto</th>
											<th style="text-align:center;">Prestador</th>
											<th style="text-align:center;">Importe</th>
											<th style="text-align:center;">Iva</th>
											<th style="text-align:center;">Total</th>
											<th style="text-align:center;">Estatus</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($solicitud->comprobantes as $comprobante) : ?>
											<tr>
												<td style="text-align:center;cursor:text;"><?php $filename=base_url("assets/docs/facturas/$comprobante->id.xml");
												if(file_exists($filename)): ?>
													<a href="<?= $filename;?>" download><span class="glyphicon glyphicon-download-alt"></span> descargar</a>
												<?php endif; ?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->centro_costo;?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->fecha;?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->concepto;?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->prestador;?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->importe;?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->iva;?></td>
												<td style="text-align:center;cursor:text;"><?= $comprobante->total;?></td>
												<td style="text-align:center;cursor:text;">
													<?php if($comprobante->estatus==1): ?>VALIDANDO
													<?php elseif($comprobante->estatus==2): ?>ACEPTADO
													<?php elseif($comprobante->estatus==3): ?>RECHAZADO
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php endif; ?>
					</div>
				</form>
			</div>
		</div>
        
    <div id="openModal" class="modalDialog">
        <div>
            <div id="title" class="title" align="center"><h2>Titulo</h2></div>
            <a title="Close" onclick="window.history.back();" class="close">X</a>
            <div id="body" class="body" align="center">  

            </div>
        </div>
    </div>
        
		<script>
            
            function modalWindow(option){
                
                switch(option){
                     
                        // Confirmar si desea autorizar
                        case "cancelar":

                            document.getElementById("title").innerHTML = '<h2>Atención</h2>'
                            document.getElementById("body").innerHTML = '<p>¿Seguro que deseas cancelar la solicitud?</p>'
                                            +'<a type="button" class="btn btn-primary" href="#procesando" onclick="cancelar();">Aceptar</a>&nbsp; &nbsp; '
                                            +'<a type="button" class="btn btn-primary" onclick="window.history.back();">Cancelar</a>';
                            window.document.location = "#openModal";

                        break;

                        case "confirm_cancelar":

                            document.getElementById("title").innerHTML = '<h2>Aviso</h2>'
                            document.getElementById("body").innerHTML = '<p>Se ha recibido su respuesta</p>'
                                            +'<a type="button" class="btn btn-primary" onclick="confirm_cancelar();">Aceptar</a>';
                            window.document.location = "#openModal";

                        break;
                }
            }
            
            function cancelar(){
                
                razon = $("#razon_txt").val();
				estatus = $("#estatus").val();
				solicitud = $("#solicitud").val();
				
                /*if(!confirm("¿Seguro que deseas cancelar la solicitud?"))
					return false;*/
                
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
							
                            /*alert('Se ha recibido su respuesta');
							window.document.location.reload();*/
                            
                            $('#razon').show('slow');
                            $('#cargando').hide('slow');
                            
                            window.modalWindow("confirm_cancelar");
                            
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
            }
            
            function confirm_cancelar(){
                parent.location.reload();
            }
            
			$("#razon").submit(function(event) {
				
                modalWindow("cancelar");
                
                /*razon = $("#razon_txt").val();
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

				event.preventDefault();*/
			});
		</script>
	</div> <!-- /container -->
</body>
</html>