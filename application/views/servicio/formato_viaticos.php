<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Solicitud de Viáticos y Gastos de Viaje</h2>
	</div>
</div>
<div class="container">
	<div align="center"><a style="text-decoration:none;cursor:pointer" onclick="window.history.back();">&laquo;Regresar</a></div>
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
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
		<div class="row" align="center">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="input-group" style="display:<?php if($this->session->userdata('tipo')<4) echo"none";?>;">
					<span class="input-group-addon required">Colaborador</span>
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
			<div class="col-md-6">
				<div class="input-group">
					<span style="min-width:250px" class="input-group-addon required">Centro de Costo</span>
					<input class="form-control" style="background-color:white;" value="" id="centro" required>
				</div><br>
				<div class="input-group">
					<span style="min-width:250px" class="input-group-addon required" style="min-width:260px">Motivo del Viaje</span>
					<input class="form-control" style="background-color:white;" value="" id="motivo" required>
				</div><br>
				<div class="input-group">
					<span class="input-group-addon required">Días</span>
					<input class="form-control" style="background-color:white;" required value="1" id="dias" placeholder="# días" onkeyup="calculaFechas();">
					<span class="input-group-addon required">Desde</span>
					<input class="form-control" type="text" id="desde" value="<?= date('Y-m-d');?>" style="text-align:center;background-color:white" readonly required>
					<span class="input-group-addon required">Hasta</span>
					<input class="form-control" type="text" id="hasta" value="" style="text-align:center;background-color:white;" readonly required>
				</div><br>
				<div class="input-group">
					<span class="input-group-addon required">Orígen</span>
					<input class="form-control" style="background-color:white;" required value="" id="origen">
					<span class="input-group-addon required">Destino</span>
					<input class="form-control" type="text" id="destino" style="background-color:white;" value="" required>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon required">Conceptos que se Solicitan</span> 
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="hotel_flag" value=""> Hotel
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="autobus_flag" value=""> Autobús
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="gasolina_flag" value=""> Gasolina
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="mensajeria_flag" value=""> Mensajería
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="comida_flag" value=""> Comida
					</label><br>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="vuelo_flag" value=""> Vuelo
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="renta_flag" value=""> Renta de Auto
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="taxi_flag" value=""> Taxi
					</label>
					<label style="min-width:20%;float:left;" class="checkbox-inline">
						<input type="checkbox" id="taxi_aero_flag" value=""> Taxi Aeropuerto
					</label>
				</div>
			</div>
			<div class="col-md-6">
				<label class="radio-inline">
					<input type="radio" name="tipo_vuelo" id="redondo_flag" value="Redondo" checked> Viaje Redondo
				</label>
				<label class="radio-inline">
					<input type="radio" name="tipo_vuelo" id="sencillo_flag" value="Sencillo"> Viaje Sencillo
				</label>
				<table width="100%">
					<thead>
						<tr>
							<th></th><th><span class="input-group-addon required">Hora</span></th><th><span class="input-group-addon required">Fecha</span></th><th><span class="input-group-addon required">Ruta</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="25%"><span class="input-group-addon required">Salida</span></td>
							<td width="15%"><input class="form-control" type="time" id="hora_salida" required title="Formato de 24 hrs (p. ej. 07:00) <<Se tomará un rango de 1hr antes o después para la búsqueda>>" pattern="[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}"></td>
							<td width="20%"><input id="fecha_salida" type="text" class="form-control" style="background-color:white;" readonly required></td>
							<td><input id="ruta_salida" type="text" class="form-control" required></td>
						</tr>
					</tbody>
				</table><br>
				<table id="regreso" width="100%">
					<thead>
						<tr>
							<th></th><th><span class="input-group-addon required">Hora</span></th><th><span class="input-group-addon required">Fecha</span></th><th><span class="input-group-addon required">Ruta</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="25%"><span class="input-group-addon required">Regreso</span></td>
							<td width="15%"><input class="form-control" type="time" id="hora_regreso" title="Formato de 24 hrs (p. ej. 07:00) <<Se tomará un rango de 1hr antes o después para la búsqueda>>" pattern="[0-2]{1}[0-9]{1}:[0-5]{1}[0-9]{1}"></td>
							<td width="20%"><input id="fecha_regreso" type="text" class="form-control" style="background-color:white" readonly></td>
							<td><input id="ruta_regreso" type="text" class="form-control"></td>
						</tr>
					</tbody>
				</table>
				<br>
				<div class="input-group">
					<span class="input-group-addon required" style="min-width:170px">Zona de Hospedaje</span>
					<input style="min-width:300px" class="form-control" required value="" id="hospedaje">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon required" style="min-width:170px"># Plan de Recompensas</span>
					<input style="min-width:300px" class="form-control" value="" id="recompensas" placeholder="Opcional (Payback, Interjet)" pattern="[0-9]*" title="*Facilita la captura de tu información al realizar la compra del vuelo">
				</div>
				<br>
			</div>
		</div>
		<div class="row" align="center" id="botones">
			<div class="col-md-12">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button id="solicitar" type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;">Solicitar</button>
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
					data: {'colaborador':colaborador,'tipo':4},
					success: function(data){
						var returnedData = JSON.parse(data);
						$('#d_nomina').val(returnedData['nomina']);
						$('#d_area').val(returnedData['nombre_area']);
						$('#autorizador').val(returnedData['jefe']).selectpicker('refresh');
						$('#dias').val(1);
						$('#desde').val('<?= date('Y-m-d');?>');
						calculaFechas();
						$('#origen').val('');
						$('#destino').val('');
						$('#hotel_flag').prop('checked',false);
						$('#autobus_flag').prop('checked',false);
						$('#gasolina_flag').prop('checked',false);
						$('#mensajeria_flag').prop('checked',false);
						$('#comida_flag').prop('checked',false);
						$('#vuelo_flag').prop('checked',false);
						$('#renta_flag').prop('checked',false);
						$('#taxi_flag').prop('checked',false);
						$('#taxi_aero_flag').prop('checked',false);
						$('#hora_salida').val('');
						$('#fecha_salida').val('');
						$('#ruta_salida').val('');
						$('#hora_regreso').val('');
						$('#fecha_regreso').val('');
						$('#ruta_regreso').val('');
						$('#hospedaje').val('');
					},
					error: function(xhr) {
						console.log(xhr.responseText);
					}
				});
			}
		}
		function calculaFechas() {
			patron = /^\d*$/; 
			dias=parseInt($('#dias').val());
			if(dias > parseInt(5)){
				$('#hasta').val('');
			}else
				if (patron.test(dias) && dias > 0) {
					inicio=$('#desde').val();
					hasta=sumaFecha(dias,inicio);
					$('#hasta').val(hasta);
				}else{
					$('#hasta').val('');
				}
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
				dateFormat: 'yy-mm-dd',
				minDate: '<?= date("Y-m-d");?>'
			});
			$('#hasta').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('#fecha_salida').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('#fecha_regreso').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('input').tooltip();
			$("#desde").change(function() {
				calculaFechas();
			});

			$("#colaborador").change(function() {
				$('#dias').val('1');
				calculaFechas();
				getColaborador();
			});

			$("input[name=tipo_vuelo]").change(function() {
				if($("input[name=tipo_vuelo]:checked").val() == 'Sencillo'){
					$('#regreso').hide('slow');
					$('#hora_regreso').prop('required',false);
					$('#ruta_regreso').prop('required',false);
					$('#fecha_regreso').prop('required',false);
				}else{
					$('#regreso').show('slow');
					$('#hora_regreso').prop('required',true);
					$('#ruta_regreso').prop('required',true);
					$('#fecha_regreso').prop('required',true);
				}
			});

			$("#update").submit(function(event){
				if(!confirm('¿Seguro que desea enviar la solicitud?'))
					return false;
				//get form values
					$("#colaborador option:selected").each(function() {
						colaborador = $('#colaborador').val();
					});
					$("#autorizador option:selected").each(function() {
						autorizador = $('#autorizador').val();
					});
					centro = $('#centro').val();
					motivo = $('#motivo').val();
					dias = $('#dias').val();
					desde = $('#desde').val();
					hasta = $('#hasta').val();
					origen = $('#origen').val();
					destino = $('#destino').val();
					hotel_flag=0;
					autobus_flag=0;
					comida_flag=0;
					vuelo_flag=0;
					renta_flag=0;
					gasolina_flag=0;
					taxi_flag=0;
					mensajeria_flag=0;
					taxi_aero_flag=0;
					//flags
						if($('#hotel_flag').is(':checked'))
							hotel_flag=1;
						if($('#autobus_flag').is(':checked'))
							autobus_flag=1;
						if($('#renta_flag').is(':checked'))
							renta_flag=1;
						if($('#vuelo_flag').is(':checked'))
							vuelo_flag=1;
						if($('#comida_flag').is(':checked'))
							comida_flag=1;
						if($('#gasolina_flag').is(':checked'))
							gasolina_flag=1;
						if($('#taxi_flag').is(':checked'))
							taxi_flag=1;
						if($('#mensajeria_flag').is(':checked'))
							mensajeria_flag=1;
						if($('#taxi_aero_flag').is(':checked'))
							taxi_aero_flag=1;
					tipo_vuelo=$("input[name=tipo_vuelo]:checked").val();
					hora_salida = $('#hora_salida').val();
					fecha_salida = $('#fecha_salida').val();
					ruta_salida = $('#ruta_salida').val();
					hora_regreso = $('#hora_regreso').val();
					fecha_regreso = $('#fecha_regreso').val();
					ruta_regreso = $('#ruta_regreso').val();
					hospedaje = $('#hospedaje').val();
					recompensas = $('#recompensas').val();
				$.ajax({
					url: '<?= base_url("servicio/registra_solicitud");?>',
					type: 'post',
					data: {'colaborador':colaborador,'autorizador':autorizador,'centro':centro,'motivo':motivo,'dias':dias,'desde':desde,'hasta':hasta,'origen':origen,'destino':destino,'hotel_flag':hotel_flag,'autobus_flag':autobus_flag,'vuelo_flag':vuelo_flag,'renta_flag':renta_flag,'gasolina_flag':gasolina_flag,'taxi_flag':taxi_flag,'mensajeria_flag':mensajeria_flag,'comida_flag':comida_flag,'taxi_aero_flag':taxi_aero_flag,'tipo_vuelo':tipo_vuelo,'hora_salida':hora_salida,'fecha_salida':fecha_salida,'ruta_salida':ruta_salida,'hora_regreso':hora_regreso,'fecha_regreso':fecha_regreso,'ruta_regreso':ruta_regreso,'hospedaje':hospedaje,'recompensas':recompensas,'tipo':4},
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok"){
							alert('Se ha enviado la Solicitud para autorización');
							window.document.location='<?= base_url();?>';
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