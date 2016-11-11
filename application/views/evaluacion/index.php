<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Resultados Evaluaciones</h2>
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
			<table id="tbl" align="center" class="display">
				<thead>
					<tr>
						<th data-halign="center" data-align="center"></th>
						<th data-halign="center">Nombre</th>
						<th data-defaultsort="asc" data-halign="center">Rating</th>
						<th data-halign="center">Total</th>
						<th data-halign="center">Competencias</th>
						<th data-halign="center">Responsabilidades</th>
						<th data-halign="center">Feedback</th>
					</tr>
				</thead>
				<tbody data-link="row">
					<?php foreach ($colaboradores as $colab):
						$total_c=0;
						$total_r=0;
						if($colab->nivel_posicion<=5)
							$total_c= ($colab->autoevaluacion + $colab->tres60 + $colab->competencias)/3;
						else
							$total_c= ($colab->autoevaluacion + $colab->competencias)/2;
						if(isset($colab->proyectos))
							$total_r=($colab->responsabilidades+$colab->proyectos)/2;
						else
							$total_r=$colab->responsabilidades;
						?>
						<tr>
							<td align="center"><small><a href="<?= base_url("evaluacion/revisar/$colab->id");?>">
								<img height="40px" class="img-circle avatar avatar-original" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></a></small></td>
							<td><small><?= "$colab->nombre ($colab->posicion - $colab->track)";?></small></td>
							<td><small><?= $colab->rating;?></small></td>
							<td><small><?= number_format(floor($colab->total * 100) / 100,2);?></small></td>
							<td class="rowlink-skip"><table id="tbl2" align="center" class="display">
								<thead>
									<tr>
										<th><small>Resultado</small></th>
										<th><small>Auto</small></th>
										<th><small>Anual</small></th>
										<th><small>360</small></th>
									</tr>
								</thead>
								<tbody data-link="row">
									<tr>
										<td><small><?= number_format(floor($total_c*100)/100,2);?></small></td>
										<td><small><?= number_format(floor($colab->autoevaluacion*100)/100,2);?></small></td>
										<td><small><?= number_format(floor($colab->competencias*100)/100,2);?></small></td>
										<td><small><?php if(isset($colab->tres60)) echo number_format(floor($colab->tres60*100)/100,2);?></small></td>
									</tr>
								</tbody>
							</table></td>
							<td class="rowlink-skip"><table id="tbl2" align="center" class="display">
								<thead>
									<tr>
										<th><small>Resultado</small></th>
										<th><small>Anual</small></th>
										<th><small>Proyecto</small></th>
									</tr>
								</thead>
								<tbody data-link="row">
									<tr>
										<td><small><?= number_format(floor($total_r*100)/100,2);?></small></td>
										<td><small><?= number_format(floor($colab->responsabilidades*100)/100,2);?></small></td>
										<td><small><?php if(isset($colab->proyectos)) echo number_format(floor($colab->proyectos*100)/100,2);?></small></td>
									</tr>
								</tbody>
							</table></td>
							<td><small><?php if($colab->feedback)
								if(isset($colab->feedback->estatus)){
									if($colab->feedback->estatus == 1) echo"Enviado"; 
									elseif($colab->feedback->estatus == 2) echo"Enterado";
									else echo"En Proceso";
								}else echo"Pendiente";?>
							</small></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true});
		} );
	</script>