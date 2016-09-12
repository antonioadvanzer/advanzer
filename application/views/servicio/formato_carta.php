<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Solicitud de Carta o Constancia Laboral</h2>
		<!--<ul>
			<li>Sea claro en sus necesidades, esto facilitará la labor en la búsqueda del candidato que cubra de la mejor manera su requerimiento.</li>
		</ul>-->
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
	<input id="id" type="hidden" value="">
	<form id="update" role="form" method="post" action="javascript:" class="form-signin">
		<div class="row" align="center">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<br>
				<div class="input-group">
					<span class="input-group-addon">Nombre Completo</span>
					<input type="text" id="name" name="name" class="form-control" value="<?= $this->session->userdata('nombre');?>" disabled>
					<span class="input-group-addon">A Quien va Dirigida la Carta</span>
					<input type="text" id="person" name="person" class="form-control" required>
				</div>
				<br>
				<div class="input-group" align="left">
					<h5 class="form-control">Selecciona los datos deber&aacute; contener:</h5>
					<br><br>
					<span class="">
						<input type="checkbox" id="sueldo" name="sueldo">
						Sueldo<br>
						<input type="checkbox" id="imss" name="imss">
						IMSS<br>
						<input type="checkbox" id="rfc" name="rfc">
						RFC<br>
						<input type="checkbox" id="curp" name="curp">
						CURP<br>
						<input type="checkbox" id="antiguedad" name="antiguedad">
						Antiguedad<br>
						<input type="checkbox" id="puesto" name="puesto">
						Puesto<br>
						<input type="checkbox" id="domicilio" name="domicilio">
						Domicilio Particular<br>
					</span>

				</div>
				<br>
			
				<div class="input-group">
					<span class="input-group-addon" style="min-width:260px">Observaciones o Datos Adicionales</span>
					<textarea class="form-control" id="observaciones" rows="4" 
						placeholder="" required></textarea>
				</div>
				<br>
			</div>
		</div>
		<div class="row" align="center">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="btn-group btn-group-lg" role="group" aria-label="...">
					<button type="submit" class="btn btn-primary" style="min-width:200px;text-align:center;display:inline;">Enviar</button>
					<button onclick="window.history.back();" type="button" class="btn" style="min-width:200px;text-align:center;display:inline;">Cancelar</button>
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
                    
                    case "enviar":
                        
                        document.getElementById("title").innerHTML = '<h2>Atención</h2>'
                        document.getElementById("body").innerHTML = '<p>Te recordamos que tu carta estará lista en un lapso de 3 dias habiles<br>¡Estamos a tus ordenes!</p>'
                                        +'<a type="button" class="btn btn-primary" href="#procesando" onclick="enviar();">Aceptar</a>&nbsp; &nbsp; '
                                        +'<a type="button" class="btn btn-primary" onclick="window.history.back();">Cancelar</a>';
                        window.document.location = "#openModal";
                    
                    break;
                    
                    case "confirm_enviar":
                    
                        document.getElementById("title").innerHTML = '<h2>Aviso</h2>'
                        document.getElementById("body").innerHTML = '<p>Se ha enviado a Capital Humano</p>'
                                        +'<a type="button" class="btn btn-primary" onclick="confirm_enviar();">Aceptar</a>';
                        window.document.location = "#openModal";
                    
                    break;
            }
            
        }
        
        function enviar(){
            
				//get form values
					data={};
					data['name'] = $('#name').val();
					data['person'] = $('#person').val();
					data['observaciones'] = $('#observaciones').val();
					data['sueldo'] = ($('#sueldo').is(":checked")) ? "1" : " ";
					data['imss'] = ($('#imss').is(":checked")) ? "1" : " ";
					data['rfc'] = ($('#rfc').is(":checked")) ? "1" : " ";
					data['curp'] = ($('#curp').is(":checked")) ? "1" : " ";
					data['antiguedad'] = ($('#antiguedad').is(":checked")) ? "1" : " ";
					data['puesto'] = ($('#puesto').is(":checked")) ? "1" : " ";
					data['domicilio'] = ($('#domicilio').is(":checked")) ? "1" : " ";
				
            $.ajax({
					url: '<?= base_url("enviar_carta");?>',
					type: 'post',
					data: data,
					beforeSend: function() {
						$('#update').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data){//alert(data);
						var returnedData = JSON.parse(data);
						if(returnedData['msg']=="ok"){
							
                            /*
							window.document.location='<?= base_url("");?>';*/
						
                            $('#update').show('slow');
                            $('#cargando').hide('slow');
                            
                            window.modalWindow("confirm_enviar");    
                            
                        }else if(returnedData['msg']=="cancel"){
							
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
						console.log(xhr.responseText);
						$('#cargando').hide('slow');
						$('#update').show('slow');
						$('#alert').prop('display',true).show('slow');
						$('#msg').html('Error, intenta de nuevo o contacta al Administrador de la Aplicación');
						setTimeout(function() {
							$("#alert").fadeOut(1500);
						},3000);
					}
				});
        }
        
        function confirm_enviar(){           
            window.document.location='<?= base_url("main");?>';
        }
        
		$(document).ready(function() {
			
			$("#update").submit(function(event){
				
                modalWindow("enviar");
            });

		});
	</script>