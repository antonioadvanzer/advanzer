<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Tus Evaluaciones</h2>
  </div>
</div>
<div class="container">
  <div align="center" id="alert" style="display:none">
    <div class="alert alert-danger" role="alert" style="max-width:400px;">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      <label id="msg"></label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div id="filterbar"> </div>
      <table id="tbl" align="center"class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
        data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
        data-striped="true" data-show-toggle="true" data-show-export="true">
        <thead>
          <tr>
            <th class="col-md-1" data-halign="center" data-align="center" data-defaultsort="disabled"></th>
            <th class="col-md-4" data-halign="center" data-field="nombre">Nombre</th>
            <th class="col-md-2" data-halign="center" data-field="area">Area</th>
            <th class="col-md-2" data-halign="center" data-field="posicion">Posición</th>
            <th class="col-md-1" data-halign="center" data-field="tipo">Tipo</th>
            <th class="col-md-1" data-halign="center" data-field="estatus">Estatus</th>
          </tr>
        </thead>
        <tbody data-link="row">
          <?php foreach ($colaboradores as $colab):?>
          <tr>
            <td><a href='<?= base_url("evaluacion/aplicar/$colab->asignacion");?>'>
              <img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></a></td>
            <td><?= "$colab->nombre ($colab->nomina)"; if($colab->id == $this->session->userdata('id')) echo" AUTOEVALUACIÓN";?></td>
            <td><?= $colab->area;?></td>
            <td><?= $colab->posicion;?></td>
            <td><?php if($colab->tipo == 1) echo"Anual"; elseif($colab->tipo == 0) echo"Por Proyecto";?></td>
            <td><?php if($colab->estatus == 0) echo"Pendiente"; elseif($colab->estatus == 1) echo"En proceso";?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    $.bootstrapSortable(true);

    $(function() {
      $('#tbl').bootstrapTable();

      $('#filterbar').bootstrapTableFilter();

    });
  </script>