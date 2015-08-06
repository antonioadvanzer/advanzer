<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Administrar Usuarios</h2>
    <p>Por medio de éste módulo podrás realizar las siguentes operaciones:<br>
      <ol type="1">
        <li>Realizar Cambios a los Usuarios Registrados</li>
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
        onclick="location.href='<?= base_url('nuevo_usuario/');?>'">Nuevo Usuario</span>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3><b>Usuarios:</b></h3>
      <div class="input-group">
        <input name="nombre" type="text" class="form-control" id="nombre" 
          placeholder="Buscar por nombre, email, track o posición">
        <span class="input-group-addon">Filtrar Resultados</span>
        <input id="filter" type="text" class="form-control" placeholder="Filtrar...">
      </div>
      <table width="90%" align="center" class="table table-striped " data-toggle="table">
        <thead>
          <tr>
            <th data-halign="center" data-align="center"></th>
            <th data-halign="center" data-field="nomina" data-sortable="true">Nómina</th>
            <th data-halign="center" data-field="nombre" data-sortable="true">Nombre</th>
            <th data-halign="center" data-field="email">E-Mail</th>
            <th data-halign="center" data-field="empresa">Empresa</th>
            <th data-halign="center" data-field="track">Track</th>
            <th data-halign="center" data-field="posición">Posición</th>
            <th data-halign="center" data-field="area">Área</th>
            <th data-halign="center" data-field="categoria">Categoría</th>
            <th data-halign="center" data-field="plaza">Plaza</th>
            <th data-halign="center" data-align="center"></th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($users as $user): ?>
          <tr>
            <td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$user->foto;?>"></td>
            <td><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="
              location.href='<?= base_url('user/ver/');?>/'+<?= $user->id;?>"></span> 
              <span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->nomina;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->nombre;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->email;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?php if($user->empresa == 1) echo "Advanzer"; 
              elseif($user->empresa == 2) echo "Entuizer";?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver');?>/'+
              <?= $user->id;?>"><?= $user->track;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->posicion;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->area;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->categoria;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->plaza;?></span></td>
            <td align="right"><span style="cursor:pointer;" onclick="
              if(confirm('Seguro que desea cambiar el estatus del usuario: \n <?= $user->nombre;?>'))location.href=
              '<?= base_url('user/del/');?>/'+<?= $user->id;?>;" class="glyphicon 
              <?php if($user->estatus ==1 ) echo "glyphicon-ok"; else echo "glyphicon-ban-circle"; ?>"></span></td>
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
        $.post("<?= base_url('user/searchByText');?>", {
          valor : valor
        }, function(data) {
          $("#result").html(data);
        });
      })
    });
  </script>