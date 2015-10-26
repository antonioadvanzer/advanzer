<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Tus Evaluaciones</h2>
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
  <div class="row" align="center">
    <div class="col-md-12">
      <a href="<?= base_url();?>">&laquo;Regresar</a>
    </div>
  </div>
  <div class="row" align="center">
    <div class="col-md-12">
      <?php if(count($colaboradores) == 0): ?>
        <h3><b>Aún no comienza el proceso de evaluación...</b></h3>
      <?php else: ?>
        <div id="filterbar"> </div>
        <table id="tbl" align="center"class="sortable table-hover table-striped table-condensed" data-toggle="table" data-toolbar="#filterbar" 
          data-pagination="true" data-show-columns="true" data-show-filter="true" data-hover="true" data-show-toggle="true">
          <thead>
            <tr>
              <th class="col-md-1" data-halign="center" data-align="center" data-defaultsort="disabled"></th>
              <th class="col-md-3" data-halign="center" data-field="nombre">Nombre</th>
              <th class="col-md-2" data-halign="center" data-field="area">Area</th>
              <th class="col-md-1" data-halign="center" data-field="posicion">Posición</th>
              <th class="col-md-2" data-halign="center" data-field="evaluacion">Evaluación</th>
              <th class="col-md-1" data-halign="center" data-field="periodo">Período</th>
              <th class="col-md-1" data-halign="center" data-field="estatus">Estatus</th>
            </tr>
          </thead>
          <tbody data-link="row">
            <?php foreach ($colaboradores as $colab):?>
            <tr>
              <td><small><a <?php if($colab->estatus != 2):?> href='<?php if($colab->tipo==0) echo base_url("evaluacion/evaluaProyecto/$colab->asignacion");
                else echo base_url("evaluacion/aplicar/$colab->asignacion");?>' <?php endif;?>>
                <img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></a></small></td>
              <td><small><?php if($colab->id == $this->session->userdata('id')) echo"AUTOEVALUACIÓN";else echo"$colab->nombre ($colab->nomina)";?></small></td>
              <td><small><?= $colab->area;?></small></td>
              <td><small><?= $colab->posicion;?></small></td>
              <td><small><?= $colab->evaluacion;?></small></td>
              <td><small><?php $inicio=strtotime($colab->inicio);$fin=strtotime($colab->fin); 
                echo strftime('%d %h',$inicio)." - ".strftime('%d %h',$fin);?></small></td>
              <td><small><?php if($colab->estatus == 0) echo"Pendiente"; elseif($colab->estatus == 1) echo"En proceso";else echo"Finalizada";?></small></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <script>
    $.bootstrapSortable(true);

    $(function() {
      $('#tbl').bootstrapTable();

      $('#filterbar').bootstrapTableFilter();

    });
  </script>