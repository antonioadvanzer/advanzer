<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Áreas</h2>
    <p>Por medio de éste módulo podrás realizar las siguentes operaciones:<br>
      <ol type="1">
        <li>Visualizar Las Áreas de la empresa</li>
        <li>Realizar Cambios</li>
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
    <?php endif; ?>
  </div>
  <div>
    <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('area/nueva/');?>'">Nueva Área</span>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Áreas:</b></h3>
      <div class="input-group">
        <input name="nombre" type="text" class="form-control" id="nombre" 
          placeholder="Buscar por nombre">
        <span class="input-group-addon">Filtrar Resultados</span>
        <input id="filter" type="text" class="form-control" placeholder="Filtrar...">
      </div>
      <table width="90%" align="center" class="table table-striped" data-toggle="table" 
        data-sort-name="area">
        <thead>
          <tr>
            <th data-halign="center" data-field="area" data-sortable="true">Área</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($areas as $resp): ?>
          <tr>
            <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
              location.href='<?= base_url('area/ver/');?>/'+<?= $resp->id;?>"></span> 
              <span style="cursor:pointer" onclick="location.href='<?= base_url('area/ver/');?>/'+
              <?= $resp->id;?>"><?= $resp->nombre;?></span></td>
            <td align="right"><span style="cursor:pointer;" onclick="
              if(confirm('Seguro que desea cambiar el estatus del área: \n <?= $resp->nombre;?>'))location.href=
              '<?= base_url('area/del/');?>/'+<?= $resp->id;?>;" class="glyphicon 
              <?php if($resp->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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

    $(document).ready(function () {
      (function ($) {
          $('#filter2').keyup(function () {
              var rex = new RegExp($(this).val(), 'i');
              $('.searchable2 tr').hide();
              $('.searchable2 tr').filter(function () {
                  return rex.test($(this).text());
              }).show();
          })
      }(jQuery));
    });

    $(document).ready(function() {
      $("#nombre").change(function() {
        valor = $('#nombre').val();
        $.post("<?= base_url('area/searchByText');?>", {
          valor : valor
        }, function(data) {
          $("#result").html(data);
        });
      })
    });
  </script>