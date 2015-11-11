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
							<td align="center"><img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
							<td><small><?= $colab->nombre;?></small></td>
							<td data-sortable="false">
								<hr>
								<?php if(count($colab->asignaciones) > 0): ?>
									<div class="row">
										<div class="col-sm-1"><small><b>Total</b></small></div>
										<div class="col-sm-3"><small><b>Responsabilidades</b></small></div>
										<div class="col-sm-2"><small><b>Competencias</b></small></div>
										<div class="col-sm-6"><small><b>Colaborador</b></small></div>
									</div>
									<?php foreach ($colab->asignaciones as $colaborador) : ?>
										<div class="row">
											<div class="col-sm-1"><small><?php if($colaborador->total){
												echo number_format($colaborador->total,2);$count++;}else echo "--";?></small></div>
											<div class="col-sm-3"><small><?php if($colaborador->total) 
												echo number_format($colaborador->responsabilidad,2);else echo "--";?></small></div>
											<div class="col-sm-2"><small><?php if($colaborador->total) 
												echo number_format($colaborador->competencia,2);else echo "--";;?></small></div>
											<div class="col-sm-6"><img height="30px" src="<?= base_url('assets/images/fotos')."/"
												.$colaborador->foto;?>"> <small><?= $colaborador->nombre;?></small></div>
										</div>
									<?php endforeach; ?>
									<hr>
								<?php endif;
								if(count($colab->asignaciones360) > 0): ?>
									<div class="row">
										<div class="col-sm-3"><small><b>Resultado</b></small></div>
										<div class="col-sm-9"><small><b>Colaborador 360</b></small></div>
									</div>
									<?php foreach ($colab->asignaciones360 as $colaborador) : ?>
										<div class="row">
											<div class="col-sm-3"><small><?php if($colaborador->total){
												echo number_format($colaborador->total,2);$count++;}else echo "--";?></small></div>
											<div class="col-sm-9"><img height="30px" src="<?= base_url('assets/images/fotos')."/"
												.$colaborador->foto;?>"> <small><?= $colaborador->nombre;?></small></div>
										</div>
									<?php endforeach; ?>
									<hr>
								<?php endif;
								if(count($colab->asignacionesProyecto) > 0): ?>
									<div class="row">
										<div class="col-sm-3"><small><b>Resultado</b></small></div>
										<div class="col-sm-9"><small><b>Colaborador de Proyecto</b></small></div>
									</div>
									<?php foreach ($colab->asignacionesProyecto as $colaborador) : ?>
										<div class="row">
											<div class="col-sm-3"><small><?php if($colaborador->total){
												echo number_format($colaborador->total,2);$count++;}else echo "--";?></small></div>
											<div class="col-sm-9"><img height="30px" src="<?= base_url('assets/images/fotos')."/"
												.$colaborador->foto;?>"> <small><?= $colaborador->nombre;?></small></div>
										</div>
									<?php endforeach; ?>
									<hr>
								<?php endif; ?>
							</td>
							<td class="text-center"><?= number_format($count/(count($colab->asignaciones)+count($colab->asignaciones360)+count($colab->asignacionesProyecto))*100,0);?></td>
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