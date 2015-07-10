<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Evaluadores 360</h2>
    <p>Por medio de éste módulo podrás realizar las siguentes operaciones:<br>
      <ol type="1">
        <li>Realizar Cambios a los Evaluadores 360</li>
        <li>Asignar evaluaciones nuevas cuando sea necesario</li>
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
        onclick="location.href='<?= base_url('evaluacion/nuevo_evaluador360');?>'"></span>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Evaluadores 360:</b></h3>
      <div class="input-group">
        <input name="nombre" type="text" class="form-control" id="nombre" 
          placeholder="Buscar por nombre">
        <span class="input-group-addon">Filtrar Resultados</span>
        <input id="filter" type="text" class="form-control" placeholder="Filtrar...">
      </div>
      <table width="90%" align="center" class="table table-striped " data-toggle="table">
        <thead>
          <tr>
            <th data-halign="center" data-align="center"></th>
            <th data-halign="center" data-field="nombre" data-sortable="true">Nombre</th>
            <th data-halign="center" data-field="evaluados">Evaluaciones</th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($evaluadores as $ev): ?>
          <tr>
            <td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$ev->foto;?>"></td>
            <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
              location.href='<?= base_url('evaluacion/asignar_colaborador360/');?>/'+<?= $ev->id;?>"></span> 
              <span style="cursor:pointer" onclick="location.href='<?= base_url('evaluacion/asignar_colaborador360/');?>/'+
              <?= $ev->id;?>"><?= $ev->nombre;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('evaluacion/asignar_colaborador360/');?>/'+
              <?= $ev->id;?>"><?= $ev->cantidad;?></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div id="pagination" class="row">
        <div class="col-md-12 text-center">
            <?php echo $pagination; ?>
        </div>
      </div>
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
      $("#nombre").change(function() {
        valor = $('#nombre').val();
        $.post("<?= base_url('evaluacion/searchByText/1');?>", {
          valor : valor
        }, function(data) {
          $("#result").html(data);
        });
      })
    });
  </script>