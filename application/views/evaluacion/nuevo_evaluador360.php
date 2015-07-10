<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nuevo Evaluador 360</h2>
  </div>
</div>
<div class="container">
  <div align="center">
  <?php if(isset($msg)): ?>
		<div id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $msg;?>
		</div>
		<script>
			$(document).ready(function() {
				setTimeout(function() {
					window.location="<?= base_url('evaluacion/nuevo_evaluador360');?>"
				},3000);
			});
		</script>
	<?php endif; ?>
	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif; ?>
  </div>
  <div class="row" align="center">
	<div class="col-md-12">
	  <div class="form-group">
	    <label for="nombre">Evaluador:</label>
	    <select id="evaluador" name="evaluador" class="form-control" style="max-width:300px;text-align:center">
		  <option disabled selected>-- Selecciona un evaluador --</option>
		  <?php foreach($evaluadores as $ev) : ?>
		  	<option value="<?= $ev->id;?>"><?= $ev->nombre ." - ". $ev->posicion;?></option>
		  <?php endforeach; ?>
	    </select>
	  </div>
	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-12">
	  <a href="<?= base_url('evaluadores360');?>">&laquo;Regresar</a>
  	</div>
  </div>
  <hr>
  <div class="row" align="center" id>
  	<div class="col-md-5">
  	  <div class="panel panel-primary">
  	  	<div class="panel-heading">Colaboradores Asignados</div>
  	  	<select id="quitar" name="agregar" multiple class="form-control" style="min-height:300px;max-height:700px">
  	  	</select>
  	  </div>
  	</div>
  	<div class="col-md-2">
	  <div class="form-group">&nbsp;</div>
	  <div class="form-group">
		<button id="btnQuitar" class="form-control" style="max-width:100px;">Quitar&raquo;</button>
	  </div>
	  <div class="form-group">
		<button id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
	  </div>
	  <div class="form-group">&nbsp;</div>
  	</div>
  	<div class="col-md-5">
  	  <div class="panel panel-primary">
  	  	<div class="panel-heading">Colaboradores Sin Asignar</div>
  	  	<select id="agregar" name="agregar" multiple class="form-control" style="min-height:300px;max-height:700px">
  	  	</select>
  	  </div>
  	</div>
  </div>

<script type="text/javascript">
		$(document).ready(function() {
			$("#evaluador").change(function() {
				$("#evaluador option:selected").each(function() {
					evaluador = $('#evaluador').val();
					$.post("<?= base_url('evaluacion/load_asignados/1');?>", {
						evaluador : evaluador
					}, function(data) {
						$("#quitar").html(data);
					});
					$.post("<?= base_url('evaluacion/load_no_asignados/1');?>", {
						evaluador : evaluador
					}, function(data) {
						$("#agregar").html(data);
					});
				});
			});
			$('#btnAgregar').click(function() {
				if($('#agregar :selected').length > 0){
					var selected = [];
					$('#agregar :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					var evaluador = $('#evaluador').val();
					$.ajax({
						url:'<?= base_url("evaluacion/add_colaboradores/");?>/'+evaluador+'/1',
						data:{'selected':selected},
						type:'POST',
						success:function(data) {
							$('body').html(data);
							alert('Se han agregado!');
							window.location.reload();
						}
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					var selected = [];
					$('#quitar :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					var evaluador = $('#evaluador').val();
					$.ajax({
						url:'<?= base_url("evaluacion/del_colaboradores");?>/'+evaluador+'/1',
						data:{'selected':selected},
						type:'POST',
						success:function(data) {
							$('body').html(data);
							alert('Se han eliminado!');
							window.location.reload();
						}
					});
				}
			});
		});
	</script>