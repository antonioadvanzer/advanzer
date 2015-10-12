<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nuevo Indicador</h2>
  </div>
</div>
<div class="container">
  <div align="center">
	<?php if(isset($err_msg)): ?>
		<div id="alert" class="alert alert-danger" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $err_msg;?>
		</div>
	<?php endif; ?>
	<?php if(isset($msg)): ?>
		<div id="alert" class="alert alert-success" role="alert" style="max-width:400px;">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?= $msg;?>
		</div>
		<script>
			$(document).ready(function() {
				setTimeout(function() {
					window.location="<?= base_url('indicador/nuevo');?>"
				},3000);
			});
		</script>
	<?php endif; ?>
  </div>
  <div class="row" align="center">
    <div class="col-md-12">
    <a href="<?= base_url('administrar_indicadores');?>">&laquo;Regresar</a>
    </div>
  </div>
  <form role="form" method="post" action="<?= base_url('indicador/create');?>" class="form-signin">
  	<div class="row" align="center">
    <div class="col-md-2"></div>
  	  <div class="col-md-4">
    		<div class="form-group">
    		  <label for="nombre">Nombre:</label>
    		  <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
    			id="nombre" required value="" placeholder="Nombre">
    		</div>
  	  </div>
  	  <div class="col-md-4">
  	  	<label for="nombre">&nbsp;</label>
  		<button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
  		  Registrar</button>
  	  </div>
    </div>
  </form>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Indicadores:</b></h3>
      <table width="90%" align="center" class="table table-striped " data-toggle="table">
        <thead>
          <tr>
            <th data-halign="center" data-field="nombre" data-sortable="true">Nombre</th>
            <th data-halign="center" data-align="center"></th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($indicadores as $indicador): ?>
          <tr>
            <td><small><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
              location.href='<?= base_url('indicador/ver/');?>/'+<?= $indicador->id;?>"></span> 
              <span style="cursor:pointer" onclick="location.href='<?= base_url('indicador/ver/');?>/'+
              <?= $indicador->id;?>"><?= $indicador->nombre;?></span></small></td>
            <td align="right"><small><span style="cursor:pointer;" onclick="
              if(confirm('Seguro que desea cambiar el estatus del indicador: \n <?= $indicador->nombre;?>'))location.href=
              '<?= base_url('indicador/ch_estatus/');?>/'+<?= $indicador->id;?>;" class="glyphicon 
              <?php if($indicador->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></small></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>