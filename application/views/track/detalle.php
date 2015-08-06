<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle Track</h2>
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
  </div>
  <form role="form" method="post" action="<?= base_url('track/update');?>" class="form-signin">
    <input type="hidden" name="id" value="<?= $track->id;?>">
    <div class="row" align="center">
    <div class="col-md-3"></div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
      id="nombre" required value="<?= $track->nombre;?>" placeholder="Nombre">
    </div>
    </div>
  </div>
  <div style="height:60px" class="row" align="center">
    <div class="col-md-12">
      <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
        Actualizar</button>
    </div>
  </div>
  </form>
  <div align="center"><a href="<?= base_url('track');?>">&laquo;Regresar</a></div>