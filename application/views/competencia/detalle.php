<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle de la competencia</h2>
  </div>
</div>
<div class="container">
  <div class="row" align="center">
	  <a href="<?= base_url('administrar_indicadores');?>">&laquo;Regresar</a>
  	<div class="col-md-12" align="center">
	  	<div class="form-group">
		  <div align="center">
			<div id="alert" style="display:none" class="alert alert-danger" role="alert" style="max-width:400px;">
		      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		      <span class="sr-only">Error:</span>
		      <label id="msg"></label>
		    </div>
		    <div id="alert_success" style="display:none" class="alert alert-success" role="alert" style="max-width:400px;">
		      <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		      <span class="sr-only">Error:</span>
		      <label id="msg_success"></label>
		    </div>
		  </div>
		</div>
	</div>
  </div>
  <form id="update" role="form" method="post" action="javascript:" class="form-signin">
  	<input type="hidden" id="id" value="<?= $competencia->id;?>">
  	<div class="row" align="center">
	  <div class="col-md-3">
		<div class="form-group">
		  <label for="nombre">Nombre:</label>
		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
			id="nombre" required value="<?= $competencia->nombre; ?>">
		</div>
	  </div>
	  <div class="col-md-3">
		<div class="form-group">
		  <label for="indicador">Indicador:</label>
		  <select id="indicador" class="form-control" style="max-width:300px; text-align:center">
		  	<?php foreach ($indicadores as $indicador) : ?>
			  <option value="<?= $indicador->id;?>" <?php if($indicador->id == $competencia->indicador) echo"selected";?>>
				<?= $indicador->nombre;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
	  </div>
	  <div class="col-md-3">
		<div class="form-group">
		  <label for="descripcion">Descripción:</label>
		  <textarea id="descripcion" class="form-control" style="max-width:300px;text-align:center" rows="3" 
		  	required><?= $competencia->descripcion;?></textarea>
		</div>
	  </div>
	  <div class="col-md-3">
		<div class="form-group">
		  <label for="resumen">Resumen:</label>
		  <textarea id="resumen" class="form-control" style="max-width:300px;text-align:center" rows="3" 
		  	required><?= $competencia->resumen;?></textarea>
		</div>
	  </div>
	</div>
	<div style="height:60px" class="row" align="center">
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
		  	Actualizar Datos</button>
		  	<span style="float:right;">
				<label onclick="$('#update').hide('slow');$('#comportamientos').show('slow');" style="cursor:pointer;">
					Ver/Asignar Comportamientos</label>
			</span>
	  </div>
	</div>
  </form>
  <div id="comportamientos" style="display:none" class="row" align="center">
	<div class="col-md-12">
	  <label>Comportamientos</label>
	</div>
  	<div class="col-md-5">
  	  <div class="panel panel-primary">
		<div class="panel-heading">Comportamientos Asignados</div>
		<div class="row">
		  <select id="quitar" name="quitar" class="form-control" style="max-width:450px">
		  	<option selected disabled>-- Selecciona un comportamiento --</option>
			<?php foreach($competencia->comportamientos as $comportamiento) : ?>
			  <option value="<?= $comportamiento->id;?>"><?= $comportamiento->descripcion;?></option>
			<?php endforeach; ?>
		  </select>
		</div>
		<div align="center"><div id="cargando" style="display:none; color: green;">
		  <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
		<div class="row" id="result"></div>
	  </div>
  	</div>
  	<div class="col-md-2">
	  <div class="form-group">&nbsp;</div>
	  <div class="form-group">
		<button type="button" id="btnQuitar" class="form-control" style="max-width:100px;" disabled>Quitar&raquo;</button>
	  </div>
	  <div class="form-group">
		<button type="button" id="btnAgregar" class="form-control" style="max-width:100px;">&laquo;Agregar</button>
	  </div>
	  <div class="form-group">&nbsp;</div>
  	</div>
  	<div class="col-md-5">
  	  <div class="panel panel-primary" style="min-height:200px">
		<div class="panel-heading">Asignar Comportamiento</div>
		<div class="input-group" style="min-height:70px">
			<span class="input-group-addon">Comportamiento</span>
		</div>
			<input id="comportamiento" type="text" class="form-control" value="" placeholder="Descripción">
			<select id="posicion" name="posicion" multiple class="form-control" 
				style="overflow-y:auto;overflow-x:auto;min-height:130px;max-height:300px">
				<option value="8">Analista</option>
				<option value="7">Consultor</option>
				<option value="6">Consultor Sr</option>
				<option value="5">Gerente / Master</option>
				<option value="4">Gerente Sr / Experto</option>
				<option value="3">Director</option>
			</select>
	  </div>
  	</div>
  	<div class="col-md-12">
		<span style="float:right;">
			<label onclick="$('#comportamientos').hide('slow');$('#update').show('slow');" style="cursor:pointer;">
				Ver información general</label>
		</span>
	</div>
  </div>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#btnAgregar').click(function() {
				if($('#comportamiento').val().length > 0 && $('#posicion :selected').length > 0){
					var comportamiento = $('#comportamiento').val();
					var competencia = <?= $competencia->id;?>;
					var selected = [];
					$('#posicion :selected').each(function(i,select) {
						selected[i] = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("competencia/add_comportamiento");?>',
						data:{'competencia':competencia,'comportamiento':comportamiento,'selected':selected},
						type:'POST',
						success:function(data) {
							var returnData = JSON.parse(data);
							if(returnData['msg'] == "ok"){
								$('#quitar').append($('<option>',{value:returnData['id']}).text(comportamiento));
								$('#posicion :selected').each(function(i,select) {
									$(select).removeAttr("selected");
								});
								$('#comportamiento').val("");
								$('#alert_success').prop('display',true).show();
								$('#msg_success').html(returnData['msg_success']);
								setTimeout(function() {
									$("#alert_success").fadeOut(1500);
									},3000);
							}else{
								$('#alert').prop('display',true).show();
								$('#msg').html(returnData['msg']);
								setTimeout(function() {
									$("#alert").fadeOut(1500);
									},3000);
							}
						}
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#quitar :selected').length > 0){
					var selected = [];
					$('#quitar :selected').each(function(i,select) {
						selected = $(select).val();
					});
					$.ajax({
						url:'<?= base_url("competencia/del_comportamiento");?>',
						data:{'selected':selected},
						type:'POST',
						success:function(data) {
							console.log(data);
							var returnData = JSON.parse(data);
							if(returnData['msg'] == "ok"){
								$('#quitar :selected').each(function(i,select) {
									$('#quitar').find(select).remove();
								});
								$('#alert_success').prop('display',true).show();
								$('#msg_success').html(returnData['msg_success']);
								setTimeout(function() {
									$("#alert_success").fadeOut(1500);
									},3000);
							}else{
								$('#alert').prop('display',true).show();
								$('#msg').html(returnData['msg']);
								setTimeout(function() {
									$("#alert").fadeOut(1500);
									},3000);
							}
						}
					});
				}
			});
			$("#quitar").change(function() {
				$('#btnQuitar').prop('disabled',false);
				$("#quitar option:selected").each(function() {
					comportamiento = $('#quitar').val();
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('competencia/load_posiciones_comportamiento');?>",
					data: {comportamiento : comportamiento},
					beforeSend: function (xhr) {
						$('#result').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$("#result").show().html(data);
						$('#cargando').hide();
					}
				});
			});

			$('#update').submit(function(event){
				id = $('#id').val();
				nombre = $('#nombre').val();
				$("#indicador option:selected").each(function() {
					indicador = $('#indicador').val();
				});
				descripcion = $('#descripcion').val();
				resumen = $('#resumen').val();
				$.ajax({
					url: '<?= base_url("competencia/update");?>',
					type: 'post',
					data: {'id':id,'nombre':nombre,'descripcion':descripcion,'indicador':indicador,'resumen':resumen},
					success: function(data){
						var returnData = JSON.parse(data);
						console.log(returnData['msg']);
						if(returnData['msg']=="ok")
							window.document.location='<?= base_url("administrar_indicadores");?>';
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