<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Nuevo Dominio</h2>
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
					window.location="<?= base_url('dominio/nuevo');?>"
				},3000);
			});
		</script>
	<?php endif; ?>
  </div>
  <div class="row" align="center">
    <div class="col-md-12">
    <a href="<?= base_url('administrar_dominios');?>">&laquo;Regresar</a>
    </div>
  </div>
  <form role="form" method="post" action="<?= base_url('dominio/create');?>" class="form-signin">
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
      <h3><b>Dominios:</b></h3>
      <table class="table sortable table-hover table-striped" align="center">
        <thead>
          <tr>
            <th data-halign="center" data-field="nombre" data-sortable="true">Nombre</th>
            <th data-halign="center" data-align="center"></th>
          </tr>
        </thead>
        <tbody data-link="row" class="rowlink" id="result">
          <?php foreach ($dominios as $dominio): ?>
          <tr>
            <td><small><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
              location.href='<?= base_url('dominio/ver/');?>/'+<?= $dominio->id;?>"></span> 
              <span style="cursor:pointer" onclick="location.href='<?= base_url('dominio/ver/');?>/'+
              <?= $dominio->id;?>"><?= $dominio->nombre;?></span></small></td>
            <td align="right"><small><span style="cursor:pointer;" onclick="
              if(confirm('Seguro que desea cambiar el estatus del dominio: \n <?= $dominio->nombre;?>'))location.href=
              '<?= base_url('dominio/ch_estatus/');?>/'+<?= $dominio->id;?>;" class="glyphicon 
              <?php if($dominio->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></small></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>