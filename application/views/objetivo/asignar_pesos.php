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
        <table class="table table-striped well">
          <tr>
            <th class="col-sm-3"></th>
            <th class="col-sm-2">Analista</th>
            <th class="col-sm-2">Consultor</th>
            <th class="col-sm-2">Consultor Sr</th>
            <th class="col-sm-2">Gerente / Master</th>
            <th class="col-sm-2">Gerente Sr / Experto</th>
            <th class="col-sm-2">Director</th>
          </tr>
          <?php foreach ($area->objetivos as $resp) : ?>
            <tr>
              <td><?= $resp->nombre;?></td>
              <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>"></td>
              <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>"></td>
              <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>"></td>
              <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>"></td>
              <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>"></td>
              <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" value="<?php if(!empty($resp->analista)) echo $resp->analista->valor;?>"></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  <?php endforeach; ?>