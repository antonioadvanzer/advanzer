<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Relación Comportamientos Laborales - Posición</h2>
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
  <?php foreach ($indicadores as $indicador) : ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <a style="text-decoration:none" href="#<?= $indicador->id;?>" data-toggle="collapse" aria-expanded="false" 
          aria-controls="collapseExample"><h3 class="panel-title"><?= $indicador->nombre;?></h3></a>
      </div>
      <div class="panel-body collapse" id="<?= $indicador->id;?>">
        <div class="panel panel-default">
          <?php foreach ($indicador->competencias as $competencia) : ?>
            <div class="panel-heading">
              <a style="text-decoration:none" href="#C<?= $competencia->id;?>" data-toggle="collapse" aria-expanded="false"
              aria-controls="collapseExample"><h3 class="panel-title"><?= $competencia->nombre;?></h3></a>
            </div>
            <div class="panel-body collapse" id="C<?= $competencia->id;?>">
              <table class="table table-bordered table-striped well">
                <thead>
                  <tr>
                    <th class="col-sm-3"></th>
                    <th>Analista</th>
                    <th>Consultor</th>
                    <th>Consultor Sr</th>
                    <th>Gerente / Master</th>
                    <th>Gerente Sr / Experto</th>
                    <th>Director</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($competencia->comportamientos as $comp) : ?>
                    <tr>
                      <td><?= $comp->descripcion;?></td>
                      <td style="vertical-align:middle;text-align:center;"><input type="checkbox" id="evalua" onclick="change(this.checked,
                        <?= $comp->id;?>,8)" <?php if(!empty($comp->analista)) echo "checked";?>>
                      <td style="vertical-align:middle;text-align:center;"><input type="checkbox" id="evalua" onclick="change(this.checked,
                        <?= $comp->id;?>,7)" <?php if(!empty($comp->consultor)) echo "checked";?>>
                      <td style="vertical-align:middle;text-align:center;"><input type="checkbox" id="evalua" onclick="change(this.checked,
                        <?= $comp->id;?>,6)" <?php if(!empty($comp->sr)) echo "checked";?>>
                      <td style="vertical-align:middle;text-align:center;"><input type="checkbox" id="evalua" onclick="change(this.checked,
                        <?= $comp->id;?>,5)" <?php if(!empty($comp->gerente)) echo "checked";?>>
                      <td style="vertical-align:middle;text-align:center;"><input type="checkbox" id="evalua" onclick="change(this.checked,
                        <?= $comp->id;?>,4)" <?php if(!empty($comp->experto)) echo "checked";?>>
                      <td style="vertical-align:middle;text-align:center;"><input type="checkbox" id="evalua" onclick="change(this.checked,
                        <?= $comp->id;?>,3)" <?php if(!empty($comp->director)) echo "checked";?>>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
    <script>
      function change(valor,comportamiento,posicion) {
        console.log(valor,comportamiento,posicion);
        $.ajax({
          type: 'post',
          url: '<?= base_url("indicador/asigna_comportamiento");?>',
          data: {'valor':valor,'comportamiento':comportamiento,'posicion':posicion},
          success: function(data) {
            var returnData = JSON.parse(data);
            console.log(returnData);
          },
          error: function(data) {
            console.log(data['responseText']);
          }
        });
      }
    </script>