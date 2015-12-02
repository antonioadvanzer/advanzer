<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Revisión de Evaluación de <?= $colaborador->nombre;?></h2>
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
	<div align="center"><a href="<?= base_url("evaluacion");?>">&laquo;Regresar</a></div>
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<hr>
	<form id="save" class="form-signin" role="form" method="post" action="javascript:">
		<div class="row" align="center">
			<div class="col-md-4"><img class="img-circle avatar avatar-original" style="max-height:200px;max-width:100%" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>"></div>
			<div class="col-md-4">
				<h4>Compromisos Internos</h4>
				<div class="form-group" align="center">
					<label title="El(la) colaborador(a) presenta sus Gastos de Viaje, bajo los procedimientos establecidos, a más tardar 7 días hábiles a partir de su fecha de regreso en al menos el 90% de sus viajes.">
						Comprobación de Gastos de Viaje?</label>
					<div><?php if(isset($colaborador->cumple_gastos) && $colaborador->cumple_gastos == "SI"): ?>
						<label><span class="glyphicon glyphicon glyphicon-ok"></span></label>
					<?php else: ?>
						<label><span class="glyphicon glyphicon glyphicon-remove"></span></label>
					<?php endif; ?></div>
					<label title="El(la) colaborador(a) captura sus horas asignadas a cada proyecto los días lunes con un máximo de tres semanas de desfase acumulado al año.">
						Captura de Asignaciones en Harvest?</label>
					<div><?php if(isset($colaborador->cumple_harvest) && $colaborador->cumple_harvest == "SI"): ?>
						<label><span class="glyphicon glyphicon glyphicon-ok"></span></label>
					<?php else: ?>
						<label><span class="glyphicon glyphicon glyphicon-remove"></span></label>
					<?php endif; ?></div>
					<label title="El(la) colaborador(a) actualiza su CV Advanzer correctamente, cada Junio y Diciembre, en la Carpeta de Documentación Personal on line.">
						Actualización de CV Advanzer?</label>
					<div><?php if(isset($colaborador->cumple_cv) && $colaborador->cumple_cv == "SI"): ?>
						<label><span class="glyphicon glyphicon glyphicon-ok"></span></label>
					<?php else: ?>
						<label><span class="glyphicon glyphicon glyphicon-remove"></span></label>
					<?php endif; ?></div>
				</div>
			</div>
			<div class="col-md-4">
				<h4>Resultados Globales</h4>
				<div class="form-group" align="center">
					<p align="center"><label>Resultado:&nbsp;&nbsp;</label><big><?= number_format(floor($colaborador->total*100)/100,2);?></big></p>
					<label for="nombre">Rating:</label>
					<select id="rating" class="form-control" style="max-width:80px">
						<option value="" selected disabled>-- Selecciona un valor --</option>
						<option value="A" <?php if($colaborador->rating == "A") echo "selected";?>>A</option>
						<option value="B" <?php if($colaborador->rating == "B") echo "selected";?>>B</option>
						<option value="C" <?php if($colaborador->rating == "C") echo "selected";?>>C</option>
						<option value="D" <?php if($colaborador->rating == "D") echo "selected";?>>D</option>
						<option value="E" <?php if($colaborador->rating == "E") echo "selected";?>>E</option>
					</select>
					<label for="nombre">Encargado de FeedBack:</label>
					<select id="feedback" class="form-control" style="max-width:300px" required>
						<option selected disabled value="">-- Asigna al FeedBack --</option>
						<?php if(isset($colaborador->feedback)): ?>
							<option value="<?= $colaborador->feedback->feedbacker;?>" selected><?= $colaborador->feedback->nombre;?></option>
						<?php endif;
						foreach ($colaborador->evaluadores as $evaluador) :
							if(isset($colaborador->feedback->feedbacker)):
								if($colaborador->feedback->feedbacker != $evaluador->id): ?>
									<option value="<?= $evaluador->id;?>" <?php if($colaborador->feedback && $evaluador->id == $colaborador->feedback->feedbacker) echo "selected";?>>
										<?= $evaluador->nombre;?></option>
								<?php endif; 
							else: ?> 
								<option value="<?= $evaluador->id;?>"><?= $evaluador->nombre;?></option>
							<?php endif;
						endforeach; ?>
						<?php foreach ($colaborador->evaluadores360 as $evaluador) :
							if(isset($colaborador->feedback->feedbacker)):
								if($colaborador->feedback->feedbacker != $evaluador->id): ?>
									<option value="<?= $evaluador->id;?>" <?php if($colaborador->feedback && $evaluador->id == $colaborador->feedback->feedbacker) echo "selected";?>>
									<?= $evaluador->nombre;?></option>
								<?php endif;
							else: ?>
								<option value="<?= $evaluador->id;?>"><?= $evaluador->nombre;?></option>
							<?php endif;
						endforeach; ?>
						<?php foreach ($colaborador->evaluadoresProyecto as $evaluador) :
							if(isset($colaborador->feedback->feedbacker)):
								if($colaborador->feedback->feedbacker != $evaluador->id): ?>
									<option value="<?= $evaluador->id;?>" <?php if($colaborador->feedback && $evaluador->id == $colaborador->feedback->feedbacker) echo "selected";?>>
									<?= $evaluador->nombre;?></option>
								<?php endif;
							else: ?>
								<option value="<?= $evaluador->id;?>"><?= $evaluador->nombre;?></option>
							<?php endif;
						endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group" align="center">
					<label>Comentarios Generales</label>
					<textarea id="comentarios" class="form-control" rows="4" style="max-width:600px;" required
						><?php if($colaborador->comentarios) echo $colaborador->comentarios;?></textarea>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group" align="center">
					<label>&nbsp;</label>
					<label>&nbsp;</label>
					<button id="submit" class="btn btn-lg btn-primary btn-block" style="max-width:250px" type="submit">Guardar Resultado</button>
				</div>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="col-md-12">
			<h3><b>Evaluación:</b></h3>
			<table id="tbl" align="center" class="table display">
				<thead>
					<tr>
						<th data-halign="center"></th>
						<th data-halign="center">Evaluador</th>
						<th data-halign="center">Responsabilidades</th>
						<th data-halign="center">Competencias</th>
						<th data-halign="center">Evaluación</th>
						<th data-halign="center">Comentarios</th>
					</tr>
				</thead>
				<tbody data-link="row">
					<?php if(count($colaborador->evaluadores) > 0): ?>
						<?php foreach ($colaborador->evaluadores as $evaluador):?>
							<tr>
								<td align="center"><a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/$evaluador->asignacion");?>">
									<img height="40px" class="img-circle avatar avatar-original" 
										src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></a></td>
								<td><?= $evaluador->nombre;?></td>
								<td align="center"><?php if($evaluador->responsabilidad) echo number_format(floor($evaluador->responsabilidad*100)/100,2);?></td>
								<td align="center"><?php if($evaluador->competencia) echo number_format(floor($evaluador->competencia*100)/100,2);?></td>
								<td>Anual</td>
								<td><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></td>
							</tr>
						<?php endforeach;
					endif;
					if(isset($colaborador->evaluadores360) && count($colaborador->evaluadores360) > 0): ?>
						<?php foreach ($colaborador->evaluadores360 as $evaluador):?>
							<tr>
								<td align="center"><a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/$evaluador->asignacion");?>">
									<img height="40px" class="img-circle avatar avatar-original" 
										src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></a></td>
								<td><?= $evaluador->nombre;?></td>
								<td>&nbsp;</td>
								<td align="center"><?php if($evaluador->competencia) echo number_format(floor($evaluador->competencia*100)/100,2);?></td>
								<td>360</td>
								<td><?= $evaluador->comentarios;?></td>
							</tr>
						<?php endforeach;
					endif;
					if(isset($colaborador->evaluadoresProyecto) && count($colaborador->evaluadoresProyecto) > 0): ?>
						<?php foreach ($colaborador->evaluadoresProyecto as $evaluador):?>
							<tr>
								<td align="center"><a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/$evaluador->asignacion/1");?>">
									<img height="40px" class="img-circle avatar avatar-original" 
										src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></a></td>
								<td><?= $evaluador->nombre;?></td>
								<td align="center"><?php if($evaluador->responsabilidad) echo number_format(floor($evaluador->responsabilidad*100)/100,2);?></td>
								<td>&nbsp;</td>
								<td>Proyecto - <?= $evaluador->evaluacion;?></td>
								<td><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></td>
							</tr>
						<?php endforeach;
					endif;?>
					<tr>
						<td align="center"><?php if($colaborador->autoevaluacion): ?>
							<a target="_blank" href="<?= base_url("evaluacion/detalle_asignacion/".$colaborador->auto->asignacion);?>">
								<img height="40px" class="img-circle avatar avatar-original" 
									src="<?= base_url('assets/images/fotos')."/".$colaborador->foto;?>"></a>
							<?php else: ?>
								<img height="40px" class="img-circle avatar avatar-original" 
									src="<?= base_url('assets/images/fotos')."/".$colaborador->foto;?>">
							<?php endif; ?>
						</td>
						<td><?= $colaborador->nombre;?></td>
						<td>&nbsp;</td>
						<td align="center"><?php if($colaborador->auto) echo number_format(floor($colaborador->autoevaluacion*100)/100,2);?></td>
						<td>AUTOEVALUACIÓN</td>
						<td><?php if($colaborador->auto) echo $colaborador->auto->comentarios;?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<script>
	function verificaRating() {
		gastos = "<?= $colaborador->cumple_gastos;?>";
		harvest = "<?= $colaborador->cumple_harvest;?>";
		cv = "<?= $colaborador->cumple_cv;?>";
		if(gastos=="NO" || harvest=="NO" || cv=="NO"){
			$('#rating option[value="A"]').remove();
			$('#rating option[value="B"]').remove();
			$('#rating option[value="C"]').remove();
			$('#rating option[value=""]').attr("selected","selected");
		}
	}
	$(document).ready(function() {
		estatus=<?= $colaborador->feedback->estatus;?>;
		if(estatus != 0){
			$('#rating').prop('disabled',true);
			$('#feedback').prop('disabled',true);
			$('#comentarios').prop('disabled',true);
			$('#submit').css('display','none');
		}
		/*verificaRating();

		$('#gastos').change(function() {
			verificaRating();
		});
		$('#harvest').change(function() {
			verificaRating();
		});
		$('#cv').change(function() {
			verificaRating();
		});*/
		$('#save').submit(function(event) {
			$('#rating :selected').each(function(i,select) {
				rating = $(select).val();
			});
			$('#feedback :selected').each(function(i,select) {
				feedback = $(select).val();
			});
			colaborador = '<?= $colaborador->id;?>';
			comentarios = $('#comentarios').val();
			console.log(colaborador,feedback,rating);
			$.ajax({
				url: '<?= base_url("evaluacion/asigna_rating");?>',
				type: 'POST',
				data: {'colaborador':colaborador,'rating':rating,'feedback':feedback,'comentarios':comentarios},
				beforeSend: function() {
					$('#save').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data) {
					console.log(data);
					var returnData = JSON.parse(data);
					if(returnData['msg'] == "ok")
						window.document.location = '<?= base_url("evaluacion");?>';
					else{
						$('#cargando').hide('slow');
						$('#save').show('slow');
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
					$('#save').show('slow');
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