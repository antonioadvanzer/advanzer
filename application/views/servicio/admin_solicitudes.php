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
							<th data-halign="center">Folio</th>
							<th data-halign="center">Tipo</th>
							<th data-halign="center">Solicitud</th>
							<th data-halign="center">Colaborador</th>
							<th data-halign="center">Autorizador</th>
							<th data-halign="center">Días</th>
							<th data-halign="center">Desde</th>
							<th data-halign="center">Hasta</th>
							<th data-halign="center">Estatus</th>
						</tr>
					</thead>
					<tbody data-link="row" class="rowlink">
						<?php foreach ($solicitudes as $solicitud):
							switch ($solicitud->estatus) {
							 	case 0: $estatus="CANCELADA";						break;
							 	case 1: $estatus="ENVIADA";							break;
							 	case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';	break;
								case 3: $estatus='RECHAZADA';						break;
								case 4: $estatus='AUTORIZADA';						break;
							}
							switch ($solicitud->tipo) {
								 	case 1: $tipo='VACACIONES';						break;
								 	case 2:	$tipo='NOTIFICACIÓN DE AUSENCIA';		break;
	 								case 3:	$tipo='PERMISO DE AUSENCIA';			break;
								 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
									case 5: $tipo='COMPROBACIÓN DE GASTOS DE VIAJE';break;
								 	default: $tipo='';								break;
								 } ?>
							<tr onmouseover="this.style.background=color;" onmouseout="this.style.background='transparent';">
								<td align="center"><a href="<?= base_url("servicio/ver/$solicitud->id");?>"><small><?= $solicitud->id;?></small></a>
                                </td>
								<td align="center"><small><?= $tipo;?></small></td>
								<td align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
								<td align="center"><small><?= $solicitud->nombre;?></small></td>
								<td align="center"><small><?= $solicitud->autorizador;?></small></td>
								<td align="center"><small><?= $solicitud->dias;?></small></td>
								<td align="center"><small><?= $solicitud->desde;?></small></td>
								<td align="center"><small><?= $solicitud->hasta;?></small></td>
								<td align="center"><small><?= $estatus;?></small></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true,info: false,order: [[ 0, "desc" ],[ 2, "desc" ]]});
		});
	</script>