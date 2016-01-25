<style type="text/css">
	#carousel {
		-moz-box-shadow: 0px 0px 20px #000; 
		-webkit-box-shadow: 0px 0px 20px #000; 
		box-shadow: 0px 0px 20px #000;
	}
</style>
<div class="jumbotron">
	<div class="container">
		<h2 style="cursor:default;"><?= $evaluacion->nombre;?></h2>
		<p><small>Evaluando a: <i><?= $colaborador->nombre;?></i></small></p>
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
			<?php for ($i=1; $i <= count($evaluacion->dominios); $i++) : ?>
				<li data-target="#carousel" data-slide-to="<?= $i+1;?>"></li>
			<?php endfor; ?>
			<li data-target="#carousel" data-slide-to="<?= count($evaluacion->dominios)+2;?>"></li>
		</ol>
		<div class="carousel-inner" style="background-color:#dedede;" role="listbox">
			<div class="item active" align="center" style="min-height:550px;">
				<img height="100%" style="opacity:0.1;position:absolute" src="<?= base_url('assets/images/evaluacion.jpg');?>">
				<div style="display:block;width:60%;position:absolute;top:20%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<h2><b>Indicaciones</b></h2><hr>
					<h4 align="left"><li>Recuerda evaluar objetivamente tomando en cuenta el desempeño durante la duración del proyecto</li>
						<li>Si tu respuesta es diferente a "<i>3</i>"" es indispensable justificar tu respuesta y darle clic a "<i>guardar</i>".</li>
						<li>Son indispensables al menos 3 palabras para que se active la opción de "<i>guardar</i>"</li>
						<li>Si deseas suspender la evaluación y continuar más tarde, asegúrate de darle "<i>guardar</i>" a todas tus respuestas 
							diferentes a "<i>3</i>" para conservar tu avance.</li>
						<li>Al retomar la evaluación, se resaltarán los reactivos pendientes de respuesta</li>
						<li>Antes de terminar y para poder enviar y cerrar cada evaluación se te solicitarán comentarios generales. Esto es, 
							un resumen breve de lo más relevante del desempeño del evaluado</li>
					</h4>
				</div>
				<!--<div class="carousel-caption">
					<h3 style="cursor:default;"><?php switch($evaluacion->estatus){ case 0:echo"Comenzar Evaluación";break;
						case 1:echo"Continuar Evaluación...";break;}?></h3>
				</div>-->
			</div>
			<div class="item" align="center" style="min-height:400px">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/responsabilidades.jpg');?>">
				<div style="width:60%;position:absolute;top:3%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<h2>Selecciona la métrica para cada dominio de acuerdo a lo siguiente:</h2><br>
					<h4 align="left">
						5. Es un modelo a seguir para toda la organización<br>
						4. Excede las expectativas<br>
						3. Cumple las expectativas al 100%<br>
						2. Cumple parcialmente las expectativas<br>
						1. No cumple las expectativas<br>
					</h4>
					<h4>Recuerda que debes justificar cada respuesta diferente a <i>3</i> y darle clic a "<i>guardar</i>" 
						para no perder tu avance.</h4>
				</div>
			</div>
			<?php foreach ($evaluacion->dominios as $dominio) : ?>
				<div class="item" align="center" style="min-height:400px;">
					<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
						<form id="mark" onsubmit="return verify(this);" action="javascript:" class="form-signin" role="form">
							<input type="hidden" value="<?= $dominio->id;?>" id="dominio">
							<input type="hidden" value="<?= $evaluacion->id;?>" id="asignacion">
							<div class="col-md-12">
								<div class="form-group" align="center">
									<label><?= $dominio->descripcion;?></label>
								</div>
							</div>
							<div class="col-md-12" id="naranja">
								<div class="form-group" align="center">
									<i>Respuesta</i>:
									<select id="respuesta" name="estatus" class="form-control" style="max-width:70px;text-align:center"
										onchange="this.form.boton.style.display='';
											if(this.options[this.selectedIndex].value == 3){
												this.form.justificacion.value='';
												this.form.justificacion.removeAttribute('required');}
											else{
												this.form.justificacion.setAttribute('required','required');
												this.form.justificacion.focus();
												if(this.form.justificacion.value.trim().split(' ').length >= 3)
													this.form.boton.removeAttribute('disabled');
											}
											verify(this.form);" required>
										<option value="" selected disabled>--</option>
										<?php for ($i=5; $i > 0; $i--) : ?>
											<option value="<?= $i;?>" <?php if($dominio->respuesta==$i)echo"selected";?>><?= $i;?></option>
										<?php endfor; ?>
									</select>
									<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center;" 
										onkeydown="if(this.value.trim().split(' ').length >= 3){ this.form.boton.removeAttribute('disabled');
											}else{ this.form.boton.setAttribute('disabled','disabled');}" placeholder="Justifique su respuesta"
										required><?= $dominio->justificacion;?></textarea>
								</div>
								<div class="form-group" align="center">
									<input id="boton" class="btn btn-lg btn-primary btn-block" style="max-width:200px;
										<?php if(!$dominio->respuesta) echo "display:none;"?>
										text-align:center;" type="submit" value="Guardar" disabled="">
								</div>
							</div>
						</form>
					</div>
					<div class="carousel-caption"><h3 style="cursor:default;"><?= $dominio->nombre;?></h3></div>
				</div>
			<?php endforeach; ?>
			<div class="item" align="center" style="min-height:400px;">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/gracias.jpg');?>">
				<div style="width:60%;position:absolute;top:15%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;"
					id="mensaje">
					<div class="col-md-12">
						<div class="form-group" align="center">
							<h2><b>Tienes reactivos pendientes por responder.</b></h2><hr>
							<h3>Revisa detenidamente los Dominios para que puedas finalizar esta evaluación</h3>
						</div>
					</div>
				</div>
				<form class="form-signin" action="javascript:" id="finalizar">
					<input id="finalizar_asignacion" type="hidden" value="<?= $evaluacion->id;?>">
					<input id="finalizar_tipo" type="hidden" value="<?= $evaluacion->tipo;?>">
					<div style="width:60%;position:absolute;top:10%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
						<div class="col-md-12">
							<div class="form-group" align="center" id="finalizar">
								<label>Escribe un comentario adicional respecto al desempeño del colaborador en el Proyecto</label>
								<textarea id="comentarios" class="form-control" rows="5" style="text-align:center" required
									><?= $evaluacion->comentarios;?></textarea>
							</div>
						</div>
					</div>
					<div class="carousel-caption" align="center">
						<button id="enviar" class="btn btn-lg btn-primary" style="max-width:200px; text-align:center;">Enviar Evaluación</button>
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
			estatus = '<?= $evaluacion->estatus;?>';
			if(estatus==1){
				mark();
				revisar();
			}

			$('[id^=finalizar]').submit(function(event){
				asignacion=$('#finalizar_asignacion').val();
				tipo=$('#finalizar_tipo').val();
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
							}else{
								alert(returnData['msg']);
								$('#carousel').show('slow');
								mark();
								return false;
							}
						},
						error: function(data){
							console.log(data.responseText);
							$('#carousel').show('slow');
							$('#cargando').hide('slow');
							alert('Error al finalizar la evaluación. Intenta de nuevo');
						}
					});
			});
		});
		var checkitem = function() {
			var $this;
			$this = $("#carousel");
			if ($("#carousel .carousel-inner .item:first").hasClass("active")) {
				$this.children(".left").hide();
				$this.children(".right").show();
			} else if ($("#carousel .carousel-inner .item:last").hasClass("active")) {
				mark();
				$this.children(".right").hide();
				$this.children(".left").show();
			} else {
				$this.children(".carousel-control").show();
			}
		};

		checkitem();

		$("#carousel").on("slid.bs.carousel", "", checkitem);

		function mark(formulario) {
			if(formulario == undefined)
				$('[id^=mark]').each(function(i,form) {
					$(form).each(function() {
						//console.log('respuesta: '+$(this[2]).val()+ 'justificación: '+$(this[3]).val());
						if($(this[2]).val() != 3 && $(this[3]).val() == "") {
							if($(this[4]).focus()){
								$(form['children'][3]).css({'background-color':'#fc8111','border-radius':'10px 10px 10px 10px'});
								console.log($(form['children']));
								$('#mensaje').show();
								$('[id^=finalizar]').hide();
							}
						}
					});
				});
			else
				$(formulario).each(function() {
					//console.log('respuesta: '+$(this[3]).val()+ 'justificación: '+$(this[4]).val());
					if($(this[2]).val() != 3 && $(this[3]).val() == "") {
						if($(this[4]).focus()){
							$(formulario['children'][3]).css({'background-color':'#fc8111','border-radius':'10px 10px 10px 10px'});
							//console.log($(form['children'][4]));
							$('#mensaje').show();
							$('[id^=finalizar]').hide();
						}
					}else
						$(formulario['children'][3]).css({'background-color':'','border-radius':''});
				});
		}

		function revisar() {
			flag=true;
			$('[id^=respuesta] option:selected').each(function(i,select) {
				if($(select).val() == ""){
					flag = false;
				}
			});
			if(flag){
				$('#mensaje').hide();
				$('[id^=finalizar]').show();
			}
			else{
				$('#mensaje').show();
				$('[id^=finalizar]').hide();
			}
		}

		function verify(form) {
			var respuesta = form.respuesta.options[form.respuesta.selectedIndex].value;
			var asignacion = form.asignacion.value;
			var dominio = form.dominio.value;
			var justificacion = form.justificacion.value;
			console.log(asignacion,dominio,respuesta,justificacion);
			form.boton.setAttribute('disabled','disabled');
			$.ajax({
				url: '<?= base_url("evaluacion/guardar_avanceProyecto");?>',
				type: 'post',
				data: {'asignacion':asignacion,'dominio':dominio,'respuesta':respuesta,'justificacion':justificacion},
				beforeSend: function (xhr) {
					//$('#carousel').hide('slow');
					$('#cargando').show('slow');
				},
				success: function(data){
					var returnedData = JSON.parse(data);
					revisar();
					console.log(returnedData);
					$('#cargando').hide('slow');
					//$('#carousel').show('slow');
					mark(form);
				},
				error: function(data){
					$('#cargando').hide('slow');
					$('#carousel').show('slow');
					form.respuesta.selectedIndex=0;
					console.log(data.status,data.responseText);
				}
			});
			return false;
		}
	</script>