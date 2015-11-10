<?php if (isset($authUrl)): ?>
	<div class="jumbotron">
		<div class="container">
			<div class="col-md-3 logo" align="center"><img vspace="8%" width="280px" src="<?= base_url('assets/images/1.png');?>"></div>
			<div class="col-md-6" align="center"><h2>Bienvenido(a) a tu Portal Personal de Capital Humano</h2></div>
			<div class="col-md-3 logo" align="center"><img vspace="8%" width="280px" src="<?= base_url('assets/images/2.png');?>"></div>
		</div>
	</div>
	<div class="container" align="center">
		<div class="col-md-1"></div>
		<div class="col-md-4">
			<a href="<?= $authUrl; ?>"><img vspace="8%" src="<?= base_url('assets/images/login.png');?>" align="center" height="80px">
				<label style="position:relative"><small style="cursor:pointer">(Click para iniciar sesión)</small></label></a>
			<!--<form role="form" method="post" action="<?= base_url('main/login');?>" class="form-signin">
			  <div class="form-group">
				<label for="email" class="sr-only">E-Mail</label>
				<input name="email" type="email" id="email" class="form-control" style="max-width:200px; text-align:center;" placeholder="E-Mail" 
					value="" required autofocus>
			  </div>
			  <div class="form-group">
				<label for="password" class="sr-only">Password</label>
				<input name="password" type="password" id="password" class="form-control" style="max-width:200px; text-align:center;" 
					placeholder="Password" value="" required>
			  </div>
			  <div class="form-group">
				<button class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;" type="submit">Entrar</button>
			  </div>
			</form>-->
		</div>
		<div class="col-md-1"></div>
		<div class="col-md-6">
			<h2>En éste espacio puedes encontrar:</h2>
			<li>Información relacionada a tu perfil como colaborador</li>
			<li>Historial de Desempeño</li>
			<li>Competencias y Responsabilidades</li>
			<li>Diferentes servicios</li>
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