<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle de la Responsabilidad Funcional</h2>
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
  <form id="update" role="form" method="post" action="javascript:" class="form-signin">
  	<input type="hidden" id="id" value="<?= $objetivo->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="<?= $objetivo->nombre; ?>">
		</div>
		<div class="form-group">
		  <label for="dominio">Dominio:</label>
		  <select id="dominio" class="form-control" style="max-width:300px; text-align:center">
		  	<?php foreach ($dominios as $dominio) : ?>
			  <option value="<?= $dominio->id;?>" <?php if($dominio->id == $objetivo->dominio) echo"selected";?>>
				<?= $dominio->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
		<div class="form-group">
		  <label for="tipo">Tipo:</label>
		  <select id="tipo" class="form-control" style="max-width:300px; text-align:center">
			<option <?php if($objetivo->tipo == 'ESPECÍFICA') echo"selected";?>>
			  ESPECÍFICA</option>
			  <option <?php if($objetivo->tipo == 'CORE') echo"selected";?>>
			  CORE</option>
		  </select>
		</div>
	  </div>
	  <div class="col-md-6">
		<div class="form-group">
		  <label for="descripcion">Descripción:</label>
		  <textarea id="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="8" 
		  	required><?= $objetivo->descripcion;?></textarea>
		</div>
	  </div>
	</div>
	<hr>
	<div class="row" align="center">
		<?php foreach ($objetivo->metricas as $metrica) : ?>
			<input type="hidden" id="metrica<?= $metrica->valor;?>" name="metrica" value="<?= $metrica->id;?>">
			<div class="col-md-4">
				<div class="form-group">
					<label>Métrica <?= $metrica->valor;?></label>
					<textarea id="descripcion<?= $metrica->valor;?>" name="descripcion" class="form-control" rows="3" 
						style="max-width:300px;text-align:center;" required><?= $metrica->descripcion;?></textarea>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
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
			<button type="button" id="btnQuitar" class="form-control" style="max-width:100px;">Quitar&raquo;</button>
		  </div>
		  <div class="form-group">
			<button type="button" id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
		  </div>
		  <div class="form-group">&nbsp;</div>
	  	</div>
	  	<div class="col-md-5">
	  	  <div class="panel panel-primary">
			<div class="panel-heading">Áreas Disponbles</div>
			<select id="agregar" name="agregar" multiple class="form-control" style="overflow-y:auto;overflow-x:auto;min-height:300px;max-height:700px">
			  <?php foreach($areas_no_asignadas as $area) : ?>
				<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
			  <?php endforeach; ?>
			</select>
	  	  </div>
	  	</div>
	</div>
	<div style="height:60px" class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Actualizar</button>
	  </div>
	</div>
  </form>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#update').submit(function(event){
				$('#alert').prop('display',false).hide();
				var descripciones = new Array();
				$("textarea[name=descripcion]").each(function(){
					descripciones.push($(this).val());
				});
				id=$('#id').val();
				descripcion=$('#descripcion').val();
				nombre=$('#nombre').val();
				$("#dominio option:selected").each(function() {
					dominio = $('#dominio').val();
				});
				$("#tipo option:selected").each(function() {
					tipo = $('#tipo').val();
				});
				var quitar = [];
				$('#agregar option').each(function(i,select) {
					quitar[i] = $(select).val();
				});
				var agregar = [];
				$('#quitar option').each(function(i,select) {
					agregar[i] = $(select).val();
				});
				$.ajax({
					url: '<?= base_url("objetivo/update");?>',
					type: 'POST',
					data: {'id':id,'nombre':nombre,'descripcion':descripcion,'dominio':dominio,'tipo':tipo,
						'descripciones':descripciones,'agregar':agregar,'quitar':quitar},
					success: function(data) {
						console.log(data);
						var returnData = JSON.parse(data);
						if(returnData['msg'] == "ok")
							window.document.location = '<?= base_url("administrar_dominios");?>';
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnData['msg']);
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