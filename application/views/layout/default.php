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
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/datepicker/css/bootstrap-datepicker.css');?>">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.dataTables.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-select.css');?>">
	<script src="<?= base_url('assets/js/jquery.min.js');?>"></script>
	<!--<script src="<?= base_url('assets/js/bootstrap-table.js');?>"></script>-->
	<script src="<?= base_url('assets/js/docs.min.js');?>"></script>
	<script src="<?= base_url('assets/datepicker/js/bootstrap-datepicker.min.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="<?= base_url('assets/js/moment.min.js');?>"></script>
	<!--<script src="<?= base_url('assets/js/tableExport.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-table-export.js');?>"></script>-->
	<script src="<?= base_url('assets/js/jquery.dataTables.js');?>"></script>
	<script src="<?= base_url('assets/js/jquery.dataTables.columnFilter.js');?>"></script>
	<script src="<?= base_url('assets/js/jasny-bootstrap.js');?>"></script>
	<script src="<?= base_url('assets/js/bootstrap-select.js');?>"></script>
	<script src="<?= base_url('assets/js/highcharts/highcharts.js');?>"></script>
	<script src="<?= base_url('assets/js/circle-progress.js');?>"></script>
	<title><?=$title_for_layout?></title>
	<style type="text/css">
		body {
			padding-top: 50px;
			padding-bottom: 20px;
		}
		.jumbotron {
			-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#628DC8, endColorstr=#ffffff)";
			filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#628DC8', endColorstr='#ffffff');
		}
		.navbar-inverse {
			background-image: -webkit-linear-gradient(top, #3c3c3c 0%, #222 100%);
			background-image: -o-linear-gradient(top, #3c3c3c 0%, #222 100%);
			background-image: -webkit-gradient(linear, left top, left bottom, from(#3c3c3c), to(#222));
			background-image: linear-gradient(to bottom, #3c3c3c 0%, #222 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3c3c3c', endColorstr='#ff222222', GradientType=0);
			filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
			background-repeat: repeat-x;
			/*border-radius: 4px;*/
		}
	</style>
	<script>
		var empresa = <?php if($this->session->userdata('empresa')) echo $this->session->userdata('empresa');else echo 0;?>;
		var color = "";
		switch(empresa){
			case 1:
				color = "#C0D339";
				font = "TitilliumText22L-400wt.otf";
				titleFont = "TitilliumText22L";
			break;
			case 2:
				color = "#628DC8";
				font = "corbel.ttf";
				titleFont = "Corbel";
			break;
			default:
				color= "#";
				font = "AvenirLTStd-Medium.otf";
				titleFont = "Avenir LT Std 65 Medium";
			break;
		}
		if(color != "#")
			document.write('\
				<style>\
					.jumbotron {\
						background: -webkit-linear-gradient('+color+',#fff); /* For Safari 5.1 to 6.0 */\
						background: -o-linear-gradient('+color+',#fff); /* For Opera 11.1 to 12.0 */\
						background: -moz-linear-gradient('+color+',#fff); /* For Firefox 3.6 to 15 */\
						background: linear-gradient('+color+',#fff); /* Standard syntax (must be last) */\
					}\
					html,body {\
						font-family: "'+titleFont+'";\
						src: url("<?= base_url("assets/fonts");?>/'+font+'");\
					}\
				</style>\
			');
		else
			document.write('\
				<style>\
					.navbar-inverse {\
						background-image: -moz-linear-gradient(left, #C0D339, #628DC8);\
						background-image: -ms-linear-gradient(left, #C0D339, #628DC8);\
						background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#C0D339), to(#628DC8));\
						background-image: -webkit-linear-gradient(left, #C0D339, #628DC8);\
						background-image: -o-linear-gradient(left, #C0D339, #628DC8);\
						background-image: linear-gradient(left, #C0D339, #628DC8);\
						background-repeat: repeat-x;\
					}\
					html,body {\
						font-family: "'+titleFont+'";\
						src: url("<?= base_url("assets/fonts");?>/'+font+'");\
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
			<?php if($this->session->userdata('id') != ""): ?>
				<div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
					<ul class="nav navbar-nav">
						<?php if(in_array($this->session->userdata('tipo'), array(4,5,6)) || $this->session->userdata('posicion') <= 3 || $this->session->userdata('area') == 4): ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									Administración<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="dropdown-submenu"><a tabindex="-1" href="#">Servicios</a>
										<ul class="dropdown-menu">
											<?php if($this->session->userdata('posicion') <= 3): ?>
												<?php //if($this->session->userdata('periodo_edicion') == 1): ?>
													<li><a href="<?= base_url('objetivo/asignar_pesos');?>">Responsabilidades Por Área</a></li>
												<?php //endif; ?>
											<?php endif; 
											if($this->session->userdata('tipo') > 3 || $this->session->userdata('area')==4): ?>
												<li><a href="<?= base_url('requisiciones');?>">Todas las Requisiciones</a></li>
												<li><a href="<?= base_url('admin_solicitudes');?>">Todas las Solicitudes</a></li>
												<?php if($this->session->userdata('tipo') > 3): ?>
													<li><a href="<?= base_url('evaluacion');?>">Evaluaciones</a></li>
													<li><a href="<?= base_url('evaluacion/por_evaluador');?>">Evaluaciones por Evaluador</a></li>
													<li><a href="<?= base_url('evaluacion/pendientes');?>">Evaluaciones Pendientes de Enviar</a></li>
												<?php endif;
											endif; ?>
										</ul>
									</li>
									<?php if(in_array($this->session->userdata('tipo'), array(4,5,6))): ?>
										<li role="separator" class="divider"></li>
										<li class="dropdown-submenu"><a tabindex="-1" href="#">ABC</a>
											<ul class="dropdown-menu">
												<li><a href="<?= base_url('area');?>">Areas de Especialidad</a></li>
												<li><a href="<?= base_url('track');?>">Tracks y Posiciones</a></li>
												<li><a href="<?= base_url('administrar_usuarios'); ?>">Colaboradores Activos</a></li>
												<li><a href="<?= base_url('administrar_usuarios/1'); ?>">Colaboradores Inactivos</a></li>
												<li><a href="<?= base_url('administrar_dominios');?>">Responsabilidades Funcionales</a></li>
												<li><a href="<?= base_url('administrar_indicadores');?>">Competencias Laborales</a></li>
												<?php if($this->session->userdata('periodo_edicion') == 1): ?>
													<li><a href="<?= base_url('indicador/asignar_comportamientos');?>">Comportamientos por Posición</a></li>
												<?php endif; ?>
												<li><a href="<?= base_url('evaluacion/proyecto');?>">Gestionar Tiempos de Evaluación (Proyecto-Anual)</a></li>
												<li><a href="<?= base_url('evaluaciones');?>">Evaluación de Desempeño</a></li>
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
								<?php if($this->session->userdata('tipo') >= 3 || $this->session->userdata('posicion') <= 5):?>
									<li><a href="<?= base_url('requisicion');?>">Requisiciones</a></li>
								<?php endif;?>
									<li><a href="<?= base_url('evaluar');?>">Feedback</a></li>
								<?php if(in_array($this->session->userdata('tipo'), array(1,2,5,6))): ?>
									<li><a href="<?= base_url('evaluacion/ci');?>">Compromisos Internos</a></li>
								<?php endif;
								if($this->session->userdata('posicion') <= 5 || in_array($this->session->userdata('tipo'),array(4,5,6))): ?>
									<li><a href="<?= base_url('evaluacion/resumen');?>">Resumen de Evaluación 360</a></li>
								<?php endif;?>
								<li><a href="<?= base_url('vacaciones');?>">Vacaciones</a></li>
								<li><a href="<?= base_url('permiso');?>">Permisos de Ausencia</a></li>
								<li><a href="<?= base_url('viaticos_gastos');?>">Viáticos y Gastos de Viaje</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#" style="cursor:default"><small><?= $this->session->userdata('nombre');?></small></a></li>
						<li><a href="<?= base_url('logout'); ?>">LogOut</a></li>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</nav>
	<?=$content_for_layout?>
	<br>
	<footer align="center">
		<p>&copy; Advanzer De México, S.A de C.V. 2015</p>
	</footer>
	</div> <!-- /container -->
</body>
</html>