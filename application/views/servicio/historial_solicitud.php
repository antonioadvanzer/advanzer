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
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/easy-modal.css');?>">
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
	<script src="<?= base_url('assets/js/easy-modal.js');?>"></script>
	<title><?=$title_for_layout?></title>
	<style type="text/css">
		body {
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
					.badge {\
						background-color: '+color+';\
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
	<div class="jumbotron">
		<div class="container">
			<h2 align="left"><b>Historial de <?= " $tipo ($colaborador)";?></b></h2>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table id="tbl" class="display" align="center" data-toggle="table" data-hover="true" data-striped="true">
					<thead>
						<tr>
							<th style="text-align:center">Folio</th>
							<th style="text-align:center">Fecha de Solicitud</th>
							<th style="text-align:center">Fecha de Resolución</th>
							<th style="text-align:center">Autorizador</th>
							<th style="text-align:center">Días</th>
							<th style="text-align:center">Desde</th>
							<th style="text-align:center">Hasta</th>
							<th style="text-align:center">Comentarios</th>
							<th style="text-align:center">Estatus</th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($solicitudes))
							foreach ($solicitudes as $solicitud):
								switch ($solicitud->estatus) :
									case 0: $estatus='CANCELADA';$comentarios=$solicitud->razon;									break;
									case 1: $estatus='ENVIADA';$comentarios=$solicitud->motivo;										break;
									case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';$comentarios=$razon=$solicitud->motivo;		break;
									case 3: $estatus='AUTORIZADA';$comentarios=$solicitud->motivo;									break;
									case 4: $estatus='RECHAZADA POR CAPITAL HUMANO';
										if($solicitud->auth_uno==0&& $solicitud->tipo < 4)
											$estatus='RECHAZADA POR AUTORIZADOR';
										$comentarios=$solicitud->razon;																break;
								endswitch; ?>
								<tr>
									<td style="cursor:default;" align="center"><small><a href='<?= base_url("servicio/ver/$solicitud->id");?>'><?= $solicitud->id;?></small></td>
									<td style="cursor:default;" align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
									<td style="cursor:default;" align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_ultima_modificacion));?></small></td>
									<td style="cursor:default;" align="center"><small><?= $solicitud->nombre_autorizador;?></small></td>
									<td style="cursor:default;" align="center"><small><?= $solicitud->dias;?></small></td>
									<td style="cursor:default;" align="center"><small><?= $solicitud->desde;?></small></td>
									<td style="cursor:default;" align="center"><small><?= $solicitud->hasta;?></small></td>
									<td style="cursor:default;" align="center"><small><?= $comentarios;?></small></td>
									<td style="cursor:default;" align="center"><small><?= $estatus;?></small></td>
								</tr>
							<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				$('#tbl').DataTable({responsive: true,order: [[ 1, "desc" ]]});
			} );
		</script>
	</div> <!-- /container -->
</body>
</html>