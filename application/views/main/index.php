<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
	<h2>Bienvenido(a)</h2>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row"><div class="col-md-12 lead">Perfil del Colaborador<hr></div></div>
					<div class="row">
						<div class="col-md-4 text-center">
							<img height="150px" class="img-circle avatar avatar-original" style="-webkit-user-select:none; 
								display:block; margin:auto;" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>">
						</div>
						<div class="col-md-8">
							<div class="row"><div class="col-md-12"><h1 class="only-bottom-margin"><?= $colaborador->nombre;?></h1></div></div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<span class="text-muted">E-Mail: </span><?= $colaborador->email;?><br>
									<span class="text-muted">Empresa: </span><?php if($colaborador->empresa == 1) echo "Advanzer";else echo"Entuizer";?><br>
									<span class="text-muted">Plaza: </span><?= $colaborador->plaza;?><br>
									<!--<span class="text-muted">Categoría: </span><?= $colaborador->categoria;?><br>-->
									<span class="text-muted"># Empleado: </span><?= $colaborador->nomina;?><br><br>
									<small class="text-muted">Fecha de ingreso: <?php $fecha=date_create($colaborador->fecha_ingreso); echo date_format($fecha,'l, F j\t\h, Y')?></small>
								</div>
								<div class="col-md-6">
									<span class="text-muted">Jefe: </span><?= $colaborador->nombre_jefe;?><br>
									<span class="text-muted">Área: </span><?= $colaborador->nombre_area;?><br>
									<span class="text-muted">Posición: </span><?= $colaborador->nombre_posicion;?><br>
									<span class="text-muted">Track: </span><?= $colaborador->nombre_track;?><br>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12"><h3>
							<span class="btn label label-default pull-left" onclick="location.href='<?= base_url("evaluar");?>';">
								<i class="glyphicon glyphicon-pencil"></i> Evaluar</span>&nbsp;&nbsp;
							<span class="btn label label-default pull-left" onclick="location.href='<?= base_url("historial");?>';">
								<i class="glyphicon glyphicon-eye-open"></i> Mis Resultados</span>
							<span class="btn label label-default pull-left" onclick="location.href='<?= base_url("evaluacion/perfil");?>';">
								<i class="glyphicon glyphicon-info-sign"></i> ¿Qué me evalúan?</span>
						</h3></div>
					</div>
				</div>
			</div>
		</div>
	</div>