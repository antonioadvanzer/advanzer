<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Evaluaciones</h2>
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
      <h3><b>Colaboradores:</b></h3>
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
            <th class="col-md-3" data-halign="center" data-field="nombre" data-sortable="true">Nombre</th>
            <th data-halign="center" data-field="rating">Rating</th>
            <th data-halign="center" data-field="total">Total</th>
            <th class="col-md-6" data-halign="center" data-field="evaluadores">Evaluadores</th>
            <th data-halign="center" data-field="feedback">Feedback</th>
            <th data-halign="center" data-field="ev_feedback">Ev. Feedback</th>
          </tr>
        </thead>
        <tbody id="result" class="searchable">
          <?php foreach ($colaboradores as $colab):?>
          <tr>
            <td><img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></td>
            <td><span style="cursor:pointer" onclick=""><?= "$colab->nombre ($colab->track - $colab->posicion)";?></span></td>
            <td><span style="cursor:pointer" onclick=""><?= $colab->rating;?></span></td>
            <td><span style="cursor:pointer" onclick=""><?= $colab->total;?></span></td>
            <td><div class="row">
                <div class="col-sm-1"><b>Total</b></div>
                <div class="col-sm-3"><b>Responsabilidades</b></div>
                <div class="col-sm-2"><b>Competencias</b></div>
                <div class="col-sm-1"></div>
                <div class="col-sm-2"><b>Evaluador</b></div>
              </div>
              <?php foreach ($colab->evaluadores as $evaluador) : ?>
                <div class="row">
                  <div class="col-sm-1"><span><?= $evaluador->total;?></span></div>
                  <div class="col-sm-3"><span><?= $evaluador->responsabilidad;?></span></div>
                  <div class="col-sm-2"><?= $evaluador->competencia;?></span></div>
                  <div class="col-sm-1"><img height="20px" src="<?= base_url('assets/images/fotos')."/".$evaluador->foto;?>"></div>
                  <div class="col-sm-2"><?= $evaluador->nombre;?></div>
                </div>
              <?php endforeach; ?>
            </td>
            <td><span style="cursor:pointer" onclick=""><?php if($colab->feedback == 0) echo"Pendiente"; elseif($colab->feedback == 1) echo"Enviado"; else echo"Enterado";?></span></td>
            <td><span style="cursor:pointer" onclick=""></span></td>
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
        $.post("<?= base_url('evaluacion/searchByText');?>", {
          valor : valor
        }, function(data) {
          $("#result").html(data);
        });
      })
    });
  </script>