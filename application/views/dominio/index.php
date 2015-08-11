<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Responsabilidades</h2>
    <p>Por medio de éste módulo podrás realizar las siguentes operaciones:<br>
      <ol type="1">
        <li>Realizar Cambios a las Responsabilidades Definidas</li>
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
          window.location="<?= base_url('dominio');?>"
        },3000);
      });
    </script>
    <?php endif; ?>
  </div>
  <div class="row">
    <div class="col-md-6">
      <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('objetivo/nuevo/');?>'">Nueva Responsabilidad</span>
    </div>
    <div class="col-md-6">
      <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('dominio/nuevo/');?>'">Nuevo Dominio</span>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3 style="cursor:default"><b>Responsabilidades:</b></h3>
      <div class="input-group">
        <span class="input-group-addon">Dominio</span>
        <select name="dominio" id="dominio" class="form-control">
          <option selected disabled>-- Selecciona un dominio --</option>
          <?php foreach ($dominios as $dominio) : ?>
            <option value="<?= $dominio->id;?>"><?= $dominio->nombre;?></option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">Área</span>
        <select name="area" id="area" class="form-control">
          <?php foreach ($areas as $area) : ?>
            <option value="<?= $area->id;?>"><?= $area->nombre;?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div align="center"><div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
      <table width="90%" align="center" class="table">
        <thead>
          <tr>
            <th class="col-md-2">Responsabilidad</th>
            <th class="col-md-2">Descripción</th>
            <th class="col-md-4">Métrica</th>
            <th class="col-md-3">Porcentaje</th>
            <th class="col-md-1"></th>
          </tr>
        </thead>
        <tbody id="result"></tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#dominio").change(function() {
        $("#dominio option:selected").each(function() {
          $("#area option:selected").each(function() {
            area = $('#area').val();
          });
          dominio = $('#dominio').val();
          $.ajax({
            type: 'post',
            url: "<?= base_url('dominio/load_objetivos');?>",
            data: {
              area : area,
              dominio : dominio
            },
            beforeSend: function (xhr) {
              $('#result').hide();
              $('#cargando').show();
            },
            success: function(data) {
              $('#cargando').hide();
              $("#result").show().html(data);
            }
          });
        });
      });
      $("#area").change(function() {
        $("#area option:selected").each(function() {
          $("#dominio option:selected").each(function() {
            dominio = $('#dominio').val();
          });
          area = $('#area').val();
          $.ajax({
            type: 'post',
            url: "<?= base_url('dominio/load_objetivos');?>",
            data: {
              area : area,
              dominio : dominio
            },
            beforeSend: function (xhr) {
              $('#result').hide();
              $('#cargando').show();
            },
            success: function(data) {
              $('#cargando').hide();
              $("#result").show().html(data);
            }
          });
        });
      });
    });
  </script>