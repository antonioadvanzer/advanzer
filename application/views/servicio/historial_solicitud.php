<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Historial de <?= " $tipo ($colaborador)";?></b></h2>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<table class="table" align="center" data-toggle="table" data-hover="true" data-striped="true">
				<thead>
					<tr>
						<th style="text-align:center">Folio</th>
						<th style="text-align:center">Fecha de Solicitud</th>
						<th style="text-align:center">Fecha de Resolución</th>
						<th style="text-align:center">Autorizador</th>
						<th style="text-align:center">Días</th>
						<th style="text-align:center">Desde</th>
						<th style="text-align:center">Hasta</th>
						<th style="text-align:center">Comentarios</th>
						<th style="text-align:center">Estatus</th>
					</tr>
				</thead>
				<tbody>
					<?php if(count($solicitudes))
						foreach ($solicitudes as $solicitud):
							switch ($solicitud->estatus) :
								case 0: $estatus='CANCELADA';$comentarios=$solicitud->razon;									break;
								case 1: $estatus='ENVIADA';$comentarios=$solicitud->motivo;										break;
								case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';$comentarios=$razon=$solicitud->motivo;		break;
								case 3: $estatus='AUTORIZADA';$comentarios=$solicitud->motivo;									break;
								case 4: $estatus='RECHAZADA POR CAPITAL HUMANO';
									if($solicitud->auth_uno==0&& $solicitud->tipo < 4)
										$estatus='RECHAZADA POR AUTORIZADOR';
									$comentarios=$solicitud->razon;																break;
							endswitch; ?>
							<tr onmouseover="this.style.background=color;" onmouseout="this.style.background='transparent';">
								<td align="center"><small><a href='<?= base_url("servicio/ver/$solicitud->id");?>'><?= $solicitud->id;?></small></td>
								<td align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
								<td align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_ultima_modificacion));?></small></td>
								<td align="center"><small><?= $solicitud->nombre_autorizador;?></small></td>
								<td align="center"><small><?= $solicitud->dias;?></small></td>
								<td align="center"><small><?= $solicitud->desde;?></small></td>
								<td align="center"><small><?= $solicitud->hasta;?></small></td>
								<td align="center"><small><?= $comentarios;?></small></td>
								<td align="center"><small><?= $estatus;?></small></td>
							</tr>
						<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>