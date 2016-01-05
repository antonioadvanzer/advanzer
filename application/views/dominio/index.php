<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Responsabilidades Funcionales</h2>
      <ul type="square">
        <li>Realizar Cambios a las Responsabilidades Definidas</li>
        <li>Agregar nuevas cuando sea necesario</li>
      </ul>
    </p>
  </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <label style="cursor:pointer" onclick="location.href='<?= base_url('objetivo/nuevo/');?>'">
        <span class="glyphicon glyphicon-plus"></span>Nueva Responsabilidad</label>
    </div>
    <div class="col-md-6">
      <label style="cursor:pointer" onclick="location.href='<?= base_url('dominio/nuevo/');?>'">
        <span class="glyphicon glyphicon-plus"></span>Nuevo Dominio</label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3 style="cursor:default"><b>Responsabilidades Funcionales:</b></h3>
      <div class="input-group" align="center">
        <span class="input-group-addon">Área</span>
        <select name="area" id="area" class="form-control">
          <option value="" selected disabled>-- Selecciona una área --</option>
          <?php foreach ($areas as $area) : ?>
            <option value="<?= $area->id;?>"><?= $area->nombre;?></option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">Dominio</span>
        <select name="dominio" id="dominio" class="form-control">
          <option value="" selected>-- Todos los dominios --</option>
          <?php foreach ($dominios as $dominio) : ?>
            <option value="<?= $dominio->id;?>"><?= $dominio->nombre;?></option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">Tipo</span>
        <select name="tipo" id="tipo" class="form-control">
          <option value="" selected>-- Todos los tipos --</option>
          <option>CORE</option>
          <option>ESPECÍFICA</option>
        </select>
      </div>
      <div align="center"><div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
      <table id="resultados" class="display" align="center">
        <thead>
          <tr>
            <th>Dominio</th>
            <th>Nombre</th>
            <th>Métrica</th>
            <th>Tipo</th>
            <th>Áreas y Posiciones</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody data-link="row" class="rowlink" id="result"></tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    /*$.bootstrapSortable(true);

    (function ($) {
          $('#filter').keyup(function () {
              var rex = new RegExp($(this).val(), 'i');
              $('.searchable tr').hide();
              $('.searchable tr').filter(function () {
                  return rex.test($(this).text());
              }).show();
          })
      }(jQuery));*/

    $(document).ready(function() {
      $('#resultados').DataTable({responsive: true,paging: false,info: false});
      $("#area").change(function() {
        $("#dominio option:selected").each(function() {
          dominio = $('#dominio').val();
        });
        $("#area option:selected").each(function() {
          area = $('#area').val();
        });
        $("#tipo option:selected").each(function() {
          tipo = $('#tipo').val();
        });
        $.ajax({
          type: 'post',
          url: "<?= base_url('dominio/load_objetivos');?>",
          data: {'dominio': dominio,'area':area,'tipo':tipo},
          beforeSend: function (xhr) {
            $('#resultados').hide('slow');
            $('#cargando').show('slow');
            $('#resultados').dataTable().fnDestroy();
          },
          success: function(data) {
            $('#cargando').hide('slow');
            $('#resultados').show('slow');
            $("#result").show('slow').html(data);
            $('#resultados').DataTable({responsive: true,paging: false,info: false});
          }
        });
      });

      $("#dominio").change(function() {
        $("#dominio option:selected").each(function() {
          dominio = $('#dominio').val();
        });
        $("#tipo option:selected").each(function() {
          tipo = $('#tipo').val();
        });
        $("#area option:selected").each(function() {
          area = $('#area').val();
        });
        if(area != "")
          $.ajax({
            type: 'post',
            url: "<?= base_url('dominio/load_objetivos');?>",
            data: {'dominio': dominio,'area':area,'tipo':tipo},
            beforeSend: function (xhr) {
              $('#resultados').hide('slow');
              $('#cargando').show('slow');
              $('#resultados').dataTable().fnDestroy();
            },
            success: function(data) {
              $('#cargando').hide('slow');
              $('#resultados').show('slow');
              $("#result").show('slow').html(data);
              $('#resultados').DataTable({responsive: true,paging: false,info: false});
            }
          });
      });

      $("#tipo").change(function() {
        $("#dominio option:selected").each(function() {
          dominio = $('#dominio').val();
        });
        $("#tipo option:selected").each(function() {
          tipo = $('#tipo').val();
        });
        $("#area option:selected").each(function() {
          area = $('#area').val();
        });
        if(area != "")
          $.ajax({
            type: 'post',
            url: "<?= base_url('dominio/load_objetivos');?>",
            data: {'dominio': dominio,'area':area,'tipo':tipo},
            beforeSend: function (xhr) {
              $('#resultados').hide('slow');
              $('#cargando').show('slow');
              $('#resultados').dataTable().fnDestroy();
            },
            success: function(data) {
              $('#cargando').hide('slow');
              $('#resultados').show('slow');
              $("#result").show('slow').html(data);
              $('#resultados').DataTable({responsive: true,paging: false,info: false});
            }
          });
      });
    });
  </script>