<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<div class="col-md-6">
			<?php $empresa=$this->session->userdata('empresa'); if(!empty($empresa)): ?>
				<img style="max-height:70px" class="logo" 
					src="<?= base_url('assets/images/'.$this->session->userdata("empresa").'.png'); ?>">
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="container">
	<div class="row" align="center"><div class="col-md-12"><a href="<?= base_url();?>">&laquo;Regresar</a></div></div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row"><div class="col-md-12 lead">Historial de Desempeño<hr></div></div>
					<div class="row">
						<div class="col-md-4 text-center">
							<img height="150px" class="img-circle avatar avatar-original" style="-webkit-user-select:none; 
								display:block; margin:auto;" src="<?= base_url("assets/images/fotos/$colaborador->foto");?>">
						</div>
						<div class="col-md-8">
							<div class="row"><div class="col-md-12"><h2 class="only-bottom-margin"><?= $colaborador->nombre;?></h2></div></div>
							<hr>
							<div class="row">
								<?php if(!empty($info)): ?>
									<div class="col-md-6">
										<select class="form-control" style="max-width:160px;" id="anio">
											<option selected disabled>- Selecciona año -</option>
											<?php foreach($info as $evaluacion): ?>
												<option><?= $evaluacion->anio;?></option>
											<?php endforeach; ?>
										</select>
									</div>
								<?php else: ?>
									<div class="col-md-12">
										<label>No has generado historial en la empresa</label>
									</div>
								<?php endif; ?>
								<div align="center"><div id="cargando" style="display:none; color: green;">
									<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
								<div class="col-md-6" style="display:none" id="result"></div>
							</div>
						</div>
					</div>
					<div id="resultados">
						<div class="row" id="chart">
							<div class="col-md-12">
								<div id="graph"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table id="tbl" align="center"class="table table-hover table-condensed table-striped" style="display:none">
									<thead>
										<tr>
											<th class="col-md-2" data-halign="center">Indicador</th>
											<th data-halign="center">Comentarios</th>
										</tr>
									</thead>
									<tbody id="datos"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function loadData(data){
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
		$(document).ready(function() {
			$("#anio").change(function() {
				$("#anio option:selected").each(function() {
					anio = $('#anio').val();
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('main/load_historial');?>",
					data: {anio : anio},
					beforeSend: function (xhr) {
						$('#result').hide();
						$('#resultados').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$('#cargando').hide();
						$("#result").show().html(data);
					}
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('main/load_graph');?>",
					data: {anio : anio},
					async: true,
					dataType: "json",
					beforeSend: function(xhr) {
						$('#tbl').hide('slow');
						$('#datos').html('');
						$('#chart').hide('slow');
					},
					success: function (data) {
						console.log(data.data);
						$('#resultados').show('slow');
						if(data.data != undefined){
							$('#chart').show('slow');
							loadData(data);
						}else
							$('#chart').hide('slow');
						$('#datos').html(data.justificacion);
						if(data.justificacion != undefined)
							$('#tbl').show('slow');
					},
					error: function(data) {
						console.log(data.responseText);
					}
				});
			});
		});
	</script>