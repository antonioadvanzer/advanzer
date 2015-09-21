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
			<div class="col-md-5" align="right"><img height="180px" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>"></div>
			<div class="col-md-5">
				<div class="form-group" align="center">
					<label>Resultado:</label>
					<input type="text" class="form-control" style="max-width:80px;background-color: #fff;" disabled value="<?= $colaborador->total;?>">
					<label for="nombre">Rating:</label>
					<select id="rating" class="form-control" style="max-width:80px">
						<option <?php if($colaborador->rating == "A") echo "selected";?>>A</option>
						<option <?php if($colaborador->rating == "B") echo "selected";?>>B</option>
						<option <?php if($colaborador->rating == "C") echo "selected";?>>C</option>
						<option <?php if($colaborador->rating == "D") echo "selected";?>>D</option>
						<option <?php if($colaborador->rating == "E") echo "selected";?>>E</option>
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
			<table id="tbl" align="center" class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
				data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
				data-striped="true" data-show-toggle="true" data-show-export="true">
				<thead>
					<tr>
						<th data-halign="center" data-field="foto"></th>
						<th class="col-md-4" data-halign="center" data-field="evaluador">Evaluador</th>
						<th class "col-md-2" data-halign="center" data-field="responsabilidades">Responsabilidades</th>
						<th class "col-md-2" data-halign="center" data-field="competencias">Competencias</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($colaborador->evaluadores as $evaluador):?>
						<tr>
							<td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;;?>"></td>
							<td><?= $evaluador->nombre;?></td>
							<td><?php if($evaluador->responsabilidad) echo $evaluador->responsabilidad;?></td>
							<td><?php if($evaluador->competencia) echo $evaluador->competencia;?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
	$(document).ready(function() {
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