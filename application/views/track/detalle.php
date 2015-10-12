<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <h2>Detalle Track</h2>
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
  <div align="center"><a href="<?= base_url('track');?>">&laquo;Regresar</a></div>
  <form id="update" role="form" method="post" action="javascript:" class="form-signin">
    <input type="hidden" id="id" value="<?= $track->id;?>">
    <div class="row" align="center">
    <div class="col-md-3"></div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input name="nombre" type="text" class="form-control" style="max-width:300px; text-align:center;" 
      id="nombre" required value="<?= $track->nombre;?>" placeholder="Nombre">
    </div>
    </div>
  </div>
  <div style="height:60px" class="row" align="center">
    <div class="col-md-12">
      <button type="submit" class="btn btn-lg btn-primary btn-block" style="max-width:200px; text-align:center;">
        Actualizar</button>
    </div>
  </div>
  </form>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#update').submit(function(event){
        $('#alert').prop('display',false);
        id = $('#id').val();
        nombre = $('#nombre').val();
        $.ajax({
          url: '<?= base_url("track/update");?>',
          type: 'post',
          data: {'id':id,'nombre':nombre},
          success: function(data){
            var returnedData = JSON.parse(data);
            console.log(returnedData['msg']);
            if(returnedData['msg']=="ok")
              window.document.location = '<?= base_url("track");?>';
            else{
              $('#alert').prop('display',true).show();
              $('#msg').html(returnedData['msg']);
            }
          }
        });

        event.preventDefault();
      });
    });
  </script>