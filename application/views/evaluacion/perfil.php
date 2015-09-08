<style type="text/css">
	.accordion {
	  margin: auto auto;
	}
	.accordion h1, h2, h3, h4 {
	  cursor: pointer;
	}
	.accordion h1 {
	  padding: 15px 20px;
	  background-color: #444;
	  /*font-family: Lobster;*/
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
	.accordion div, .accordion p, .accordion span {
	  display: none;
	}
	.accordion h2 {
	  padding: 5px 25px;
	  background: -webkit-gradient(linear, left bottom, left top, from(#B0B914), to(#FFF));
	  /*background-color: #B0B914;*/
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
	  background-color: #dadada;
	  font-size: 1.4rem;
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
	  padding: 15px 35px;
	  background-color: #ddd;
	  font-size: .8rem;
	  color: #333;
	  line-height: 1.3rem;
	}
	.accordion span {
		display: block;
	}
</style>
<script>
	document.write('\
		<style>\
		.accordion h2 {\
				background: -webkit-gradient(linear, left top, left bottom, from(#fff), to('+color+'));\
			}\
		</style>\
	');
</script>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2 style="cursor:default;">Perfil de Evaluación</h2>
    <p>Las responsabilidades miden los puntos clave de desempeño aplicados al proyecto y/o asignación 
    	en los cuales te has desempeñado durante el año.</p>
  </div>
</div>
<div class="container">
  <div align="center">
    <?php if(isset($msg)): ?>
      <div id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <?= $msg;?>
      </div>
    <?php endif; ?>
  </div>
  <div class="row" align="center">
  	<div class="input-group">
	  <span class="input-group-addon">Área</span>
	  <select name="area" id="area" class="form-control">
		<?php foreach ($areas as $area) : ?>
		  <option value="<?= $area->id;?>" <?php if($area->id == $area_usuario) echo "selected";?>><?= $area->nombre;?></option>
		<?php endforeach; ?>
	  </select>
	  <span class="input-group-addon">Posición</span>
	  <select id="posicion" name="posicion" class="form-control">
	  	<option <?php if($this->session->userdata('posicion')==8) echo"selected"; ?> value="8">Nivel 8 o Superior (Analista)</option>
		<option <?php if($this->session->userdata('posicion')==7) echo"selected"; ?> value="7">Nivel 7 (Consultor / Especialista)</option>
		<option <?php if($this->session->userdata('posicion')==6) echo"selected"; ?> value="6">Nivel 6 (Consultor Sr / Especialista Sr)</option>
		<option <?php if($this->session->userdata('posicion')==5) echo"selected"; ?> value="5">Nivel 5 (Gerente / Master)</option>
		<option <?php if($this->session->userdata('posicion')==4) echo"selected"; ?> value="4">Nivel 4 (Gerente Sr / Experto)</option>
		<option <?php if($this->session->userdata('posicion')==3) echo"selected"; ?> value="3">Nivel 3 o Inferior (Director)</option>
	  </select>
	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
  		<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div id="vista" class="row" align="center">
  	<div class="col-md-6">
	  <label>Responsabilidades</label>
      <aside id="perfil" class="accordion">
  		<?php foreach ($dominios as $dominio) :?>
		<h1><?= $dominio->nombre;?></h1>
		<div>
			<?php foreach ($dominio->responsabilidades as $resp) : ?>
			<h2><?= $resp->nombre;?><span style="float:right;"><?= $resp->valor;?>%</span></h2>
			<div align="left">
				<label><?= $resp->descripcion;?></label>
				<p><ol reversed>
					<?php foreach ($resp->metricas as $metrica): ?>
					<li><?= $metrica->descripcion;?></li>
				<?php endforeach; ?>
				</ol></p>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endforeach; ?>
	  </aside>
    </div>
    <div class="col-md-6">
	  <label>Competencias</label>
	  <aside id="competencias" class="accordion">
		<?php foreach ($indicadores as $indicador) : ?>
		<h1><?= $indicador->nombre;?></h1>
		<div>
			<?php foreach ($indicador->competencias as $comp) : ?>
			<h2><?= $comp->nombre;?></h2>
			<div align="left">
				<label><?= $comp->descripcion;?></label>
				<p><ul type="square">
					<?php foreach ($comp->comportamientos as $comportamiento) : ?>
						<span class="glyphicon glyphicon-ok-circle"><?= $comportamiento->descripcion;?></span>
					<?php endforeach; ?>
				</ul></p>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endforeach; ?>
	  </aside>
    </div>
  </div>

  <script type="text/javascript">
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
  
    var headers = ["H1","H2","H3","H4","H5","H6"];

	$(".accordion").click(function(e) {
	  var target = e.target,
	      name = target.nodeName.toUpperCase();
	  
	  if($.inArray(name,headers) > -1) {
	    var subItem = $(target).next();
	    
	    //slideUp all elements (except target) at current depth or greater
	    var depth = $(subItem).parents().length;
	    var allAtDepth = $(".accordion p, .accordion div").filter(function() {
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