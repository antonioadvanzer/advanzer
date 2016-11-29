<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Solicitud de Vacaciones</h2>
	</div>
</div>
<div class="container">
	<div align="center"><a style="cursor:pointer;" onclick="window.history.back();">&laquo;Regresar</a></div>
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
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
		<input type="hidden" value="" id="ochoMeses">
		<div class="row" align="center">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="input-group" style="display:<?php if($this->session->userdata('tipo')<4) echo"none";?>;">
					<span class="input-group-addon">Colaborador</span>
					<select class="selectpicker" data-header="Selecciona al Colaborador" data-width="300px" data-live-search="true" 
						style="max-width:300px;text-align:center;" id="colaborador" required>
						<option value="" disabled selected>-- Selecciona al Colaborador --</option>
						<?php foreach($colaboradores as $colaborador): ?>
							<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$this->session->userdata('id'))echo"selected";?>><?= $colaborador->nombre;?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="input-group">
					<span class="input-group-addon required">Autorizador</span>
					<select class="selectpicker" data-header="Selecciona al autorizador" data-width="300px" data-live-search="true" 
						style="max-width:300px;text-align:center;" id="autorizador" required <?php //echo ($this->session->userdata('posicion') <= 4) ? "" :"disabled=disabled" ?>>
						<option value="" disabled selected>-- Selecciona al Jefe Directo / Líder --</option>
						
						<?php foreach($colaboradores as $colaborador):
							if(($colaborador->id != $this->session->userdata('id')) && ($colaborador->nivel_posicion <= 4)): ?>
								<option value="<?= $colaborador->id;?>" <?php if($colaborador->id==$yo->jefe)echo"selected";?>><?= $colaborador->nombre;?></option>
						<?php endif;
							endforeach; ?>
                        <?php foreach($autorizadores as $aut):?>
                            <option value="<?= $aut->id;?>" <?php if($aut->id==$yo->jefe)echo"selected";?>><?= $aut->nombre;?></option>
                        <?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<br>
		<div class="row" align="center">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="input-group">
					<span class="input-group-addon"># Nómina</span>
					<input class="form-control" style="text-align:center;cursor:default;background-color: #fff" value="" id="d_nomina" disabled>
					<span class="input-group-addon">Área Actual</span>
					<input class="form-control" style="min-width:300px;text-align:center;cursor:default;background-color: #fff" value="" id="d_area" disabled>
				</div>
				<br>
				<div class="input-group">
					<span class="input-group-addon">Fecha de Ingreso</span>
					<input class="form-control" style="text-align:center;cursor:default;background-color: #fff" value="" id="d_ingreso" disabled>
					<span class="input-group-addon">Antigüedad</span>
					<input class="form-control" style="text-align:center;cursor:default;background-color: #fff" value="" id="d_antiguo" disabled>
				</div>
				<input type="hidden" id="disponibles">
			</div>
		</div>
		<hr>
		<div class="row" align="center">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div id="generales">
					<h3>Detalle de Solicitud</h3>
					<div class="input-group">
						<span class="input-group-addon required">Días a Solicitar</span>
						<select class="form-control" style="background-color:white;min-width:80px" required id="dias" onchange="calculaFechas();"></select>
						<span class="input-group-addon required">Desde</span>
						<input class="form-control" type="text" id="desde" style="text-align:center;background-color:white;cursor:default" value="<?= date('Y-m-d');?>" required>
						<span class="input-group-addon required">Hasta</span>
						<input class="form-control" type="text" id="hasta" style="text-align:center;background-color:white;cursor:default" 
							value="" readonly required disabled>
						<span class="input-group-addon required">Regresa a Laborar</span>
						<input class="form-control" type="text" id="regresa" style="text-align:center;background-color:white;cursor:default" 
							value="" readonly required disabled>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon required" style="min-width:260px">Observaciones</span>
						<textarea class="form-control" id="observaciones" rows="4" placeholder="Agrega cualquier comentario que consideres relevante para la autorización de tus días" required></textarea>
					</div>
					<br>
				</div>
				<div id="auth" style="display:none;color:red;border-color:red;border-radius:10px;border-style:dashed;">
					<h5>Estás solicitando días adicionales a los que te corresponden actualmente. Se revisará si procede tu solicitud.</h5>
				</div>
				<br>
			</div>
		</div>
		<div class="row" align="right" id="botones">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button id="solicitar" type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;">Solicitar</button>
				</div>
			</div>
		</div>
        
    <div id="openModal" class="modalDialog">
        <div>
            <div id="title" class="title" align="center"><h2>Titulo</h2></div>
            <a title="Close" onclick="window.history.back();" class="close">X</a>
            <div id="body" class="body" align="center">  

            </div>
        </div>
    </div>
        
	</form>
	<script>
        
        function modalWindow(option){
            
            switch(option){
                   
                    // Confirmar si desea autorizar
            case "solicitar":

                document.getElementById("title").innerHTML = '<h2>Atención</h2>'
                document.getElementById("body").innerHTML = '<p>SE ESTÁ ENVIANDO TU SOLICITUD A AUTORIZACION. TAN PRONTO SEA RESUELTA, SE TE NOTIFICARÁ POR CORREO.</p>'
                                +'<a type="button" class="btn btn-primary" href="#procesando" onclick="solicitar();">Aceptar</a>&nbsp; &nbsp; '
                                +'<a type="button" class="btn btn-primary" onclick="window.history.back();">Cancelar</a>';
                window.document.location = "#openModal";

            break;

            case "confirm_solicitar":

                document.getElementById("title").innerHTML = '<h2>Aviso</h2>'
                document.getElementById("body").innerHTML = '<p>Se ha recibido su respuesta</p>'
                                +'<a type="button" class="btn btn-primary" onclick="confirm_solicitar();">Aceptar</a>';
                window.document.location = "#openModal";

            break;
            }
        }
        
        function solicitar(){
            
            /*if(!confirm('SE ESTÁ ENVIANDO TU SOLICITUD A AUTORIZACION. TAN PRONTO SEA RESUELTA, SE TE NOTIFICARÁ POR CORREO.'))
					return false;*/
				//get form values
			
            $("#colaborador option:selected").each(function() {
                    colaborador = $('#colaborador').val();
                });
                $("#autorizador option:selected").each(function() {
                    autorizador = $('#autorizador').val();
                });
                $('#dias :selected').each(function(){
                    dias=$('#dias').val();
                })
                acumulados = $('#acumulados').val();
                disponibles = $('#disponibles').val();
                desde = $('#desde').val();
                hasta = $('#hasta').val();
                regresa = $('#regresa').val();
                observaciones = $('#observaciones').val();
                ochoMeses=$('#ochoMeses').val();
				$.ajax({
					url: '<?= base_url("servicio/registra_solicitud");?>',
					type: 'post',
					data: {'colaborador':colaborador,'autorizador':autorizador,'dias':dias,'desde':desde,'hasta':hasta,'regresa':regresa,
						'observaciones':observaciones,'tipo':1,'ochoMeses':ochoMeses,'acumulados':acumulados},
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok")
							window.document.location='<?= base_url("solicitudes");?>';
						else{
							$('#cargando').hide('slow');
							$('#update').show('slow');
							$('#alert').prop('display',true).show('slow');
							$('#msg').html(returnedData['msg']);
							setTimeout(function() {
								$("#alert").fadeOut(1500);
							},3000);
						}
					},
					error: function(xhr) {
						console.log(xhr);
						$('#cargando').hide('slow');
						$('#update').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				});

				event.preventDefault();
        }
        
		document.write('\
			<style>\
				.required {\
					background: '+color+'\
				}\
			</style>\
		');
		function getColaborador() {
			$('#colaborador :selected').each(function(){
				colaborador=$('#colaborador').val();
			});
			if(colaborador != ""){
				$.ajax({
					url: '<?= base_url("servicio/getColabInfo");?>',
					type: 'post',
					data: {'colaborador':colaborador,'tipo':1},
					success: function(data){
						var returnedData = JSON.parse(data);

						/*alert(returnedData['maxdays']
							+" "+returnedData['acumulados']['dias_uno']
							+" "+returnedData['acumulados']['dias_dos']
							+" "+returnedData['acumulados']['dias_acumulados']
							+" "+returnedData['disponibles']
							+" "+returnedData['extra']);*/

						$('#ochoMeses').val(returnedData['ochoMeses']);
						$('#autorizador').val(returnedData['jefe']);
						$('#autorizador').selectpicker('refresh');
						//$('#disponibles').val(returnedData['disponibles']);
						$('#disponibles').val(returnedData['maxdays']);
						$('#dias').empty();
						/*if(returnedData['acumulados']['dias_acumulados'] > 0){
							$('#disponibles').val(parseInt(returnedData['acumulados']['dias_acumulados']) + parseInt($('#disponibles').val()));
						}*/
						for (var i = 1; i <= (parseInt($('#disponibles').val())+parseInt(returnedData['extra'])); i++) {
							$('#dias').append(new Option(i,i,true,true));
						}
						$('#d_nomina').val(returnedData['nomina']);
						$('#d_area').val(returnedData['nombre_area']);
						$('#d_ingreso').val(returnedData['fecha_ingreso']);
						$('#d_antiguo').val(returnedData['diff']['y']+' años, '+returnedData['diff']['m']+' meses');
						$('#dias').val('');
						$('#desde').val(returnedData['fecha_minima']);
						calculaFechas();
						$('#observaciones').val('');
					},
					error: function(xhr) {
						console.log(xhr.responseText);
					}
				});
			}
		}
		function calculaFechas() {
			patron = /^\d*$/;
			$('#dias :selected').each(function(){
				dias=$('#dias').val();
			})
			dias=parseInt(dias);
			if(dias > 0){
				inicio=$('#desde').val();
				hasta=sumaFecha(dias,inicio);
				$('#hasta').val(hasta);
				$('#regresa').val(sumaFecha(dias+1,inicio));
			}else{
				$('#hasta').val('');
				$('#regresa').val('');
			}
			if(dias > parseInt($('#disponibles').val()))
				$('#auth').show('slow');
			else
				$('#auth').hide('slow');
		}
		sumaFecha = function(d, fecha){
			var Fecha = new Date();
			var sFecha = fecha || (Fecha.getFullYear() + "-" + (Fecha.getMonth() +1) + "-" + Fecha.getDate());
			var aFecha = sFecha.split('-');
			var fecha = aFecha[0]+'-'+aFecha[1]+'-'+aFecha[2];
			fecha= new Date(fecha);
			i=0;
			while(i < parseInt(d)){
				fecha.setTime(fecha.getTime()+24*60*60*1000);
				if(fecha.getDay() != 6 && fecha.getDay() != 0)
					i++;
			}
			//fecha.setDate(fecha.getDate()+parseInt(d));
			var anno=fecha.getFullYear();
			var mes= fecha.getMonth()+1;
			var dia= fecha.getDate();
			mes = (mes < 10) ? ("0" + mes) : mes;
			dia = (dia < 10) ? ("0" + dia) : dia;
			var fechaFinal = anno+'-'+mes+'-'+dia;
			return (fechaFinal);
		}
		$(document).ready(function() {//alert(pascua(2016)+" "+lunes_pascua(pascua(2016)));
			// set location
			$.datepicker.setDefaults($.datepicker.regional['es']);

			$('#razon').hide('slow');
			calculaFechas();
			getColaborador();
			$('#desde').datepicker({
				dateFormat: 'yy-mm-dd',
				minDate: '<?= date("Y-m-d");?>',
				beforeShowDay: noWeekendsOrHolidays
			});
			$('#hasta').datepicker({
				dateFormat: 'yy-mm-dd',
				beforeShowDay: $.datepicker.noWeekends
			});
			$('#regresa').datepicker({
				dateFormat: 'yy-mm-dd',
				beforeShowDay: $.datepicker.noWeekends
			});
			$('#hasta').change(function() {
				hasta=$('#hasta').val();
				regresa=sumaFecha(2,hasta);
				$('#regresa').val(regresa);
			});

			$("#desde").change(function() {
				calculaFechas();
			});

			$("#colaborador").change(function() {
				getColaborador();
			});

			$("#update").submit(function(event){
				
                modalWindow("solicitar");
                
                /*if(!confirm('SE ESTÁ ENVIANDO TU SOLICITUD A AUTORIZACION. TAN PRONTO SEA RESUELTA, SE TE NOTIFICARÁ POR CORREO.'))
					return false;
				//get form values
					$("#colaborador option:selected").each(function() {
						colaborador = $('#colaborador').val();
					});
					$("#autorizador option:selected").each(function() {
						autorizador = $('#autorizador').val();
					});
					$('#dias :selected').each(function(){
						dias=$('#dias').val();
					})
					acumulados = $('#acumulados').val();
					disponibles = $('#disponibles').val();
					desde = $('#desde').val();
					hasta = $('#hasta').val();
					regresa = $('#regresa').val();
					observaciones = $('#observaciones').val();
					ochoMeses=$('#ochoMeses').val();
				$.ajax({
					url: '<?= base_url("servicio/registra_solicitud");?>',
					type: 'post',
					data: {'colaborador':colaborador,'autorizador':autorizador,'dias':dias,'desde':desde,'hasta':hasta,'regresa':regresa,
						'observaciones':observaciones,'tipo':1,'ochoMeses':ochoMeses,'acumulados':acumulados},
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){
						var returnedData = JSON.parse(data);
						console.log(returnedData['msg']);
						if(returnedData['msg']=="ok")
							window.document.location='<?= base_url("solicitudes");?>';
						else{
							$('#cargando').hide('slow');
							$('#update').show('slow');
							$('#alert').prop('display',true).show('slow');
							$('#msg').html(returnedData['msg']);
							setTimeout(function() {
								$("#alert").fadeOut(1500);
							},3000);
						}
					},
					error: function(xhr) {
						console.log(xhr);
						$('#cargando').hide('slow');
						$('#update').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				});

				event.preventDefault();*/
			});
		});

		//date and calculate holidays
		var now = new Date();
		var disabledDates = [
			'01/01/'+ now.getFullYear(),
			'01/04/'+ now.getFullYear(),
			'16/09/'+ now.getFullYear(),
			'24/12/'+ now.getFullYear(),
			'25/12/'+ now.getFullYear(),
			'31/12/'+ now.getFullYear()
		];

		function noWeekendsOrHolidays(date) {
			var noWeekend = $.datepicker.noWeekends(date);
			if (noWeekend[0]) {
				return disableDays(date);
			} else {
				return noWeekend;
			}
		}

		function disableDays(date) {
			for (var i = 0; i < disabledDates.length; i++) {
				if (new Date(disabledDates[i]).toString() == date.toString()) {
					return [false];
				}
			}
			return [true];
		}

		function pascua($annio) {
			if      ($annio>1583 && $annio<1699) { $M=22; $N=2; }
			else if ($annio>1700 && $annio<1799) { $M=23; $N=3; }
			else if ($annio>1800 && $annio<1899) { $M=23; $N=4; }
			else if ($annio>1900 && $annio<2099) { $M=24; $N=5; }
			else if ($annio>2100 && $annio<2199) { $M=24; $N=6; }
			else if ($annio>2200 && $annio<2299) { $M=25; $N=0; }
			$a = $annio % 19;
			$b = $annio % 4;
			$c = $annio % 7;
			$d = ((19*$a) + $M) % 30;
			$e = ((2*$b) + (4*$c) + (6*$d) + $N) % 7;
			$f = $d + $e;
			if ($f < 10) {
				$dia = $f + 22;
				$mes = 2;
			} else  {
				$dia = $f - 9;
				$mes = 3;
			};
			if ($dia == 26 && $mes == 4){
				$dia = 19;
			};
			if ($dia == 25 && $mes == 4 && $d == 28 && $e == 6 && $a > 10){
				$dia = 18;
			};
			$pascua = new Date($annio,$mes,$dia);
			return $pascua;
		};

		function lunes_pascua($pascua){
			$time = $pascua.getTime();
			$dias = 6*24*60*60*1000 //recuerda que en javascript se expresa en milisegundos
			$lunes = $time-$dias;
			$lunes = new Date($lunes);
			return $lunes;
		}
	</script>