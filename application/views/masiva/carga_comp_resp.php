<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Carga de Información Masiva</h2>
	</div>
</div>
<div class="container">
	<div align="center" class="row">
		<div class="col-md-12" align="center">
			<div class="form-group" align="center">
				<?php if(isset($err_msg)): ?>
					<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						<?= $err_msg;?>
					</div>
				<?php endif; ?>
				<?php if(isset($msg)): ?>
					<div id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						<?= $msg;?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div align="center" class="row">
		<form id="frmCarga2" role="form" action="javascript:;" method="post" enctype="multipart/form-data" class="form-signin">
			<div class="col-md-6" align="center">
				<div class="form-group">
					<label for="foto" class="control-label">Selecciona el archivo</label>
					<input class="form-control" type="file" id="file" name="file" size="40" style="max-width:300px; text-align:center;" required/>
				</div>
			</div>
			<div class="col-md-3" align="center">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">
						<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Cargar Archivo</button>
				</div>
			</div>
		</form>
	</div>
	<div class="row" align="center">
		<div class="col-md-12">
			<div class="loading-progress" style="width:80%;"></div>
			<div id="data"></div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#frmCarga2').submit(function(e) {
				e.preventDefault();
				formData = new FormData($('#frmCarga2')[0]);

				//var progress = $(".loading-progress").progressTimer();
				$( ".loading-progress" ).progressbar({
					value: false
				});
				$.ajax({
					url:'<?= base_url("masiva/upload_comp_resp");?>',
					type:'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					resetForm: true,
					success: function(data,status) {
						//$('#data').html(data);
						var json = $.parseJSON(data);
						console.log(data);
						if(json.status != 'error') {
							alert(json.msg);
							//window.location.reload();
						}
						$('.loading-progress').hide();
					}
				});
				return false;
			});
		});
	</script>