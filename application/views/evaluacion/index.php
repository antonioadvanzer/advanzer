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
			<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
				data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
				data-striped="true" data-show-toggle="true" data-show-export="true">
				<thead>
					<tr>
						<th class="col-md-1" data-halign="center" data-align="center" data-field="foto" data-defaultsort="disabled"></th>
						<th class="col-md-2" data-halign="center" data-field="nombre">Nombre</th>
						<th data-halign="center" data-field="autoevaluacion">Auto</th>
						<th data-defaultsort="asc" data-halign="center" data-field="rating">Rating</th>
						<th data-halign="center" data-field="total">Total</th>
						<th class="col-md-5" data-halign="center" data-field="evaluadores">Evaluaciones</th>
						<th class="col-md-1" data-halign="center" data-field="feedback">Feedback</th>
					</tr>
				</thead>
				<tbody data-link="row">
					<?php foreach ($colaboradores as $colab):?>
						<tr>
							<td><small><a href="<?= base_url("evaluacion/revisar/$colab->id/$flag");?>">
								<img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></a></small></td>
							<td><small><?= "$colab->nombre ($colab->posicion - $colab->track)";?></small></td>
							<td><small><?= number_format($colab->autoevaluacion,2);?></small></td>
							<td><small><?= $colab->rating;?></small></td>
							<td><small><?= number_format($colab->total,2);?></small></td>
							<td data-sortable="false" class="rowlink-skip"><hr><?php if(count($colab->evaluadores) > 0): ?>
								<div class="row" align="center">
									<div class="col-sm-2"><small><b>Resultado</b></small></div>
									<div class="col-sm-3"><small><b>Responsabilidades</b></small></div>
									<div class="col-sm-2"><small><b>Competencias</b></small></div>
									<?php if($flag == true): ?><div class="col-sm-5"><small><b>Evaluador</b></small></div><?php endif;?>
								</div>
								<?php foreach ($colab->evaluadores as $evaluador) : ?>
									<div class="row" align="center">
										<div class="col-sm-2"><small><?= number_format($evaluador->total,2);?></small></div>
										<div class="col-sm-3"><small><?= number_format($evaluador->responsabilidad,2);?></small></div>
										<div class="col-sm-2"><small><?= number_format($evaluador->competencia,2);?></small></div>
										<?php if($flag == true): ?><div class="col-sm-5" title="Comentarios: <?= $evaluador->comentarios;?>">
											<img style="float:left" height="30px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"> 
											<small><?= $evaluador->nombre;?></small></div><?php endif; ?>
									</div>
								<?php endforeach; ?>
								<hr>
							<?php endif;
							if(isset($colab->evaluadores360) && count($colab->evaluadores360) > 0): ?>
								<div class="row" align="center">
									<div class="col-sm-3"><small><b>Resultado</b></small></div>
									<?php if($flag == true): ?><div class="col-sm-9"><small><b>Evaluador 360</b></small></div><?php endif;?>
								</div>
								<?php foreach ($colab->evaluadores360 as $evaluador) : ?>
									<div class="row" align="center">
										<div class="col-sm-3"><small><?= number_format($evaluador->competencia,2);?></small></div>
										<?php if($flag == true): ?><div class="col-sm-9" title="Comentarios: <?= $evaluador->comentarios;?>">
											<small><img style="float:left" height="30px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"> 
											<?= $evaluador->nombre;?></small></div><?php endif; ?>
									</div>
								<?php endforeach; ?>
								<hr>
							<?php endif;
							if(isset($colab->evaluadoresProyecto) && count($colab->evaluadoresProyecto) > 0): ?>
								<div class="row" align="center">
									<div class="col-sm-2"><small><b>Resultado</b></small></div>
									<div class="col-sm-4"><small><b>Proyecto</b></small></div>
									<?php if($flag == true): ?><div class="col-sm-6"><small><b>Evaluador</b></small></div><?php endif;?>
								</div>
								<?php foreach ($colab->evaluadoresProyecto as $evaluador) : ?>
									<div class="row" align="center">
										<div class="col-sm-2"><small><?= number_format($evaluador->responsabilidad,2);?></small></div>
										<div class="col-sm-4"><small><?= $evaluador->evaluacion;?></small></div>
										<?php if($flag == true): ?><div class="col-sm-6" title="Comentarios: <?= $evaluador->comentarios;?>">
											<img style="float:left" height="30px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"> 
											<small><?= $evaluador->nombre;?></small></div><?php endif;?>
									</div>
								<?php endforeach; ?>
								<hr>
							<?php endif; ?></td>
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
	<script type="text/javascript">
		$.bootstrapSortable(true);
		$(function() {
			$('#tbl').bootstrapTable();
			$('#filterbar').bootstrapTableFilter();
		});
	</script>