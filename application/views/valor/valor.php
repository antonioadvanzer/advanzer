<?php

$e = base_url('valores_mes');
//$i = base_url('descargar');

// Archivo final para actividad
$fd = base_url('/assets/valores/Albert_Einstein.pdf');

//echo "<script>setTimeout(function(){window.location.href = '".$e."';} ,3000)</script>" ;
//echo "<iframe src='".$i."' ></iframe>" ;


$img = "";
$alert = "";

switch($this->session->userdata('empresa')){
    case 1:
        $img = base_url('/assets/images/valores/advanzer/AD_CH_VALORES_ROMPE.png');
        $alert = "alert-success";
        break;
    case 2:
        $img = base_url('/assets/images/valores/entuizer/EN_CH_VALORES_ROMPE.png');
        $alert = "alert-info";
        break;
}

?>
<div class="container">
    <div class="row" align="center">
        <h3>Valores por Mes</h3>
        <img class="" height="300px" src="<?= $img ?>"><br>
        <a id="download" class="alert <?= $alert ?>" href="<?= $fd ?>" download>
            Descargar
        </a>
     </div>
</div>


<script>
    $(document).ready(function(){

        $('#download').click(function(){
            window.location.href = '<?= $e ?>';
        });


        //window.location.replace("<?= $e ?>");;
       // var win = window.open('http://stackoverflow.com/', '_blank');
        //if (win) {
            //Browser has allowed it to be opened
            //win.focus();
            //window.location.replace("http://www.google.com.mx/");
        //window.location.replace("http://www.youtube.com/");
        /*} else {
            //Browser has blocked it
            alert('Please allow popups for this website');
        }*/

    });
</script>