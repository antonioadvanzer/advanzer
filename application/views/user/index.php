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
      <table id="tbl" class="display" align="center" data-toggle="table" data-show-export="true">
        <thead>
          <tr>
            <th data-halign="center" data-align="center">Foto</th>
            <th data-halign="center">Nómina</th>
            <th class="col-sm-2" data-halign="center">Nombre</th>
            <th class="col-sm-2" data-halign="center">E-Mail</th>
            <th class="col-sm-1" data-halign="center">Empresa</th>
            <th class="col-sm-1" data-halign="center">Track</th>
            <th class="col-sm-1" data-halign="center">Posición</th>
            <th class="col-sm-2" data-halign="center">Área</th>
            <th class="col-sm-1" data-halign="center">Plaza</th>
            <th data-halign="center" data-align="center">Estatus</th>
          </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
          <?php foreach ($users as $user): ?>
          <tr class="click-row">
            <td><small><a href='<?= base_url("user/ver/").'/'.$user->id;?>'><img height="40px" class="img-circle avatar avatar-original" 
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

  <script>
    /*$.bootstrapSortable(true);

    $(function() {
      $('#tbl').bootstrapTable();

      $('#filterbar').bootstrapTableFilter();

    });*/
    $(document).ready(function() {
      $('#tbl').DataTable({responsive: true});
    } );
  </script>