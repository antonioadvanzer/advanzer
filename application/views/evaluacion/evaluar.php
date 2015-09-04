<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Tus Evaluaciones</h2>
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
  <div class="row">
    <div class="col-md-12">
      <div id="filter-bar"> </div>
      <table class="sortable" align="center" data-toggle="table" data-toolbar="#filter-bar" data-pagination="true" 
        data-search="true" data-show-toggle="true" data-show-columns="true" data-show-filter="true" 
        data-hover="true" data-striped="true">
        <thead>
          <tr>
            <th class="col-md-1" data-halign="center" data-align="center" data-defaultsort="disabled"></th>
            <th class="col-md-4" data-halign="center" data-field="nombre">Nombre</th>
            <th class="col-md-2" data-halign="center" data-field="area">Area</th>
            <th class="col-md-1" data-halign="center" data-field="posicion">Posición</th>
            <th class="col-md-2" data-halign="center" data-field="track">Track</th>
            <th class="col-md-1" data-halign="center" data-field="tipo">Tipo</th>
            <th class="col-md-1" data-halign="center" data-field="estatus">Estatus</th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($colaboradores as $colab):?>
          <tr>
            <td><img style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)" height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= "$colab->nombre ($colab->nomina)";?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= $colab->area;?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= $colab->posicion;?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= $colab->track;?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?php if($colab->tipo == 0) echo"Anual"; 
              elseif($colab->tipo == 1) echo"Por Proyecto"; else echo"360";?></span></td>
            <td data-value="<?= $colab->estatus;?>"><span style="cursor:pointer" 
              onclick="ir(<?= $colab->asignacion;?>)"><?php if($colab->estatus == 0) echo"Pendiente"; 
              elseif($colab->estatus == 1) echo"En proceso"; else echo"Terminada";?></span></td>
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

    function ir(asignacion) {
      location.href='<?= base_url("evaluacion/aplicar");?>/'+asignacion;
    }

    $(document).ready(function() {
      $("#nombre").change(function() {
        valor = $('#nombre').val();
        $.post("<?= base_url('evaluacion/searchByText');?>", {
          valor : valor
        }, function(data) {
          $("#result").html(data);
        });
      })
    });
  </script>