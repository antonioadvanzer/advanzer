<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Requisiciones de Personal</h2>
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
	<div>
		<label style="cursor:pointer" onclick="location.href='<?= base_url('requisicion/choose/');?>'">
			<span class="glyphicon glyphicon-plus"></span>Nueva Requisición</label>
	</div>
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<div class="row" align="center">
		<div class="col-md-12">
			<table id="tbl" class="display" align="center" data-toggle="table" data-hover="true" data-striped="true">
				<thead>
					<tr>
						<th data-halign="center">Folio</th>
						<th data-halign="center">Fecha Solicitud</th>
						<th data-halign="center">Solicita</th>
						<th data-halign="center">Proyecto</th>
						<th data-halign="center">Track</th>
						<th data-halign="center">Posición</th>
						<th data-halign="center">Área</th>
						<th data-halign="center">Empresa</th>
						<th data-halign="center">Estatus</th>
					</tr>
				</thead>
				<tbody data-link="row" class="rowlink">
					<?php foreach ($requisiciones as $requisicion){
						/*if($this->session->userdata('id') == $requisicion->solicita 
							|| $this->session->userdata('tipo') >=4 
							|| ($requisicion->director == $this->session->userdata('id') && $requisicion->estatus == 1)
							|| ($requisicion->autorizador == $this->session->userdata('id') && $requisicion->estatus == 2 && $requisicion->tipo_requisicion==1)
							|| ($this->session->userdata('tipo') == 3 && $this->session->userdata('area') == 4)
							|| ($requisicion->tipo==2 && $requisicion->estatus==1 &&$requisicion->autorizador==$this->session->userdata('id'))true
						): */
							switch ($requisicion->estatus) {
								case 0:
									$estatus="CANCELADA";
									break;
                                case 1:
									$estatus="ENVIADA";
									break;
								case 2:
									$estatus="ACEPTADA";
									break;
								case 3:
									$estatus="AUTORIZADA";
									break;
								case 4:
									$estatus="RECHAZADA";
									break;
                                case 5:
									$estatus="CANCELADA";
									break;
								case 6:
									$estatus="CERRADA";
									break;
								case 7:
									$estatus="STAND BY";
									break;
                                case 8:
									$estatus="EN PROCESO";
									break;
                                    
							}
							if($requisicion->empresa == '1')
								$empresa="Advanzer";
							elseif($requisicion->empresa == '2')
								$empresa="Entuizer";
							else
								$empresa=$requisicion->empresa;
							?>
							<tr onmouseover="this.style.background=color;" onmouseout="this.style.background='transparent';">
								<td>
                                    <small><a style="text-decoration:none" href='<?php if($requisicion->tipo_requisicion==1) echo base_url("requisicion/ver/$requisicion->id"); else echo base_url("requisicion/ver/$requisicion->id");?>'><?= $requisicion->id;?></a></small>
                                <?php if(( ($requisicion->solicita == $this->session->userdata('id')) 
                                            && ($requisicion->alerta == 1)
                                            && ( /*($requisicion->estatus == 3) ||*/ ($requisicion->estatus == 4) || ($requisicion->estatus == 8)    || ($requisicion->estatus == 8) || ($requisicion->estatus == 0) || ($requisicion->estatus == 5))
                                            )
                                         ||
                                         
                                         (($requisicion->director == $this->session->userdata('id')) && ($requisicion->estatus == 1) && ($requisicion->alerta == 1) )
                                         
                                         ||
                                         
                                         (($requisicion->autorizador == $this->session->userdata('id')) && ($requisicion->estatus == 2) && ($requisicion->alerta == 1) )
                                         
                                         ||
                                         
                                         (($this->session->userdata('tipo') == 4) && ($requisicion->estatus == 3) && ($requisicion->alerta == 1) )
                                        
                                        ) {?>    
                                    &#09;<img height="15px" wigth="15px"  src="<?= base_url("assets/images/icons/nra.png");?>">
                                <?php }?>
                                    
                                </td>
								<td><small><?= $requisicion->fecha_solicitud;?></small></td>
								<td><small><?= $requisicion->solicitante;?></small></td>
								<td><small><?= $requisicion->proyecto;?></small></td>
								<td><small><?= $requisicion->track;?></small></td>
								<td><small><?= $requisicion->posicion;?></small></td>
								<td><small><?= $requisicion->area;?></small></td>
								<td><small><?= $empresa;?></small></td>
								<td><small><?= $estatus;?></small></td>
							</tr>
						<?php }//endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			//$('#tbl').DataTable({responsive: true,info: false,paging: false,order: [[ 0, "desc" ]]});
            $('#tbl').DataTable({responsive: true,info: false,paging: false,order: [[ 0, "desc" ],[ 1, "desc" ]]});
	} );
	</script>