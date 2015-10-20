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
			<?php for ($i=1; $i <= count($evaluacion->dominios); $i++) : ?>
				<li data-target="#carousel" data-slide-to="<?= $i;?>"></li>
			<?php endfor; ?>
			<li data-target="#carousel" data-slide-to="<?= count($evaluacion->dominios)+1;?>"></li>
		</ol>
		<div class="carousel-inner" style="background-color:#dedede;" role="listbox">
			<div class="item active" align="center" style="min-height:300px;">
				<img height="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/evaluacion.jpg');?>">
				<div class="carousel-caption">
					<h3 style="cursor:default;"><?php switch($evaluacion->estatus){ case 0:echo"Comenzar Evaluación";break;
						case 1:echo"Continuar Evaluación...";break;}?></h3>
				</div>
			</div>
			<?php foreach ($evaluacion->dominios as $dominio) : ?>
				<div class="item" align="center" style="min-height:300px;">
					<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
						<form onsubmit="return verify(this);" action="javascript:" class="form-signin" role="form">
							<input type="hidden" value="<?= $dominio->id;?>" id="dominio">
							<input type="hidden" value="<?= $evaluacion->id;?>" id="asignacion">
							<div class="col-md-12">
								<div class="form-group" align="center">
									<label><?= $dominio->descripcion;?></label>
									<select id="respuesta" name="estatus" class="form-control" style="max-width:60px;text-align:center"
										onchange="verify(this.form);" required>
										<option value="" selected disabled>--</option>
										<?php for ($i=5; $i > 0; $i--) : ?>
											<option value="<?= $i;?>" <?php if($dominio->respuesta==$i)echo"selected";?>><?= $i;?></option>
										<?php endfor; ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group" align="center">
									<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center;
										<?php if($dominio->respuesta == 3 || $dominio->respuesta == 0)echo'display:none;';?>" 
										onkeyup="if(this.value.split(' ').length >= 4){ this.form.boton.style.display='';
											}else{ this.form.boton.style.display='none';}" placeholder="Justifique su respuesta"
										required><?= $dominio->justificacion;?></textarea>
								</div>
								<div class="form-group" align="center">
									<input id="boton" class="btn btn-lg btn-primary btn-block" style="display:none;max-width:200px;
										text-align:center;" type="submit" value="Guardar">
								</div>
							</div>
						</form>
					</div>
					<div class="carousel-caption"><h3 style="cursor:default;"><?= $dominio->nombre;?></h3></div>
				</div>
			<?php endforeach; ?>
			<div class="item" align="center" style="min-height:300px;">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/gracias.jpg');?>">
				<form onsubmit="return finalizar(<?= $evaluacion->id;?>,<?= $evaluacion->tipo;?>);" class="form-signin" 
					action="javascript:" id="finalizar">
					<div style="width:60%;position:absolute;top:10%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
						<div class="col-md-12">
							<div class="form-group" align="center" id="finalizar">
								<label>Escribe un comentario adicional respecto al desempeño del colaborador en el Proyecto</label>
								<textarea id="comentarios" class="form-control" rows="2" style="max-width:300px;text-align:center" 
									required><?= $evaluacion->comentarios;?></textarea>
							</div>
						</div>
					</div>
					<div class="carousel-caption" align="center">
						<button class="btn btn-lg btn-primary" style="max-width:200px; text-align:center;">Enviar Evaluación</button>
						<h3 style="cursor:default;">Gracias por tu tiempo...!</h3>
					</div>
				</form>
			</div>
		</div>
		<!-- Controls -->
		<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('[id^=finalizar]').hide();
			revisar();
		});
		function revisar() {
			flag=true;
			$('[id^=respuesta] option:selected').each(function(i,select) {
				if($(select).val() == ""){
					flag = false;
				}
			});
			if(flag)
				$('[id^=finalizar]').show();
		}

		function verify(form) {
			var respuesta = form.respuesta.options[form.respuesta.selectedIndex].value;
			if (respuesta != 3 && form.justificacion.value.split(' ').length < 4)
				form.justificacion.style.display='';
			else{
				if(respuesta==3){
					form.justificacion.value="";
					form.justificacion.style.display='none';
				}
				var asignacion = form.asignacion.value;
				var dominio = form.dominio.value;
				var justificacion = form.justificacion.value;
				console.log(asignacion,dominio,respuesta,justificacion);
				$.ajax({
					url: '<?= base_url("evaluacion/guardar_avanceProyecto");?>',
					type: 'post',
					data: {'asignacion':asignacion,'dominio':dominio,'respuesta':respuesta,'justificacion':justificacion},
					beforeSend: function (xhr) {
						$('#carousel').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						revisar();
						console.log(returnedData);
						form.boton.style.display='none';
						$('#cargando').hide('slow');
						$('#carousel').show('slow');
					}
				});
			}
			return false;
		}

		function finalizar(asignacion,tipo) {
			console.log(asignacion,tipo);
			if(confirm('Una vez que haya enviado ésta evaluación no será posible editarla. ¿Seguro(a) que desea enviarla?'))
				$.ajax({
					url: '<?= base_url("evaluacion/finalizar_evaluacion");?>',
					type: 'post',
					data: {'asignacion':asignacion,'tipo':tipo,'comentarios':$('#comentarios').val()},
					beforeSend: function (xhr) {
						$('#carousel').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						console.log(data);
						var returnData = JSON.parse(data);
						$('#cargando').hide('slow');
						if(returnData['redirecciona'] == "si"){
							alert(returnData['msg'])
							location.href="<?= base_url('evaluar');?>";
						}
					},
					error: function(data){
						console.log(data.status,data.responseText);
					}
				});
			return false;
		}
	</script>