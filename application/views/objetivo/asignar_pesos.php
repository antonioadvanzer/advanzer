<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Relación Responsabilidades Funcionales - Áreas</h2>
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
  <?php foreach ($areas as $area) : ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <a style="text-decoration:none" href="#<?= $area->id;?>" data-toggle="collapse" aria-expanded="false" 
          aria-controls="collapseExample"><h3 class="panel-title"><?= $area->nombre;?></h3></a>
      </div>
      <div class="panel-body collapse" id="<?= $area->id;?>">
        <table class="table table-striped well table-bordered">
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
            <?php foreach ($area->objetivos as $resp) : ?>
              <tr>
                <td><?= $resp->nombre;?></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,8)" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->consultor)) echo $resp->consultor->valor;?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,7)" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->sr)) echo $resp->sr->valor;?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,6)" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->gerente)) echo $resp->gerente->valor;?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,5)" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->experto)) echo $resp->experto->valor;?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,4)" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->director)) echo $resp->director->valor;?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,3)" ></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endforeach; ?>
    <script>
      function change(valor,objetivo,area,posicion) {
        console.log(valor,objetivo,area,posicion);
        $.ajax({
          type: 'post',
          url: '<?= base_url("objetivo/asigna_peso");?>',
          data: {'valor':valor,'responsabilidad':objetivo,'area':area,'posicion':posicion},
          success: function(data) {
            var returnData = JSON.parse(data);
            console.log(returnData);
          },
          error: function(data) {
            alert(data['statusText']);
          }
        });
      }
    </script>