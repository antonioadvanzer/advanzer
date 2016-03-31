<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Solicitudes Recibidas</b></h2>
		<p><small>Para aceptar o rechazar una solicitud pendiente, es necesario hacer click sobre ella y escoger la opción deseada</small></p>
	</div>
</div>
<div class="container">
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<div class="row">
		<div class="col-md-12" align="center">
			<div>
				<?php if(!empty($solicitudes)): ?>
					<table id="tbl" class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
						<thead>
							<tr>
								<th style="text-align:center">Folio</th>
								<th style="text-align:center">Tipo</th>
								<th style="text-align:center">Fecha de Solicitud</th>
								<th style="text-align:center">Colaborador</th>
								<th style="text-align:center">Días</th>
								<th style="text-align:center">Desde</th>
								<th style="text-align:center">Hasta</th>
								<th style="text-align:center">Estatus</th>
								<th style="text-align:center">Historial</th>
							</tr>
						</thead>
						<tbody data-link="row" class="rowlink">
							<?php foreach ($solicitudes as $solicitud):
								switch ($solicitud->estatus) {
									case 0: $estatus='CANCELADA';								break;
									case 1: $estatus='ENVIADA';									break;
									case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';			break;
									case 3: $estatus='AUTORIZADA';								break;
									case 4: $estatus='RECHAZADA';								break;
								}
								switch ($solicitud->tipo) {
								 	case 1: $tipo='VACACIONES';						break;
								 	case 2:	$tipo='NOTIFICACIÓN DE AUSENCIA';		break;
								 	case 3:	$tipo='PERMISO DE AUSENCIA';			break;
								 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
									case 5: $tipo='COMPROBACIÓN DE GASTOS DE VIAJE';break;
								 	default: $tipo='';								break;
								} ?>
								<tr data-target="#collapse<?= $solicitud->id;?>" data-toggle="collapse" onmouseover="this.style.background=color;" onmouseout="this.style.background='transparent';">
									<td align="center"><small><a class="view-pdf" href='<?= base_url("servicio/resolver/$solicitud->id");?>'><?= $solicitud->id;?></small></td>
									<td align="center"><small><?= $tipo;?></small></td>
									<td align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
									<td align="center"><small><?=$solicitud->nombre; ?></small></td>
									<td align="center"><small><?= $solicitud->dias;?></small></td>
									<td align="center"><small><?= $solicitud->desde;?></small></td>
									<td align="center"><small><?= $solicitud->hasta;?></small></td>
									<td align="center"><small><?= $estatus;?></small></td>
									<td align="center"><a class="view-pdf" target="_blank" title="Ver Historial del Colaborador" href="<?= base_url("servicio/historial/$solicitud->tipo/$solicitud->colaborador");?>"><span class="glyphicon glyphicon-time"></span></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true,order: [[ 2, "desc" ]]});
		} );
	</script>