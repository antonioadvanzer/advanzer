<?php if (isset($authUrl)): ?>
	<div class="jumbotron">
		<div class="container">
			<div class="col-md-3 logo" align="center"><img vspace="8%" width="280px" src="<?= base_url('assets/images/1.png');?>"></div>
			<div class="col-md-6" align="center"><h2>Bienvenido(a) a tu Portal Personal</h2></div>
			<div class="col-md-3 logo" align="center"><img vspace="8%" width="280px" src="<?= base_url('assets/images/2.png');?>"></div>
		</div>
	</div>
	<div class="container" align="center">
		<div class="col-md-1"></div>
		<div class="col-md-4">
			<a href="<?= $authUrl; ?>"><img vspace="8%" src="<?= base_url('assets/images/login.png');?>" align="center" height="80px"><br>
				<label style="position:relative"><small style="cursor:pointer">(Click para iniciar sesión)</small></label></a>
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-6">
			<h4>En este espacio puedes encontrar:</h4><br>
			<h4>
			<li>Información relacionada a tu perfil como colaborador</li>
			<li>Historial de Desempeño</li>
			<li>Competencias y Responsabilidades</li>
			<li>Diferentes servicios</li></h4>
		</div>
	</div>
	<?php if(isset($err_msg)){ ?>
		<div id="alert" class="container" align="center">
			<div class="alert alert-danger" role="alert" style="max-width:400px;">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				<?= $err_msg;?>
			</div>
		</div>
	<?php } ?>
<?php endif; ?>
<div class="container">
