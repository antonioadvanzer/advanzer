<style type="text/css">
	.accordion {
	  margin: 40px auto;
	  text-align: center;
	}
	.accordion h1, h2, h3, h4 {
	  cursor: pointer;
	}
	.accordion h1 {
	  padding: 15px 20px;
	  background-color: #444;
	  font-size: 2rem;
	  font-weight: normal;
	  color: #FFF;
	  text-transform: uppercase;
	}
	.accordion h1:hover {
	  color: #999;
	}
	.accordion h1:first-child {
	  border-radius: 10px 10px 0 0;
	}
	.accordion h1:last-of-type {
	  border-radius: 0 0 10px 10px;
	}
	.accordion h1:not(:last-of-type) {
	  border-bottom: 1px dotted #FFF;
	}
	.accordion h2 {
	  padding: 5px 25px;
	  font-size: 1.2rem;
	  color: #666666;
	  text-transform: uppercase;
	}
	.accordion h2:hover {
	  color: #000;
	}
	.accordion label {
	  width: 100%;
	  padding: 5px 30px;
	  font-size: 1.2rem;
	  color: #000; 
	}
	.accordion h3:hover {
	  background-color: #000;
	  color: #FFF;
	}
	.accordion h4 {
	  padding: 5px 35px;
	  background-color: #ffc25a;
	  font-size: .9rem;
	  color: #af720a; 
	}
	.accordion h4:hover {
	  background-color: #e0b040;
	}
	.accordion p {
	  padding: 15px 20px;
	  background-color: #ddd;
	  font-size: 1.2rem;
	  color: #333;
	  line-height: 1.3rem;
	}
	.accordion ol {
	  padding: 15px 20px;
	  color: #333;
	  background-color: #ddd;
	  margin-top: 0px;
	  margin-bottom: 0px;
	}
</style>
<script>
	document.write('\
		<style>\
		.accordion h2 {\
				background: -webkit-linear-gradient(#fff,'+color+'); /* For Safari 5.1 to 6.0 */\
				background: -o-linear-gradient(#fff,'+color+'); /* For Opera 11.1 to 12.0 */\
				background: -moz-linear-gradient(#fff,'+color+'); /* For Firefox 3.6 to 15 */\
				background: linear-gradient(#fff,'+color+'); /* Standard syntax (must be last) */\
			}\
		</style>\
	');
</script>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2 style="cursor:default;">Perfil de Evaluación</h2>
  </div>
</div>
<div class="container">
  <div class="row" align="center">
  	<div class="col-md-12">
	  <a href="<?= base_url();?>">&laquo;Regresar</a>
  	</div>
  </div>
  <hr>
  <div class="row" align="center">
  	<div class="input-group">
	  <span class="input-group-addon">Área</span>
	  <select name="area" id="area" class="form-control">
		<option value="" selected disabled>-- Selecciona un área --</option>
		<?php foreach ($areas as $area) : ?>
		  <option value="<?= $area->id;?>" <?php if($area->id == $area_usuario) echo "selected";?>><?= $area->nombre;?></option>
		<?php endforeach; ?>
	  </select>
	  <span class="input-group-addon">Posición</span>
	  <select id="posicion" name="posicion" class="form-control">
	  	<option <?php if($this->session->userdata('posicion')==8) echo"selected"; ?> value="8">Analista</option>
		<option <?php if($this->session->userdata('posicion')==7) echo"selected"; ?> value="7">Consultor</option>
		<option <?php if($this->session->userdata('posicion')==6) echo"selected"; ?> value="6">Consultor Sr</option>
		<option <?php if($this->session->userdata('posicion')==5) echo"selected"; ?> value="5">Gerente / Master</option>
		<option <?php if($this->session->userdata('posicion')==4) echo"selected"; ?> value="4">Gerente Sr / Experto</option>
		<option <?php if($this->session->userdata('posicion')<=3) echo"selected"; ?> value="3">Director</option>
	  </select>
	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
  		<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div class="row" id="label">
    <div class="col-md-12">
    	<label style="float:left;cursor:pointer" onclick="switchView();">Ver Competencias</label>
    </div>
  </div>
  <div id="vista" class="row" align="center">
  	<div class="col-md-2"></div>
  	<div class="col-md-8" id="resp">
	  <label>Responsabilidades</label>
      <aside id="perfil" class="accordion">
  		<?php if(isset($dominios)) foreach ($dominios as $dominio) : if(count($dominio->responsabilidades) > 0): ?>
		<h1><?= $dominio->nombre;?></h1>
		<div>
			<?php foreach ($dominio->responsabilidades as $resp) : ?>
			<h2><?= $resp->nombre;?><span style="float:right;"><?= $resp->valor;?>%</span>
				<label><?= $resp->descripcion;?></label>
			</h2>
			<div align="left">
				<ol reversed>
					<?php foreach ($resp->metricas as $metrica): ?>
					<li><?= $metrica->descripcion;?></li>
				<?php endforeach; ?>
				</ol>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; endforeach; ?>
	  </aside>
    </div>
    <div class="col-md-8" id="comp" style="display:none">
	  <label>Competencias</label>
	  <aside id="competencias" class="accordion">
		<?php if(isset($indicadores)) foreach ($indicadores as $indicador) : if(count($indicador->competencias)): ?>
		<h1><?= $indicador->nombre;?></h1>
		<div>
			<?php foreach ($indicador->competencias as $comp) : ?>
			<h2><?= $comp->nombre;?>
			<label><?= $comp->descripcion;?></label>
			</h2>
			<div align="left">
				<p><?php foreach ($comp->comportamientos as $comportamiento) : ?>
					<span class="glyphicon glyphicon-ok"></span> <?= $comportamiento->descripcion;?><br>
				<?php endforeach; ?></p>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; endforeach; ?>
	  </aside>
    </div>
  </div>

  <script type="text/javascript">
  	function switchView() {
  		if($('#comp').css('display') == 'block'){
  			$('#comp').hide('slow');
  			$('#resp').show('slow');
  			$('#label>div>label').html('Ver Competencias');
  		}else if($('#resp').css('display') == 'block'){
  			$('#comp').show('slow');
  			$('#resp').hide('slow');
  			$('#label>div>label').html('Ver Responsabilidades');
  		}
  	}

	$(document).ready(function() {
		$("#area").change(function() {
			$("#area option:selected").each(function() {
				area = $('#area').val();
				$("#posicion option:selected").each(function() {
					posicion = $('#posicion').val();
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_perfil');?>",
					data: {
						area : area,
						posicion : posicion
					},
					beforeSend: function (xhr) {
						$('#vista').hide('slow');
						$('#cargando').show('slow');
					},
					success: function(data) {
						$('#cargando').hide('slow');
						$("#vista").show('slow');
						$("#perfil").html(data);
					}
				});
			});
		});
		$("#posicion").change(function() {
			$("#posicion option:selected").each(function() {
				$("#area option:selected").each(function() {
					area = $('#area').val();
				});
				posicion = $('#posicion').val();
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_perfil');?>",
					data: {
						area : area,
						posicion : posicion
					},
					beforeSend: function (xhr) {
						$('#vista').hide();
						$('#cargando').show('slow');
					},
					success: function(data) {
						$('#perfil').html(data);
					}
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_competencias');?>",
					data: {
						posicion : posicion
					},
					success: function(data) {
						$('#cargando').hide('slow');
						$('#competencias').html(data);
						$("#vista").show('slow');
					}
				});
			});
		});
    });
  
    var headers = ["H1","H2"];

	$(".accordion").click(function(e) {
	  var target = e.target,
	      name = target.nodeName.toUpperCase();
	  
	  if($.inArray(name,headers) > -1) {
	    var subItem = $(target).next();
	    
	    //slideUp all elements (except target) at current depth or greater
	    var depth = $(subItem).parents().length;
	    var allAtDepth = $(".accordion ul").filter(function() {
	      if($(this).parents().length >= depth && this !== subItem.get(0)) {
	        return true; 
	      }
	    });
	    $(allAtDepth).slideUp("fast");
	    
	    //slideToggle target content and adjust bottom border if necessary
	    subItem.slideToggle("fast",function() {
	        $(".accordion :visible:last").css("border-radius","0 0 10px 10px");
	    });
	    $(target).css({"border-bottom-right-radius":"0", "border-bottom-left-radius":"0"});
	  }
	});
    
  </script>