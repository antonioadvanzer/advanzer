<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nuevo Perfil de Colaborador</h2>
  </div>
</div>
<div class="container">
  <div class="row" align="center">
	<a href="<?= base_url('administrar_usuarios');?>">&laquo;Regresar</a>
	<div class="col-md-12" align="center">
	  	<div class="form-group">
		  <div align="center">
			<div id="alert" style="display:none" class="alert alert-danger" role="alert" style="max-width:400px;">
		      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		      <span class="sr-only">Error:</span>
		      <label id="msg"></label>
		    </div>
		  </div>
		</div>
	</div>
	<form id="create" role="form" method="post" action="javascript:" class="form-signin">
	  <div class="col-md-4">
		  <div class="form-group">
		    <label for="nombre">Nombre:</label>
		    <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    id="nombre" required>
		  </div>
		  <div class="form-group">
		    <label for="nombre">E-Mail:</label>
		    <input id="email" type="email" class="form-control" style="max-width:300px; text-align:center;" required>
		  </div>
		  <div class="form-group">
		    <label for="tipo">Empresa:</label>
		    <select class="form-control" style="max-width:300px; text-align:center;" id="empresa" required>
		    	<option value="" disabled selected>--</option>
		    	<option value="1">Advanzer</option>
		    	<option value="2">Entuizer</option>
		    </select>
		  </div>
		  <div class="form-group">
			<label for="jefe">Jefe Directo:</label>
			<select class="selectpicker" data-header="Selecciona al Jefe Directo" data-width="300px" data-live-search="true" 
				style="max-width:300px; text-align:center;" name="jefe" id="jefe" required>
				<option value="" disabled selected>-- Selecciona al Jefe Directo --</option>
				<?php foreach($jefes as $jefe): ?>
					<option value="<?= $jefe->id;?>"><?= $jefe->nombre;?></option>
				<?php endforeach; ?>
			</select>
		  </div>
	  </div>
	  <div class="col-md-4">
	  	  <div class="form-group">
		    <label for="plaza">Plaza:</label>
		    <input name="plaza" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    	required value="" id="plaza">
		  </div>
		  <div class="form-group">
			<label for="track">Track</label>
			<select class="form-control" style="max-width:300px;text-align:center" name="track" id="track" required>
			  <option disabled selected>-- Selecciona un track --</option>
				<?php foreach ($tracks as $track) : ?>
				  <option value="<?= $track->id;?>"><?= $track->nombre;?></option>
				<?php endforeach; ?>
			</select>
		  </div>
	  	  <div class="form-group">
			<label for="posicion">Posición:</label>
			<select id="posicion" class="form-control" style="max-width:300px; text-align:center;" name="posicion" required>
				<option disabled selected>-- Selecciona una posición --</option>
				<?php foreach ($posiciones as $posicion) : ?>
					<option value="<?= $posicion->id;?>"><?= $posicion->nombre;?></option>
				<?php endforeach; ?>
			</select>
		  </div>
		  <div class="form-group">
		    <label for="area">Área:</label>
		    <select id="area" class="form-control" style="max-width:300px; text-align:center;" name="area" required>
		    	<?php foreach ($areas as $area) : ?>
		    		<option value="<?= $area->id;?>"><?= $area->nombre;?></option>
		    	<?php endforeach; ?>
		    </select>
		  </div>
	  </div>
	  <div class="col-md-4">
		  <div class="form-group">
			<label for="ingreso">Fecha de Ingreso:</label>
			<input data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" type="text" 
				style="max-width:300px; text-align:center;background-color:white" name="ingreso" id="ingreso" 
				value="<?= date('Y-m-d');?>" readonly required>
		  </div>
		  <div class="form-group">
			<label for="nomina"># Nómina:</label>
			<input class="form-control" style="max-width:300px;text-align:center" name="nomina" value="" id="nomina" required>
		  </div>
		  <div class="form-group">
		    <label for="categoria">Categoría:</label>
		    <input name="categoria" type="text" class="form-control" style="max-width:300px; text-align:center;" 
		    	value="" required id="categoria">
		  </div>
		  <div class="form-group">
			<label for="tipo">Tipo de Acceso:</label>
			<select class="form-control" style="max-width:300px; text-align:center;" id="tipo">
				<option value="0">Colaborador</option>
				<option value="1">Requisiciones</option>
				<option value="2">Administrador</option>
				<option value="3">Requisiciones y Administrador</option>
			</select>
		  </div>
	  </div>
	  <div class="col-md-12">
		  <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">Registrar</button>
	  </div>
	</form>
  </div>

  <script type="text/javascript">
	$(document).ready(function() {
		$('.selectpicker').selectpicker();
		$('#create').submit(function(event){
			nombre = $('#nombre').val();
			email = $('#email').val();
			$("#empresa option:selected").each(function() {
				empresa = $('#empresa').val();
			});
			$("#jefe option:selected").each(function() {
				jefe = $('#jefe').val();
			});
			plaza = $('#plaza').val();
			$("#track option:selected").each(function() {
				track = $('#track').val();
			});
			$("#posicion option:selected").each(function() {
				posicion = $('#posicion').val();
			});
			$("#area option:selected").each(function() {
				area = $('#area').val();
			});
			ingreso = $('#ingreso').val();
			nomina = $('#nomina').val();
			categoria = $('#categoria').val();
	  		$("#tipo option:selected").each(function() {
				tipo = $('#tipo').val();
			});
			if(jefe != null || track != null || posicion != null)
				$.ajax({
					url: '<?= base_url("user/create");?>',
					type: 'post',
					data: {'nombre':nombre,'email':email,'empresa':empresa,'jefe':jefe,'plaza':plaza,
						'track':track,'posicion':posicion,'area':area,'ingreso':ingreso,'nomina':nomina,
						'categoria':categoria,'tipo':tipo},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok")
							window.document.location='<?= base_url("user/ver");?>/'+returnedData['id'];
						else{
							$('#alert').prop('display',true).show();
							$('#msg').html(returnedData['msg']);
						}
					}
				});
			else
				alert("elige al jefe");

			event.preventDefault();
		});

		$("#track").change(function() {
			$("#track option:selected").each(function() {
				track = $('#track').val();
				$.post("<?= base_url('user/load_posiciones');?>", {
					track : track
				}, function(data) {
					$("#posicion").html(data);
				});
			});
		});
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10)
			dd='0'+dd
		if(mm<10)
			mm='0'+mm
		today = yyyy+'-'+mm+'-'+dd;
		$('#ingreso').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});
  </script>