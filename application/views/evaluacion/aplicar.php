<style type="text/css">
	#carousel {
		-moz-box-shadow: 0px 0px 20px #000; 
		-webkit-box-shadow: 0px 0px 20px #000; 
		box-shadow: 0px 0px 20px #000;
	}
	.accordion {
	  margin: 40px auto;
	  text-align: center;
	}
	.accordion h1, h2, h3, h4 {
	  cursor: pointer;
	}
	.accordion h1 {
	  padding: 15px 20px;
	  background-color: #444;
	  /*font-family: Lobster;*/
	  font-size: 2rem;
	  font-weight: normal;
	  color: #FFF;
	  text-transform: uppercase;
	  border-radius: 10px 10px 10px 10px;
	}
	.accordion h1:hover {
	  color: #999;
	}
	/*.accordion h1:first-child {
	  border-radius: 10px 10px 0 0;
	}
	.accordion h1:last-of-type {
	  border-radius: 0 0 10px 10px;
	}
	.accordion h1:not(:last-of-type) {
	  border-bottom: 1px dotted #FFF;
	}*/
	.accordion div {
	  display: none;
	}
	.accordion h2 {
	  padding: 5px 25px;
	  background: -webkit-gradient(linear, left bottom, left top, from(#B0B914), to(#FFF));
	  /*background-color: #B0B914;*/
	  font-size: 1.2rem;
	  color: #666666;
	  text-transform: uppercase;
	  border-radius: 10px 10px 10px 10px;
	}
	.accordion h2:hover {
	  color: #000;
	}
	.accordion label {
	  width: 100%;
	  padding: 5px 30px;
	  background-color: #dadada;
	  font-size: 1.4rem;
	  color: #000; 
	  border-radius: 10px 10px 10px 10px;
	}
	.accordion h3:hover {
	  background-color: #000;
	  color: #FFF;
	}
	.accordion h4 {
	  padding: 5px 35px;
	  background-color: #ffc25a;
	  font-size: .9rem;
	  color: #af720a; 
	}
	.accordion h4:hover {
	  background-color: #e0b040;
	}
	.accordion p {
	  padding: 15px 35px;
	  background-color: #ddd;
	  font-size: .8rem;
	  color: #333;
	  line-height: 1.3rem;
	}
	.accordion span {
		display: block;
	}
</style>
<script>
	document.write('\
		<style>\
		.accordion h2 {\
				background: -webkit-gradient(linear, left top, left bottom, from(#fff), to('+color+'));\
			}\
		</style>\
	');
</script>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2 style="cursor:default;">Seguimiento de Evaluación - <?php if($evaluacion->tipo == 0) echo"Proyecto";else echo"Anual";?></h2>
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
			<?php $k=2; if(isset($evaluacion->dominios)){
				$k = count($evaluacion->dominios)+2;
				for ($i=0; $i < count($evaluacion->dominios); $i++) : ?>
					<li data-target="#carousel" data-slide-to="<?= $i+2;?>"></li>
				<?php endfor;?>
				<li data-target="#carousel" data-slide-to="<?= $k++;?>"></li>
			<?php } for ($i=0; $i < count($evaluacion->indicadores); $i++): ?>
				<li data-target="#carousel" data-slide-to="<?= $k++;?>"></li>
			<?php endfor; ?>
			<li data-target="#carousel" data-slide-to="<?= $k;?>"></li>
		</ol>
		<!-- Wrapper for slides -->
		<div class="carousel-inner" style="background-color:#dedede;" role="listbox">
			<div class="item active" align="center" style="min-height:480px;">
				<img height="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/evaluacion.jpg');?>">
				<div class="carousel-caption">
					<h3 style="cursor:default;"><?php switch($evaluacion->estatus){ case 0:echo"Comenzar Evaluación";break;
						case 1:echo"Continuar Evaluación...";break;}?></h3>
				</div>
			</div>
			<?php if(isset($evaluacion->dominios)): ?>
				<div class="item" align="center" style="min-height:480px;">
					<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/responsabilidades.jpg');?>">
					<div class="carousel-caption"><h3 style="cursor:default;">Responsabilidades</h3></div>
				</div>
				<?php foreach ($evaluacion->dominios as $dominio) : ?>
					<div class="item" style="min-height:400px;">
						<aside class="accordion" style="max-width:70%;">
							<h1><?= $dominio->nombre;?></h1>
							<div>
								<?php foreach ($dominio->responsabilidades as $resp) : ?>
									<h2><?= $resp->nombre;?><span style="min-width:100px;float:right;">
										<i>Respuesta</i>: 
										<select onchange="guardar(this,<?= $resp->id;?>,'responsabilidad');" class="form-control" id="resp" 
											style="height:15px;padding: 0px 10px;font-size:10px;max-width:50px;display:inline">
											<option disabled selected value="">-- Selecciona tu respuesta --</option>
											<?php for ($i=5; $i >= 1; $i--) : ?>
												<option <?php if($resp->respuesta == $i) echo "selected";?>><?= $i;?></option>
											<?php endfor; ?>
										</select>
									</span></h2>
									<div align="left">
									<label><?= $resp->descripcion;?></label>
									<p><ol reversed>
									<?php foreach ($resp->metricas as $metrica) : ?>
									<li><?= $metrica->descripcion;?></li>
									<?php endforeach; ?>
									</ol></p>
									</div>
								<?php endforeach; ?>
							</div>
						</aside>
					</div>
				<?php endforeach; 
			endif; ?>
			<div class="item" align="center" style="min-height:480px;">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/competencias.jpg');?>">
				<div class="carousel-caption"><h3 style="cursor:default;">Competencias</h3></div>
			</div>
			<?php foreach ($evaluacion->indicadores as $indicador) : ?>
				<div class="item" style="min-height:400px;">
					<aside class="accordion" style="max-width:70%;">
						<h1><?= $indicador->nombre;?></h1>
						<div>
							<?php foreach ($indicador->competencias as $comp) : ?>
								<h2><?= $comp->nombre;?></h2>
								<div align="left">
									<label><?= $comp->descripcion;?></label>
									<p><ul type="square">
										<?php foreach ($comp->comportamientos as $comportamiento) : ?>
											<label><?= $comportamiento->descripcion;?><span style="min-width:70px;float:right"><i>Respuesta</i>: 
												<select onchange="guardar(this,<?= $comportamiento->id;?>);" class="form-control" id="resp" 
													style="height:15px;padding: 0px 10px;font-size:10px;max-width:50px;display:inline">
													<option disabled selected value="">-- Selecciona tu respuesta --</option>
													<?php for ($i=5; $i >= 1; $i--) : ?>
														<option <?php if(isset($comportamiento->respuesta) && $comportamiento->respuesta == $i) echo "selected";?>><?= $i;?></option>
													<?php endfor; ?>
												</select>
											</span></label>
										<?php endforeach; ?>
									</ul></p>
								</div>
							<?php endforeach; ?>
						</div>
					</aside>
				</div>
			<?php endforeach; ?>
			<div class="item" align="center" style="min-height:480px;">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/gracias.jpg');?>">
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

		var headers = ["H1","H2","H3","H4","H5","H6"];
		$(".accordion").click(function(e) {
			var target = e.target,
			name = target.nodeName.toUpperCase();
			if($.inArray(name,headers) > -1) {
				var subItem = $(target).next();
				//slideUp all elements (except target) at current depth or greater
				var depth = $(subItem).parents().length;
				var allAtDepth = $(".accordion p, .accordion div").filter(function() {
					if($(this).parents().length >= depth && this !== subItem.get(0))
						return true; 
				});
				$(allAtDepth).slideUp("fast");

				//slideToggle target content and adjust bottom border if necessary
				subItem.slideToggle("fast",function() {
					$(".accordion :visible:last").css("border-radius","10px 10px 10px 10px");
				});
				$(target).css({"border-bottom-right-radius":"0", "border-bottom-left-radius":"0"});
			}
		});
	</script>