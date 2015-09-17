<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Evaluaciones</h2>
      <ul type="square">
        <li>Realizar Cambios a los Evaluadores</li>
        <li>Asignar evaluaciones nuevas cuando sea necesario</li>
      </ul>
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
  <div class="row">
    <div class="col-md-12">
      <h3><b>Evaluaciones:</b></h3>
    </div>
  <div class="row" align="center">
    <div class="col-md-12">
      <div id="cargando" style="display:none; color: green;">
        <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div id="filterbar"> </div>
      <table id="tbl" class="sortable table-hover" align="center" data-toggle="table" data-toolbar="#filterbar" 
        data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" 
        data-striped="true" data-show-toggle="true" data-show-export="true">
        <thead>
          <tr>
            <th data-halign="center" data-align="center" data-field="foto" data-defaultsort="disabled"></th>
            <th data-halign="center" data-field="nombre">Nombre</th>
            <th data-halign="center" data-field="area">Área</th>
            <th data-halign="center" data-field="evaluados">Evaluadores</th>
          </tr>
        </thead>
        <tbody data-link="row">
          <?php foreach ($colaboradores as $colab): ?>
          <tr>
            <td><a href='<?= base_url("evaluacion/asignar_evaluador/").'/'.$colab->id;?>'><img height="25px" 
              src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
            <td><?= $colab->nombre;?></td>
            <td><?= $colab->area;?></td>
            <td><?= $colab->total_evaluadores;?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $.bootstrapSortable(true);

    $(function() {
      $('#tbl').bootstrapTable();

      $('#filterbar').bootstrapTableFilter();

    });
  </script>