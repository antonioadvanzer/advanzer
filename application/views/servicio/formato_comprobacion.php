<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Comprobación de Gastos de Viaje</h2>
	</div>
</div>
<div class="container">
	<div align="center"><a style="text-decoration:none;cursor:pointer" onclick="window.history.back();">&laquo;Regresar</a></div>
	<div align="center" id="alert" style="display:none">
		<div class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<label id="msg"></label>
		</div>
	</div>
	<hr>
	<div class="row" align="center">
		<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
			<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
	</div>
	<div class="row" align="center">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="input-group">
				<span class="input-group-addon">Colaborador</span>
				<select class="selectpicker" data-header="Selecciona al Colaborador" data-width="300px" data-live-search="true" 
					style="max-width:300px;text-align:center;" id="colaborador" required <?php if($this->session->userdata('tipo')<4) echo"disabled";?>>
					<option value="" disabled selected>-- Selecciona al Colaborador --</option>
					<?php foreach($colaboradores as $colaborador): ?>
						<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$this->session->userdata('id'))echo"selected";?>><?= $colaborador->nombre;?></option>
					<?php endforeach; ?>
				</select>
				<span class="input-group-addon">Centro de Costo</span>
				<input type="text" class="form-control" id="centro_costo" value="" required>
			</div><br>
		</div>
	</div>
	<div class="row" id="registros" align="center">
		<form id="comprobante" role="form" method="post" action="javascript:" class="form-signin" enctype="multipart/form-data"><div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Comprobante</div>
				<div class="input-group">
					<span class="input-group-addon">Factura</span>
					<input id="factura" type="file" name="factura"  accept="text/xml" onchange="leeXML(this.form);" class="form-control" style="text-align:center;">
				</div>
				<div class="input-group">
					<span class="input-group-addon">Fecha</span>
					<input type="text" class="form-control datepicker" style="text-align:center;background-color:white;" value="" readonly required name="fecha[]">
					<span class="input-group-addon">Concepto</span>
					<select id="concepto" class="form-control" required name="concepto[]" style="text-align:center;">
						<option value="" disabled selected>-- Selecciona un Concepto --</option>
						<option>Consumo</option>
						<option>Propina</option>
						<option>Autobús</option>
						<option>Caseta</option>
						<option>Gasolina</option>
						<option>Mensajería</option>
						<option>Renta de Auto</option>
						<option>Taxi</option>
						<option>Vuelo</option>
						<option>Otros</option>
					</select>
				</div>
				<div class="input-group">
					<span class="input-group-addon">Prestador del Servicio</span>
					<input type="text" class="form-control" id="prestador" value="" required name="prestador[]" style="text-align:center;">
				</div>
				<div class="input-group">
					<span class="input-group-addon">Importe</span>
					<input type="text" class="form-control" id="importe" value="0" name="importe[]" required onchange="setTotal(this.form);sumarTotales();" style="text-align:center;">
					<span class="input-group-addon">IVA</span>
					<input type="text" class="form-control" id="iva" value="0" name="iva[]" required onchange="setTotal(this.form);sumarTotales();" style="text-align:center;">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" id="total" value="0" name="total[]" readonly required style="text-align:center;background-color:white;cursor:default;">
				</div>
				<input id="agregar" onclick="agg(this.form);" type="button" class="btn btn-primary" style="text-align:center;display:inline;" value="+ Add">
				<input id="eliminar" onclick="if(confirm('Seguro que desea eliminar el comprobante?')){this.form.remove();sumarTotales();}" type="button" class="btn btn-primary" style="text-align:center;display:none;" value="- Del">
			</div>
		</div></form>
	</div>
	<div class="row" align="center">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th><span class="input-group-addon">Importe</span></th>
						<th><span class="input-group-addon">IVA</span></th>
						<th><span class="input-group-addon">Total</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="cursor:default;"></td>
						<td style="cursor:default;"><input type="text" value="0" readonly id="suma_importe" class="form-control"></td>
						<td style="cursor:default;"><input type="text" value="0" readonly id="suma_iva" class="form-control"></td>
						<td style="cursor:default;"><input type="text" value="0" readonly id="suma_total" class="form-control"></td>
					</tr>
					<tr>
						<td style="cursor:default;"><span class="input-group-addon">Anticipo</span></td>
						<td style="cursor:default;"></td>
						<td style="cursor:default;"></td>
						<td style="cursor:default;"><input type="text" class="form-control" value="0" id="anticipo" disabled style="cursor:default;" onchange="setDiferencia();"></td>
					</tr>
					<tr>
						<td style="cursor:default;"><span class="input-group-addon">Diferencia</span></td>
						<td style="cursor:default;"></td>
						<td style="cursor:default;"></td>
						<td style="cursor:default;"><input type="text" class="form-control" value="0" id="diferencia" readonly></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row" align="center">
		<div class="col-md-12">
			<div class="btn-group btn-group-lg" role="group" aria-label="...">
				<button id="enviar" type="button" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Enviar</button>
			</div>
		</div>
	</div>
	<script>
		function leeXML(form) {
			if(form.factura.value ==''){
				form.elements['fecha[]'].value='';
				form.prestador.value='';
				form.importe.value='';
				form.iva.value='';
				form.total.val='';
				form.concepto.value='';
			}
			var formData = new FormData(form);
			$.ajax({
				url: '<?= base_url("servicio/leeXML");?>',
				type: 'post',
				cache: false,
				contentType: false,
				processData: false,
				resetForm: true,
				data: formData,
				success: function(data){
					var returnedData = JSON.parse(data);
					form.elements['fecha[]'].value=returnedData['fecha'];
					form.prestador.value=returnedData['prestador']['0'];
					form.importe.value=returnedData['subTotal']['0'];
					form.iva.value=returnedData['iva']['0'];
					form.total.value=returnedData['total']['0'];
					form.concepto.value='';
					sumarTotales();
				},
				error: function(xhr) {
					console.log(xhr.responseText);
				}
			});
		}
		function setDiferencia() {
			$('#diferencia').val(parseFloat($('#anticipo').val()) - parseFloat($("#suma_total").val()));
		}
		function setTotal(form) {
			form.total.value = parseFloat(form.importe.value)+parseFloat(form.iva.value);
		}
		function sumarTotales() {
			importe = 0;
			iva = 0;
			total = 0;
			$("form#comprobante").each(function() {
				importe+=parseFloat(this.importe.value);
				iva+=parseFloat(this.iva.value);
				total+=parseFloat(this.total.value);
			});
			if(importe>=0)
				$('#suma_importe').val(importe);
			if(iva>=0)
				$('#suma_iva').val(iva);
			if(total>=0)
				$('#suma_total').val(total);
			setDiferencia();
		}
		function agg(form){
			if(form.elements['fecha[]'].value==''){
				form.elements['fecha[]'].focus();
				return false;
			}
			if(form.concepto.options[form.concepto.selectedIndex].value==''){
				alert('Elige un Concepto');
				form.concepto.focus();
				return false;
			}
			if(form.prestador.value==''){
				form.prestador.focus();
				return false;
			}
			if(form.total.value==0){
				alert('Verifica los montos');
				form.importe.focus();
				return false;
			}
			form.eliminar.style.display='block';
			form.agregar.style.display='none';
			sumarTotales();
			$('#registros').append('<form id="comprobante" role="form" method="post" action="javascript:" class="form-signin" enctype="multipart/form-data"><div class="col-md-6">\
				<div class="panel panel-default">\
					<div class="panel-heading">Comprobante</div>\
					<div class="input-group">\
						<span class="input-group-addon">Factura</span>\
						<input id="factura" type="file" name="factura"  accept="text/xml" onchange="leeXML(this.form);" class="form-control" style="text-align:center;">\
					</div>\
					<div class="input-group">\
						<span class="input-group-addon">Fecha</span>\
						<input type="text" class="form-control datepicker" style="text-align:center;background-color:white;" value="" readonly required name="fecha[]">\
						<span class="input-group-addon">Concepto</span>\
						<select id="concepto" class="form-control" required name="concepto[]" style="text-align:center;">\
							<option value="" disabled selected>-- Selecciona un Concepto --</option>\
							<option>Consumo</option>\
							<option>Propina</option>\
							<option>Autobús</option>\
							<option>Caseta</option>\
							<option>Gasolina</option>\
							<option>Mensajería</option>\
							<option>Renta de Auto</option>\
							<option>Taxi</option>\
							<option>Vuelo</option>\
							<option>Otros</option>\
						</select>\
					</div>\
					<div class="input-group">\
						<span class="input-group-addon">Prestador del Servicio</span>\
						<input type="text" class="form-control" id="prestador" value="" required name="prestador[]" style="text-align:center;">\
					</div>\
					<div class="input-group">\
						<span class="input-group-addon">Importe</span>\
						<input type="text" class="form-control" id="importe" value="0" name="importe[]" required onchange="setTotal(this.form);sumarTotales();" style="text-align:center;">\
						<span class="input-group-addon">IVA</span>\
						<input type="text" class="form-control" id="iva" value="0" name="iva[]" required onchange="setTotal(this.form);sumarTotales();" style="text-align:center;">\
						<span class="input-group-addon">Total</span>\
						<input type="text" class="form-control" id="total" value="0" name="total[]" readonly required style="text-align:center;background-color:white;cursor:default;">\
					</div>\
					<input id="agregar" onclick="agg(this.form);" type="button" class="btn btn-primary" style="text-align:center;display:inline;" value="+ Add">\
					<input id="eliminar" onclick="if(confirm(\'Seguro que desea eliminar el comprobante?\')){this.form.remove();sumarTotales();}" type="button" class="btn btn-primary" style="text-align:center;display:none;" value="- Del">\
				</div>\
			</div></form>');
			setDiferencia();
			//$('input').filter('.datepicker').removeClass('hasDatepicker').datepicker();
			$('input').filter('.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd'
			});
		}
		$(document).ready(function() {
			$('input').filter('.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd'
			});

			$('#centro_costo').change(function() {
				centro_costo=$('#centro_costo').val();
				$('#colaborador :selected').each(function(){
					colaborador=$('#colaborador').val();
				});
				$.ajax({
					url: '<?= base_url("servicio/getViaticosInfo");?>',
					type: 'post',
					data: {'colaborador':colaborador,'centro_costo':centro_costo,'tipo':4},
					success: function(data){
						var returnedData = JSON.parse(data);
						if(returnedData['viaticos'])
							$('#anticipo').val(returnedData['viaticos']['anticipo']).prop('disabled',true);
						else
							$('#anticipo').val(0).prop('disabled',false);
						setDiferencia();
					},
					error: function(xhr) {
						console.log(xhr.responseText);
					}
				});
			});

			$('#enviar').click(function() {
				if($('#centro_costo').val()==''){
					$('#centro_costo').focus();
					return false;
				}
				$('form#comprobante').each(function() {
					flag=0;
					if(this.elements['fecha[]'].value!='' && this.concepto.options[this.concepto.selectedIndex].value!='' && this.prestador.value!='' && this.importe.value!=0 && this.iva.value!=0){
						flag++;
						var formData = new FormData(this);
						$('#colaborador :selected').each(function(){
							colaborador=$('#colaborador').val();
						});
						formData.append('colaborador',colaborador);
						formData.append('centro_costo',$('#centro_costo').val());
						formData.append('diferencia',$('#diferencia').val());
						console.log(formData);
						$.ajax({
							url: '<?= base_url("servicio/guardar_comprobante");?>',
							type: 'post',
							cache: false,
							contentType: false,
							processData: false,
							resetForm: true,
							data: formData,
							success: function(data){
								console.log(data);
								var returnedData = JSON.parse(data);
								if(returnedData['msg']=='ok')
									this.remove();
							},
							error: function(xhr) {
								console.log(xhr.responseText);
							}
						});
					}
					alert(flag+' comprobantes se han turnado al área de finanzas para su validación y aceptación');
				});
			});
		});
	</script>