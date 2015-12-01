<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<div class="col-md-6">
			<?php $empresa=$this->session->userdata('empresa'); if(!empty($empresa)): ?>
				<img style="max-height:70px" class="logo" 
					src="<?= base_url('assets/images/'.$this->session->userdata("empresa").'.png'); ?>">
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="container">
	<div class="row" align="center"><div class="col-md-12"><a href="<?= base_url();?>">&laquo;Regresar</a></div></div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row"><div class="col-md-12 lead">Historial de Desempeño<hr></div></div>
					<div class="row">
						<div class="col-md-4 text-center">
							<img height="150px" class="img-circle avatar avatar-original" style="-webkit-user-select:none; 
								display:block; margin:auto;" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>">
						</div>
						<div class="col-md-8">
							<div class="row"><div class="col-md-12"><h2 class="only-bottom-margin"><?= $colaborador->nombre;?></h2></div></div>
							<hr>
							<div class="row">
								<?php if(!empty($info)): ?>
									<div class="col-md-6">
										<select class="form-control" style="max-width:160px;" id="anio">
											<option selected disabled>- Selecciona año -</option>
											<?php foreach($info as $evaluacion): ?>
												<option><?= $evaluacion->anio;?></option>
											<?php endforeach; ?>
										</select>
									</div>
								<?php else: ?>
									<div class="col-md-12">
										<label>No has generado historial en la empresa</label>
									</div>
								<?php endif; ?>
								<div align="center"><div id="cargando" style="display:none; color: green;">
									<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
								<div class="col-md-6" style="display:none" id="result"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$("#anio").change(function() {
				$("#anio option:selected").each(function() {
					anio = $('#anio').val();
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('main/load_historial');?>",
					data: {anio : anio},
					beforeSend: function (xhr) {
						$('#result').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$('#cargando').hide();
						$("#result").show().html(data);
					}
				});
			});
		});
	</script>