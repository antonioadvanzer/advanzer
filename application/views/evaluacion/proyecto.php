<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Gestión de Tiempos de Evaluaciones</h2>
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
  <div align="center" id="alert_success" style="display:none">
		<div class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg_success"></label>
		</div>
  </div>
  <div class="row" align="center">
    <div class="col-md-12">
      <div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div>
    <span title="crear evaluación" style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('evaluacion/nueva');?>'">Nueva Evaluación</span>
  </div>
  <div>&nbsp;</div>
	<form id="update" action="javascript:" role="form" class="form-signin">
	  <div class="row" align="center">
	  	<div class="col-md-12">
		  <div class="form-group">
			<label for="evaluacion">Evaluación</label>
			<select class="form-control" style="max-width:300px;text-align:center;" id="evaluacion" name="evaluacion">
			  <option value="" disabled selected>-- Selecciona una encuesta --</option>
			  <?php foreach ($evaluaciones as $evaluacion) :
			  	if($evaluacion->tipo==0)
			  		$extra="Proyecto - ";
			  	else
			  		$extra="Anual - ";
			  ?>
				<option value="<?= $evaluacion->id;?>"><?= "$extra $evaluacion->nombre - $evaluacion->anio";?></option>
			  <?php endforeach; ?>
			</select>
		  </div>
		</div>
	  </div>
	  <div class="row" align="center" id="datos"></div>
	</form>
	<script>
		$(document).ready(function() {
			$("#evaluacion").change(function() {
				$("#evaluacion option:selected").each(function() {
					evaluacion = $('#evaluacion').val();
				});
				$.ajax({
					url: '<?= base_url("evaluacion/load_info_evaluacion");?>',
					type: 'post',
					data: {'evaluacion': evaluacion},
					beforeSend: function(xhr) {
						$('#update').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$('#cargando').hide();
						$('#update').show();
						$("#datos").html(data);
						$("#submit").show();
					}
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
