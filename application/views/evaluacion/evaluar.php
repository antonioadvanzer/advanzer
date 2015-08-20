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
      <h3><b>Colaboradores Asignados:</b></h3>
      <div class="input-group">
        <!--<input name="nombre" type="text" class="form-control" id="nombre" 
          placeholder="Buscar por nombre">-->
        <span class="input-group-addon">Filtrar Resultados</span>
        <input id="filter" type="text" class="form-control" placeholder="Filtrar...">
      </div>
      <table width="90%" align="center" class="table table-striped " data-toggle="table">
        <thead>
          <tr>
            <th class="col-md-1" data-halign="center" data-align="center"></th>
            <th class="col-md-3" data-halign="center" data-field="nombre" data-sortable="true">Nombre</th>
            <th class="col-md-2" data-halign="center" data-field="area" data-sortable="true">Area</th>
            <th class="col-md-1" data-halign="center" data-field="posicion" data-sortable="true">Posición</th>
            <th class="col-md-2" data-halign="center" data-field="track" data-sortable="true">Track</th>
            <th class="col-md-2" data-halign="center" data-field="tipo" data-sortable="true">Tipo</th>
            <th class="col-md-1" data-halign="center" data-field="estatus" data-sortable="true">Estatus</th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($colaboradores as $colab):?>
          <tr>
            <td><img style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)" height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= "$colab->nomina - $colab->nombre";?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= $colab->area;?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= $colab->posicion;?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?= $colab->track;?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?php if($colab->tipo == 0) echo"De Responsabilidades"; 
              elseif($colab->tipo == 1) echo"De Competencias"; else echo"360";?></span></td>
            <td><span style="cursor:pointer" onclick="ir(<?= $colab->asignacion;?>)"><?php if($colab->estatus == 0) echo"Pendiente"; 
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