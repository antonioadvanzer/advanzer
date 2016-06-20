<?php
	$ingreso=new DateTime($yo->fecha_ingreso);
	$hoy=new DateTime(date('Y-m-d'));
	$date_dif = $ingreso->diff($hoy);
?>
<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Vacaciones</b></h2>
	</div>
</div>
<div class="container">
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
    <div class="row" align="left">
		
        <div class="col-md-6"><button class="btn btn-primary" onclick="location.href='<?= base_url("solicitudes")."/?tipo=vacaciones";?>';"><big>Solicitudes Propias</big></button></div>
	   
        <div class="col-md-6"><button class="btn btn-primary" onclick="location.href='<?= base_url("solicitudes_pendientes");?>';"><big>Solicitudes Recibidas</big></button></div>
        
    </div>
    <br/>
	<div class="row">
		<div class="col-md-12">
			Las vacaciones que generas como empleado de Advanzer/Entuizer son de acuerdo al artículo 76 de la Ley Federal del Trabajo (en rojo los días que te corresponden de acuerdo a tu antigüedad):
			<p>
                <table align="center" style="width:50%" class="tbl table table-condensed table-bordered">
				<tbody>
					<tr>
						<th width="10%" style="cursor:default;text-align:center;">Años</th>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 1) echo 'bgcolor="red"' ?>>1</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 2) echo 'bgcolor="red"' ?>>2</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 3) echo 'bgcolor="red"' ?>>3</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 4) echo 'bgcolor="red"' ?>>4</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 5 && $date_dif->y+1 <= 9) echo 'bgcolor="red"' ?>>5-9</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 10 && $date_dif->y+1 <= 14) echo 'bgcolor="red"' ?>>10-14</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 15 && $date_dif->y+1 <= 19) echo 'bgcolor="red"' ?>>15-19</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 20 && $date_dif->y+1 <= 24) echo 'bgcolor="red"' ?>>20-24</td>
						<td width="10%" style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 25 && $date_dif->y+1 <= 29) echo 'bgcolor="red"' ?>>25-29</td>
					</tr>
					<tr><th style="cursor:default;text-align:center;">Días</th>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 1) echo 'bgcolor="red"' ?>>6</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 2) echo 'bgcolor="red"' ?>>8</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 3) echo 'bgcolor="red"' ?>>10</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 == 4) echo 'bgcolor="red"' ?>>12</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 5 && $date_dif->y+1 <= 9) echo 'bgcolor="red"' ?>>14</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 10 && $date_dif->y+1 <= 14) echo 'bgcolor="red"' ?>>16</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 15 && $date_dif->y+1 <= 19) echo 'bgcolor="red"' ?>>18</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 20 && $date_dif->y+1 <= 24) echo 'bgcolor="red"' ?>>20</td>
						<td style="cursor:default;text-align:center;" <?php if($date_dif->y+1 >= 25 && $date_dif->y+1 <= 29) echo 'bgcolor="red"' ?>>22</td></tr>
				</tbody>
            </table>
            </p>
			<p>
            <table align="center" style="width:50%" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>Días Disponibles</th>
						<th>Días próximos a vencer</th>
						<th>Fecha de vencimiento</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="cursor:default;text-align:center;"><?php $cantdias=0; $suma=0; 
                            if($yo->acumulados){ 
                                $cantdias = $yo->disponibles + $yo->acumulados->dias_acumulados + $yo->acumulados->dias_dos;
                            }else{ 
                                $cantdias = $yo->disponibles;
                            }
                            
                            echo $cantdias;
                            
                            ?></td>
						<td style="cursor:default;text-align:center;"><?php if($yo->acumulados){$suma=$yo->acumulados->dias_uno+$yo->de_solicitud; if($suma>0)echo $suma;}else echo 0;?></td>
						<td style="cursor:default;text-align:center;"><?php if($yo->acumulados) if($suma>0) echo date_format(date_create($yo->acumulados->vencimiento_uno),'j-M-Y')?></td>
					</tr>
				</tbody>
			</table>
            </p>
		</div>
	</div><br>
    
    <?php
    if($cantdias <= 0){
    ?>    
    <div class="alert alert-warning" align="center">
        <strong>¡Atención!</strong> Ya no tienes dias disponibles, te sugerimos solicitar un permiso de ausencia.
    </div>
    <?php 
        }
    ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default" style="background-color:color;">
				<div class="panel-heading">
						<h3 class="panel-title">Premisas Básicas</h3>
				</div>
				<div class="panel-body" id="premisas">
					<ol type="a">
						<p><li>Los días que se consideran como hábiles, son los días que laboras de acuerdo a tus condiciones contractuales. Por ejemplo: Si laboras de Lunes a Viernes, los días hábiles son esos 5 y los días Sábado y Domingo no se contabilizan como vacaciones sino como días de descanso.</li></p>
						<p><li>Podrás disfrutar de los días proporcionales de vacaciones que te corresponden a partir de los 9 meses de ingreso a la empresa.</li></p>
						<p><li>A partir de tu fecha de aniversario cuentas con un período de 18 meses para disfrutar tus días de vacaciones. Los días de vacaciones que no se disfruten dentro del período de 18  meses establecido no se acumularán para el siguiente período y caducarán. Por ningún motivo se pagarán los días no disfrutados.</li></p>
						<p><li>La Prima Vacacional será pagada en la segunda quincena del mes que corresponda a tu aniversario de la empresa y corresponde al 25% de los días de vacaciones generados en el período que acabe de cerrar.</li></p>
						<p><li>Las vacaciones deberán solicitarse con un período mínimo de 30 días y las autorizaciones que deberás gestionar son las siguientes (según aplique):
							<ul type="square">
								<li>Si estás en proyecto: El líder de proyecto te autorizará.</li>
								<li>Si no está en proyecto o eres área administrativa: El superior inmediato de acuerdo a la estructura será quien autorice.</li>
							</ul>
						</li></p>
						<p><li>Una vez autorizadas por tu líder/superior, tu solicitud pasará a validación por parte de Capital Humano. Una vez que Capital Humano valide, se te notificará vía correo electrónico.</li></p>
						<p><li>Los dias mostrados como disponibles, son los dias proporcionales disponibles al día de hoy.</li></p>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div align="center"><button class="btn btn-primary" onclick="location.href='<?= base_url("solicitar_vacaciones");?>';"><big>Solicitar Vacaciones</big></button></div>
	</div>
	<hr>
	<script>
		document.write('\
			<style>\
				.tbl > tbody > tr > th {\
					background: '+color+'\
				}\
				table>thead>tr>th {\
					background: '+color+'\
				}\
			</style>\
		');
	</script>