<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?= base_url('assets/images/favicon.ico');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-table.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-theme.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/datepicker/css/bootstrap-datepicker.min.css');?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.dataTables.min');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-select.css');?>">
	<script src="<?= base_url('assets/js/jquery.min.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
	<!--<script src="<?= base_url('assets/js/bootstrap-table.js');?>"></script>-->
	<script src="<?= base_url('assets/js/docs.min.js');?>"></script>
	<script src="<?= base_url('assets/datepicker/js/bootstrap-datepicker.min.js');?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="<?= base_url('assets/js/moment.min.js');?>"></script>
	<script src="<?= base_url('assets/js/tableExport.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-table-export.js');?>"></script>
	<script src="<?= base_url('assets/js/jquery.dataTables');?>"></script>
	<script src="<?= base_url('assets/js/jasny-bootstrap.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-select.js');?>"></script>
	<title><?=$title_for_layout?></title>
	<style type="text/css">
		body {
			padding-top: 50px;
			padding-bottom: 20px;
		}
		.jumbotron {
			-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#488FCD, endColorstr=#ffffff)";
			filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#488FCD', endColorstr='#ffffff');
		}
		.navbar-inverse {
			background-image: -webkit-linear-gradient(top, #3c3c3c 0%, #222 100%);
			background-image: -o-linear-gradient(top, #3c3c3c 0%, #222 100%);
			background-image: -webkit-gradient(linear, left top, left bottom, from(#3c3c3c), to(#222));
			background-image: linear-gradient(to bottom, #3c3c3c 0%, #222 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3c3c3c', endColorstr='#ff222222', GradientType=0);
			filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
			background-repeat: repeat-x;
			border-radius: 4px;
		}
	</style>
	<script>
		var empresa = <?php if($this->session->userdata('empresa')) echo $this->session->userdata('empresa');else echo 0;?>;
		var color = "";
		switch(empresa){
			case 1:
				color = "#B0B914";
			break;
			case 2:
				color = "#488FCD";
			break;
		}
		if(color != "")
			document.write('\
				<style>\
					.jumbotron {\
						background: -webkit-gradient(linear, left bottom, left top, from(#fff), to('+color+'));\
					}\
				</style>\
			');
		else
			document.write('\
				<style>\
					.navbar-inverse {\
						background-image: -moz-linear-gradient(left, #B0B914, #488FCD);\
						background-image: -ms-linear-gradient(left, #B0B914, #488FCD);\
						background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#B0B914), to(#488FCD));\
						background-image: -webkit-linear-gradient(left, #B0B914, #488FCD);\
						background-image: -o-linear-gradient(left, #B0B914, #488FCD);\
						background-image: linear-gradient(left, #B0B914, #488FCD);\
						background-repeat: repeat-x;\
						border-radius: 4px;\
					}\
				</style>\
			');
	</script>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php if($this->session->userdata('id')): ?>
					<a class="navbar-brand" href="<?= base_url(); ?>">INICIO</a>
				<?php endif; ?>
			</div>
			<div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
				<ul class="nav navbar-nav">
					<?php if($this->session->userdata('id') != ""):
							if(in_array($this->session->userdata('tipo'), array(3,4,5,6)) || $this->session->userdata('posicion') <= 3): ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									Administración<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="dropdown-submenu"><a tabindex="-1" href="#">Servicios</a>
										<ul class="dropdown-menu">
											<?php if($this->session->userdata('posicion') <= 3): ?>
												<?php if($this->session->userdata('periodo_edicion') == 1): ?>
													<li><a href="<?= base_url('objetivo/asignar_pesos');?>">Responsabilidades Por Área</a></li>
												<?php endif; ?>
											<?php endif; if(in_array($this->session->userdata('tipo'), array(3,4,5,6))): ?>
													<li><a href="<?= base_url('evaluacion');?>">Evaluaciones</a></li>
													<!--<li><a href="<?= base_url('evaluacion/index/false');?>">Evaluaciones Confidencial</a></li>-->
													<li><a href="<?= base_url('evaluacion/por_evaluador');?>">Evaluaciones por Evaluador</a></li>
												<li><a href="<?= base_url('ver_requisiciones');?>">Requisiciones</a></li>
											<?php endif;?>
										</ul>
									</li>
									<?php if(in_array($this->session->userdata('tipo'), array(3,4,5,6))): ?>
										<li role="separator" class="divider"></li>
										<li class="dropdown-submenu"><a tabindex="-1" href="#">ABC</a>
											<ul class="dropdown-menu">
												<li><a href="<?= base_url('area');?>">Areas de Especialidad</a></li>
												<li><a href="<?= base_url('track');?>">Tracks y Posiciones</a></li>
												<li><a href="<?= base_url('administrar_usuarios'); ?>">Colaboradores</a></li>
												<li><a href="<?= base_url('administrar_dominios');?>">Responsabilidades Funcionales</a></li>
												<li><a href="<?= base_url('administrar_indicadores');?>">Competencias Laborales</a></li>
												<?php if($this->session->userdata('periodo_edicion') == 1): ?>
													<li><a href="<?= base_url('indicador/asignar_comportamientos');?>">Comportamientos por Posición</a></li>
												<?php endif; ?>
												<li><a href="<?= base_url('evaluaciones');?>">Evaluación de Desempeño</a></li>
												<li><a href="<?= base_url('evaluacion/proyecto');?>">Gestionar Tiempos de Evaluación (Proyecto-Anual)</a></li>
											</ul>
										</li>
									<?php endif; ?>
								</ul>
							</li>
						<?php endif; ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								Servicios<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php if(in_array($this->session->userdata('tipo'), array(3,5,6))): ?>
									<li><a href="<?= base_url('requisiciones');?>">Requisiciones</a></li>
								<?php endif; ?>
									<li><a href="<?= base_url('evaluar');?>">Evaluaciones</a></li>
								<?php if(in_array($this->session->userdata('tipo'), array(1,2,5,6))): ?>
									<li><a href="<?= base_url('evaluacion/ci');?>">Compromisos Internos</a></li>
								<?php endif; ?>
							</ul>
						</li>
						<!--
						<li><a href="<?= base_url('estructura_organizacional'); ?>">Estructura Organizacional</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								Políticas <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?= base_url('cartas_constancias');?>">Cartas y Constancias Laborales</a></li>
								<li><a href="<?= base_url('sap'); ?>">Certificación SAP</a></li>
								<li><a href="<?= base_url('viaticos'); ?>">Viáticos y Gastos de Viaje</a></li>
								<li><a href="<?= base_url('vacaciones');?>">Vacaciones</a></li>
								<li><a href="<?= base_url('permisos');?>">Permisos</a></li>
								<li><a href="<?= base_url('vestimenta');?>">Código de Vestimenta</a></li>
								<li><a href="#">Horarios</a></li>
								<li><a href="#">Días Festivos</a></li>
							</ul>
						</li>
						<li><a href="#about">Evaluación de Desempeño y Guía de Crecimiento</a></li>
						<li><a href="#about">SGMM</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								e-Learning <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">SAP modules</a></li>
							</ul>
						</li>
						<li><a href="#about">Cumpleaños del Mes</a></li>
						<li><a href="#about">Eventos Internos</a></li>
						-->
					<?php endif; ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php $idU=$this->session->userdata('id'); if($idU): ?>
						<li><a href="#" style="cursor:default"><?= $this->session->userdata('nombre');?></a></li>
						<li><a href="<?= base_url('logout'); ?>">LogOut</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
	<?=$content_for_layout?>
	<hr>
	<footer align="center">
		<p>&copy; Advanzer De México, S.A de C.V. 2015</p>
	</footer>
	</div> <!-- /container -->
</body>
</html>