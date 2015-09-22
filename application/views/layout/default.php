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
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-table-filter.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-select.css');?>">
	<script src="<?= base_url('assets/js/jquery.min.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-table.js');?>"></script>
	<script src="<?= base_url('assets/js/docs.min.js');?>"></script>
	<script src="<?= base_url('assets/datepicker/js/bootstrap-datepicker.min.js');?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="<?= base_url('assets/js/bootstrap-table-filter.js');?>"></script>
	<script src="<?= base_url('assets/js/moment.min.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-sortable.js');?>"></script>
	<script src="<?= base_url('assets/js/tableExport.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-table-export.js');?>"></script>
	<script src="<?= base_url('assets/js/bs-table.js');?>"></script>
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
	</style>
	<script>
		var empresa = <?=$this->session->userdata('empresa');?>;
		switch(empresa){
			case 1:
				var color = "#B0B914";
			break;
			case 2:
				var color = "#488FCD";
			break;
		}
		document.write('\
			<style>\
				.jumbotron {\
					background: -webkit-gradient(linear, left bottom, left top, from(#fff), to('+color+'));\
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
				<?php $empresa=$this->session->userdata('empresa'); if(!empty($empresa)): ?>
					<a id="logo" class="navbar-brand" href="<?= base_url(); ?>"><img style="max-height:30px" class="logo" 
						src="<?= base_url('assets/images/'.$this->session->userdata("empresa").'.png'); ?>"></a>
				<?php else: ?>
					<a id="logo" class="navbar-brand" href="<?= base_url(); ?>"><img style="max-height:30px" class="logo" 
						src="<?= base_url('assets/images/0.png'); ?>"></a>
				<?php endif; ?>
			</div>
			<div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							Administración<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="dropdown-submenu"><a tabindex="-1" href="#">Servicios</a>
								<ul class="dropdown-menu">
									<li><a href="<?= base_url('objetivo/asignar_pesos');?>">Responsabilidades Por Área</a></li>
									<li><a href="<?= base_url('ver_requisiciones');?>">Requisiciones</a></li>
									<li><a href="<?= base_url('evaluacion');?>">Evaluaciones</a></li>
									<li><a href="<?= base_url('evaluacion/por_evaluador');?>">Evaluaciones por Evaluador</a></li>
									<li><a href="<?= base_url('gestion_evaluaciones');?>">Gestión de Evaluaciones</a></li>
								</ul>
							</li>
							<li role="separator" class="divider"></li>
							<li class="dropdown-submenu"><a tabindex="-1" href="#">ABC</a>
								<ul class="dropdown-menu">
									<li><a href="<?= base_url('area');?>">Areas de Especialidad</a></li>
									<li><a href="<?= base_url('track');?>">Tracks y Posiciones</a></li>
									<li><a href="<?= base_url('administrar_usuarios'); ?>">Colaboradores</a></li>
									<li><a href="<?= base_url('administrar_dominios');?>">Responsabilidades Funcionales</a></li>
									<li><a href="<?= base_url('administrar_indicadores');?>">Competencias Laborales</a></li>
									<li><a href="<?= base_url('indicador/asignar_comportamientos');?>">Comportamientos por Posición</a></li>
									<li><a href="<?= base_url('evaluaciones');?>">Evaluación de Desempeño</a></li>
									<li><a href="<?= base_url('evaluacion/proyecto');?>">Evaluación por Proyecto</a></li>
								</ul>
							</li>
							<!--<li role="separator" class="divider"></li>
							<li class="dropdown-submenu"><a tabindex="-1" href="#">Carga Masiva</a>
								<ul class="dropdown-menu">
									<li><a href="<?= base_url('carga_comp_resp');?>">Competencias y Responsabilidades</a></li>
								</ul>
							</li>-->
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							Servicios<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?= base_url('requisiciones');?>">Requisiciones</a></li>
							<li><a href="<?= base_url('evaluar');?>">Evaluaciones</a></li>
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
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php $idU=$this->session->userdata('id'); if(!empty($idU)): ?>
						<li><a href="<?= base_url('evaluacion/perfil');?>"><?= $this->session->userdata('nombre');?></a></li>
						<li><a href="<?= base_url('logout'); ?>">LogOut</a></li>
					<?php else: ?>
						<li><a href="<?= base_url("login") ?>">LogIn</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
	<?=$content_for_layout?>
	<hr>
	<footer>
		<p>&copy; Advanzer De México, S.A de C.V. 2015</p>
	</footer>
	</div> <!-- /container -->
</body>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $("#alert").fadeOut(1500);
    },3000);
    setTimeout(function() {
        $("#alert_success").fadeOut(1500);
    },3000);
});
</script>
</html>