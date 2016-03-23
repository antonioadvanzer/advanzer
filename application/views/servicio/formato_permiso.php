<?php
	$ingreso=new DateTime($yo->fecha_ingreso);
	$hoy=new DateTime(date('Y-m-d'));
	$date_dif = $ingreso->diff($hoy);
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Solicitud de Ausencia</h2>
	</div>
</div>
<div class="container">
	<div align="center"><a style="text-decoration:none;cursor:pointer" onclick="window.location=history.back();">&laquo;Regresar</a></div>
	<div align="center" id="alert" style="display:none">
		<div class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg"></label>
		</div>
	</div>
	<hr>
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<form id="update" role="form" method="post" action="javascript:" class="form-signin" enctype="multipart/form-data">
		<div class="row" align="center">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="input-group" style="display:<?php if($this->session->userdata('tipo')<4) echo"none";?>;">
					<span class="input-group-addon">Colaborador</span>
					<select class="selectpicker" data-header="Selecciona al Colaborador" data-width="300px" data-live-search="true" 
						style="max-width:300px;text-align:center;" id="colaborador" required>
						<option value="" disabled selected>-- Selecciona al Colaborador --</option>
						<?php foreach($colaboradores as $colaborador): ?>
							<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$this->session->userdata('id'))echo"selected";?>><?= $colaborador->nombre;?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="input-group">
					<span class="input-group-addon required">Autorizador</span>
					<select class="selectpicker" data-header="Selecciona al autorizador" data-width="300px" data-live-search="true" 
						style="max-width:300px;text-align:center;" id="autorizador" required>
						<option value="" disabled selected>-- Selecciona al Jefe Directo / Líder --</option>
						<?php foreach($colaboradores as $colaborador)
							if($colaborador->id != $this->session->userdata('id')): ?>
								<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$yo->jefe)echo"selected";?>><?= $colaborador->nombre;?></option>
							<?php endif; ?>
					</select>
				</div>
			</div>
		</div>
		<hr>
		<div class="row" align="center">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon"># Nómina</span>
					<input class="form-control" style="max-width:100px;text-align:center;cursor:default;background-color:white" value="" id="d_nomina" disabled>
					<span class="input-group-addon">Área Actual</span>
					<input class="form-control" style="min-width:300px;text-align:center;cursor:default;background-color:white" value="" id="d_area" disabled>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Fecha de Ingreso</span>
					<input class="form-control" style="max-width:150px;ttext-align:center;cursor:default;background-color:white" value="" id="d_ingreso" disabled>
					<span class="input-group-addon">Antigüedad</span>
					<input class="form-control" style="max-width:350px;ttext-align:center;cursor:default;background-color:white" value="" id="d_antiguo" disabled>
				</div>
			</div>
		</div>
		<hr>
		<div class="row" align="center">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<h3>Detalle de Solicitud</h3>
				<div class="input-group">
					<span class="input-group-addon required">Motivo</span>
					<select class="form-control" id="motivo" required>
						<option value="" selected disabled>-- Selecciona el motivo --</option>
						<option value="2">MATRIMONIO</option>
						<option value="5">NACIMIENTO DE HIJOS</option>
						<option value="2">FALLECIMIENTO DE CÓNYUGE</option>
						<option value="2">FALLECIMIENTO DE HERMANOS</option>
						<option value="3">FALLECIMIENTO DE HIJOS</option>
						<option value="3">FALLECIMIENTO DE PADRES</option>
						<option value="2">FALLECIMIENTO DE PADRES POLÍTICOS</option>
						<option value="42">ENFERMEDAD</option>
						<option>Otro</option>
					</select>
					<span class="input-group-addon required" id="especifique_label">Especifique</span>
					<input class="form-control" id="especifique" value="" disabled style="background-color:white;">
					<span class="input-group-addon required">Comprobante</span>
					<input class="form-control" type="file" id="file" name="file" value="">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon required">Días a Solicitar</span>
					<select class="form-control" id="dias" onchange="calculaFechas();" required>
						<option value="" selected disabled>-- Elegir --</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
					</select>
					<span class="input-group-addon required">Desde</span>
					<input class="form-control" type="text" id="desde" style="text-align:center;background-color:white;cursor:default" 
						value="<?= date('Y-m-d');?>" required readonly>
					<span class="input-group-addon required">Hasta</span>
					<input class="form-control" type="text" id="hasta" style="text-align:center;background-color:white;cursor:default" 
						value="" readonly required>
				</div>
				<br>
				<p style="width:80%;border-radius:10px;border-color:red;border-style:dotted;color:red;display:none" id="otro_label"><small>Favor de redactar el detalle de tu ausencia en el campo <i>Observaciones</i> para facilitar la resolución de la solicitud</small></p>
				<div class="input-group">
					<span class="input-group-addon required" style="min-width:260px">Observaciones</span>
					<textarea class="form-control" id="observaciones" rows="4" placeholder="Agrega cualquier comentario que consideres relevante para la autorización de tus días" required></textarea>
				</div>
				<br>
				<br>
			</div>
		</div>
		<div class="row" align="right" id="botones">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button id="solicitar" type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Solicitar</button>
				</div>
			</div>
		</div>
	</form>
	<script>
		document.write('\
			<style>\
				.required {\
					background: '+color+'\
				}\
			</style>\
		');
		function getColaborador() {
			$('#colaborador :selected').each(function(){
				colaborador=$('#colaborador').val();
			});
			if(colaborador != ""){
				$.ajax({
					url: '<?= base_url("servicio/getColabInfo");?>',
					type: 'post',
					data: {'colaborador':colaborador,'tipo':2},
					success: function(data){
						var returnedData = JSON.parse(data);
						$('#d_nomina').val(returnedData['nomina']);
						$('#d_area').val(returnedData['nombre_area']);
						$('#d_ingreso').val(returnedData['fecha_ingreso']);
						$('#d_antiguo').val(returnedData['diff']['y']+' años, '+returnedData['diff']['m']+' meses');
						$('#autorizador').val(returnedData['jefe']).selectpicker('refresh');
						$('#dias').val('');
						$('#desde').val('<?= date("Y-m-d");?>');
						calculaFechas();
						$('#observaciones').val('');
					},
					error: function(xhr) {
						console.log(xhr.responseText);
					}
				});
			}
		}
		function calculaFechas() {
			patron = /^\d*$/;
			$('#dias :selected').each(function(){
				dias=$('#dias').val();
			})
			dias=parseInt(dias);
			if(dias > 0){
				inicio=$('#desde').val();
				hasta=sumaFecha(dias,inicio);
				$('#hasta').val(hasta);
			}else
				$('#hasta').val('');
		}
		sumaFecha = function(d, fecha){
			var Fecha = new Date();
			var sFecha = fecha || (Fecha.getFullYear() + "-" + (Fecha.getMonth() +1) + "-" + Fecha.getDate());
			var aFecha = sFecha.split('-');
			var fecha = aFecha[0]+'-'+aFecha[1]+'-'+aFecha[2];
			fecha= new Date(fecha);
			i=0;
			while(i < parseInt(d)){
				fecha.setTime(fecha.getTime()+24*60*60*1000);
				if(fecha.getDay() != 6 && fecha.getDay() != 0)
					i++;
			}
			//fecha.setDate(fecha.getDate()+parseInt(d));
			var anno=fecha.getFullYear();
			var mes= fecha.getMonth()+1;
			var dia= fecha.getDate();
			mes = (mes < 10) ? ("0" + mes) : mes;
			dia = (dia < 10) ? ("0" + dia) : dia;
			var fechaFinal = anno+'-'+mes+'-'+dia;
			return (fechaFinal);
		}
		$(document).ready(function() {
			calculaFechas();
			getColaborador();
			$('#desde').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('#hasta').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('#hasta').change(function() {
				hasta=$('#hasta').val();
			});
			$('#motivo').change(function() {
				$('#motivo :selected').each(function(){
					motivo=$('#motivo').val();
				});
				$('#dias').empty();
				if(motivo > 5){
					limite=parseInt(motivo);
					$('#file').prop('required',true);
				}else{
					limite=5;
					$('#file').prop('required',false);
				}
				for (var i = 1; i <= limite; i++)
					$('#dias').append(new Option(i,i,true,true));
				if(motivo == "Otro"){
					$('#otro_label').show('slow');
					$('#especifique_label').show('slow');
					$('#especifique').prop({'disabled':false,'required':true}).show('slow');
					$('#dias').val('');
				}else{
					$('#especifique_label').hide('slow');
					$('#especifique').prop({'disabled':true,'required':false}).hide('slow');
					$('#dias').val(motivo);
					$('#otro_label').hide('slow');
				}
				calculaFechas();
			});
			
			$("#desde").change(function() {
				calculaFechas();
			});

			$("#colaborador").change(function() {
				$('#motivo').val('');
				$('#observaciones').val('');
				$('#dias').val('1');
				calculaFechas();
				getColaborador();
			});

			$("#update").submit(function(event){
				if(!confirm('¿Seguro que desea enviar la solicitud?'))
					return false;
				//get form values
					var formData = new FormData($('#update')[0]);
					$("#colaborador option:selected").each(function() {
						colaborador = $('#colaborador').val();
					});
					formData.append('colaborador',colaborador);
					$("#autorizador option:selected").each(function() {
						autorizador = $('#autorizador').val();
					});
					formData.append('autorizador',autorizador);
					m = $('#motivo option:selected').val();
					if(m=='Otro')
						tipo=3;
					else
						tipo=2;
					formData.append('tipo',tipo);
					motivo = $("#motivo option:selected").text();
					if(motivo=='Otro')
						motivo=$('#especifique').val();
					formData.append('motivo',String(motivo));
					$('#dias :selected').each(function(){
						dias=$('#dias').val();
					})
					formData.append('dias',dias);
					formData.append('desde',$('#desde').val());
					formData.append('hasta',$('#hasta').val());
					formData.append('observaciones',$('#observaciones').val());
				$.ajax({
					url: '<?= base_url("servicio/registra_solicitud");?>',
					type: 'post',
					cache: false,
					contentType: false,
					processData: false,
					resetForm: true,
					data: formData,
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok"){
							alert('Se ha enviado la solicitud');
							window.document.location='<?= base_url("solicitudes");?>';
						}else{
							$('#cargando').hide('slow');
							$('#update').show('slow');
							$('#alert').prop('display',true).show('slow');
							$('#msg').html(returnedData['msg']);
							setTimeout(function() {
								$("#alert").fadeOut(1500);
							},3000);
						}
					},
					error: function(xhr) {
						console.log(xhr);
						$('#cargando').hide('slow');
						$('#update').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				});

				event.preventDefault();
			});
		});
	</script>