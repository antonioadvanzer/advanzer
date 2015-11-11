<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Competencias</h2>
      <ul type="square">
        <li>Realizar Cambios a las Competencias Laborales</li>
        <li>Agregar nuevas cuando sea necesario</li>
      </ul>
    </p>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <label style="cursor:pointer" onclick="location.href='<?= base_url('competencia/nuevo/');?>'">
        <span class="glyphicon glyphicon-plus"></span>Nueva Competencia</label>
    </div>
    <div class="col-md-6">
      <label style="cursor:pointer" onclick="location.href='<?= base_url('indicador/nuevo/');?>'">
        <span class="glyphicon glyphicon-plus"></span>Nuevo Indicador</label>
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
      </div>
      <div align="center"><div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
      <table id="resultados" class="table sortable table-hover table-striped" align="center">
        <thead>
          <tr>
            <th data-field="competencia" class="col-md-1">Competencia</th>
            <th data-field="comportamientos" class="col-md-5">Comportamientos/Posición</th>
          </tr>
        </thead>
        <tbody data-link="row" class="rowlink searchable" id="result"></tbody>
      </table>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#indicador").change(function() {
        $("#indicador option:selected").each(function() {
          indicador = $('#indicador').val();
        });
        $.ajax({
          type: 'post',
          url: "<?= base_url('indicador/load_competencias');?>",
          data: {indicador : indicador},
          beforeSend: function (xhr) {
            $('#resultados').hide();
            $('#cargando').show();
          },
          success: function(data) {
            $('#cargando').hide();
            $('#resultados').show();
            $("#result").show().html(data);
          }
        });
      });
    });
  </script>