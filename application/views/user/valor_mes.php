<!-- Main jumbotron for a primary marketing message or call to action -->

<?php

$fe = "";

switch($this->session->userdata('empresa')){
	case 1:
		$fe = "advanzer";
		break;
	case 2:
		$fe = "entuizer";
		break;
}

?>

<div class="jumbotron">
	<div class="container">
		
		<div class="col-md-6" align="center"><h2>EMPRESAS CON VALOR</h2></div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<?php foreach ($avm as $r): ?>
			  			<div class="col-md-4 well">
						  <div class="form-group">

						  <?php 
						  		$folder = "";
						  		switch($r->valor){
						  			case 1:
						  				$folder = "integridad";
						  			break;
						  			case 2:
							  			$folder = "proactividad";
						  			break;
						  			case 3:
						  				$folder = "compromiso";
						  			break;
						  			case 4:
						  				$folder = "colaboracion";
						  			break;
						  			case 5:
						  				$folder = "gestion_al_cambio";
						  			break;
						  			case 6:
						  				$folder = "pensamiento_creativo";
						  			break;
						  		}

						  		$ip = "http://www.ginesisnatural.com/images/no_image.jpg";

						  		if(($r->a1 == 1) && ($r->a2 == 0) && ($r->a3 == 0)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 1.png";
						  		}elseif(($r->a1 == 1) && ($r->a2 == 1) && ($r->a3 == 0)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 2.png";
						  		}elseif(($r->a1 == 1) && ($r->a2 == 1) && ($r->a3 == 1)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 3.png";
						  		}elseif(($r->a1 == 0) && ($r->a2 == 1) && ($r->a3 == 0)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 4.png";
						  		}elseif(($r->a1 == 0) && ($r->a2 == 1) && ($r->a3 == 1)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 5.png";
						  		}elseif(($r->a1 == 0) && ($r->a2 == 0) && ($r->a3 == 1)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 6.png";
						  		}elseif(($r->a1 == 1) && ($r->a2 == 0) && ($r->a3 == 1)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 7.png";
						  		}elseif(($r->a1 == 0) && ($r->a2 == 0) && ($r->a3 == 0)){
					  				$ip = "assets/images/valores/".$fe."/".$folder."/CH_VALORES_ROMPE CASE 8.png";
						  		}
						  ?>

						  	<img class="" height="180px" src="<?= base_url($ip);?>">

						  	<h3><?= $r->nombre ?></h3>
						  	<h3><?= $r->mes ?></h3>
						  </div>
						</div>
			  		<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function(){

			//alert("aaa");
		});
	</script>