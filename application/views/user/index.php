<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Colaboradores</h2>
      <ul type="square">
        <li>Realizar Cambios a los Colaboradores Registrados</li>
        <li>Agregar nuevos cuando sea necesario</li>
      </ul>
  </div>
</div>
<div class="container">
  <div>
    <span style="cursor:pointer" class="glyphicon glyphicon-plus" 
        onclick="location.href='<?= base_url('nuevo_usuario/');?>'">Nuevo Colaborador</span>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Colaboradores:</b></h3>
    </div>
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
        data-pagination="true" data-show-columns="true" data-show-filter="true" 
        data-hover="true" data-striped="true" data-show-toggle="true" data-show-export="true">
        <thead>
          <tr>
            <th data-halign="center" data-field="foto" data-align="center" 
              data-defaultsort="disabled">Foto</th>
            <th data-halign="center" data-field="nomina">Nómina</th>
            <th class="col-sm-2" data-halign="center" data-field="nombre">Nombre</th>
            <th class="col-sm-2" data-halign="center" data-field="email">E-Mail</th>
            <th class="col-sm-1" data-halign="center" data-field="empresa">Empresa</th>
            <th class="col-sm-1" data-halign="center" data-field="track">Track</th>
            <th class="col-sm-1" data-halign="center" data-field="posicion">Posición</th>
            <th class="col-sm-2" data-halign="center" data-field="area">Área</th>
            <th class="col-sm-1" data-halign="center" data-field="plaza">Plaza</th>
            <th data-halign="center" data-align="center" data-field="estatus">Estatus</th>
          </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
          <?php foreach ($users as $user): ?>
          <tr class="click-row">
            <td><small><a href='<?= base_url("user/ver/").'/'.$user->id;?>'><img height="40px" 
              src="<?= base_url('assets/images/fotos')."/".$user->foto;?>"></a></small></td>
            <td><small><?= $user->nomina;?></small></td>
            <td><small><?= $user->nombre;?></small></td>
            <td><small><?= $user->email;?></small></td>
            <?php if($user->empresa == 1) $empresa="Advanzer"; else $empresa="Entuizer"; ?>
            <td><small><?= $empresa; ?></small></td>
            <td><small><?= $user->track;?></small></td>
            <td><small><?= $user->posicion;?></small></td>
            <td><small><?= $user->area;?></small></td>
            <td><small><?= $user->plaza;?></small></td>
            <td data-value="<?= $user->estatus;?>"><small>
              <?php if($user->estatus ==1 ) echo "Activo"; else echo "Inactivo"; ?></small></td>
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