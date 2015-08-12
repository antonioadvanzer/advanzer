<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Gestión de Tiempos de Evaluaciones</h2>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#evaluacion").change(function() {
			$("#evaluacion option:selected").each(function() {
				evaluacion = $('#evaluacion').val();
				$.post("<?= base_url('evaluacion/load_info_evaluacion');?>", {
					evaluacion : evaluacion
				}, function(data) {
					$("#datos").html(data);
					$("#submit").show();
				});
			});
		});
	});

	function valida_fechas(f) {
		var evaluacion = f.evaluacion.options[f.evaluacion.selectedIndex].value;
		if(evaluacion == ""){
			alert('Selecciona una evaluación');
			return(false);
		}
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
<div class="container">
  <div align="center">
  	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif; ?>
	<?php if(isset($msg)): ?>
		<div align="center" id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $msg;?>
		</div>
		<script>
			$(document).ready(function() {
				setTimeout(function() {
					window.location="<?= base_url('evaluacion/gestion');?>"
				},3000);
			});
		</script>
	<?php endif; ?>
  </div>
  <div>
    <span title="crear evaluación" style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('evaluacion/nueva');?>'">Nueva Evaluación</span>
  </div>
  <div>&nbsp;</div>
	<form id="form" onsubmit="return valida_fechas(this);" role="form" method="post" action="<?= base_url('evaluacion/gestionar');?>" class="form-signin">
	  <div class="row" align="center">
	  	<div class="col-md-12">
		  <div class="form-group">
			<label for="evaluacion">Evaluación</label>
			<select class="form-control" style="max-width:300px;text-align:center;" id="evaluacion" name="evaluacion">
			  <option value="" disabled selected>-- Selecciona una encuesta --</option>
			  <?php foreach ($evaluaciones as $evaluacion) : ?>
				<option value="<?= $evaluacion->id;?>"><?= "$evaluacion->nombre - $evaluacion->anio";?></option>
			  <?php endforeach; ?>
			</select>
		  </div>
		</div>
	  </div>
	  <div class="row" align="center" id="datos"></div>
	  <div class="row" align="center">
		<div class="col-md-12">
		  <button id="submit" type="submit" class="btn btn-lg btn-primary btn-block" style="display:none;max-width:200px; text-align:center;">Asignar</button>
		</div>
	  </div>
	</form>