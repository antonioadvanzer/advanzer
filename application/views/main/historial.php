<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<div class="col-md-6">
			<?php $empresa=$this->session->userdata('empresa'); if(!empty($empresa)): ?>
				<img style="max-height:70px" class="logo" 
					src="<?= base_url('assets/images/'.$this->session->userdata("empresa").'.png'); ?>">
			<?php endif; ?>
		</div>
		<div class="col-md-6" align="right"><h2>¡Bienvenido(a)!</h2></div>
	</div>
</div>
<div class="container" align="center">
	<a href="<?= base_url();?>">&laquo;Regresar</a>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row"><div class="col-md-12 lead">Perfil del Colaborador <?php if($this->session->userdata('tipo')!=0)
					switch ($this->session->userdata('tipo')) {
						case 1:
						case 2:
							echo " (Capturista de Compromisos Internos)";
							break;
						case 3:
							echo " (Requisiciones)";
							break;
						case 4:
							echo " (Administrador)";
							break;
						case 5:
							echo " (Administrador y Requisiciones)";
							break;
						case 6:
							echo " (Soporte Técnico)";
							break;
						default:
							# code...
							break;
					}
					?><hr></div></div>
					<div class="row">
						<div class="col-md-4 text-center">
							<img height="150px" class="img-circle avatar avatar-original" style="-webkit-user-select:none; 
								display:block; margin:auto;" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>">
						</div>
						<div class="col-md-8">
							<div class="row"><div class="col-md-12"><h1 class="only-bottom-margin"><?= $colaborador->nombre;?></h1></div></div>
							<hr>
							<div class="row">
								<?php if(!empty($info)):
									foreach($info as $evaluacion): ?>
										<div class="col-md-6">
											<span class="text-muted">Año de Evaluación: </span><?= $evaluacion->anio;?><br>
											<span class="text-muted">Rating Obtenido: </span><?= $evaluacion->rating;?><br>
										</div>
									<?php endforeach;
								else: ?>
									<div class="col-md-12">
										<label>No has generado historial en la empresa</label>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>