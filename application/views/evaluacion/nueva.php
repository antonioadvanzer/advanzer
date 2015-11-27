<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Registro de Nueva Evaluación</h2>
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
	  <a href="<?= base_url('evaluacion/proyecto');?>">&laquo;Regresar</a>
  	</div>
  </div>
  <div class="row" align="center">
    <div class="col-md-12">
      <div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <form id="create" role="form" action="javascript:" class="form-signin">
	  <div align="center" class="row">
		<div class="col-md-3"></div>
		<div class="col-md-3">
		  <div class="form-group" align="center">
			<label for="nombre">Año de Evaluación:</label>
			<input class="form-control" style="max-width:300px;text-align:center;" type="text" id="anio" 
				value="<?= date('Y')-1;?>" required>
		  </div>
		</div>
		<div class="col-md-3">
		  <div class="form-group" align="center">
			<label for="tipo">Tipo</label>
			<select class="form-control" style="max-width:300px;text-align:center" id="tipo">
			  <option value="0">Por proyecto</option>
			  <option value="1">Anual</option>
			</select>
		  </div>
		</div>
	  </div>
	  <div class="row" align="center">
	  	<div class="col-md-4">
		  <div class="form-group">
			<label for="nombre">Evaluación</label>
			<input type="text" id="nombre" class="form-control" style="max-width:300px;text-align:center;" value="" 
				placeholder="Nombre de la evaluación" required>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="inicio">Inicia Evaluación:</label>
		    <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="inicio" id="inicio" onchange="setFin(this);" 
		    	value="<?= date('Y-m-d');?>" class="form-control" style="max-width:300px;text-align:center;" required>
		  </div>
		</div>
	  	<div class="col-md-4">
		  <div class="form-group">
		    <label for="fin">Termina Evaluación:</label>
		    <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="fin" id="fin" 
		    	value="<?= $fecha=date('Y-m-d');?>" 
		    	class="form-control" style="max-width:300px;text-align:center;" required>
		  </div>
		</div>
	  </div>
	  <div class="row" align="center" id="proyecto">
		<div class="col-md-4">
			<div class="form-group" align="center">
				<label for="lider">Líder de Proyecto</label>
				<select id="lider" name="lider" class="form-control" style="max-width:300px" required>
					<option value="" disabled selected>-- Selecciona un líder --</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="inicio">Inicia Proyecto:</label>
		    <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="inicio_p" id="inicio_p" 
		    	value="<?= date('Y-m-d');?>" class="form-control" style="max-width:300px;text-align:center;" required>
		  </div>
		</div>
	  	<div class="col-md-4">
		  <div class="form-group">
		    <label for="fin">Termina Proyecto:</label>
		    <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="fin_p" id="fin_p" 
		    	value="<?= $fecha=date('Y-m-d');?>" 
		    	class="form-control" style="max-width:300px;text-align:center;" required>
		  </div>
		</div>
		<div class="col-md-5">
			<div class="form-group" align="center">
				<label for="participantes">Participantes</label>
				<select id="agregar" name="agregar" multiple class="form-control" style="overflow-y:auto;
					overflow-x:auto;min-height:200px;max-height:700px" required></select>
			</div>
		</div>
		<div class="col-md-2"><div class="form-group">&nbsp;</div>
			<div class="form-group">
				<button type="button" id="btnQuitar" style="max-width:100px" class="form-control">Quitar&raquo;</button>
			</div>
			<div class="form-group">
				<button type="button" id="btnAgregar" style="max-width:100px" class="form-control">&laquo;Agregar</button>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group" align="center">
				<label for="participantes">Colaboradores Disponibles</label>
				<select id="quitar" name="quitar" multiple class="form-control" style="overflow-y:auto;
					overflow-x:auto;min-height:200px;max-height:700px">
					<?php foreach($colaboradores as $colaborador) : if($colaborador->nivel_posicion <= 8): ?>
						<option value="<?= $colaborador->id;?>">
							<?= "$colaborador->nombre - $colaborador->posicion ($colaborador->track)";?>
						</option>?>
					<?php endif; endforeach; ?>
				</select>
			</div>
		</div>
	  </div>
	  <div class="row" align="center">
	  	<div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" 
		  	style="max-width:200px; text-align:center;">Guardar</button>
		</div>
	  </div>
	</form>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tipo').change(function() {
				if($('#tipo').val() == 1){
					$('#proyecto').hide('slow');
					$('#lider').removeAttr('required');
					$('#agregar').removeAttr('required');
				}else{
					$('#proyecto').show('slow');
					$('#lider').attr('required','required');
					$('#agregar').attr('required','required');
				}
			});
			$('#btnAgregar').click(function() {
				if($('#quitar :selected').length > 0){
					$('#quitar :selected').each(function(i,select) {
						$('#quitar').find($(select)).remove();
						$('#agregar').append($('<option>',{value:$(select).val()}).text($(select).text()));
						$('#lider').append($('<option>',{value:$(select).val()}).text($(select).text()));
					});
				}
			});
			$('#btnQuitar').click(function() {
				if($('#agregar :selected').length > 0){
					$('#agregar :selected').each(function(i,select) {
						$('#agregar').find($(select)).remove();
						$('#lider').find("option[value='"+$(select).val()+"']").remove();
						$('#quitar').append($('<option>',{value:$(select).val()}).text($(select).text()));
					});
				}
			});

			$('#create').submit(function(event){
				$('#alert').prop('display',false).hide();
				anio=$('#anio').val();
				$('#tipo option:selected').each(function(i,select) {
					tipo = $(select).val();
				});
				nombre=$('#nombre').val();
				fin=$('#fin').val();
				inicio=$('#inicio').val();
				fin_p=$('#fin_p').val();
				inicio_p=$('#inicio_p').val();
				$('#lider option:selected').each(function(i,select) {
					lider = $(select).val();
				});
				var agregar = [];
				$('#agregar option').each(function(i,select) {
					if($(select).val() != lider)
						agregar[i] = $(select).val();
				});
				console.log(anio,tipo,nombre,fin,inicio,lider,agregar,fin_p,inicio_p);
				$.ajax({
					url: '<?= base_url("evaluacion/registrar");?>',
					type: 'POST',
					data: {'anio':anio,'tipo':tipo,'nombre':nombre,'fin':fin,'inicio':inicio,'lider':lider,'agregar':agregar,'fin_p':fin_p,
						'inicio_p':inicio_p},
					beforeSend: function (xhr) {
						$('#create').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data) {
						console.log(data);
						var returnData = JSON.parse(data);
						if(returnData['msg'] == "ok")
							if(tipo == 1)
								window.document.location = '<?= base_url("evaluaciones");?>';
							else
								window.document.location = '<?= base_url("evaluacion/proyecto");?>';
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnData['msg']);
						}
					},
					error: function(xdr) {
						console.log(xdr.responseText);
					}
				});
				event.preventDefault();
			});

			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			if(dd<10)
				dd='0'+dd
			if(mm<10)
				mm='0'+mm
			today = yyyy+'-'+mm+'-'+dd;
			$('#inicio').datepicker({dateFormat: 'yy-mm-dd'});
			$('#fin').datepicker({dateFormat: 'yy-mm-dd'});
			$('#inicio_p').datepicker({dateFormat: 'yy-mm-dd'});
			$('#fin_p').datepicker({dateFormat: 'yy-mm-dd'});
			$('#inicio').change(function(){
				$('#fin').datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: $('#inicio').val(),
					maxDate: '+90d'
				});
			});
		});

		function valida_fechas(f) {
			var inicio = f.inicio;
			var fin = f.fin;
			var anio = parseInt(inicio.value.substring(0,4));
			var mes = inicio.value.substring(5,7);
			var dia = inicio.value.substring(8,10);
			var c_anio = parseInt(fin.value.substring(0,4));
			var c_mes = fin.value.substring(5,7);
			var c_dia = fin.value.substring(8,10);
			if(c_anio > anio)
				return(true);
			else{
				if (c_anio == anio){
					if(c_mes > mes)
						return(true);
					if(c_mes == mes)
						if(c_dia >= dia)
							return(true);
						else{
							alert('Error. Elige un rango de fechas válido');
							return(false);
						}
					else{
						alert('Error. Elige un rango de fechas válido');
						return(false);
					}
				}else{
					alert('Error. Elige un rango de fechas válido');
					return(false);
				}
			}
		}

		function setFin(inicio) {
			document.getElementById('fin').value = inicio.value;
		}
	</script>