<style type="text/css">
	#carousel {
		-moz-box-shadow: 0px 0px 20px #000; 
		-webkit-box-shadow: 0px 0px 20px #000; 
		box-shadow: 0px 0px 20px #000;
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
<div class="jumbotron">
	<div class="container">
		<h2 style="cursor:default;">Revisión de la Evaluación - <?= $evaluacion->nombre;?></h2>
		<p><small>Evaluador: <i><?= $evaluador->nombre;?></i></small></p>
		<p><small>Evalua a: <i><?= $evaluado->nombre;?></i></small></p>
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
			<?php $k=1; if(isset($evaluacion->dominios)): ?>
				<li data-target="#carousel" data-slide-to="<?= $k++;?>"></li>
				<?php for ($i=1; $i <= count($evaluacion->dominios); $i++) : ?>
					<li data-target="#carousel" data-slide-to="<?= $k++;?>"></li>
				<?php endfor;
			endif;
			if(isset($evaluacion->indicadores)): ?>
				<li data-target="#carousel" data-slide-to="<?= $k++;?>"></li>
				<?php for ($i=1; $i <= count($evaluacion->indicadores); $i++) : ?>
					<li data-target="#carousel" data-slide-to="<?= $k++;?>"></li>
				<?php endfor;
			endif; ?>
			<li data-target="#carousel" data-slide-to="<?= $k?>"></li>
		</ol>
		<div class="carousel-inner" style="background-color:#dedede;" role="listbox">
			<div class="item active" align="center" style="min-height:550px;">
				<img height="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/evaluacion.jpg');?>">
				<div class="carousel-caption">
					<h3 style="cursor:default;">Detalle de Evaluación</h3>
				</div>
			</div>
			<?php if(isset($evaluacion)) if($evaluacion->tipo == 1):
				if(isset($evaluacion->dominios)): ?>
					<div class="item" align="center" style="min-height:550px;">
						<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/responsabilidades.jpg');?>">
						<div class="carousel-caption"><h3 style="cursor:default;">Responsabilidades</h3></div>
					</div>
					<?php foreach ($evaluacion->dominios as $dominio) : if(count($dominio->responsabilidades) > 0): ?>
						<div class="item" style="min-height:470px;">
							<aside class="accordion" style="max-width:70%;">
								<h1><?= $dominio->nombre;?></h1>
								<?php foreach ($dominio->responsabilidades as $resp) : ?>
									<label>
										<div class="col-md-12">
											<div class="form-group" align="center">
												<h2><?= $resp->nombre;?><span style="min-width:100px;float:right;">
														<i>Respuesta</i>: 
														<select class="form-control" id="respuesta" disabled 
															style="height:15px;padding: 0px 10px;font-size:10px;max-width:50px;display:inline">
															<?php for ($i=5; $i >= 1; $i--) : ?>
																<option <?php if($resp->respuesta == $i) echo "selected";?>><?= $i;?></option>
															<?php endfor; ?>
														</select>
													</span>
													<label><?= $resp->descripcion;?></label>
												</h2>
												<div align="left">
													<p><ol reversed>
													<?php foreach ($resp->metricas as $metrica) : ?>
														<li><?= $metrica->descripcion;?></li>
													<?php endforeach; ?>
													</ol></p>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group" align="center">
												<textarea id="justificacion" class="form-control" rows="5" style="max-width:300px;text-align:center;
													<?php if($resp->respuesta=="" || $resp->respuesta == 3)echo'display:none;';?>" 
													disabled><?= $resp->justificacion;?></textarea>
											</div>
										</div>
									</label>
								<?php endforeach; ?>
							</aside>
						</div>
					<?php endif; endforeach; 
				endif;
				if(isset($evaluacion->indicadores)): ?>
					<div class="item" align="center" style="min-height:550px;">
						<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/competencias.jpg');?>">
						<div class="carousel-caption"><h3 style="cursor:default;">Competencias</h3></div>
					</div>
					<?php foreach ($evaluacion->indicadores as $indicador) : ?>
						<div class="item" style="min-height:470px;">
							<aside class="accordion" style="max-width:70%;">
								<h1><?= $indicador->nombre;?></h1>
								<div class="col-md-12">
								<?php foreach ($indicador->competencias as $comp) : ?>
									<h2><?= $comp->nombre;?>
										<label><?= $comp->descripcion;?></label>
									</h2>
									<div align="left">
										<ul type="square"><label>
										<?php foreach ($comp->comportamientos as $comportamiento) : ?>
											<label><?= $comportamiento->descripcion;?><span style="min-width:70px;float:right">
												<i>Respuesta</i>: 
												<select onchange="this.form.justificacion.html='';
													verify(this.form);" class="form-control" id="respuesta" disabled 
													style="height:15px;padding: 0px 10px;font-size:10px;max-width:50px;display:inline">
													<option disabled selected value="">-- Selecciona tu respuesta --</option>
													<?php for ($i=5; $i >= 1; $i--) : ?>
														<option <?php if(isset($comportamiento->respuesta) && $comportamiento->respuesta == $i)
															echo "selected";?>><?= $i;?></option>
													<?php endfor; ?>
												</select>
											</span></label>
											<div class="col-md-6">
												<div class="form-group" align="center">
													<textarea id="justificacion" class="form-control" rows="2" style="max-width:300px;text-align:center;
														<?php if($comportamiento->respuesta=="" || $comportamiento->respuesta == 3)echo'display:none;';?>" 
														onkeyup="if(this.value.trim().split(' ').length >= 4){ this.form.boton.style.display='';
															}else{ this.form.boton.style.display='none';}" placeholder="Justifique su respuesta"
														required disabled><?= $comportamiento->justificacion;?></textarea>
												</div>
											</div>
										<?php endforeach; ?></label></ul>
									</div>
								<?php endforeach; ?>
								</div>
							</aside>
						</div>
					<?php endforeach;
				endif;
			else :
				foreach ($evaluacion->dominios as $dominio) : ?>
					<div class="item" align="center" style="min-height:300px;">
						<div style="width:60%;position:absolute;top:5%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
							<div class="col-md-12">
								<div class="form-group" align="center">
									<label><?= $dominio->descripcion;?></label>
									<select id="respuesta" name="estatus" class="form-control" style="max-width:60px;text-align:center"
										onchange="verify(this.form);" required disabled>
										<option value="" selected disabled>--</option>
										<?php for ($i=5; $i > 0; $i--) : ?>
											<option value="<?= $i;?>" <?php if($dominio->respuesta==$i)echo"selected";?>><?= $i;?></option>
										<?php endfor; ?>
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group" align="center">
									<textarea id="justificacion" class="form-control" rows="5" style="max-width:300px;text-align:center;
										<?php if($dominio->respuesta == 3 || $dominio->respuesta == 0)echo'display:none;';?>" 
										onkeyup="if(this.value.split(' ').length >= 4){ this.form.boton.style.display='';
											}else{ this.form.boton.style.display='none';}" placeholder="Justifique su respuesta"
										required disabled><?= $dominio->justificacion;?></textarea>
								</div>
							</div>
						</div>
						<div class="carousel-caption"><h3 style="cursor:default;"><?= $dominio->nombre;?></h3></div>
					</div>
				<?php endforeach;
			endif; ?>
			<div class="item" align="center" style="min-height:300px;">
				<img width="100%" style="opacity:0.3;position:absolute" src="<?= base_url('assets/images/gracias.jpg');?>">
				<div style="width:60%;position:absolute;top:15%;z-index:20;left: 50%;width: 60%;margin-left: -30%;text-align: center;">
					<div class="col-md-12">
						<div class="form-group" align="center" id="finalizar">
							<label>Comentarios generales de la evaluación</label>
							<textarea id="comentarios" class="form-control" rows="5" style="max-width:300px;text-align:center" 
								disabled><?= $evaluacion->comentarios;?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Controls -->
		<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#carousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>