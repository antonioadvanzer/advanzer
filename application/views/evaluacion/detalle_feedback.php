<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Detalle Feedback</h2>
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
			<div class="col-md-4">
				<img src="<?= base_url("assets/images/fotos/$feedback->foto");?>" height="120px">
				<label><?= $feedback->nombre;?> - <small><?= $feedback->rating;?></small></label>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="contenido">Descripción:</label>
					<textarea onkeyup="$('#guardar').show('slow');$('#enviar').hide('slow');" class="form-control" style="max-width:300px;text-align:center;" rows="4" 
						id="contenido" required <?php if($feedback->estatus !=0)echo"disabled";?>><?= $feedback->contenido;?></textarea>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label for="boton">&nbsp;</label>
					<?php if($feedback->estatus ==0): ?>
						<button id="guardar" type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;
							display:none">
							Guardar</button>
						<button id="enviar" type="button" class="btn btn-lg btn-primary btn-block" style="max-width:200px;text-align:center;
							<?php if($feedback->contenido == "")echo 'display:none' ?>">Enviar</button>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</form>
	<script>
	$(document).ready(function() {
		$('#update').submit(function(event){
			contenido=$('#contenido').val();
			id=$('#id').val();
			$.ajax({
				url: '<?= base_url("evaluacion/updateFeedback");?>',
				type: 'POST',
				data: {'id':id,'contenido':contenido},
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