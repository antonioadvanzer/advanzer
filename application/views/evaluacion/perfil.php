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
		  <option value="<?= $area->id;?>"><?= $area->nombre;?></option>
		<?php endforeach; ?>
	  </select>
	  <span class="input-group-addon">Posición</span>
	  <select id="posicion" name="posicion" class="form-control">
	    	<option <?php if($this->session->userdata('posicion')=="Analista") echo"selected"; ?>>Analista</option>
	    	<option <?php if($this->session->userdata('posicion')=="Consultor") echo"selected"; ?>>Consultor</option>
	    	<option <?php if($this->session->userdata('posicion')=="Consultor Sr") echo"selected"; ?>>Consultor Sr</option>
	    	<option <?php if($this->session->userdata('posicion')=="Gerente / Master") echo"selected"; ?>>Gerente / Master</option>
	    	<option <?php if($this->session->userdata('posicion')=="Gerente Sr / Experto") echo"selected"; ?>>Gerente Sr / Experto</option>
	    	<option <?php if($this->session->userdata('posicion')=="Director") echo"selected"; ?>>Director</option>
	  </select>
	</div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-12"><div id="cargando" style="display:none; color: green;">
  		<img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div class="row" align="center">
  	<div class="col-md-6">
	  <label>Responsabilidades</label>
      <aside id="perfil" class="accordion">
  		<?php foreach ($dominios as $dominio) : ?>
		<h1><?= $dominio->nombre;?></h1>
		<div>
			<?php foreach ($dominio->responsabilidades as $resp) : ?>
			<h2><?= $resp->nombre;?><span style="float:right;"><?= $resp->valor;?>%</span></h2>
			<div>
				<label><?= $resp->descripcion;?></label>
				<p><ol reversed>
					<?php foreach ($resp->metricas as $metrica) : ?>
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
			<h2><?= $comp->nombre;?><span style="float:right;"><?= $comp->puntuacion;?></span></h2>
			<div>
				<label><?= $comp->descripcion;?></label>
				<p><ul>
					<?php foreach ($comp->comportamientos as $comportamiento) : ?>
					<li><?= $comportamiento->descripcion;?></li>
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
						$('#perfil').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$('#cargando').hide();
						$("#perfil").show().html(data);
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
						$('#perfil').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$('#cargando').hide();
						$('#perfil').show().html(data);
					}
				});
				$.ajax({
					type: 'post',
					url: "<?= base_url('evaluacion/load_competencias');?>",
					data: {
						posicion : posicion
					},
					beforeSend: function(xhr) {
						$('#competencias').hide();
						$('#cargando').show();
					},
					success: function(data) {
						$('#cargando').hide();
						$('#competencias').show().html(data);
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