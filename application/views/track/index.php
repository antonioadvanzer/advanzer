<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Tracks y Posiciones</h2>
      <ul type="square">
        <li>Realizar Cambios a Tracks y Posiciones Definidas</li>
        <li>Agregar nuevas cuando sea necesario</li>
      </ul>
    </p>
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
      <script>
      $(document).ready(function() {
        setTimeout(function() {
          window.location="<?= base_url('track');?>"
        },3000);
      });
    </script>
    <?php endif; ?>
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-4">
      <label style="cursor:pointer" onclick="location.href='<?= base_url('posicion/nuevo/');?>'">
        <span class="glyphicon glyphicon-plus"></span>Nueva Posicion</label>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-4">
      <label style="cursor:pointer" onclick="location.href='<?= base_url('track/nuevo/');?>'">
      <span class="glyphicon glyphicon-plus"></span>Nuevo Track</label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-5">
      <h3 style="cursor:default"><b>Posiciones:</b></h3>
      <div class="input-group">
        <span class="input-group-addon">Track</span>
        <select name="track" id="track" class="form-control">
          <option selected disabled>-- Selecciona un track --</option>
          <?php foreach ($tracks as $track) : ?>
            <option value="<?= $track->id;?>"><?= $track->nombre;?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <table id="tbl" width="90%" align="center" class="table">
        <thead>
          <tr>
            <th class="col-md-3">Posicion</th>
          </tr>
        </thead>
        <tbody id="result">
          <?php foreach($posiciones as $posicion): ?>
            <tr>
              <td><small><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
                location.href='<?= base_url('posicion/ver');?>/'+<?= $posicion->id;?>"></span>
                <span style="cursor:pointer" onclick="location.href='<?= base_url('posicion/ver');?>/'+
                  <?= $posicion->id;?>"><?= $posicion->nombre;?></span></small></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5">
      <h3 style="cursor:default"><b>Tracks:</b></h3>
      <table id="tbl2" width="90%" align="center" class="table">
        <thead>
          <tr>
            <th>Track</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tracks as $track) : ?>
            <tr>
              <td><small><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
                  location.href='<?= base_url('track/ver');?>/'+<?= $track->id;?>"></span>
                  <span style="cursor:pointer" onclick="location.href='<?= base_url('track/ver');?>/'+
                    <?= $track->id;?>"><?= $track->nombre;?></span></small></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#track").change(function() {
        $("#track option:selected").each(function() {
          track = $('#track').val();
          $.post("<?= base_url('track/load_posiciones');?>", {
            track : track
          }, function(data) {
            $("#result").html(data);
          });
        });
      });
    });
  </script>