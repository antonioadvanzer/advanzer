<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Solicitudes Capturadas</b></h2>
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
				<table id="tbl" class="display" align="center" data-toggle="table" data-hover="true" data-striped="true">
					<thead>
						<tr>
							<th data-halign="center">Tipo</th>
							<th data-halign="center">Solicitud</th>
							<th data-halign="center">Colaborador</th>
							<th data-halign="center">Autorizador</th>
							<th data-halign="center">Días</th>
							<th data-halign="center">Desde</th>
							<th data-halign="center">Hasta</th>
							<th data-halign="center">Observaciones</th>
							<th data-halign="center">Razón</th>
							<th data-halign="center">Estatus</th>
						</tr>
					</thead>
					<tbody data-link="row" class="rowlink">
						<?php foreach ($solicitudes as $solicitud):
							switch ($solicitud->estatus) {
							 	case 0: $estatus="CANCELADA";$razon=$solicitud->razon;							break;
							 	case 1: $estatus="ENVIADA";$razon=$solicitud->motivo;							break;
							 	case 2: $estatus="AUTORIZADA";$razon=$solicitud->motivo;
							 		if($solicitud->auth_ch)
							 			$estatus='PENDIENTE AUTORIZACIÓN DE CAPITAL HUMANO';
							 		break;
							 	case 3: $estatus="RECHAZADA";$razon=$solicitud->razon;							break;
							 	case 4: $estatus="AUTORIZADA POR CAPITAL HUMANO";$razon=$solicitud->motivo;		break;
							}
							switch ($solicitud->tipo) {
							 	case 1: $tipo="VACACIONES";				break;
							 	case 2: $tipo='PERMISO DE AUSENCIA';		break;
							 	case 3: $tipo='VIATICOS Y GASTOS DE VIAJE';		break;
							 	default:
							 		# code...
							 		break;
							} ?>
							<tr>
								<td style="cursor:default;"><small><?= $tipo;?></small></td>
								<td style="cursor:default;"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->nombre;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->autorizador;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->dias;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->desde;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->hasta;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->observaciones;?></small></td>
								<td style="cursor:default;"><small><?= $razon;?></small></td>
								<td style="cursor:default;"><small><?= $estatus;?></small></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true,info: false,order: [[ 9, "asc" ]]});
		});

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
						window.document.location='<?= base_url("vacaciones");?>';
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
				url: '<?= base_url("servicio/rechazar_vacaciones");?>',
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
						window.document.location='<?= base_url("vacaciones");?>';
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