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
        <h3><b>No tienes asignadas evaluaciones por responder aún...</b></h3>
      <?php else: ?>
        <table id="tbl" align="center"class="display">
          <thead>
            <tr>
              <th data-halign="center" data-align="center"></th>
              <th data-halign="center">Nombre</th>
              <th data-halign="center">Area</th>
              <th data-halign="center">Posición</th>
              <th data-halign="center">Evaluación</th>
              <th data-halign="center">Período</th>
              <th data-halign="center">Estatus</th>
            </tr>
          </thead>
          <tbody data-link="row">
            <?php foreach ($colaboradores as $colab):?>
            <tr>
              <td><small><a <?php if($colab->estatus != 2):?> href='<?php if($colab->tipo==0) echo base_url("evaluacion/evaluaProyecto/$colab->asignacion");
                  else echo base_url("evaluacion/aplicar/$colab->asignacion");?>' <?php 
                else: ?> href='<?= base_url("evaluacion/detalle_asignacion/$colab->asignacion");?>'
                <?php endif;?>>
                <img height="25px" src="<?= base_url('assets/images/fotos')."/".$colab->foto;?>"></a></small></td>
              <td><small><?= $colab->nombre;?></small></td>
              <td><small><?= $colab->area;?></small></td>
              <td><small><?= $colab->posicion;?></small></td>
              <td><small><?php echo "$colab->evaluacion - ";
               if($colab->anual==1) 
                  echo "Anual";
                elseif($colab->tipo==1 && $colab->id != $this->session->userdata('id')) 
                  echo "360";
                elseif($colab->tipo==0)
                  echo "Proyecto";
                else
                  echo "Autoevaluación"?></small></td>
              <td><small><?php $inicio=strtotime($colab->inicio);$fin=strtotime($colab->fin);
                echo strftime('%d %b',$inicio)." - ".strftime('%d %b',$fin);?></small></td>
              <td><small><?php if($colab->estatus == 0) echo"Pendiente"; elseif($colab->estatus == 1) echo"En proceso";else echo"Finalizada";?></small></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#tbl').DataTable({responsive: true});
    } );
  </script>