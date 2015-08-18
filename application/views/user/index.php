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
        <input name="nombre" type="text" class="form-control" id="nombre" style="max-width:50%;" 
          placeholder="Buscar por nómina,nombre, email, track o posición">
        <select name="estatus" id="estatus" class="form-control" style="max-width:25%;">
          <option value="1">Activos</option>
          <option value="0">Inactivos</option>
          <option value="2">Todos</option>
        </select>
        <select name="orden" id="orden" class="form-control" style="max-width:25%;">
          <option value="ASC">Ascendente</option>
          <option value="DESC">Descendente</option>
        </select>
        <span class="input-group-addon">Filtrar Resultados</span>
        <input id="filter" type="text" class="form-control" placeholder="Filtrar...">
      </div>
    </div>
  </div>
  <div class="row" align="center">
    <div class="col-md-12"><div id="cargando" style="display:none; color: green;">
      <img src="<?= base_url('assets/images/loading.gif');?>"></div></div>
  </div>
  <div class="row">
    <div id="resultados" class="col-md-12">
      <table align="center" data-toggle="table" data-striped="true" data-hover="true">
        <thead>
          <tr>
            <th data-halign="center" data-align="center"></th>
            <th data-halign="center" data-field="nomina">Nómina</th>
            <th class="col-sm-2" data-halign="center" data-field="nombre">Nombre</th>
            <th class="col-sm-2" data-halign="center" data-field="email">E-Mail</th>
            <th class="col-sm-1" data-halign="center" data-field="empresa">Empresa</th>
            <th class="col-sm-1" data-halign="center" data-field="track">Track</th>
            <th class="col-sm-1" data-halign="center" data-field="posicion">Posición</th>
            <th class="col-sm-1" data-halign="center" data-field="area">Área</th>
            <th class="col-sm-1" data-halign="center" data-field="plaza">Plaza</th>
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
              <?= $user->id;?>"><img width="60px"src="<?= base_url('assets/images').'/'.$user->empresa.'.png';?>"></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver');?>/'+
              <?= $user->id;?>"><?= $user->track;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->posicion;?></span></td>
            <td><span style="cursor:pointer" onclick="location.href='<?= base_url('user/ver/');?>/'+
              <?= $user->id;?>"><?= $user->area;?></span></td>
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
              $('#pagination').hide();
          })
      }(jQuery));
    });

    $(document).ready(function() {
      $("#nombre").change(function() {
        valor = $('#nombre').val();
        $("#estatus option:selected").each(function() {
          estatus = $('#estatus').val();
        });
        $("#orden option:selected").each(function() {
          orden = $('#orden').val();
        });
        $('#resultados').hide();
        $('#cargando').show();
        $.ajax({
          url: '<?= base_url("user/searchByText");?>',
          type: 'POST',
          data: {'valor':valor,'estatus':estatus,'orden':orden},
          success: function(data) {
            $('#cargando').hide();
            $('#result').show().html(data);
            $('#resultados').show();
          },
          error: function(data){
            $('body').html(data);
          }
        });
      });
      $("#estatus").change(function() {
        $("#estatus option:selected").each(function() {
          estatus = $('#estatus').val();
        });
        $("#orden option:selected").each(function() {
          orden = $('#orden').val();
        });
        valor = $('#nombre').val();
        $('#resultados').hide();
        $('#cargando').show();
        $.ajax({
          url: '<?= base_url("user/searchByText");?>',
          type: 'POST',
          data: {'valor':valor,'estatus':estatus,'orden':orden},
          success: function(data) {
            $('#cargando').hide();
            $('#result').show().html(data);
            $('#resultados').show();
          }
        });
      });
      $("#orden").change(function() {
        $("#estatus option:selected").each(function() {
          estatus = $('#estatus').val();
        });
        $("#orden option:selected").each(function() {
          orden = $('#orden').val();
        });
        valor = $('#nombre').val();
        $('#resultados').hide();
        $('#cargando').show();
        $.ajax({
          url: '<?= base_url("user/searchByText");?>',
          type: 'POST',
          data: {'valor':valor,'estatus':estatus,'orden':orden},
          success: function(data) {
            $('#cargando').hide();
            $('#result').show().html(data);
            $('#resultados').show();
          }
        });
      })
    });
  </script>