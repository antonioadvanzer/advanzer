<div class="jumbotron">
	<div class="container">
		<h2 style="cursor:default;">Evaluaciones Pendientes</h2>
	</div>
</div>
<div class="container">
	<div class="row" align="center"><div class="col-md-12"><a href="<?= base_url();?>">&laquo;Regresar</a></div></div>
	<hr>
	<div class="row" align="center">
		<div class="input-group">
			<span class="input-group-addon">Tipo</span>
			<select name="tipo" id="tipo" class="form-control">
				<option value="" selected>Todas</option>
				<option value="auto">Autoevaluación</option>
				<option value="360">360</option>
				<option value="anual">Anual</option>
			</select>
			<span class="input-group-addon">Estatus</span>
			<select id="estatus" name="estatus" class="form-control">
				<option value="">Todas</option>
				<option value="1">En proceso</option>
				<option value="0">Pendientes</option>
			</select>
		</div>
	</div>
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<div id="vista" class="row">
		<div class="col-md-12">
			<h3><b>Evaluaciones</b></h3>
			<table id="tbl" align="center" class="display">
				<thead>
					<tr>
						<th data-halign="center" align="center"></th>
						<th data-halign="center" align="center">Evaluador</th>
						<th data-halign="center" align="center"># Anuales</th>
						<th data-halign="center" align="center"># 360</th>
						<th data-halign="center" align="center">Autoevaluación</th>
					</tr>
					<tr>
						<th data-halign="center" align="center"></th>
						<th data-halign="center" align="center">Evaluador</th>
						<th data-halign="center" align="center"># Anuales</th>
						<th data-halign="center" align="center"># 360</th>
						<th data-halign="center" align="center">Autoevaluación</th>
					</tr>
				</thead>
				<tbody>
					<?php if($evaluadores)
						foreach ($evaluadores as $evaluador) : ?>
							<tr>
								<td style="cursor:default;" align="center"><img height="40px" class="img-circle avatar avatar-original" 
									src="<?= base_url("assets/images/fotos/$evaluador->foto");?>"></td>
								<td class="col-md-7" style="cursor:default;"><?= $evaluador->nombre;?></td>
								<td style="cursor:default;" align="center"><?= $evaluador->anuales;?></td>
								<td style="cursor:default;" align="center"><?= $evaluador->tres60;?></td>
								<td style="cursor:default;" align="center"><?php if($evaluador->auto == 1) echo "No ha enviado";else echo "Enviada";?></td>
							</tr>
						<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td>Todos</td>
						<td># Anuales</td>
						<td># 360</td>
						<td>Todos</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#tbl').dataTable({responsive: true}).columnFilter({
				sPlaceHolder: "head:after",
				aoColumns: [ null,
					{ type: "select" },
					{ type: "number" },
					{ type: "number" },
					{ type: "select" }
				]
			});

			$("#tipo").change(function() {
				$("#tipo option:selected").each(function() {
					tipo = $('#tipo').val();
				});
				$("#estatus option:selected").each(function() {
					estatus = $('#estatus').val();
				});
				if(tipo == "" && estatus == "")
					location.href='<?= base_url("evaluacion/pendientes");?>';
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_pendientes');?>",
					data: {tipo : tipo,estatus : estatus},
					beforeSend: function (xhr) {
						$('#vista').hide('slow');
						$('#cargando').show('slow');
						$('#tbl').dataTable().fnDestroy();
					},
					success: function(data) {
						$('#cargando').hide('slow');
						$("#vista").show('slow');
						$("#tbl").html(data);
						$('#tbl').DataTable({responsive: true});
					},
					error: function(data) {
						console.log(data.responseText);
						$('#cargando').hide('slow');
						$("#vista").show('slow');
					}
				});
			});
			$("#estatus").change(function() {
				$("#estatus option:selected").each(function() {
					estatus = $('#estatus').val();
				});
				$("#tipo option:selected").each(function() {
					tipo = $('#tipo').val();
				});
				if(tipo == "" && estatus == "")
					location.href='<?= base_url("evaluacion/pendientes");?>';
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_pendientes');?>",
					data: {tipo : tipo,estatus : estatus},
					beforeSend: function (xhr) {
						$('#vista').hide();
						$('#cargando').show('slow');
						$('#tbl').dataTable().fnDestroy();
					},
					success: function(data) {
						$('#cargando').hide('slow');
						$("#vista").show('slow');
						$("#tbl").html(data);
						$('#tbl').DataTable({responsive: true});
					},
					error: function(data) {
						console.log(data.responseText);
						$('#cargando').hide('slow');
						$("#vista").show('slow');
					}
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_competencias');?>",
					data: {
						posicion : posicion
					},
					success: function(data) {
						$('#cargando').hide('slow');
						$('#competencias').html(data);
						$("#vista").show('slow');
					}
				});
			});
		});
	</script>