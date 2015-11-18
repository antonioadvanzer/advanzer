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
							<td data-sortable="false" class="rowlink-skip"> <table id="tbl2" align="center" class="display">
								<?php if(count($colab->asignaciones) > 0): ?>
									<thead>
										<tr>
											<th><small>Total</small></th>
											<th><small>Responsabilidades</small></th>
											<th><small>Competencias</small></th>
											<th><small>Colaborador</small></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($colab->asignaciones as $colaborador) : ?>
										<tr>
											<td><small><?php if($colaborador->total){
												echo number_format($colaborador->total,2);$count++;}else echo "--";?></small></td>
											<td><small><?php if($colaborador->total) 
												echo number_format($colaborador->responsabilidad,2);else echo "--";?></small></td>
											<td><small><?php if($colaborador->total) 
												echo number_format($colaborador->competencia,2);else echo "--";;?></small></td>
											<td><small><img height="30px" src="<?= base_url('assets/images/fotos')."/"
												.$colaborador->foto;?>"><?= $colaborador->nombre;?></small></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								<?php endif;
								if(count($colab->asignaciones360) > 0): ?>
									<thead>
										<tr>
											<th><small>Resultado</small></th>
											<th><small>Colaborador 360</small></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($colab->asignaciones360 as $colaborador) : ?>
											<tr>
												<td><small><?php if($colaborador->total){
													echo number_format($colaborador->total,2);$count++;}else echo "--";?></small></td>
												<td colspan="3"><small><img height="30px" src="<?= base_url('assets/images/fotos')."/"
													.$colaborador->foto;?>"><?= $colaborador->nombre;?></small></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								<?php endif;
								if(count($colab->asignacionesProyecto) > 0): ?>
									<thead>
										<tr>
											<th><small>Resultado</small></th>
											<th><small>Colaborador de Proyecto</small></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($colab->asignacionesProyecto as $colaborador) : ?>
											<tr>
												<td><small><?php if($colaborador->total){
													echo number_format($colaborador->total,2);$count++;}else echo "--";?></small></td>
												<td colspan="3"><small><img height="30px" src="<?= base_url('assets/images/fotos')."/"
													.$colaborador->foto;?>"><?= $colaborador->nombre;?></small></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								<?php endif; ?>
							</table></td>
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