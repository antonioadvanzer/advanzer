<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nueva Responsabilidad Funcional</h2>
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
  <div align="center"><a href="<?= base_url('administrar_dominios');?>">&laquo;Regresar</a></div>
  <form id="create" role="form" method="post" action="javascript:" class="form-signin">
  	<div class="row" align="center">
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="" placeholder="Nombre">
		</div>
		<div class="form-group">
		  <label for="dominio">Dominio:</label>
		  <select id="dominio" class="form-control" style="max-width:300px; text-align:center">
		  	<?php foreach ($dominios as $dominio) : ?>
			  <option value="<?= $dominio->id;?>"><?= $dominio->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
		<div class="form-group">
		  <label for="tipo">Tipo:</label>
		  <select id="tipo" class="form-control" style="max-width:300px; text-align:center">
			<option>ESPECÍFICA</option>
			  <option>CORE</option>
		  </select>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="descripcion">Descripción:</label>
		  <textarea id="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="8" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-4">
		<div class="form-group">
		<label>Métrica 5</label>
			<textarea id="metrica5" class="form-control" rows="3" style="max-width:300px;text-align:center;" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		<label>Métrica 4</label>
			<textarea id="metrica4" class="form-control" rows="3" style="max-width:300px;text-align:center;" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		<label>Métrica 3</label>
			<textarea id="metrica3" class="form-control" rows="3" style="max-width:300px;text-align:center;" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	</div>
	<div class="row" align="center">
	  <div class="col-md-2"></div>
	  <div class="col-md-4">
		<div class="form-group">
		<label>Métrica 2</label>
			<textarea id="metrica2" class="form-control" rows="3" style="max-width:300px;text-align:center;" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	  <div class="col-md-4">
		<div class="form-group">
		<label>Métrica 1</label>
			<textarea id="metrica1" class="form-control" rows="3" style="max-width:300px;text-align:center;" 
		  	required placeholder="Agrega una descripción"></textarea>
		</div>
	  </div>
	</div>
	<div class="row" align="center">
	  	<div class="col-md-5">
	  	  <div class="panel panel-primary">
			<div class="panel-heading">Áreas Asignadas</div>
			<select id="quitar" name="quitar" multiple class="form-control" 
				style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px"></select>
	  	  </div>
	  	</div>
	  	<div class="col-md-2">
		  <div class="form-group">&nbsp;</div>
		  <div class="form-group">
			<button type="button" id="btnQuitar" class="form-control" style="max-width:100px;">Quitar&raquo;</button>
		  </div>
		  <div class="form-group">
			<button type="button" id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
		  </div>
		  <div class="form-group">&nbsp;</div>
	  	</div>
	  	<div class="col-md-5">
	  	  <div class="panel panel-primary">
			<div class="panel-heading">Áreas Disponibles</div>
			<select id="agregar" name="agregar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
			  <?php foreach($areas as $area) : ?>
				<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
			  <?php endforeach; ?>
			</select>
	  	  </div>
	  	</div>
	</div>
	<div style="height:60px" class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Registrar Datos</button>
	  </div>
	</div>
  </form>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#create').submit(function(event){
				$('#alert').prop('display',false);
				$('#dominio :selected').each(function() {
					dominio = $('#dominio').val();
				});
				$('#tipo :selected').each(function() {
					tipo = $('#tipo').val();
				});
				nombre = $('#nombre').val();
				descripcion = $('#descripcion').val();
				metrica1 = $('#metrica1').val();
				metrica2 = $('#metrica2').val();
				metrica3 = $('#metrica3').val();
				metrica4 = $('#metrica4').val();
				metrica5 = $('#metrica5').val();
				var agregar = [];
				$('#quitar option').each(function(i,select) {
					agregar[i] = $(select).val();
				});
				$.ajax({
					url: '<?= base_url("objetivo/create");?>',
					type: 'post',
					data: {'nombre':nombre,'dominio':dominio,'descripcion':descripcion,'tipo':tipo,'uno':metrica1,
						'dos':metrica2,'tres':metrica3,'cuatro':metrica4,'cinco':metrica5,'agregar':agregar},
					success: function(data){
						console.log(data);
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok")
							window.document.location='<?= base_url("administrar_dominios");?>';
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnedData['msg']);
						}
					}
				});
				event.preventDefault();
			});

			$('#btnAgregar').click(function() {
				if($('#agregar :selected').length > 0){
					$('#agregar :selected').each(function(i,select) {
						$('#agregar').find($(select)).remove();
						$('#quitar').append($('<option>',{value:$(select).val()}).text($(select).text()));
					});
				}
			});

			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					$('#quitar :selected').each(function(i,select) {
						$('#quitar').find($(select)).remove();
						$('#agregar').append($('<option>',{value:$(select).val()}).text($(select).text()));
					});
				}
			});
		});
	</script>