<div class="jumbotron">
	<div class="container">
		<h2 align="left"><b>Permiso de Ausencia</b></h2>
	</div>
</div>
<div class="container">
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
    <div class="row" align="left">
		
        <div class="col-md-6"><button class="btn btn-primary" onclick="location.href='<?= base_url("solicitudes")."/?tipo=permiso";?>';"><big>Solicitudes Propias</big></button></div>
        
        <div class="col-md-6"><button class="btn btn-primary" onclick="location.href='<?= base_url("solicitudes_pendientes");?>';"><big>Solicitudes Recibidas</big></button></div>
        
	</div>
    <br/>
	<div class="row">
		<div class="col-md-12">
			<p>La ausencia a tus labores de la cual haya conocimiento con antelación podrá ser autorizada como permiso (con goce o sin goce de sueldo) de acuerdo a los lineamientos que continuación se describen.
			<ol type="1">
				<p><li>Ausencias Justificadas</li>
				<ol type="a">
					<p><li>Las situaciones previstas por Capital Humano dentro de las cuales se podrá autorizar un permiso de ausencia justificada serán las siguientes:
						<p><table width="50%" align="center" class="tbl table-condensed table-bordered">
							<thead>
								<tr>
									<th style="cursor:default">Ocasión</th>
									<th style="cursor:default">Días Autorizados</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="cursor:default">Matrimonio</td>
									<td style="cursor:default">2 Días hábiles</td></tr>
								<tr>
									<td style="cursor:default">Nacimiento de Hijos</td>
									<td style="cursor:default">5 Días hábiles</td></tr>
								<tr>
									<td style="cursor:default">Fallecimiento de Cónyuge</td>
									<td style="cursor:default">2 Días hábiles</td></tr>
								<tr>
									<td style="cursor:default">Fallecimiento de Hermanos</td>
									<td style="cursor:default">2 Días hábiles</td></tr>
								<tr>
									<td style="cursor:default">Fallecimiento de Hijos</td>
									<td style="cursor:default">3 Días hábiles</td></tr>
								<tr>
									<td style="cursor:default">Fallecimiento de Padres</td>
									<td style="cursor:default">3 Días hábiles</td></tr>
								<tr>
									<td style="cursor:default">Fallecimiento Padres Políticos</td>
									<td style="cursor:default">2 Días hábiles</td></tr>
							</tbody>
						</table></p>
					</li></p>
					<p><li>Procedimiento</li></p>
					<ol type="i">
						<p><li>Ingresar a tu Portal Personal, llena la Solicitud de Ausencia y enviala a autorización con tu Superior Inmediato o Líder de Proyecto.</li></p>
						<p><li>Una vez autorizada por tu Superior Inmediato o Líder de Proyecto pasará a validación a Capital Humano.</li></p>
						<p><li>Contando con ambas autorizaciones, serás notificado vía correo electrónico.</li></p>
					</ol>
				</ol></p>
				<p><li>Ausencias por Enfermedad</li>
				<ol type="a">
					<p><li>Si se trata de Incapacidad por parte del IMSS, deberás subir a la solicitud de Ausencia, el comprobante expedido por el Instituto para que proceda el pago de tus días de ausencia.</li></p>
					<p><li>Si se trata de Ausencia por enfermedad y la atención fue de forma particular deberás subir a la Solicitud de Ausencia, el comprobante médico para que proceda el pago de tus días de ausencia.</li></p>
					<p><li>Procedimiento</li></p>
					<ol type="i">
						<p><li>Deberás ingresar a tu Portal Personal, llenar y enviar la Solicitud de Ausencia, marcando como motivo "Enfermedad".</li></p>
						<p><li>Deberás subir en el campo correspondiente, el comprobante médico que justifique tus días de ausencia.</li></p>
						<p><li>Tu Superior Inmediato/Líder de Proyecto y Capital Humano serán notificados de los días, enfermedad y comprobante de la misma vía correo electrónico.</li></p>
					</ol>
				</ol>
				<p><li>Otras Ausencias</li>
				<ol type="a">
					<p><li>En el caso que requirieras ausentarte con antelación de tus labores por una situación específica y justificada y el motivo no sea contemplado dentro del punto anterior, deberás primeramente considerar solicitar los días de ausencia vía vacaciones.</li></p>
					<p><li>En caso de no contar con días disponibles deberás llenar la Solicitud de Ausencia y los días solicitados serán sin goce de sueldo.</li></p>
					<p><li>El periodo máximo de Permiso de Ausencia es de 5 días</li></p>
					<p><li>Procedimiento</li></p>
					<ol type="i">
						<p><li>Deberás ingresar a tu Portal Personal, llenar y enviar la Solicitud de Ausencia marcando como motivo "Otros", especificar el motivo y detallar en el campo de Observaciones el motivo de la ausencia.</li></p>
						<p><li>Una vez autorizada por tu Superior Inmediato/Líder de Proyecto pasará a validación a Capital Humano.</li></p>
						<p><li>Una vez que cuentes con las autorizaciones requeridas, serás notificado vía correo electrónico si fue autorizado o no el permiso.</li></p>
					</ol>
				</ol></p>
			</ol>
			Cualquier situación no expuesta en esta Política, deberás verificarlo con Capital Humano.</p>
		</div>
	</div>
	<div class="row" align="center">
		<button class="btn btn-primary" onclick="location.href='<?= base_url("solicitar_permiso");?>';"><big>Solicitar Permiso de Ausencia</big></button>
	</div>
	<hr>
	<script>
		document.write('\
			<style>\
				.tbl > thead > tr > th {\
					background: '+color+'\
				}\
			</style>\
		');
	</script>