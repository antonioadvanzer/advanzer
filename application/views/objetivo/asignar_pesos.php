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
        <table id="tabla<?= $area->id;?>" class="table table-striped well table-bordered">
          <thead>
            <tr>
              <th class="col-sm-4"></th>
              <th class="text-center col-sm-1">Analista</th>
              <th class="text-center col-sm-1">Consultor</th>
              <th class="text-center col-sm-1">Consultor Sr</th>
              <th class="text-center col-sm-1">Gerente / Master</th>
              <th class="text-center col-sm-1">Gerente Sr / Experto</th>
              <th class="text-center col-sm-1">Director</th>
            </tr>
          </thead>
          <tbody>
            <?php $total1=0;$total2=0;$total3=0;$total4=0;$total5=0;$total6=0;
            foreach ($area->objetivos as $resp) : ?>
              <tr>
                <td><small><?= $resp->nombre;?> - <small><i><?= $resp->tipo;?></i></small></small></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->analista)){ echo $resp->analista->valor; $total1+=$resp->analista->valor;}else echo "0";?>" 
                  onchange="if(this.value == '') this.value=0;change(this.value,<?= $resp->id;?>,<?= $area->id;?>,8);sumarColumna(<?= $area->id;?>,1);" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->consultor)){ echo $resp->consultor->valor;$total2+=$resp->consultor->valor;}else echo "0";?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,7);sumarColumna(<?= $area->id;?>,2);" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->sr)){echo $resp->sr->valor; $total3+=$resp->sr->valor;}else echo "0";?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,6);sumarColumna(<?= $area->id;?>,3);" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->gerente)){ echo $resp->gerente->valor;$total4+=$resp->gerente->valor;}else echo "0";?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,5);sumarColumna(<?= $area->id;?>,4);" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->experto)){echo $resp->experto->valor;$total5+=$resp->experto->valor;}else echo "0";?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,4);sumarColumna(<?= $area->id;?>,5);" ></td>
                <td><input style="max-width:80px;text-align:center" class="form-control" type="text" maxlength="3" required pattern="[0-9]+" 
                  value="<?php if(!empty($resp->director)){ echo $resp->director->valor;$total6+=$resp->director->valor;}else echo "0";?>" 
                  onchange="change(this.value,<?= $resp->id;?>,<?= $area->id;?>,3);sumarColumna(<?= $area->id;?>,6);" ></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td align="right"><small><b>&sum;</b></small></td>
              <td align="center"><small><?= $total1;?></small></td>
              <td align="center"><small><?= $total2;?></small></td>
              <td align="center"><small><?= $total3;?></small></td>
              <td align="center"><small><?= $total4;?></small></td>
              <td align="center"><small><?= $total5;?></small></td>
              <td align="center"><small><?= $total6;?></small></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  <?php endforeach; ?>
    <script>
      function change(valor,objetivo,area,posicion) {
        console.log(valor,objetivo,area,posicion);
        if(valor == ''){
          $valor=0;
        }
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
      function sumarColumna(tabla,columna) {
        var resultVal = 0.0; 
        $("#"+ tabla +" tbody tr").each(
          function() {
            var celdaValor = $(this).find('td:eq(' + columna + ') input');
            console.log(celdaValor.val());
            if (celdaValor.val() != null)
              resultVal += parseInt(celdaValor.val());
          } //function
        ) //each
        $("#"+ tabla +" tfoot tr td:eq(" + columna + ")").html(resultVal);   
      }
    </script>