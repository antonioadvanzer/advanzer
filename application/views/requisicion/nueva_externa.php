<div class="jumbotron">
	<div class="container">
		<h2>Requisición de Personal - Colocación Externa</h2>
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
	<input id="id" type="hidden" value="">
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
		<div class="row" align="center">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<br>
				<div class="input-group">
					<span class="input-group-addon">Autorizador</span>
					<input readonly value="JULIO VALENTE LUNA ALATORRE" class="form-control" style="max-width:40%;background-color:white;">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Fecha de Solicitud</span>
					<input data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" type="text" id="solicitud" 
						style="text-align:center;background-color:white" value="<?= date('Y-m-d');?>" readonly required>
					<span class="input-group-addon">Fecha Estimada de Ingreso</span>
					<input data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" type="text" id="fecha_estimada" 
						style="text-align:center;background-color:white" value="<?= date('Y-m-d');?>" readonly required>
				</div>
				<br>
				<label>Información del Cliente</label>
				<div class="input-group">
					<span class="input-group-addon">Empresa</span>
					<input type="text" id="empresa" class="form-control" required>
					<span class="input-group-addon">Dirección</span>
					<input type="text" id="domicilio_cte" class="form-control" required>
				</div><br>
				<div class="input-group">
					<span class="input-group-addon">Contacto</span>
					<input type="text" id="contacto" class="form-control" required>
					<span class="input-group-addon">Teléfono</span>
					<input type="text" id="telefono_contacto" class="form-control" required>
				</div><br>
				<div class="input-group">
					<span class="input-group-addon">Celular</span>
					<input type="text" id="celular_contacto" class="form-control" required>
					<span class="input-group-addon">Email</span>
					<input type="email" class="form-control" value="" id="email_contacto" required>
				</div><br>
				<label>Datos de la Posición</label>
				<div class="input-group">
					<span class="input-group-addon">Posición Solicitada</span>
					<input class="form-control" required value="" id="posicion">
					<span class="input-group-addon">Nivel de Expertise</span>
					<select id="expertise" class="form-control">
						<option>JUNIOR</option>
						<option>SENIOR</option>
						<option>GERENTE</option>
					</select>
				</div><br>
				<div class="input-group">
					<span class="input-group-addon">Duración de la Asignación</span>
					<select id="contratacion" class="form-control">
						<option>INDETERMINADO</option>
						<option>3 MESES</option>
						<option>6 MESES</option>
						<option>9 MESES</option>
						<option>12 MESES</option>
						<option>DURACIÓN DEL PROYECTO</option>
					</select>
					<span class="input-group-addon">Tarifa Mensual del Cliente</span>
					<input class="form-control" value="" id="costo_maximo_cliente"pattern="[0-9]+" title="Introduce un número entero">
					<span class="input-group-addon">más IVA</span>
				</div><br>
			</div>
		</div>
		<div class="row" align="right">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Guardar</button>
					<button onclick="window.history.back();" type="button" class="btn" style="min-width:200px;text-align:center;display:inline;">Cancelar</button>
				</div>
			</div>
		</div>
	</form>
	<script>
		$(document).ready(function() {
			//changes
				$('#solicitud').datepicker({
					dateFormat: 'yy-mm-dd'
				});
				$('#fecha_estimada').datepicker({
					dateFormat: 'yy-mm-dd'
				});

			$("#update").submit(function(event){
				event.preventDefault();
				if(!confirm('SE ESTÁ ENVIANDO LA REQUISICIÓN PARA SU AUTORIZACIÓN Y CALCULO DE TARIFA MENSUAL, SE TE NOTIFICARÁ VÍA EMAIL CUANDO SE TENGA UNA RESOLUCIÓN'))
					return false;
				//get form values
					data={};
					data['director_area'] = 2;
					data['autorizador'] = 2;
					data['solicitud'] = $('#solicitud').val();
					data['fecha_estimada'] = $('#fecha_estimada').val();
					data['empresa'] = $('#empresa').val();
					data['domicilio_cte'] = $('#domicilio_cte').val();
					data['contacto'] = $('#contacto').val();
					data['telefono_contacto'] = $('#telefono_contacto').val();
					data['celular_contacto'] = $('#celular_contacto').val();
					data['email_contacto'] = $('#email_contacto').val();
					data['posicion'] = $('#posicion').val();
					$("#expertise option:selected").each(function() {
						data['expertise'] = $('#expertise').val();
					});
					$("#contratacion option:selected").each(function() {
						data['contratacion'] = $('#contratacion').val();
					});
					data['costo_maximo_cliente'] = $('#costo_maximo_cliente').val();
					data['tipo'] = 2;
				$.ajax({
					url: '<?= base_url("requisicion/guardar");?>',
					type: 'post',
					data: data,
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						if(returnedData['msg']=="ok"){
							alert('Se ha enviado para autorización');
							window.document.location='<?= base_url("requisicion");?>';
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
						console.log(xhr.responseText);
						$('#cargando').hide('slow');
						$('#update').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				});
			});
		});
	</script>