<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Resultados Evaluaciones</h2>
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
			<h3><b>Colaboradores:</b></h3>
			<div id="filterbar"> </div>
			<table id="tbl" align="center" class="display">
				<thead>
					<tr>
						<th data-halign="center" data-align="center"></th>
						<th data-halign="center">Nombre</th>
						<th data-halign="center">Auto</th>
						<th data-defaultsort="asc" data-halign="center">Rating</th>
						<th data-halign="center">Total</th>
						<th data-halign="center">Evaluaciones</th>
						<th data-halign="center">Feedback</th>
					</tr>
				</thead>
				<tbody data-link="row">
					<?php foreach ($colaboradores as $colab):?>
						<tr>
							<td align="center"><small><a href="<?= base_url("evaluacion/revisar/$colab->id");?>">
								<img height="40px" class="img-circle avatar avatar-original" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></a></small></td>
							<td><small><?= "$colab->nombre ($colab->posicion - $colab->track)";?></small></td>
							<td><small><?= number_format($colab->autoevaluacion,2);?></small></td>
							<td><small><?= $colab->rating;?></small></td>
							<td><small><?= number_format(floor($colab->total * 100) / 100,2);?></small></td>
							<td data-sortable="false" class="rowlink-skip"><table id="tbl2" align="center" class="display">
								<?php if(count($colab->evaluadores) > 0): ?>
										<thead>
											<tr>
												<th><small>Resultado</small></th>
												<th><small>Responsabilidades</small></th>
												<th><small>Competencias</small></th>
												<th><small>Evaluador</small></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($colab->evaluadores as $evaluador) : ?>
												<tr>
													<td><small><?= number_format($evaluador->total,2);?></small></td>
													<td><small><?= number_format($evaluador->responsabilidad,2);?></small></td>
													<td><small><?= number_format($evaluador->competencia,2);?></small></td>
													<td><small><img style="float:left" height="30px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"> 
													<small><?= $evaluador->nombre;?></small></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
								<?php endif;
								if(isset($colab->evaluadores360) && count($colab->evaluadores360) > 0): ?>
									<thead>
										<tr>
											<th><small>Resultado</small></th>
											<th colspan="3"><small>Evaluador 360</small></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($colab->evaluadores360 as $evaluador) : ?>
											<tr>
												<td><small><?= number_format($evaluador->competencia,2);?></small></td>
												<td colspan="3"><small><img style="float:left" height="30px" 
													src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"> 
													<?= $evaluador->nombre;?></small></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								<?php endif;
								if(isset($colab->evaluadoresProyecto) && count($colab->evaluadoresProyecto) > 0): ?>
									<thead>
										<tr>
											<th><small>Resultado</small></th>
											<th><small>Proyecto</small></th>
											<th colspan="2"><small>Evaluador</small></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($colab->evaluadoresProyecto as $evaluador) : ?>
											<tr>
												<td><small><?= number_format($evaluador->responsabilidad,2);?></small></td>
												<td><small><img style="float:left" height="30px" 
													src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"> 
													<?= $evaluador->nombre;?></small></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								<?php endif; ?>
							</table></td>
							<td><small><?php if($colab->feedback){ echo$colab->feedback->nombre." <i>("; 
								if(isset($colab->feedback->estatus))
									if($colab->feedback->estatus == 0) echo"Pendiente"; 
									elseif($colab->feedback->estatus == 1) echo"Enviado"; else echo"Enterado"; echo")</i>";}?></small></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true});
			$('id^=tbl2').DataTable({responsive: true});
		} );
	</script>