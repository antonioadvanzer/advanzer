<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Registro de Nueva Evaluación</h2>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10)
			dd='0'+dd
		if(mm<10)
			mm='0'+mm
		today = yyyy+'-'+mm+'-'+dd;
		$('#inicio').datepicker({
			format: 'yyyy-mm-dd',
			startDate: ''+today+'',
			endDate: '+30d'
		});
		$('#fin').datepicker({
			format: 'yyyy-mm-dd',
			startDate: ''+today+'',
			endDate: '+60d'
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
<div class="container">
  	<?php if(isset($err_msg)): ?>
		<div align="center" id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
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
	<form onsubmit="return valida_fechas(this);" role="form" method="post" action="<?= base_url('evaluacion/registrar');?>" class="form-signin">
	  <div align="center" class="row">
		<div class="col-md-4">
		  <div class="form-group" align="center">
			<label for="nombre">Año de Evaluación: <?= date('Y')-1;?></label>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="form-group" align="center">
			<label for="tipo">Tipo</label>
			<select class="form-control" style="max-width:300px;text-align:center" name="tipo">
			  <option value="0">Por Responsabilidades</option>
			  <option value="1">360</option>
			</select>
		  </div>
		</div>
	  </div>
	  <div class="row" align="center">
	  	<div class="col-md-3">
		  <div class="form-group">
			<label for="evaluacion">Evaluación</label>
			<input type="text" name="nombre" class="form-control" style="max-width:300px;text-align:center;" value="" 
				placeholder="Nombre de la evaluación" required>
		  </div>
		</div>
		<div class="col-md-3">
		  <div class="form-group">
			<label for="descripcion">Descripción</label>
			<input type="text" name="descripcion" class="form-control" style="max-width:300px;text-align:center;" value="" 
				placeholder="Breve descripción de la evaluación" required>
		  </div>
		</div>
		<div class="col-md-3">
		  <div class="form-group">
		    <label for="inicio">Inicia:</label>
		    <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="inicio" id="inicio" onchange="setFin(this);" 
		    	value="<?= date('Y-m-d');?>" class="form-control" style="max-width:300px;text-align:center;">
		  </div>
		</div>
	  	<div class="col-md-3">
		  <div class="form-group">
		    <label for="fin">Termina:</label>
		    <input data-provide="datepicker" data-date-format="yyyy-mm-dd" name="fin" id="fin" 
		    	value="<?= $fecha=date('Y-m-d'); $fecha=date_create($fecha); 
		    		date_add($fecha,date_interval_create_from_date_string('1 month'));?>" 
		    	class="form-control" style="max-width:300px;text-align:center;">
		  </div>
		</div>
	  </div>
	  <div class="row" align="center">
	  	<div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Asignar</button>
		  <a href="<?= base_url('gestion_evaluaciones');?>">&laquo;Regresar</a>
		</div>
	  </div>
	</form>