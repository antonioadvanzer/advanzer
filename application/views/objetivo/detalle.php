<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle de la Responsabilidad</h2>
  </div>
</div>
<div class="container">
  <div align="center">
	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif; ?>
  </div>
  <form role="form" method="post" action="<?= base_url('objetivo/update');?>" class="form-signin">
  	<input type="hidden" name="id" value="<?= $objetivo->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="<?= $objetivo->nombre; ?>">
		</div>
		<div class="form-group">
		  <label for="dominio">Dominio:</label>
		  <select name="dominio" class="form-control" style="max-width:300px; text-align:center">
		  	<?php foreach ($dominios as $dominio) : ?>
			  <option value="<?= $dominio->id;?>" <?php if($dominio->id == $objetivo->dominio) echo"selected";?>>
				<?= $dominio->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Descripción:</label>
		  <textarea name="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="5" 
		  	required><?= $objetivo->descripcion;?></textarea>
		</div>
	  </div>
	</div>
	<div style="height:60px" class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Actualizar Datos</button>
	  </div>
	</div>
  </form>
  <hr>
  <form role="form" method="post" action="<?= base_url('objetivo/update_metrica');?>" class="form-signin">
  	<input type="hidden" name="objetivo" value="<?= $objetivo->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-12">
		<label>Métrica</label>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-4">
		<div class="form-group">
		  <select id="valor" name="valor" class="form-control" style="max-width:210px;text-align:center;">
		  	<option selected disabled>-- Selecciona un valor --</option>
		  	<?php for ($i=5; $i >= 1; $i--) : ?>
			  <option><?= $i; ?></option>
		  	<?php endfor; ?>
		  </select>
		</div>
	  </div>
	  <div class="col-md-4">
		<div id="metrica" class="form-group">
		  <textarea name="descripcion" class="form-control" rows="3" style="max-width:300px;text-align:center;" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	  <div id="boton" class="col-md-4">
		<div class="form-group" align="center">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:180px; text-align:center;">
			Actualizar Métrica</button>
		</div>
	  </div>
	</div>
  </form>
  <hr>
  <form role="form" method="post" action="<?= base_url('objetivo/update_peso');?>" class="form-signin">
  	<input type="hidden" name="objetivo" value="<?= $objetivo->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-12">
		<label>Peso Relativo</label>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-4">
		<div class="form-group">
		  <select id="posicion" name="posicion" class="form-control" style="max-width:210px;text-align:center;">
		  	<option selected disabled>-- Selecciona un valor --</option>
		  	<option value="8">Nivel 8 o Superior (Analista)</option>
		    <option value="7">Nivel 7 (Consultor / Especialista)</option>
		    <option value="6">Nivel 6 (Consultor Sr / Especialista Sr)</option>
		    <option value="5">Nivel 5 (Gerente / Master)</option>
		    <option value="4">Nivel 4 (Gerente Sr / Experto)</option>
		    <option value="3">Nivel 3 o Inferior (Director)</option>
		  </select>
		</div>
	  </div>
	  <div class="col-md-4">
		<div id="pesos" class="form-group">
		  <input class="form-control" name="valor" style="max-width:300px;text-align:center;" required value="">
		</div>
	  </div>
	  <div id="boton" class="col-md-4">
		<div class="form-group" align="center">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:180px; text-align:center;">
			Actualizar Peso</button>
		</div>
	  </div>
	</div>
  </form>
  <hr>
  <div class="row" align="center">
	<div class="col-md-12">
	  <label>Áreas</label>
	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-5">
  	  <div class="panel panel-primary">
		<div class="panel-heading">Áreas Asignadas</div>
		<select id="quitar" name="quitar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
		  <?php foreach($areas_asignadas as $area) : ?>
			<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
		  <?php endforeach; ?>
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
		<div class="panel-heading">Áreas Sin Asignar</div>
		<select id="agregar" name="agregar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
		  <?php foreach($areas_no_asignadas as $area) : ?>
			<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
		  <?php endforeach; ?>
		</select>
  	  </div>
  	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-12">
	  <a href="<?= base_url('administrar_dominios');?>">&laquo;Regresar</a>
  	</div>
  </div>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#valor").change(function() {
				$("#valor option:selected").each(function() {
					valor = $('#valor').val();
					$.post("<?= base_url('objetivo/load_metricas')."/".$objetivo->id;?>", {
						valor : valor
					}, function(data) {
						$("#metrica").html(data);
					});
				});
			});

			$("#posicion").change(function() {
				$("#posicion option:selected").each(function() {
					posicion = $('#posicion').val();
					$.post("<?= base_url('objetivo/load_pesos')."/".$objetivo->id;?>", {
						posicion : posicion
					}, function(data) {
						$("#pesos").html(data);
					});
				});
			});

			$('#btnAgregar').click(function() {
				if($('#agregar :selected').length > 0){
					var selected = [];
					var objetivo = <?= $objetivo->id;?>;
					$('#agregar :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("objetivo/add_areas");?>',
						data:{'selected':selected,'objetivo':objetivo},
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
					var objetivo = <?= $objetivo->id;?>;
					$('#quitar :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("objetivo/del_areas");?>',
						data:{'selected':selected,'objetivo':objetivo},
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