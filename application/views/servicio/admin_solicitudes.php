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
							 	case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';$razon=$solicitud->motivo;	break;
								case 3: $estatus='AUTORIZADA';$razon=$solicitud->motivo;						break;
								case 4: $estatus='RECHAZADA';$razon=$solicitud->razon;							break;
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
							<tr>
								<td style="cursor:default;"><small><?= $tipo;?></small></td>
								<td style="cursor:default;"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->nombre;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->autorizador;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->dias;?></small></td>
								<td style="cursor:default;"><small><?= $solicitud->desde;?></small></td>
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
	</script>