<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Objetivos</h2>
    <p>Por medio de éste módulo podrás realizar las siguentes operaciones:<br>
      <ol type="1">
        <li>Realizar Cambios a los Objetivos Definidos</li>
        <li>Agregar nuevos cuando sea necesario</li>
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
        onclick="location.href='<?= base_url('objetivo/nuevo/');?>'">Nuevo Objetivo</span>
    </div>
    <div class="col-md-6">
      <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('dominio/nuevo/');?>'">Nuevo Dominio</span>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Objetivos:</b></h3>
      <div class="input-group">
        <select name="dominio" id="dominio" class="form-control">
          <option selected disabled>-- Selecciona un dominio --</option>
          <?php foreach ($dominios as $dominio) : ?>
            <option value="<?= $dominio->id;?>"><?= $dominio->nombre;?></option>
          <?php endforeach; ?>
        </select>
        <span class="input-group-addon">Filtrar Resultados</span>
        <input id="filter" type="text" class="form-control" placeholder="Filtrar...">
      </div>
      <table width="90%" align="center" class="table table-striped " data-toggle="table">
        <thead>
          <tr>
            <th data-halign="center" data-field="nombre" data-sortable="true">Objetivo</th>
            <th data-halign="center" data-field="descripcion">Descripción</th>
            <th data-halign="center" data-field="metrica">Métrica</th>
            <th data-halign="center" data-field="porcentaje">Porcentaje</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          
        </tbody>
      </table>
      <!--<div id="pagination" class="row">
        <div class="col-md-12 text-center">
            <?php echo $pagination; ?>
        </div>
      </div>-->
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
      (function ($) {
          $('#filter').keyup(function () {
              var rex = new RegExp($(this).val(), 'i');
              $('.searchable tr').hide();
              $('.searchable tr').filter(function () {
                  return rex.test($(this).text());
              }).show();
          })
      }(jQuery));
    });

    $(document).ready(function() {
      $("#dominio").change(function() {
        $("#dominio option:selected").each(function() {
          dominio = $('#dominio').val();
          $.post("<?= base_url('dominio/load_objetivos');?>", {
            dominio : dominio
          }, function(data) {
            $("#result").html(data);
          });
        });
      })
    });
  </script>