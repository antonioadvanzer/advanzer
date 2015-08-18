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
      <div class="input-group" align="center">
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
        <span class="input-group-addon">Posición</span>
        <select id="posicion" name="posicion" class="form-control">
          <option value="8">Nivel 8 o Superior (Analista)</option>
          <option value="7">Nivel 7 (Consultor / Especialista)</option>
          <option value="6">Nivel 6 (Consultor Sr / Especialista Sr)</option>
          <option value="5">Nivel 5 (Gerente / Master)</option>
          <option value="4">Nivel 4 (Gerente Sr / Experto)</option>
          <option value="3">Nivel 3 o Inferior (Director)</option>
        </select>
      </div>
      <div align="center"><div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
      <table width="90%" align="center" class="table">
        <thead>
          <tr>
            <th class="col-md-2">Responsabilidad</th>
            <th class="col-md-4">Descripción</th>
            <th class="col-md-5">Métrica</th>
            <th class="col-md-1">Porcentaje</th>
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
          dominio = $('#dominio').val();
        });
        $("#area option:selected").each(function() {
          area = $('#area').val();
        });
        $("#posicion option:selected").each(function() {
          posicion = $('#posicion').val();
        });
        
        $.ajax({
          type: 'post',
          url: "<?= base_url('dominio/load_objetivos');?>",
          data: {
            area : area,
            dominio : dominio,
            posicion : posicion
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
      $("#area").change(function() {
        $("#area option:selected").each(function() {
          area = $('#area').val();
        });
        $("#dominio option:selected").each(function() {
          dominio = $('#dominio').val();
        });
        $("#posicion option:selected").each(function() {
          posicion = $('#posicion').val();
        });
        $.ajax({
          type: 'post',
          url: "<?= base_url('dominio/load_objetivos');?>",
          data: {
            area : area,
            dominio : dominio,
            posicion : posicion
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
      $("#posicion").change(function() {
        $("#area option:selected").each(function() {
          area = $('#area').val();
        });
        $("#dominio option:selected").each(function() {
          dominio = $('#dominio').val();
        });
        $("#posicion option:selected").each(function() {
          posicion = $('#posicion').val();
        });
        $.ajax({
          type: 'post',
          url: "<?= base_url('dominio/load_objetivos');?>",
          data: {
            area : area,
            dominio : dominio,
            posicion : posicion
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
  </script>