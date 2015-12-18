<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Resumén Proceso de Evaluación</h2>
	</div>
</div>
<div class="container">
	<div align="center" id="alert" style="display:none">
		<div class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg"></label>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3><b>Colaboradores:</b></h3>
			<div class="input-group">
				<span class="input-group-addon">Colaborador</span>
				<select name="indicador" id="indicador" class="form-control">
					<option value="<?= $this->session->userdata('id');?>" selected>Tú</option>
					<?php foreach ($subordinados as $colab) : ?>
						<option value="<?= $colab->id;?>"><?= $colab->nombre;?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	<div id="graph"></div><hr>
	<div class="row">
		<div class="col-md-12">
			<table id="tbl" align="center"class="display" data-hover="true">
				<thead>
					<tr>
						<th class="col-md-2" data-halign="center">Indicador</th>
						<th data-halign="center">Comentarios</th>
					</tr>
				</thead>
				<tbody id="result"></tbody>
			</table>
		</div>
	</div>
	
	<script>
		function loadData(data){
			if(data.data != undefined)
				$('#graph').highcharts({
					colors: [color],
					chart: {
						type: 'column',
						style: {
							fontFamily: titleFont
						}
					},
					title: {
						text: 'Resultados 360°'
					},
					xAxis: {
						categories: data.categories
					},
					yAxis: {
						min: 0,
						max: 6,
						title: {
							text: 'Media Ponderada'
						},
						stackLabels: {
							enabled: false,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
					legend: {
						align: 'right',
						x: -30,
						verticalAlign: 'top',
						y: 25,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: false
					},
					tooltip: {
						formatter: function () {
							return '<b>' + this.x + '</b><br/>' +
							'Total: ' + this.point.stackTotal;
						}
					},
					plotOptions: {
						column: {
							stacking: 'normal',
							dataLabels: {
								enabled: false,
								color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
								style: {
									textShadow: '0 0 3px black'
								}
							}
						}
					},
					series: [{
						name: data.name,
						data: data.data
					}]
				});
		}
		$(function () {
			colaborador=<?= $this->session->userdata('id');?>;
			console.log(colaborador);
			$.ajax({
				url: '<?= base_url("evaluacion/getResumenByColaborador");?>/'+colaborador,
				type: 'POST',
				async: true,
				dataType: "json",
				beforeSend: function(xhr) {
					$('#tbl').dataTable().fnDestroy();
					$('#result').html('');
				},
				success: function (data) {
					console.log(data.justificacion);
					loadData(data);
					$('#result').html(data.justificacion);
					$('#tbl').DataTable({responsive: true});
				},
				error: function(data) {
					console.log(data);
				}
			});

			$("#indicador").change(function() {
				$("#indicador option:selected").each(function() {
					colaborador = $('#indicador').val();
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/getResumenByColaborador');?>/"+colaborador,
					async: true,
					dataType: "json",
					beforeSend: function(xhr) {
						$('#tbl').dataTable().fnDestroy();
						$('#result').html('');
					},
					success: function (data) {
						console.log(data.justificacion);
						loadData(data);
						$('#result').html(data.justificacion);
						$('#tbl').DataTable({responsive: true});
					},
					error: function(data) {
						console.log(data);
					}
				});
			});
		});
	</script>