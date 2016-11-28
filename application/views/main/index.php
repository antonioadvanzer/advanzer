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
<div class="container">
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
							<div class="row"><div class="col-md-12"><h2 align="center" class="only-bottom-margin"><?= $colaborador->nombre;?></h2></div></div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<span class="text-muted">E-Mail: </span><span style="font-size:14px"><?= $colaborador->email;?></span><br>
									<span class="text-muted">Empresa: </span><span style="font-size:14px"><?php if($colaborador->empresa == 1) echo "Advanzer";else echo"Entuizer";?></span><br>
									<span class="text-muted">Plaza: </span><span style="font-size:14px"><?= $colaborador->plaza;?></span><br>
									<span class="text-muted"># Empleado: </span><span style="font-size:14px"><?= $colaborador->nomina;?></span><br>
									<span class="text-muted">Fecha de ingreso: </span><span style="font-size:14px"><?php $lenguage = 'es_ES.UTF-8';
										putenv("LANG=$lenguage");
										setlocale(LC_ALL, $lenguage);
										$fecha=strtotime($colaborador->fecha_ingreso);
										echo strftime("%A %d de %B del %Y",$fecha);
										//$fecha=date_create($colaborador->fecha_ingreso);
										//echo date_format($fecha,'l, F j\t\h, Y')?></span>
								</div>
								<div class="col-md-6">
									<span class="text-muted">Jefe: </span><span style="font-size:14px"><?= $colaborador->nombre_jefe;?></span><br>
									<span class="text-muted">Área: </span><span style="font-size:14px"><?= $colaborador->nombre_area;?></span><br>
									<span class="text-muted">Posición: </span><span style="font-size:14px"><?= $colaborador->nombre_posicion;?></span><br>
									<span class="text-muted">Track: </span><span style="font-size:14px"><?= $colaborador->nombre_track;?></span><br>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<nav class="navbar">
						<div class="navbar-collapse" aria-expanded="false">
							<ul class="nav navbar-nav">
								<?php if($solicitudes_pendientes): ?>
									<li><a href="<?= base_url("solicitudes");?>">Solicitudes Propias <span class="badge"><?php echo $solicitudes_pendientes;?></span></a></li>
								<?php endif;
								if($auth_pendientes): ?>
									<li><a href="<?= base_url("solicitudes_pendientes");?>">Solicitudes Recibidas <span class="badge"><?php echo $auth_pendientes;?></span></a></li>
								<?php endif;
								/*if($requisiciones_pendientes+count($requisiciones)): $count=count($requisiciones) + $requisiciones_pendientes; */
                                if($rp = $this->session->userdata('permisos')['requisicion_pendiente']):
                                ?>
									<li><a href="<?= base_url('requisiciones')."/?status=own";?>"><b>Requisiciones <span class="badge"><?php /*if($count>0) echo $count;*/ echo $rp;?></span></b></a></li>
								<?php endif;
								if($evaluacion): ?>
									<li><a href="<?= base_url("evaluar");?>"><?= $this->session->userdata('evaluacion')?'Evaluaci&oacute;n de Desempeño':'Feedback';?></a></li>
								<?php endif;
								if($this->session->userdata('posicion') <= 8 && !in_array($this->session->userdata('id'), array(1,2,51))): ?>
									<li><a href="<?= base_url("evaluacion/perfil");?>">¿Qué me evalúan?</a></li>
									<?php if(!empty($colaborador->historial)):?>
										<li><a href="<?= base_url("historial");?>">Historial de Desempeño</a></li>
									<?php endif; ?>
									<li onclick="alert('La sección está en construcción.');"><a href="#">Mi plan de Capacitación</a></li>
								<?php endif; ?>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>