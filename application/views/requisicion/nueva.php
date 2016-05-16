<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Requisición de Personal</h2>
		<ul>
			<li>Sea claro en sus necesidades, esto facilitará la labor en la búsqueda del candidato que cubra de la mejor manera su requerimiento.</li>
		</ul>
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
					<span class="input-group-addon">Director de Área</span>
					<select class="form-control" id="director_area" required name="director_area">
						<option value="" selected disabled>-- Selecciona un Director --</option>
						<option value="40">MICAELA LLANO AGUILAR</option>
						<?php if(isset($directores)) foreach($directores as $director): ?>
							<option value="<?= $director->id;?>"><?= $director->nombre;?></option>
						<?php endforeach; ?>
					</select>
					<span class="input-group-addon">Autorizador</span>
					<select class="form-control" id="autorizador" name="autorizador">
						<option value="" selected disabled>-- Selecciona un Autorizador --</option>
						<option value="1">MAURICIO CRUZ VELÁZQUEZ DE LEÓN</option>
						<option value="2">JULIO VALENTE LUNA ALATORRE</option>
						<option value="51">JOSÉ LUIS PERALTA</option>
					</select>
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
				<div class="input-group">
					<span class="input-group-addon">Área</span>
					<select id="area" class="form-control" style="text-align:center;" required>
						<option value="" disabled selected>-- Selecciona un área --</option>
						<?php foreach ($areas as $area) : ?>
							<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
						<?php endforeach; ?>
					</select>
					<span class="input-group-addon">Track</span>
					<select class="form-control" style="text-align:center" id="track" required>
						<option value="" disabled selected>-- Selecciona un track --</option>
						<?php foreach ($tracks as $track) : ?>
							<option value="<?= $track->id;?>"><?= $track->nombre;?></option>
						<?php endforeach; ?>
					</select>
					<span class="input-group-addon">Posición</span>
					<select id="posicion" class="form-control" style="max-width:300px; text-align:center;" required>
						<option value="" disabled selected>-- Selecciona una posición --</option>
						<?php foreach ($posiciones as $posicion) : ?>
							<option value="<?= $posicion->id;?>"><?= $posicion->nombre;?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Empresa</span>
					<select id="empresa" class="form-control" style="text-align:center;" required>
						<option value="" selected disabled>-- Selecciona una empresa --</option>
						<option value="1">Advanzer</option>
						<option value="2">Entuizer</option>
					</select>
					<span class="input-group-addon">Tipo</span>
					<select id="tipo" class="form-control" style="text-align:center;">
						<option value="1"selected>Posición Nueva</option>
						<option value="2">Sustitución</option>
					</select>
					<span class="input-group-addon">Sustituye a:</span>
					<input type="text" id="sustituye_a" style="background-color:white;" class="form-control" disabled>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Proyecto</span>
					<input class="form-control" required value="" id="proyecto">
					<span class="input-group-addon">Clave del Proyecto</span>
					<input class="form-control" value="" id="clave">
					<span class="input-group-addon">Costo Máximo</span>
					<select id="costo" class="form-control">
						<option>DE ACUERDO A TABULADOR</option>
						<option>DEFINIR</option>
					</select>
					<span class="input-group-addon">Define</span>
					<input class="form-control" value="" id="costo_maximo" style="background-color:white;" disabled pattern="[0-9]+" placeholder="Número entero" title="Introduce un número entero">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Residencia</span>
					<select id="residencia" class="form-control">
						<option>MTY</option>
						<option>CDMX</option>
						<option>INDISTINTO</option>
						<option value="">OTRO...</option>
					</select>
					<span class="input-group-addon">Especifique</span>
					<input class="form-control" style="background-color:white" disabled value="" id="residencia_otro">
					<span class="input-group-addon">Lugar de Trabajo</span>
					<select id="lugar_trabajo" class="form-control">
						<option>OFICINAS MTY-CDMX</option>
						<option>OFICINAS DEL CLIENTE</option>
						<option>AMBOS</option>
					</select>
					<span class="input-group-addon">Domicilio del Cliente</span>
					<input class="form-control" style="background-color:white" disabled value="" id="domicilio_cte">
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Contratación</span>
					<select id="contratacion" class="form-control">
						<option>INDETERMINADO</option>
						<option>3 MESES</option>
						<option>6 MESES</option>
						<option>9 MESES</option>
						<option>12 MESES</option>
						<option>DURACIÓN DEL PROYECTO</option>
					</select>
					<span class="input-group-addon">Evaluador Técnico</span>
					<input type="text" class="form-control" id="entrevista" required>
					<span class="input-group-addon">Disponibilidad p/Viajar</span>
					<select id="disp_viajar" class="form-control">
						<option>INDISTINTO</option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Edad de</span>
					<select id="edad_uno" class="form-control" onchange="$('#edad_dos').val($(this).val());">
						<?php for($i=20;$i<=50;$i++): ?>
							<option><?= $i;?></option>
						<?php endfor;?>
					</select>
					<span class="input-group-addon">a</span>
					<select id="edad_dos" class="form-control">
						<?php for($i=20;$i<=50;$i++): ?>
							<option><?= $i;?></option>
						<?php endfor;?>
					</select>
					<span class="input-group-addon">Sexo</span>
					<select id="sexo" class="form-control">
						<option>INDISTINTO</option>
						<option>HOMBRE</option>
						<option>MUJER</option>
					</select>
					<span class="input-group-addon">Nivel de estudios</span>
					<select id="nivel" class="form-control">
						<option>PRACTICANTE</option>
						<option>PASANTE</option>
						<option>TÉCNICO</option>
						<option selected>LICENCIATURA/INGENIERÍA</option>
						<option>MAESTRÍA</option>
						<option>DOCTORADO</option>
					</select>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Carrera</span>
					<input class="form-control" required value="" id="carrera">
					<span class="input-group-addon">Inglés Oral</span>
					<select id="ingles_hablado" class="form-control" required>
						<option>Excelente</option>
						<option selected>Bueno</option>
						<option>Básico</option>
					</select>
					<span class="input-group-addon">Inglés Lectura</span>
					<select id="ingles_lectura" class="form-control" required>
						<option>Excelente</option>
						<option selected>Bueno</option>
						<option>Básico</option>
					</select>
					<span class="input-group-addon">Inglés Escritura</span>
					<select id="ingles_escritura" class="form-control" required>
						<option>Excelente</option>
						<option selected>Bueno</option>
						<option>Básico</option>
					</select>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon" style="min-width:260px">Experiencia / Conocimientos en</span>
					<textarea class="form-control" required id="experiencia" rows="4" 
						placeholder="Áreas que debe dominar para la vacante."></textarea>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon" style="min-width:260px">Características / Habilidades Deseadas</span>
					<textarea class="form-control" required id="habilidades" rows="4" 
						placeholder="Habilidades deseadas que el/la aspirante cubra para la vacante."></textarea>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon" style="min-width:260px">Funciones a Desempeñar</span>
					<textarea class="form-control" required id="funciones" rows="4" 
						placeholder="Responsabilidades que realizará en la posición."></textarea>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon" style="min-width:260px">Observaciones</span>
					<textarea class="form-control" id="observaciones" rows="4" 
						placeholder="Consideraciones adicionales a tomar en cuenta para la búsqueda de personal."></textarea>
				</div>
				<br>
			</div>
		</div>
		<div class="row" align="right">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Enviar</button>
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

				$("#residencia").change(function() {
					$("#residencia option:selected").each(function() {
						residencia = $('#residencia').val();
					});
					if(residencia!="")
						$('#residencia_otro').prop({'required':false,'disabled':true}).val('');
					else
						$('#residencia_otro').prop({'required':true,'disabled':false}).val('');
				});

				$("#tipo").change(function() {
					$("#tipo option:selected").each(function() {
						tipo = $('#tipo').val();
					});
					if(tipo==1)
						$('#sustituye_a').prop({'required':false,'disabled':true}).val('');
					else
						$('#sustituye_a').prop({'required':true,'disabled':false}).val('');
				});
				
				$("#costo").change(function() {
					$("#costo option:selected").each(function() {
						costo = $('#costo').val();
					});
					if(costo!='DEFINIR')
						$('#costo_maximo').prop({'required':false,'disabled':true}).val('');
					else
						$('#costo_maximo').prop({'required':true,'disabled':false}).val('');
				});
				
				$("#lugar_trabajo").change(function() {
					$("#lugar_trabajo option:selected").each(function() {
						lugar_trabajo = $('#lugar_trabajo').val();
					});
					if(lugar_trabajo!='OFICINAS DEL CLIENTE' && lugar_trabajo!='AMBOS')
						$('#domicilio_cte').prop({'required':false,'disabled':true}).val('');
					else
						$('#domicilio_cte').prop({'required':true,'disabled':false}).val('');
				});

				$("#track").change(function() {
					$("#track option:selected").each(function() {
						track = $('#track').val();
					});
					$.ajax({
						url: '<?= base_url("user/load_posiciones");?>',
						type: 'post',
						data: {'track':track},
						success: function(data){
							$("#posicion").html(data);
						},
						error: function(xhr) {
							console.log(xhr);
						}
					});
				});

				$("#director_area").change(function() {
					$("#director_area option:selected").each(function() {
						director = $('#director_area').val();
					});
					if(director == 1 || director == 2 || director == 51)
						$('#autorizador').val(director).prop('disabled',true);
					else
						$('#autorizador').val('').prop('disabled',false);
				});

			$("#update").submit(function(event){
				event.preventDefault();
				if(!confirm('¿Seguro que desea enviar la requisición?'))
					return false;
				//get form values
					data={};
					$("#director_area option:selected").each(function() {
						data['director_area'] = $('#director_area').val();
					});
					$("#autorizador option:selected").each(function() {
						data['autorizador'] = $('#autorizador').val();
					});
					data['solicitud'] = $('#solicitud').val();
					data['fecha_estimada'] = $('#fecha_estimada').val();
					$("#area option:selected").each(function() {
						data['area'] = $('#area').val();
					});
					$("#track option:selected").each(function() {
						data['track'] = $('#track').val();
					});
					$("#posicion option:selected").each(function() {
						data['posicion'] = $('#posicion').val();
					});
					$("#empresa option:selected").each(function() {
						data['empresa'] = $('#empresa').val();
					});
					$("#tipo option:selected").each(function() {
						data['tipo'] = $('#tipo').val();
					});
					data['sustituye_a'] = $('#sustituye_a').val();
					data['proyecto'] = $('#proyecto').val();
					data['clave'] = $('#clave').val();
					$("#costo option:selected").each(function() {
						data['costo'] = $('#costo').val();
					});
					if(data['costo']=='DEFINIR')
						data['costo']=$('#costo_maximo').val();
					$("#residencia option:selected").each(function() {
						data['residencia'] = $('#residencia').val();
					});
					if(residencia=="")
						data['residencia']=$('#residencia_otro').val();
					$("#lugar_trabajo option:selected").each(function() {
						data['lugar_trabajo'] = $('#lugar_trabajo').val();
					});
					data['domicilio_cte'] = $('#domicilio_cte').val();
					$("#contratacion option:selected").each(function() {
						data['contratacion'] = $('#contratacion').val();
					});
					data['entrevista'] = $('#entrevista').val();
					$("#disp_viajar option:selected").each(function() {
						data['disp_viajar'] = $('#disp_viajar').val();
					});
					$("#edad_uno option:selected").each(function() {
						data['edad_uno'] = $('#edad_uno').val();
					});
					$("#edad_dos option:selected").each(function() {
						data['edad_dos'] = $('#edad_dos').val();
					});
					$("#sexo option:selected").each(function() {
						data['sexo'] = $('#sexo').val();
					});
					$("#nivel option:selected").each(function() {
						data['nivel'] = $('#nivel').val();
					});
					data['carrera'] = $('#carrera').val();
					$("#ingles_hablado option:selected").each(function() {
						data['ingles_hablado'] = $('#ingles_hablado').val();
					});
					$("#ingles_lectura option:selected").each(function() {
						data['ingles_lectura'] = $('#ingles_lectura').val();
					});
					$("#ingles_escritura option:selected").each(function() {
						data['ingles_escritura'] = $('#ingles_escritura').val();
					});
					data['experiencia'] = $('#experiencia').val();
					data['habilidades'] = $('#habilidades').val();
					data['funciones'] = $('#funciones').val();
					data['observaciones'] = $('#observaciones').val();
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