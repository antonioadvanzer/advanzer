<style type="text/css">
	#carousel {
		-moz-box-shadow: 0px 0px 20px #000; 
		-webkit-box-shadow: 0px 0px 20px #000; 
		box-shadow: 0px 0px 20px #000;
	}
</style>
<div class="jumbotron">
	<div class="container">
		<h2 style="cursor:default;">Seguimiento de Evaluación - <?= $evaluacion->nombre;?></h2>
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
	<div id="carousel" class="carousel slide" data-wrap="false" data-ride="carousel" data-interval="false">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel" data-slide-to="0" class="active"></li>
			<li data-target="#carousel" data-slide-to="1"></li>
			<li data-target="#carousel" data-slide-to="2"></li>
			<li data-target="#carousel" data-slide-to="3"></li>
			<li data-target="#carousel" data-slide-to="4"></li>
			<li data-target="#carousel" data-slide-to="5"></li>
			<li data-target="#carousel" data-slide-to="6"></li>
			<li data-target="#carousel" data-slide-to="7"></li>
			<li data-target="#carousel" data-slide-to="8"></li>
		</ol>
		<div class="carousel-inner" style="background-color:#dedede;" role="listbox">
			<div class="item active" align="center" style="min-height:300px;">
				<img height="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/evaluacion.jpg');?>">
				<div class="carousel-caption">
					<h3 style="cursor:default;"><?php switch($evaluacion->estatus){ case 0:echo"Comenzar Evaluación";break;
						case 1:echo"Continuar Evaluación...";break;}?></h3>
				</div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Llevó a cabo acciones que permitieron eficientar los gastos del proyecto en el que participó, así como 
								aprovechar al máximo los recursos disponibles.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:60px;text-align:center" 
								onchange="verify(this);">
								<option value="5" <?php if($evaluacion->costo && $evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo && $evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo && $evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo && $evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo && $evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion1" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Costo</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Cumplió con los plazos acordados para la entrega de información requerida.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:300px;text-align:center">
								<option value="5" <?php if($evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Tiempo</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Realizo cada una de sus actividades y/o asignaciones con el nivel de excelencia requerido.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:300px;text-align:center">
								<option value="5" <?php if($evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Calidad</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Entregó los productos comprometidos cumpliendo con las especificaciones acordadas/necesarias.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:300px;text-align:center">
								<option value="5" <?php if($evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Entregables</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Desarrolló vínculos efectivos de colaboración con cada uno de los clientes a los que les dio servicio, 
								sin importar que fueran internos o externos.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:300px;text-align:center">
								<option value="5" <?php if($evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Relación con Clientes</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Capitalizó su interacción con el cliente externo para identificar y sugerir/plantear alguna oportunidad 
								comercial.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:300px;text-align:center">
								<option value="5" <?php if($evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Generación de Negocio</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>Demostró la expertise necesaria (conocimientos, aptitudes, destrezas, etc.) para dar respuesta a las 
								demandas del proyecto/asignación.</label>
							<select id="respuesta" name="estatus" class="form-control" style="max-width:300px;text-align:center">
								<option value="5" <?php if($evaluacion->costo->respuesta==5) echo "selected"; ?>>5</option>
								<option value="4" <?php if($evaluacion->costo->respuesta==4) echo "selected"; ?>>4</option>
								<option value="3" <?php if($evaluacion->costo->respuesta==3) echo "selected"; ?>>3</option>
								<option value="2" <?php if($evaluacion->costo->respuesta==2) echo "selected"; ?>>2</option>
								<option value="1" <?php if($evaluacion->costo->respuesta==1) echo "selected"; ?>>1</option>
							</select>
						</div>
					</div>
					<div class="col-md-12" id="justifica">
						<div class="form-group" align="center">
							<label>Justifique su respuesta</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center" required></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption"><h3 style="cursor:default;">Habilidades</h3></div>
			</div>
			<div class="item" align="center" style="min-height:300px;">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/gracias.jpg');?>">
				<div style="width:60%;position:absolute;top:10%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<label>¿Tienes algún comentario adicional para el colaborador?</label>
							<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center"></textarea>
						</div>
					</div>
				</div>
				<div class="carousel-caption" align="center">
					<button id="finalizar" class="btn btn-lg btn-primary" onclick="finalizar(<?= $evaluacion->id;?>,<?= $evaluacion->tipo;?>);" 
					style="max-width:200px; text-align:center;">Enviar Evaluación</button>
					<h3 style="cursor:default;">Gracias por tu tiempo...!</h3>
				</div>
			</div>
		</div>
		<!-- Controls -->
		<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#finalizar').hide();
			revisar();
		});
		function revisar() {
			flag=true;
			$('[id^=resp] option:selected').each(function(i,select) {
				console.log($(select).val());
				if($(select).val() == ""){
					flag = false;
				}
			});
			if(flag)
				$('#finalizar').show();
		}

		function verify(select) {
			if (select.value != 3) {
				alert('Justifica tu respuesta porfavor');
			};
		}

		function finalizar(asignacion,tipo) {
			console.log(asignacion,tipo);
			if(confirm('Una vez que haya enviado ésta evaluación no será posible editarla. ¿Seguro(a) que desea enviarla?'))
				$.ajax({
					url: '<?= base_url("evaluacion/finalizar_evaluacion");?>',
					type: 'post',
					data: {'asignacion':asignacion,'tipo':tipo},
					success: function(data){
						console.log(data);
						var returnData = JSON.parse(data);
						if(returnData['redirecciona'] == "si"){
							alert(returnData['msg'])
							location.href="<?= base_url('evaluar');?>";
						}
					}
				});
		}
		function guardar(valor,elemento,tipo) {
			var asignacion = <?= $evaluacion->id;?>;
			console.log(valor.value,tipo,asignacion,elemento);
			$.ajax({
				url: '<?= base_url("evaluacion/guardar_avance");?>',
				type: 'post',
				data: {'asignacion':asignacion,'tipo':tipo,'valor':valor.value,'elemento':elemento},
				success: function(data){
					var returnedData = JSON.parse(data);
					revisar();
					console.log(returnedData);
				}
			});
		}
	</script>