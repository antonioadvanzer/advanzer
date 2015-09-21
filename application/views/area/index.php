<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Áreas de Especialidad</h2>
      <ul type="square">
        <li>Realizar Cambios</li>
        <li>Agregar nuevos cuando sea necesario</li>
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
  <div>
    <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('area/nueva/');?>'">Nueva Área</span>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Áreas de Especialidad:</b></h3>
    </div>
  </div>
  <div class="row" align="center">
    <div class="col-md-12"><div id="cargando" style="display:none; color: green;">
      <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div class="row" align="center">
    <div class="col-md-12">
      <div id="filterbar"> </div>
      <table id="tbl" class="sortable table-hover" align="center" data-toggle="table" 
        data-toolbar="#filterbar" data-pagination="true" data-show-columns="true" data-show-filter="true" 
        data-hover="true" data-striped="true" data-show-toggle="true" data-show-export="true">
        <thead>
          <tr>
            <th class="col-md-2" data-halign="center" data-field="area">Área</th>
            <th class="col-md-2" data-halign="center" data-field="direccion">Dirección</th>
            <th class="col-md-1" data-halign="center" data-field="estatus">Estatus</th>
          </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
          <?php foreach ($areas as $area): ?>
          <tr>
            <td><small><a style="text-decoration:none" href='<?= base_url("area/ver/$area->id");?>'>
              <?= $area->nombre;?></a></small></td>
            <td><small><?= $area->direccion;?></small></td>
            <td data-value="<?= $area->estatus;?>">
              <small><?php if($area->estatus ==1 ) echo "Habilitada"; else echo "Deshabilitada"; ?></small></td>
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