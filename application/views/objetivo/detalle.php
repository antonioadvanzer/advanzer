<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle del Objetivo</h2>
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
		  <textarea name="descripcion" class="form-control" rows="2" style="max-width:300px;text-align:center;" required 
            placeholder="Agrega una descripción"></textarea>
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
		  	<option>Analista</option>
		    <option>Consultor / Especialista</option>
		    <option>Consultor Sr / Especialista Sr</option>
		    <option>Gerente / Master</option>
		    <option>Gerente Sr / Experto</option>
		    <option>Director</option>
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
  	<div class="col-md-6">
  	  <div class="panel panel-primary">
  	  <div class="panel-heading">Áreas Asignadas</div>
  	  <table class="table table-striped">
  	  	<tbody>
  	  	  <?php foreach($areas_asignadas as $area) : ?>
  	  	  	<form onsubmit="if(!confirm('Seguro que desea eliminar el área: \n <?= $area->nombre;?>')) return false;" 
  	  	  		role="form" method="post" action="<?= base_url('objetivo/del_area');?>" class="form-signin">
  	  	  		<input type="hidden" name="area" value="<?= $area->id;?>">
  	  	  		<input type="hidden" name="objetivo" value="<?= $objetivo->id;?>">
	  	  		<tr>
				  <td><?= $area->nombre;?></td>
	  	  		  <td><button type="submit" class="form-control" style="max-width:55px;">&raquo;</button></td>
	  	  		</tr>
	  	  	</form>
  	  	  <?php endforeach; ?>
  	  	</tbody>
  	  </table>
  	  </div>
  	</div>
  	<div class="col-md-6">
  	  <div class="panel panel-primary">
  	  <div class="panel-heading">Áreas Sin Asignar</div>
  	  <table class="table table-striped">
  	  	<tbody>
  	  	  <?php foreach($areas_no_asignadas as $area) : ?>
  	  	  	<form onsubmit="if(!confirm('Seguro que desea asignar el área: \n <?= $area->nombre;?>')) return false;" 
  	  	  		role="form" method="post" action="<?= base_url('objetivo/add_area');?>" class="form-signin">
  	  	  		<input type="hidden" name="area" value="<?= $area->id;?>">
  	  	  		<input type="hidden" name="objetivo" value="<?= $objetivo->id;?>">
	  	  		<tr>
	  	  		  <td><button type="submit" class="form-control" style="max-width:55px;">&laquo;</button></td>
	  	  		  <td><?= $area->nombre;?></td>
	  	  		</tr>
	  	  	</form>
  	  	  <?php endforeach; ?>
  	  	</tbody>
  	  </table>
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
			})
		});

		$(document).ready(function() {
			$("#posicion").change(function() {
				$("#posicion option:selected").each(function() {
					posicion = $('#posicion').val();
					$.post("<?= base_url('objetivo/load_pesos')."/".$objetivo->id;?>", {
						posicion : posicion
					}, function(data) {
						$("#pesos").html(data);
					});
				});
			})
		});
	</script>