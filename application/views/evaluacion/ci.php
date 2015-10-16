<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Revisión de Compromisos Internos</h2>
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
	<div class="row" align="center">
		<div class="col-md-12">
			<a href="<?= base_url();?>">&laquo;Regresar</a>
		</div>
	</div>
	<hr>
	<?php if(isset($evaluacion)):
		if($evaluacion->estatus < 2):
			if(count($info_archivos) == 0):?>
				<div class="row">
					<div class="col-md-12">
						<h3><b>Colaboradores:</b></h3>
						<div id="filterbar"> </div>
						<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" 
							data-toolbar="#filterbar" data-pagination="true" data-hover="true" data-striped="true" data-show-toggle="true">
							<thead>
								<tr>
									<th class="col-md-1" data-halign="center" data-align="center" data-field="foto" data-defaultsort="disabled"></th>
									<th class="col-md-5" data-halign="center" data-field="nombre">Nombre</th>
									<?php if($this->session->userdata('tipo') == 1): ?>
										<th class="col-md-1" data-halign="center" data-field="gastos">Cumple Gastos?</th>
									<?php elseif($this->session->userdata('tipo') == 2): ?>
										<th class="col-md-1" data-halign="center" data-field="harvest">Cumple Harvest?</th>
									<?php elseif($this->session->userdata('tipo') >= 4): ?>
										<th class="col-md-1" data-halign="center" data-field="cv">Cumple CV?</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($colaboradores as $colab):?>
									<tr>
										<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
										<td><small><?= "$colab->nombre ($colab->posicion - $colab->track)";?></small></td>
										<?php if($this->session->userdata('tipo') == 1): ?>
											<td style="vertical-align:middle;text-align:center;"><input type="checkbox" 
												<?php if(isset($colab->cumple_gastos) && $colab->cumple_gastos=="SI")echo "checked";?> 
												onclick="change(this.checked,<?= $colab->id;?>,'cumple_gastos');"></td>
										<?php elseif($this->session->userdata('tipo') == 2): ?>
											<td style="vertical-align:middle;text-align:center;"><input type="checkbox" 
												<?php if(isset($colab->cumple_harvest) && $colab->cumple_harvest=="SI")echo "checked";?> 
												onclick="change(this.checked,<?= $colab->id;?>,'cumple_harvest');"></td>
										<?php elseif($this->session->userdata('tipo') >= 4): ?>
											<td style="vertical-align:middle;text-align:center;"><input type="checkbox" 
												<?php if(isset($colab->cumple_cv) && $colab->cumple_cv=="SI")echo "checked";?> 
												onclick="change(this.checked,<?= $colab->id;?>,'cumple_cv');"></td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row" align="center">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<form role="form" method="post" enctype="multipart/form-data" action="<?= base_url('evaluacion/captura');?>" class="form-signin">
							<input type="hidden" name="tipo" value="<?= $this->session->userdata('tipo');?>">
							<h4><b>Incluye un archivo de respaldo de los datos capturados</b></h4>
							<p>Se recomienda adjuntar el archivo en formato <i>PDF</i> para mayor seguridad<br>Una vez adjuntado el archivo no será posible editar los datos capturados</p>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Elige el archivo</span>
									<input class="form-control" type="file" name="archivo" size="40" style="height:120%;max-width:400px;text-align:center;" 
									required onchange="$('#boton').show('slow');">
								</div>
							</div>
							<div class="form-group">
								<button id="boton" class="btn btn-primary" type="submit" style="display:none">
									<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>Subir Archivo</button>
							</div>
						</form>
					</div>
				</div>
			<?php else: ?>
				<div class="row" align="center">
					<div class="col-md-12">
						<h3><b>Ya has entregado el archivo de respaldo, no es posible editar los datos capturados</b></h3>
						<label>Gracias por haber capturado los datos a tiempo</label>
					</div>
				</div>
			<?php endif;
		else: ?>
			<div class="row" align="center">
				<div class="col-md-12">
					<h3><b>Ya ha finalizado el proceso de Evaluación</b></h3>
					<label>Gracias por haber capturado los datos a tiempo</label>
				</div>
			</div>
		<?php endif;
	else: ?>
		<div class="row" align="center">
			<div class="col-md-12">
				<h3><b>Aún no comienza el proceso de evaluación</b></h3>
				<label>Regresa más tarde</label>
			</div>
		</div>
	<?php endif; ?>
	<script type="text/javascript">
		$.bootstrapSortable(true);
		$(function() {
			$('#tbl').bootstrapTable();
			$('#filterbar').bootstrapTableFilter();
		});
		function change(valor,colaborador,tipo) {
			console.log(valor,colaborador,tipo);
			$.ajax({
				type: 'post',
				url: '<?= base_url("evaluacion/asigna_ci");?>',
				data: {'valor':valor,'colaborador':colaborador,'tipo':tipo},
				success: function(data) {
					var returnData = JSON.parse(data);
					console.log(returnData);
				},
				error: function(data) {
					console.log(data['responseText']);
				}
			});
		}
	</script>