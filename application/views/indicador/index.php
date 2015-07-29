<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Competencias</h2>
    <p>Por medio de éste módulo podrás realizar las siguentes operaciones:<br>
      <ol type="1">
        <li>Realizar Cambios a las Competencias Definidas</li>
        <li>Agregar nuevas cuando sea necesario</li>
      </ol>
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
          window.location="<?= base_url('administrar_indicadores');?>"
        },3000);
      });
    </script>
    <?php endif; ?>
  </div>
  <div class="row">
    <div class="col-md-6">
      <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('competencia/nuevo/');?>'">Nueva Competencia</span>
    </div>
    <div class="col-md-6">
      <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('indicador/nuevo/');?>'">Nuevo Indicador</span>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3 style="cursor:default"><b>Competencias:</b></h3>
      <div class="input-group">
        <span class="input-group-addon">Indicador</span>
        <select name="indicador" id="indicador" class="form-control">
          <option selected disabled>-- Selecciona un indicador --</option>
          <?php foreach ($indicadores as $indicador) : ?>
            <option value="<?= $indicador->id;?>"><?= $indicador->nombre;?></option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">Posición</span>
        <select name="posicion" id="posicion" class="form-control">
          <option>Analista</option>
          <option>Consultor</option>
          <option>Consultor Sr</option>
          <option>Gerente / Master</option>
          <option>Gerente Sr / Experto</option>
          <option>Director</option>
        </select>
      </div>
      <table width="90%" align="center" class="table">
        <thead>
          <tr>
            <th class="col-md-2">Competencia</th>
            <th class="col-md-3">Descripción</th>
            <th class="col-md-4">Comportamientos</th>
            <th class="col-md-2">Puntuación esperada</th>
          </tr>
        </thead>
        <tbody id="result"></tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#indicador").change(function() {
        $("#indicador option:selected").each(function() {
          $("#posicion option:selected").each(function() {
            posicion = $('#posicion').val();
          });
          indicador = $('#indicador').val();
          $.post("<?= base_url('indicador/load_competencias');?>", {
            indicador : indicador,
            posicion : posicion
          }, function(data) {
            $("#result").html(data);
          });
        });
      });
      $("#posicion").change(function() {
        $("#posicion option:selected").each(function() {
          $("#indicador option:selected").each(function() {
            indicador = $('#indicador').val();
          });
          posicion = $('#posicion').val();
          $.post("<?= base_url('indicador/load_competencias');?>", {
            indicador : indicador,
            posicion : posicion
          }, function(data) {
            $("#result").html(data);
          });
        });
      });
    });
  </script>