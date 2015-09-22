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
			<h3><b>Evaluadores:</b></h3>
			<div id="filterbar"> </div>
			<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" 
				data-toolbar="#filterbar" data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
				data-striped="true" data-show-toggle="true" data-show-export="true">
				<thead>
					<tr>
						<th class="col-md-1" data-halign="center" data-align="center" data-field="foto" data-defaultsort="disabled"></th>
						<th class="col-md-2" data-halign="center" data-field="evaluador">Evaluador</th>
						<th class="col-md-4" data-halign="center" data-field="evaluadores">Evaluaciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($evaluadores as $colab):?>
						<tr>
							<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
							<td><small><?= $colab->nombre;?></small></td>
							<td data-sortable="false">
								<?php if(count($colab->asignaciones) > 0): ?>
									<div>
										<div class="col-sm-1"><small><b>Total</b></small></div>
										<div class="col-sm-3"><small><b>Responsabilidades</b></small></div>
										<div class="col-sm-2"><small><b>Competencias</b></small></div>
										<div class="col-sm-6"><small><b>Colaborador</b></small></div>
									</div>
									<?php foreach ($colab->asignaciones as $colaborador) : ?>
										<div>
											<div class="col-sm-1"><small><?php if($colaborador->total) 
												echo number_format($colaborador->total,2);else echo "--";?></small></div>
											<div class="col-sm-3"><small><?php if($colaborador->total) 
												echo number_format($colaborador->responsabilidad,2);else echo "--";?></small></div>
											<div class="col-sm-2"><small><?php if($colaborador->total) 
												echo number_format($colaborador->competencia,2);else echo "--";;?></small></div>
											<div class="col-sm-6"><img height="30px" src="<?= base_url('assets/images/fotos')."/"
												.$colaborador->foto;?>"> <small><?= $colaborador->nombre;?></small></div>
										</div>
									<?php endforeach;
								endif;
								if(count($colab->asignaciones360) > 0): ?>
									<div>
										<div class="col-sm-3"><small><b>Resultado</b></small></div>
										<div class="col-sm-7"><small><b>Colaborador 360</b></small></div>
									</div>
									<?php foreach ($colab->asignaciones360 as $colaborador) : ?>
										<div>
											<div class="col-sm-3"><small><?php if($colaborador->total) 
												echo number_format($colaborador->total,2); else echo "--";?></small></div>
											<div class="col-sm-7"><img height="30px" src="<?= base_url('assets/images/fotos')."/"
												.$colaborador->foto;?>"> <small><?= $colaborador->nombre;?></small></div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</td>
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