<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Solicitudes</b> 
            <?php 
                
                if($option == 1){
                    echo "(Vacaciones)";
                }elseif($option == 2){
                    echo "(Permisos de Ausencia)";
                }
            
            ?> 
        </h2>
	</div>
</div>
<div class="container">
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<div class="row" align="center">
		
        <?php 
        if(($option == 1) || ($option == 3)){ 
        ?> 
        
        <div class="col-md-6"><button class="btn btn-primary" onclick="location.href='<?= base_url("vacaciones");?>';"><big>Solicitar Vacaciones</big></button></div>
        
        <?php 
        }    
        if(($option == 2) || ($option == 3)){
        ?>
		
        <div class="col-md-6"><button class="btn btn-primary" onclick="location.href='<?= base_url("permiso");?>';"><big>Solicitar Permiso de Ausencia</big></button></div>
        
        <?php 
        } 
        ?>
	
    </div>
	<hr>
	<div class="row">
		<div class="col-md-12" align="center">
			<div>
				<?php if(!empty($propias)): ?>
					<table id="tbl" class="display" align="center">
						<thead>
							<tr>
								<th style="text-align:center">Folio</th>
								<th style="text-align:center">Tipo</th>
								<th style="text-align:center">Fecha de Solicitud</th>
								<th style="text-align:center">Autorizador</th>
								<th style="text-align:center">Días</th>
								<th style="text-align:center">Desde</th>
								<th style="text-align:center">Hasta</th>
								<th style="text-align:center">Estatus</th>
							</tr>
						</thead>
						<tbody data-link="row" class="rowlink">
							<?php foreach ($propias as $solicitud):
								switch ($solicitud->estatus) {
									case 0: $estatus='CANCELADA';								break;
									case 1: $estatus='ENVIADA';									break;
									case 2: $estatus='EN REVISIÓN POR CAPITAL HUMANO';			break;
									case 3: $estatus='RECHAZADA';								break;
									case 4: $estatus='AUTORIZADA';								break;
								}
								switch ($solicitud->tipo) {
								 	case 1: $tipo='VACACIONES';						break;
								 	case 2:	$tipo='NOTIFICACIÓN DE AUSENCIA';		break;
								 	case 3:	$tipo='PERMISO DE AUSENCIA';			break;
								 	case 4: $tipo='VIÁTICOS Y GASTOS DE VIAJE';		break;
									case 5: $tipo='COMPROBACIÓN DE GASTOS DE VIAJE';break;
								 	default: $tipo='';								break;
								 } ?>
								<tr onmouseover="this.style.background=color;" onmouseout="this.style.background='transparent';">
                                    <td align="center"><small><a class="view-pdf" href='<?= base_url("servicio/ver/$solicitud->id");?>'><?= $solicitud->id;?></a></small>
                                        
                                        <?php if( ( ($solicitud->colaborador == $this->session->userdata('id')) 
                                            && ($solicitud->alerta == 1)
                                            && (($solicitud->estatus == 3) || ($solicitud->estatus == 4))
                                            ) )
                                        {?>    
                                    &#09;<img height="15px" wigth="15px"  src="<?= base_url("assets/images/icons/nra.png");?>">
                                <?php }?>
                                        
                                    </td>
									<td align="center"><small><?= $tipo;?></small></td>
									<td align="center"><small><?= date('Y-m-d',strtotime($solicitud->fecha_solicitud));?></small></td>
									<td align="center"><small><?= $solicitud->nombre;?></small></td>
									<td align="center"><small><?= $solicitud->dias;?></small></td>
									<td align="center"><small><?= $solicitud->desde;?></small></td>
									<td align="center"><small><?= $solicitud->hasta;?></small></td>
									<td align="center"><small><?= $estatus;?></small></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#tbl').DataTable({responsive: true,order: [[ 0, "desc" ],[ 2, "desc" ]]});
		} );
		document.write('\
			<style>\
				.highlighted {\
					background: '+color+'\
				}\
				table>tbody>tr>td>small>div>h5{\
					height:30px;\
				}\
			</style>\
		');
	</script>