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
	<div align="center"><a href="<?= base_url('evaluacion');?>">&laquo;Regresar</a></div>
	<hr>
	<form id="save" class="form-signin" role="form" method="post" action="javascript:">
		<div class="row" align="center">
			<div class="col-md-4"><h4>&nbsp;</h4><img style="max-height:220px;max-width:100%" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>"></div>
			<div class="col-md-4">
				<h4>Compromisos Internos</h4>
				<div class="form-group" align="center">
					<label title="El(la) colaborador(a) presenta sus Gastos de Viaje, bajo los procedimientos establecidos, a más tardar 7 días hábiles a partir de su fecha de regreso en al menos el 90% de sus viajes.">
						Comprobación de Gastos de Viaje?</label>
					<input id="gastos" type="text" class="form-control" style="max-width:50px;background-color: #fff;" disabled 
						value="<?= $colaborador->cumple_gastos;?>">
					<label title="El(la) colaborador(a) captura sus horas asignadas a cada proyecto los días lunes con un máximo de tres semanas de desfase acumulado al año.">
						Captura de Asignaciones en Harvest?</label>
					<input id="harvest" type="text" class="form-control" style="max-width:50px;background-color: #fff;" disabled 
						value="<?= $colaborador->cumple_harvest;?>">
					<label title="El(la) colaborador(a) actualiza su CV Advanzer correctamente, cada Junio y Diciembre, en la Carpeta de Documentación Personal on line.">
						Actualización de CV Advanzer?</label>
					<input id="cv" type="text" class="form-control" style="max-width:50px;background-color: #fff;" disabled 
						value="<?= $colaborador->cumple_cv;?>">
				</div>
			</div>
			<div class="col-md-4">
				<h4>Resultados Globales</h4>
				<div class="form-group" align="center">
					<label>Resultado:</label>
					<input type="text" class="form-control" style="max-width:80px;background-color: #fff;" 
						disabled value="<?= number_format($colaborador->total,2);?>">
					<label for="nombre">Rating:</label>
					<select id="rating" class="form-control" style="max-width:80px">
						<option value="" selected disabled>-- Selecciona un valor --</option>
						<option value="A" <?php if($colaborador->rating == "A") echo "selected";?>>A</option>
						<option value="B" <?php if($colaborador->rating == "B") echo "selected";?>>B</option>
						<option value="C" <?php if($colaborador->rating == "C") echo "selected";?>>C</option>
						<option value="D" <?php if($colaborador->rating == "D") echo "selected";?>>D</option>
						<option value="E" <?php if($colaborador->rating == "E") echo "selected";?>>E</option>
					</select>
					<label for="nombre">FeedBack:</label>
					<select id="feedback" class="form-control" style="max-width:300px" required>
						<option selected disabled value="">-- Asigna al FeedBack --</option>
						<?php foreach ($colaborador->evaluadores as $evaluador) : ?>
							<option value="<?= $evaluador->id;?>" <?php if($colaborador->feedback && $evaluador->id == $colaborador->feedback->feedbacker) echo "selected";?>>
								<?= $evaluador->nombre;?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-md-12" style="height:100%;vertical-align:middle">
				<div class="form-group" align="center">
					<label>&nbsp;</label>
					<label>&nbsp;</label>
					<button class="btn btn-lg btn-primary btn-block" style="max-width:250px" type="submit">Guardar Datos</button>
				</div>
			</div>
		</div>
	</form>
	<div class="row">
		<div class="col-md-12">
			<h3><b>Evaluadores:</b></h3>
			<?php if(count($colaborador->evaluadores) > 0): ?>
				<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
					data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
					data-striped="true" data-show-toggle="true" data-show-export="true">
					<thead>
						<tr>
							<th data-halign="center" data-field="foto"></th>
							<th class="col-md-4" data-halign="center" data-field="evaluador">Evaluador</th>
							<th class "col-md-1" data-halign="center" data-field="responsabilidades">Responsabilidades</th>
							<th class "col-md-1" data-halign="center" data-field="competencias">Competencias</th>
							<th class "col-md-2" data-halign="center" data-field="resultado">Resultado</th>
							<th class "col-md-2" data-halign="center" data-field="comentarios">Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($colaborador->evaluadores as $evaluador):?>
							<tr>
								<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></td>
								<td><?= $evaluador->nombre;?></td>
								<td><?php if($evaluador->responsabilidad) echo number_format($evaluador->responsabilidad,2);?></td>
								<td><?php if($evaluador->competencia) echo number_format($evaluador->competencia,2);?></td>
								<td><?php if($evaluador->competencia) echo number_format(($evaluador->competencia*0.3+
									$evaluador->responsabilidad*0.7),2);?></td>
								<td><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif;
			if(isset($colaborador->evaluadores360) && count($colaborador->evaluadores360) > 0): ?>
				<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
					data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
					data-striped="true" data-show-toggle="true" data-show-export="true">
					<thead>
						<tr>
							<th data-halign="center" data-field="foto"></th>
							<th class="col-md-4" data-halign="center" data-field="evaluador">Evaluador 360</th>
							<th class "col-md-2" data-halign="center" data-field="responsabilidades">Resultado</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($colaborador->evaluadores360 as $evaluador):?>
							<tr>
								<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></td>
								<td><?= $evaluador->nombre;?></td>
								<td><?php if($evaluador->competencia) echo number_format($evaluador->competencia,2);?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif;
			if(isset($colaborador->evaluadoresProyecto) && count($colaborador->evaluadoresProyecto) > 0): ?>
				<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
					data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
					data-striped="true" data-show-toggle="true" data-show-export="true">
					<thead>
						<tr>
							<th data-halign="center" data-field="foto"></th>
							<th class="col-md-4" data-halign="center" data-field="evaluador">Líder de Proyecto</th>
							<th class "col-md-3" data-halign="center" data-field="responsabilidades">Proyecto</th>
							<th class "col-md-1" data-halign="center" data-field="competencias">Resultado</th>
							<th class "col-md-2" data-halign="center" data-field="comentarios">Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($colaborador->evaluadoresProyecto as $evaluador):?>
							<tr>
								<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></td>
								<td><?= $evaluador->nombre;?></td>
								<td><?php if($evaluador->evaluacion) echo $evaluador->evaluacion;?></td>
								<td><?php if($evaluador->responsabilidad) echo number_format($evaluador->responsabilidad,2);?></td>
								<td><?php if($evaluador->comentarios) echo $evaluador->comentarios;?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif;?>
		</div>
	</div>
	<script>
	function verificaRating() {
		gastos = $('#gastos').val();
		harvest = $('#harvest').val();
		cv = $('#cv').val();
		if(gastos=="NO" || harvest=="NO" || cv=="NO"){
			$('#rating option[value="A"]').attr("disabled","disabled");
			$('#rating option[value="B"]').attr("disabled","disabled");
			$('#rating option[value="C"]').attr("disabled","disabled");
			$('#rating option[value=""]').attr("selected","selected");
		}
	}
	$(document).ready(function() {
		verificaRating();

		$('#gastos').change(function() {
			verificaRating();
		});
		$('#harvest').change(function() {
			verificaRating();
		});
		$('#cv').change(function() {
			verificaRating();
		});
		$('#save').submit(function(event) {
			$('#rating :selected').each(function(i,select) {
				rating = $(select).val();
			});
			$('#feedback :selected').each(function(i,select) {
				feedback = $(select).val();
			});
			colaborador = '<?= $colaborador->id;?>';
			console.log(colaborador,feedback,rating);
			$.ajax({
				url: '<?= base_url("evaluacion/asigna_rating");?>',
				type: 'POST',
				data: {'colaborador':colaborador,'rating':rating,'feedback':feedback},
				success: function(data) {
					console.log(data);
					var returnData = JSON.parse(data);
					if(returnData['msg'] == "ok")
						window.document.location = "<?= base_url('evaluacion');?>";
					else{
						$('#alert').prop('display',true).show();
						$('#msg').html(returnData['msg']);
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				}
			});

			event.preventDefault();
		});
	});
	</script>