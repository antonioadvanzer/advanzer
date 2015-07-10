<div class="jumbotron">
	<div class="container">
		<?php if (isset($authUrl)): ?>

			<h2>Inicia Sesión con Google Advanzer</h2>
			<hr>
			<div align="center">
				<a class="ghost" href="<?= $authUrl; ?>">INICIAR SESIÓN CON GOOGLE</a>
			</div>
			<!--<div id="content" style="position: absolute; width: 90%; margin: 0;">
				<center>
					<a class="ghost" href="<?= $authUrl; ?>">Entrar con Google</a>
				</center>
			</div>-->
		</div><br><br>
		<div class="container" align="center">
			<form role="form" method="post" action="<?= base_url('main/login');?>" class="form-signin">
			  <div class="form-group">
				<label for="email" class="sr-only">E-Mail</label>
				<input name="email" type="email" id="email" class="form-control" style="max-width:200px; text-align:center;" placeholder="E-Mail" required autofocus>
			  </div>
			  <div class="form-group">
				<label for="password" class="sr-only">Password</label>
				<input name="password" type="password" id="password" class="form-control" style="max-width:200px; text-align:center;" placeholder="Password" required>
			  </div>
			  <div class="form-group">
				<button class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;" type="submit">Entrar</button>
			  </div>
			</form>
			<?php if(isset($err_msg)){ ?>
			</div>
			<div id="alert" class="container" align="center">
				<div class="alert alert-danger" role="alert" style="max-width:400px;">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					<?= $err_msg;?>
				</div>
			<?php } ?>
		<?php else: ?>
			<h2><img class="user_img" src="<?= base_url("assets/images/fotos/$user->foto");?>" width="80px" />Bienvenido <?= $userData->email; ?></h2>
		<?php endif;?>
	</div>
</div>
<div class="container">