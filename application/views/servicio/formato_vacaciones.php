<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Solicitud de Vacaciones</h2>
	</div>
</div>
<div class="container">
	<div align="center"><a style="cursor:pointer;" onclick="window.history.back();">&laquo;Regresar</a></div>
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
		<input type="hidden" value="" id="ochoMeses">
		<div class="row" align="center">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="input-group">
					<span class="input-group-addon">Colaborador</span>
					<select class="selectpicker" data-header="Selecciona al Colaborador" data-width="300px" data-live-search="true" 
						style="max-width:300px;text-align:center;" id="colaborador" required <?php if($this->session->userdata('tipo')<4) echo"disabled";?>>
						<option value="" disabled selected>-- Selecciona al Colaborador --</option>
						<?php foreach($colaboradores as $colaborador): ?>
							<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$this->session->userdata('id'))echo"selected";?>><?= $colaborador->nombre;?></option>
						<?php endforeach; ?>
					</select>
					<span class="input-group-addon">Jefe Directo / Líder</span>
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
				<label>DATOS</label>
				<div class="input-group">
					<span class="input-group-addon"># Nómina</span>
					<input class="form-control" style="max-width:100px;text-align:center;cursor:default;background-color: #fff" value="" id="d_nomina" disabled>
					<span class="input-group-addon">Área Actual</span>
					<input class="form-control" style="min-width:300px;text-align:center;cursor:default;background-color: #fff" value="" id="d_area" disabled>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Fecha de Ingreso</span>
					<input class="form-control" style="max-width:300px;text-align:center;cursor:default;background-color: #fff" value="" id="d_ingreso" disabled>
					<span class="input-group-addon">Antigüedad</span>
					<input class="form-control" style="max-width:300px;text-align:center;cursor:default;background-color: #fff" value="" id="d_antiguo" disabled>
				</div>
			</div>
		</div>
		<hr>
		<div class="row" align="center">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<br>
				<div class="input-group">
					<span class="input-group-addon" id="pendientes_label">Días del año en curso</span>
					<input class="form-control" style="max-width:80px;text-align:center;cursor:default;background-color: #fff" id="disponibles" disabled>
					<span class="input-group-addon">Días generados</span>
					<input class="form-control" style="max-width:80px;text-align:center;cursor:default;background-color: #fff" id="acumulados" 
						value="0" disabled>
						<span class="input-group-addon">Vencimiento</span>
					<input class="form-control" style="min-width:250px;text-align:center;cursor:default;background-color: #fff" id="vencimiento" 
						value="" disabled>
				</div>
				<br>
				<div id="generales">
					<label>DETALLE SOLICITUD</label>
					<div class="input-group">
						<span class="input-group-addon">Días</span>
						<input class="form-control" style="max-width:80px;text-align:center;background-color:white;cursor:default" required value="1" id="dias"
							placeholder="# días" onkeyup="calculaFechas();$('#auth').show('slow');">
						<span class="input-group-addon">Desde</span>
						<input class="form-control" type="text" id="desde" style="max-width:300px; text-align:center;background-color:white;cursor:default" 
							value="<?= date('Y-m-d');?>" required>
						<span class="input-group-addon">Hasta</span>
						<input class="form-control" type="text" id="hasta" style="max-width:300px; text-align:center;background-color:white;cursor:default" 
							value="" readonly required>
						<span class="input-group-addon">Regresa a Laborar</span>
						<input class="form-control" type="text" id="regresa" style="max-width:300px; text-align:center;background-color:white;cursor:default" 
							value="" readonly required>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon" style="min-width:260px">Observaciones</span>
						<textarea class="form-control" id="observaciones" rows="4" placeholder="Observaciones" 
							style="background-color:white;cursor:default" required></textarea>
					</div>
					<br>
				</div>
				<div id="auth" style="display:none;">
					<h2>Si tu solicitud se excede de la política de Vacaciones, se turnará al área de Capital Humano para validación final una vez que tu Jefe/Líder haya autorizado la misma</h2>
				</div>
				<br>
			</div>
		</div>
		<div class="row" align="right" id="botones">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button id="solicitar" type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Solicitar</button>
					<!--<button id="cancelar" type="button" class="btn" style="min-width:200px;text-align:center;display:none;">Cancelar</button>-->
				</div>
			</div>
		</div>
	</form>
	<script>
		function getColaborador() {
			$('#colaborador :selected').each(function(){
				colaborador=$('#colaborador').val();
			});
			if(colaborador != ""){
				$.ajax({
					url: '<?= base_url("servicio/getColabInfo");?>',
					type: 'post',
					data: {'colaborador':colaborador,'tipo':1},
					success: function(data){
						var returnedData = JSON.parse(data);
						$('#ochoMeses').val(returnedData['ochoMeses']);
						$('#autorizador').val(returnedData['jefe']);
						$('#autorizador').selectpicker('refresh');
						$('#disponibles').val(returnedData['disponibles']);
						if(returnedData['acumulados']['dias_acumulados'] > 0){
							$('#acumulados').val(returnedData['acumulados']['dias_acumulados']);
							$('#vencimiento').val(returnedData['acumulados']['dias_uno']+' días vencen el '+returnedData['acumulados']['vencimiento_uno']);
						}else{
							//$('#disponibles').val(returnedData['disponibles']+returnedData['acumulados']['dias_acumulados']);
							$('#acumulados').val('0');
							$('#vencimiento').val('');
						}
						$('#d_nomina').val(returnedData['nomina']);
						$('#d_area').val(returnedData['nombre_area']);
						$('#d_ingreso').val(returnedData['fecha_ingreso']);
						$('#d_antiguo').val(returnedData['diff']['y']+' años, '+returnedData['diff']['m']+' meses');
						antiguo=parseInt(returnedData['diff']['y'])*12 + parseInt(returnedData['diff']['m']);
						if(antiguo < 9)
							$('#auth').show('slow');
						else
							$('#auth').hide('slow');
						$('#dias').val('1');
						$('#desde').val(returnedData['fecha_minima']);
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
			dias=parseInt($('#dias').val());
			if(dias > 0){
				inicio=$('#desde').val();
				hasta=sumaFecha(dias,inicio);
				$('#hasta').val(hasta);
				$('#regresa').val(sumaFecha(dias+1,inicio));
			}else{
				$('#hasta').val('');
				$('#regresa').val('');
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
			$('#razon').hide('slow');
			calculaFechas();
			getColaborador();
			$('#desde').datepicker({
				dateFormat: 'yy-mm-dd',
				minDate: '<?= date("Y-m-d");?>'
			});
			$('#hasta').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('#regresa').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			$('#hasta').change(function() {
				hasta=$('#hasta').val();
				regresa=sumaFecha(2,hasta);
				$('#regresa').val(regresa);
			});

			$("#desde").change(function() {
				calculaFechas();
				$('#auth').show('slow');
			});

			$("#colaborador").change(function() {
				getColaborador();
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
					dias = $('#dias').val();
					acumulados = $('#acumulados').val();
					disponibles = $('#disponibles').val();
					desde = $('#desde').val();
					hasta = $('#hasta').val();
					regresa = $('#regresa').val();
					observaciones = $('#observaciones').val();
					ochoMeses=$('#ochoMeses').val();
				$.ajax({
					url: '<?= base_url("servicio/registra_solicitud");?>',
					type: 'post',
					data: {'colaborador':colaborador,'autorizador':autorizador,'dias':dias,'desde':desde,'hasta':hasta,'regresa':regresa,
						'observaciones':observaciones,'tipo':1,'ochoMeses':ochoMeses,'disponibles':disponibles,'acumulados':acumulados},
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok")
							window.document.location='<?= base_url("solicitudes");?>';
						else{
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