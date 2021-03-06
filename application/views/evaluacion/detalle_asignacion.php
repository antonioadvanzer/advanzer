<style type="text/css">
	.accordion {
	  text-align: center;
	}
	.accordion h1, h2, h3, h4 {
	  -webkit-margin-before: 0em;
	  -webkit-margin-after: 0em;
	}
	.accordion h1 {
	  margin: 10px auto;
	  padding: 15px 20px;
	  background-color: #444;
	  font-size: 1.4rem;
	  font-weight: normal;
	  color: #FFF;
	  text-transform: uppercase;
	  border-radius: 10px 10px 10px 10px;
	}
	.accordion h1:hover {
	  color: #999;
	}
	.accordion h2 {
	  padding: 5px 100px;
	  font-size: 14px;
	  color: #666666;
	  text-transform: uppercase;
	  border-radius: 10px 10px 10px 10px;
	}
	.accordion h2:hover {
	  color: #000;
	}
	.accordion label {
	  width: 100%;
	  padding: 5px 70px;
	  font-size: .8rem;
	  color: #000;
	  margin-bottom: 0px;
	}
	.accordion h3 {
	  padding: 5px;
	  font-size: 1.1rem;
	  color: #af720a;
	  background-color: #E3E3E3;
	  border-radius: 10px 10px 10px 10px;
	}
	.accordion p {
	  text-transform: uppercase;
	  padding: 5px 100px 0px 60px;
	  color: #333;
	  font-size: 11px;
	}
	.accordion hr {
		margin-top: 0px;
		margin-bottom: 0px;
		border: 0;
		border-top: 1px solid #eee;
	}
</style>
<script>
	document.write('\
		<style>\
		.accordion h2 {\
				background: -webkit-linear-gradient(#fff,'+color+'); /* For Safari 5.1 to 6.0 */\
				background: -o-linear-gradient(#fff,'+color+'); /* For Opera 11.1 to 12.0 */\
				background: -moz-linear-gradient(#fff,'+color+'); /* For Firefox 3.6 to 15 */\
				background: linear-gradient(#fff,'+color+'); /* Standard syntax (must be last) */\
			}\
		</style>\
	');
</script>
<div class="jumbotron">
	<div class="container">
		<h2 style="cursor:default;">Revisión de la Evaluación - <?= $evaluacion->nombre;?></h2>
		<!--<p><small>Evaluador: <i><?= $evaluador->nombre;?></i></small></p>-->
		<p><small>Evaluación a: <i><?= $evaluado->nombre;?></i></small></p>
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
	<?php if(isset($evaluacion)):
		$total=0;
		if($evaluacion->tipo == 1 && ($evaluacion->anual==1 || $evaluacion->evaluador == $evaluacion->evaluado)):
			if(isset($evaluacion->dominios)): 
				if(count($evaluacion->dominios) > 0):
					$total = $resultado->competencias*.3 + $resultado->responsabilidades*.7; ?>
					<div class="row" align="center"><div class="col-md-12"><h1>Responsabilidades Funcionales</h1></div></div>
					<div class="row">
						<?php foreach ($evaluacion->dominios as $dominio) : if(count($dominio->responsabilidades) > 0): ?>
							<div class="col-md-12">
								<aside class="accordion">
									<h1><?= $dominio->nombre;?></h1>
									<?php foreach ($dominio->responsabilidades as $resp) :?>
										<label style="padding: 5px 0px;">
											<h2><?= $resp->nombre;?><span style="min-width:100px;float:right;">
													<i>Respuesta</i>: <?= $resp->respuesta;?>
												</span>
												<?php if($resp->justificacion):?><label><?= $resp->justificacion;?></label><?php endif;?>
											</h2>
										</label>
									<?php endforeach; ?>
								</aside>
							</div>
						<?php endif; endforeach; ?>
					</div>
				<?php else:
					$total = $resultado->competencias;
				endif; ?>
			<?php else:
				$total=$resultado->autoevaluacion;
			endif;
			if(isset($evaluacion->indicadores)): ?>
				<div class="row" align="center"><div class="col-md-12"><h1>Competencias Laborales</h1></div></div>
				<div class="row">
					<?php foreach ($evaluacion->indicadores as $indicador) : ?>
						<div class="col-md-12">
							<aside class="accordion">
								<h1><?= $indicador->nombre;?></h1>
								<?php foreach ($indicador->competencias as $comp) : ?>
									<h2><?= $comp->nombre;?></h2>
									<h3 align="left"><hr>
										<?php foreach ($comp->comportamientos as $comportamiento) : ?>
											<p><?= $comportamiento->descripcion;?><span style="min-width:100px;float:right;display:block;">
												<i>Respuesta</i>: <?= $comportamiento->respuesta;?></span>
												<?php if($comportamiento->justificacion):?>
													<label><?= $comportamiento->justificacion;?></label>
												<?php endif;?>
											</p><hr>
										<?php endforeach; ?>
									</h3>
								<?php endforeach; ?>
							</aside>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif;
		elseif($evaluacion->tipo == 0) :
			$cont=0;
			$items=0; ?>
			<div class="row" align="center"><div class="col-md-12"><h1>Responsabilidades Funcionales</h1></div></div>
			<div class="row">
				<?php foreach ($evaluacion->dominios as $dominio) :
					$cont += $dominio->respuesta; ?>
					<div class="col-md-12">
						<aside class="accordion">
							<h1><?= $dominio->nombre;?></h1>
							<label><h2><i>Respuesta: </i><?=$dominio->respuesta;?>
								<?php if($dominio->justificacion): ?><label><?= $dominio->justificacion;?></label><?php endif; ?>
							</h2></label>
						</aside>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $total=$cont / count($evaluacion->dominios);
		else:
			$cont=0;
			$items=0; ?>
			<div class="row" align="center"><div class="col-md-12"><h1>Competencias Laborales</h1></div></div>
			<div class="row">
				<?php foreach ($evaluacion->indicadores as $indicador) : ?>
					<div class="col-md-12">
						<aside class="accordion">
							<h1><?= $indicador->nombre;?></h1>
							<?php foreach ($indicador->competencias as $competencia) :
								$cont += $competencia->respuesta;
								$items++; ?>
								<h2><?= $competencia->nombre; ?><span style="min-width:100px;float:right;display:block;">
									<i>Respuesta: </i><?=$competencia->respuesta;?></span>
									<?php if($competencia->justificacion): ?><label><?= $competencia->justificacion;?></label><?php endif; ?>
								</h2>
							<?php endforeach; ?>
						</aside>
					</div>
				<?php endforeach; ?>
			</div>
			<?php $total = $cont / $items;
		endif;
	endif; ?>
	<div class="row" align="center"><div class="col-md-12"><h1>Comentarios Generales</h1></div></div>
	<div class="row" align="center">
		<div style="col-md-12">
			<aside class="accordion">
				<label><?= $evaluacion->comentarios;?></label>
			</aside>
		</div>
		<?php if($evaluacion->evaluado != $this->session->userdata('id')): ?>
			<div class="col-md-12"><h1>Calificación:</h1><label><big><?= number_format($total,2);?></big></label></div>
		<?php endif; ?>
	</div>