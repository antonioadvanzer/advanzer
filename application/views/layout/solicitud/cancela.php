<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		.jumbotron {
			-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#628DC8, endColorstr=#ffffff)";
			filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#628DC8', endColorstr='#ffffff');
		}
		.container {
			padding-right: 15px;
			padding-left: 15px;
			margin-right: auto;
			margin-left: auto;
		}
		@media (min-width: 768px) {
			.container {
				width: 750px;
			}
		}
		@media (min-width: 992px) {
			.container {
				width: 970px;
			}
		}
		@media (min-width: 1200px) {
			.container {
				width: 90%;
			}
		}
		.container .jumbotron,
		.container-fluid .jumbotron {
			border-radius: 6px;
		}
		.jumbotron .container {
			max-width: 100%;
		}
		@media screen and (min-width: 768px) {
			.jumbotron {
				padding-top: 48px;
				padding-bottom: 48px;
			}
			.container .jumbotron,
			.container-fluid .jumbotron {
				padding-right: 60px;
				padding-left: 60px;
			}
			.jumbotron h1,
			.jumbotron .h1 {
				font-size: 63px;
			}
		}
		.col-md-12{
			position: relative;
			min-height: 1px;
			padding-right: 15px;
			padding-left: 15px;
		}
		@media (min-width: 992px) {
			.col-md-12{
				float: left;
				width: 100%;
			}
		}
		p{
			font-size: 13pt;
		}
		a{
			text-decoration: none;
			color: gray;
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
		document.write('\
			<style>\
				@font-face {\
				font-family: "'+titleFont+'";\
				src: url("http://intranet.advanzer.com:3000/assets/fonts/'+font+'");\
			}\
				html,body {\
					font-family: "'+titleFont+'";\
				}\
			</style>\
		');
	</script>
</head>
<body>
	<div class="container">
		<div class="col-md-12" align="center"><img width="100%" src="http://drive.google.com/uc?export=view&id=0B7vcCZhlhZiONkE0ZU9qcVU5S3M"></div>
		<div style="width:80%" class="container">
			<?php 
			switch($solicitud->tipo){
				case 1: $tipo="VACACIONES";											break;
				case 2: $tipo="NOTIFICACION DE AUSENCIA ($solicitud->motivo)";		break;
				case 3: $tipo="PERMISO DE AUSENCIA ($solicitud->motivo)";			break;
				default: $tipo="";													break;
			}?>
			<p>Se ha cancelado una solicitud de <?= $tipo;?> que ya haz autorizado con Folio #<b><?=$solicitud->id;?></b> en la que solicitó <?=$solicitud->dias;?> días comprendido(s) entre <?= date_format(date_create($solicitud->desde),'D j F, Y');?> hasta el <?=date_format(date_create($solicitud->hasta),'D j F, Y');?> por motivo de: <b><?= $solicitud->razon;?></b></p>
		</div>
		<div class="col-md-12" align="center"><img width="100%" src="http://drive.google.com/uc?export=view&id=0B7vcCZhlhZiOOWNiNHJnZGhnaDA"></div>
		<footer align="center">
			<p>&copy; Advanzer De México, S.A de C.V. 2015</p>
		</footer>
	</div> <!-- /container -->
</body>
</html>