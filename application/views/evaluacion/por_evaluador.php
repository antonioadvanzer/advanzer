<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Evaluadores</h2>
	</div>
</div>
<div class="container">
	<div align="center" id="alert" style="display:none">
		<div class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg"></label>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table id="tbl" align="center" class="display">
				<thead>
					<tr>
						<th data-halign="center" data-align="center" data-defaultsort="disabled"></th>
						<th data-halign="center">Evaluador</th>
						<th data-halign="center">Asignaciones</th>
						<th data-halign="center">Avance (%)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($evaluadores as $colab): $count=0;?>
						<tr>
							<td style="cursor:default" align="center"><img class="img-circle avatar avatar-original" height="40px" 
								src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
							<td style="cursor:default"><small><?= $colab->nombre;?></small></td>
							<td style="cursor:default" data-sortable="false"> <table id="tbl2" align="center" class="display" width="100%">
								<thead>
									<tr>
										<th style="width:10%"><small>Total</small></th>
										<th style="width:20%"><small>Responsabilidades</small></th>
										<th style="width:20%"><small>Competencias</small></th>
										<th style="width:50%"><small>Colaborador</small></th>
									</tr>
								</thead>
								<tbody data-link="row">
									<?php if(count($colab->asignaciones) > 0)
										foreach ($colab->asignaciones as $colaborador) : ?>
											<tr>
												<td><a target="_blank" style="text-decoration:none" href="<?= base_url("evaluacion/detalle_asignacion/$colaborador->id");?>">
													<small><?php if($colaborador->total){
													echo number_format(floor($colaborador->total*100)/100,2);$count++;}?></small></a></td>
												<td><small><?php if($colaborador->total) 
													echo number_format(floor($colaborador->responsabilidad*100)/100,2);?></small></td>
												<td><small><?php if($colaborador->total) 
													echo number_format(floor($colaborador->competencia*100)/100,2);?></small></td>
												<td><small><img class="img-circle avatar avatar-original" height="40px" 
													src="<?= base_url('assets/images/fotos')."/"
													.$colaborador->foto;?>"><?= $colaborador->nombre;?></small></td>
											</tr>
										<?php endforeach;
									if(count($colab->asignaciones360) > 0)
										foreach ($colab->asignaciones360 as $colaborador) : ?>
											<tr>
												<td><a target="_blank" style="text-decoration:none" href="<?= base_url("evaluacion/detalle_asignacion/$colaborador->id");?>">
													<small><?php if($colaborador->total){
													echo number_format(floor($colaborador->total*100)/100,2);$count++;}?></small></a></td>
												<td>&nbsp;</td>
												<td><small><?php if($colaborador->total)
													echo number_format(floor($colaborador->total*100)/100,2);?></small></td>
												<td colspan="3"><small><img class="img-circle avatar avatar-original" height="40px" 
													src="<?= base_url('assets/images/fotos')."/"
													.$colaborador->foto;?>"><?= $colaborador->nombre;?></small></td>
											</tr>
										<?php endforeach;
									if(count($colab->asignacionesProyecto) > 0)
										foreach ($colab->asignacionesProyecto as $colaborador) : ?>
											<tr>
												<td><a target="_blank" style="text-decoration:none" href="<?= base_url("evaluacion/detalle_asignacion/$colaborador->id");?>">
													<small><?php if($colaborador->total){
													echo number_format(floor($colaborador->total*100)/100,2);$count++;}?></small></a></td>
												<td><small><?php if($colaborador->total)
													echo number_format(floor($colaborador->total*100)/100,2);?></small></td>
												<td>&nbsp;</td>
												<td colspan="3"><small><img class="img-circle avatar avatar-original" height="40px" 
													src="<?= base_url('assets/images/fotos')."/"
													.$colaborador->foto;?>"><?= $colaborador->nombre;?></small></td>
											</tr>
										<?php endforeach; ?>
								</tbody>
							</table></td>
							<td style="cursor:default" class="text-center"><?= number_format($count/(count($colab->asignaciones)+count($colab->asignaciones360)+count($colab->asignacionesProyecto))*100,0);?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true});
		} );
	</script>