<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Detalle Feedback</h2>
		<p><li>Define cada punto del feedback y presiona "Guardar" (En la sección inferior están los comentarios de los colaboradores que 
			evaluaron a <i><?= $feedback->nombre;?></i>).</li>
			<li>Luego presiona "Enviar" para que el colaborador tenga acceso al mismo (una vez enviado no será posible editarlo).</li></p>
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
			<a href="<?= base_url('evaluacion/evaluar');?>">&laquo;Regresar</a>
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
			<div class="col-md-3">
				<img src="<?= base_url("assets/images/fotos/$feedback->foto");?>" height="120px">
				<label><?= $feedback->nombre;?></label>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="fortalezas">Fortalezas/Logros:</label>
					<textarea onkeyup="$('#guardar').show('slow');$('#enviar').hide('slow');" class="form-control" style="max-width:300px;text-align:center;" rows="4" 
						id="fortalezas" required <?php if($feedback->estatus !=0)echo"disabled";?>><?= $feedback->fortalezas;?></textarea>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="oportunidad">Área(s) de Oportunidad:</label>
					<textarea onkeyup="$('#guardar').show('slow');$('#enviar').hide('slow');" class="form-control" style="max-width:300px;text-align:center;" rows="4" 
						id="oportunidad" required <?php if($feedback->estatus !=0)echo"disabled";?>><?= $feedback->oportunidad;?></textarea>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="compromisos">Compromisos:</label>
					<textarea onkeyup="$('#guardar').show('slow');$('#enviar').hide('slow');" class="form-control" style="max-width:300px;text-align:center;" rows="4" 
						id="compromisos" required <?php if($feedback->estatus !=0)echo"disabled";?>><?= $feedback->compromisos;?></textarea>
				</div>
			</div>
		</div>
		<div class="row" align="center">
			<div class="col-md-12">
				<div class="form-group">
					<label for="boton">&nbsp;</label>
					<?php if($feedback->estatus ==0): ?>
						<button id="guardar" type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;
							display:none">
							Guardar</button>
						<button id="enviar" type="button" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;
							<?php if($feedback->fortalezas == "" || $feedback->oportunidad == "" || $feedback->compromisos == "")
							echo 'display:none' ?>">Enviar</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($evaluaciones->evaluadores) && count($evaluaciones->evaluadores) > 0): ?>
				<h3><b>Evaluaciones:</b></h3>
				<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" 
					 data-show-columns="true" data-hover="true" data-striped="true" data-show-toggle="true">
					<thead>
						<tr>
							<th data-halign="center" data-field="foto"></th>
							<th class="col-md-4" data-halign="center" data-field="evaluador">Evaluador</th>
							<th class "col-md-6" data-halign="center" data-field="comentarios">Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($evaluaciones->evaluadores as $evaluador):?>
							<tr>
								<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></td>
								<td><?= $evaluador->nombre;?></td>
								<td><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></td>
							</tr>
						<?php endforeach;
						if(isset($evaluaciones->evaluadores360) && count($evaluaciones->evaluadores360) > 0)
							foreach ($evaluaciones->evaluadores360 as $evaluador):?>
								<tr>
									<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></td>
									<td><?= $evaluador->nombre;?></td>
									<td><?= $evaluador->comentarios;?></td>
								</tr>
							<?php endforeach;
						if(isset($evaluaciones->evaluadoresProyecto) && count($evaluaciones->evaluadoresProyecto) > 0)
							foreach ($evaluaciones->evaluadoresProyecto as $evaluador):?>
								<tr>
									<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></td>
									<td><?= $evaluador->nombre;?></td>
									<td><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></td>
								</tr>
							<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>
	<script>
	$(document).ready(function() {
		$('#update').submit(function(event){
			fortalezas=$('#fortalezas').val();
			oportunidad=$('#oportunidad').val();
			compromisos=$('#compromisos').val();
			id=$('#id').val();
			$.ajax({
				url: '<?= base_url("evaluacion/updateFeedback");?>',
				type: 'POST',
				data: {'id':id,'compromisos':compromisos,'fortalezas':fortalezas,'oportunidad':oportunidad},
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
						$('#enviar').show('slow');
						$('#alert_success').prop('display',true).show();
						$('#msg_success').html('Se ha guardado el feedback. Presiona "Enviar" para hacerlo llegar al Colaborador');
						setTimeout(function() {
							$("#alert_success").fadeOut(1500);
						},3000);
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

		$('#enviar').click(function() {
			id = $('#id').val();
			estatus = 1;
			$.ajax({
				url: '<?= base_url("evaluacion/updateEstatusFeedback");?>',
				type: 'POST',
				data: {'id':id,'estatus':estatus},
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
					console.log(xhr);
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
	});
	</script>