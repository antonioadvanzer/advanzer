<div class="jumbotron">
	<div class="container">
		<h2>Revisión Feedback</h2>
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
	<div align="center" id="alert_success" style="display:none">
		<div class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg_success"></label>
		</div>
	</div>
	<div class="row" align="center">
		<div class="col-md-12">
			<a href="<?php if($feedback->colaborador != $this->session->userdata('id')) 
				echo base_url("evaluacion/update_feedback/$feedback->id");
			else
				echo base_url("evaluacion/evaluar");?>">&laquo;Regresar</a>
		</div>
	</div>
	<hr>
	<div class="row" align="center">
		<div class="col-md-12">
			<div id="cargando" style="display:none; color: green;">
				<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
		<input type="hidden" id="id" value="<?= $feedback->id;?>">
		<div class="row" align="center">
			<div class="col-md-12">
				<label>Rating Obtenido:</label><br><span><big><?= $feedback->rating;?></big></span>
			</div>
			<div class="col-md-2">
				<img class="img-circle avatar avatar-original" src="<?= base_url("assets/images/fotos/$feedback->foto");?>" height="120px">
				<label><?= $feedback->nombre;?></label>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label for="fortalezas">Fortalezas/Logros:</label>
					<p style="text-align:center;"><?= $feedback->fortalezas;?></p>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label for="oportunidad">Área(s) de Oportunidad:</label>
					<p style="text-align:center;"><?= $feedback->oportunidad;?></p>
				</div>
			</div>
		</div>
		<?php if($feedback->estatus !=0):?>
			<div class="row" align="center">
				<div class="col-md-12">
					<div class="form-group">
						<label for="compromisos">Compromisos:</label>
						<p style="text-align:center;"><?= $feedback->compromisos;?></p>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="row" align="center">
				<div class="col-md-12">
					<div class="form-group">
						<label for="compromisos">Compromisos:</label>
						<textarea onkeyup="$('#guardar').show('slow');" class="form-control" style="text-align:center;" 
						rows="6" id="compromisos" required <?php if($feedback->estatus !=0)echo"disabled";?>><?= $feedback->compromisos;?></textarea>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="row" align="center">
			<div class="col-md-12">
				<div class="form-group">
					<label for="boton">&nbsp;</label>
					<?php if($feedback->estatus ==0): ?>
						<button id="guardar" type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;
							display:none">Guardar y Enviar</button>
					<?php endif;
					if($feedback->colaborador == $this->session->userdata('id') && $feedback->estatus !=2): ?>
						<button id="enterado" type="button" class="btn btn-lg btn-primary btn-block" 
							style="max-width:200px;text-align:center;">Enterado</button>
					<?php endif;
					if($feedback->estatus == 2): ?>
						<h3><b>Detalle de tu evaluación:</b></h3>
						<table id="tbl" align="center" class="table table-hover table-condensed table-striped">
							<thead>
								<tr>
									<th data-halign="center">Evaluación</th>
									<th data-halign="center">Comentarios</th>
								</tr>
							</thead>
							<tbody data-link="row">
								<?php foreach ($evaluaciones->evaluadores as $evaluador):?>
									<tr>
										<td><small><a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/$evaluador->asignacion");?>">Anual</a></small></td>
										<td><small><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></small></td>
									</tr>
								<?php endforeach;
								if(isset($evaluaciones->evaluadores360) && count($evaluaciones->evaluadores360) > 0)
									foreach ($evaluaciones->evaluadores360 as $evaluador):?>
										<tr>
											<td><small><a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/$evaluador->asignacion");?>">360</a></small></td>
											<td><small><?= $evaluador->comentarios;?></small></td>
										</tr>
									<?php endforeach;
								if(isset($evaluaciones->evaluadoresProyecto) && count($evaluaciones->evaluadoresProyecto) > 0)
									foreach ($evaluaciones->evaluadoresProyecto as $evaluador):?>
										<tr>
											<td><small><a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/$evaluador->asignacion/1");?>">
												Proyecto - <?= $evaluador->evaluacion;?></a></small></td>
											<td><small><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></small></td>
										</tr>
									<?php endforeach; ?>
								<tr>
									<td><small><?php if($evaluaciones->auto):?>
											<a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/".$evaluaciones->auto->asignacion);?>">
											AUTOEVALUACIÓN</a>
										<?php else: ?>AUTOEVALUACIÓN
										<?php endif;?>
									</small></td>
									<td><small><?php if($evaluaciones->auto) echo $evaluaciones->auto->comentarios;?></small></td>
								</tr>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</form>
	<script>
	$(document).ready(function() {
		$('#enterado').click(function(){
			compromisos=$('#compromisos').val();
			estatus=2;
			id=$('#id').val();
			$.ajax({
				url: '<?= base_url("evaluacion/updateEstatusFeedback");?>',
				type: 'POST',
				data: {'id':id,'estatus':estatus,'compromisos':compromisos},
				beforeSend: function() {
					$('#update').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data) {
					console.log(data);
					var returnData = JSON.parse(data);
					$('#cargando').hide('slow');
					$('#update').show('slow');
					if(returnData['msg'] == "ok"){
						$('#guardar').hide('slow');
						alert('Respuesta recibida.');
						window.document.location.reload();
					}else{
						$('#alert').prop('display',true).show();
						$('#msg').html(returnData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr.responseText);
					$('#cargando').hide('slow');
					$('#update').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});
		});
		$('#update').submit(function(event){
			if(!confirm('Al enviar los compromisos no será posible editarlos después.\n ¿Seguro que desea enviar el feedback?'))
				return false;
			compromisos=$('#compromisos').val();
			estatus=1;
			id=$('#id').val();
			$.ajax({
				url: '<?= base_url("evaluacion/updateEstatusFeedback");?>',
				type: 'POST',
				data: {'id':id,'estatus':estatus,'compromisos':compromisos},
				beforeSend: function() {
					$('#update').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data) {
					console.log(data);
					var returnData = JSON.parse(data);
					$('#cargando').hide('slow');
					$('#update').show('slow');
					if(returnData['msg'] == "ok"){
						$('#guardar').hide('slow');
						$('#alert_success').prop('display',true).show();
						alert('Se ha enviado el feedback correctamente.');
						window.document.location = '<?= base_url("evaluacion/evaluar");?>';
					}else{
						$('#alert').prop('display',true).show();
						$('#msg').html(returnData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				},
				error: function(xhr) {
					console.log(xhr.responseText);
					$('#cargando').hide('slow');
					$('#update').show('slow');
					$('#alert').prop('display',true).show('slow');
					$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
					setTimeout(function() {
						$("#alert").fadeOut(1500);
					},3000);
				}
			});
			event.preventDefault();
		});
	});
	</script>