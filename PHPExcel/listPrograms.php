<?php
session_start();
require_once(ptplg_path . 'conexion.php');
require_once(ptplg_path . 'programs/funciones.php');
require_once(ptplg_path . 'lng/lang_en.php');
?>
<!-- material-design-iconic-font stylesheet -->
<link href="<?=ptplg_url?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css" rel="stylesheet">
<!-- /material-design-iconic-font stylesheet -->
<!-- theme-indigo stylesheet -->
<link href="<?=ptplg_url?>css/theme-indigo.min.css" rel="stylesheet">
<!-- /theme-indigo stylesheet -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">
<div class="loader-backdrop">
    <!-- Loader -->
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
    </div>
    <!-- /loader-->
</div>
<!-- loader backdrop -->
<div class="gx-card-body manage-margin-header text-center">
	 <h1><strong><?= $_REFINE_SEARCH_PROG ?></strong></h1>
	 <?php //clude ptplg_path . 'programs///ccionFiltros.php';?>
	 <!-- div class="gx-btn-group">
		<?php /* 
		foreach ($_SESSION['arrayApp /*iltersValues'] as &$valor) {
		  if(!empty($valor)){ 
		      $arrayValor = explode("=", $valor);
        		if( isset($arrayValor[1]) ) {
        		*//*?>
        	  	<a href="javaScript:d*//*eFilter('<?php echo $arrayValor[0];?>','<?php echo $arrayValor[1];?>');" class="gx-btn gx-btn-default gx-btn-shadow btnApplyFilter">
                    <span><?php echo $arrayValor[1];?></span>
                    <i class="zmdi zmdi-close zmdi-hc-fw zmdi-hc-lg text-danger"></i>
                </a>
        		<?php/* 
        		}
		  }
		}*/ ?>
    </div -->
  	<div class="manage-margi*/ eader">
    <div class="inline-div-left">			
    	<?php include ptplg_path . 'programs/seccionLista.php';?>
  	</div>
    <div class="inline-div-right">			
    	<?php //include ptplg_path . 'programs/seccionMapa.php'; ?>
    </div>
    </div>
</div>
<!-- Menu Backdrop -->
<div class="menu-backdrop fade"></div>
<!-- /menu backdrop -->
<!--Load JQuery-->
<script src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<!--Bootstrap JQuery-->
<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--Perfect Scrollbar JQuery-->
<script src="<?=ptplg_url?>node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<!--Big Slide JQuery-->
<script src="<?=ptplg_url?>node_modules/bigslide/dist/bigSlide.min.js"></script>

<script type="text/javascript"
	src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=ptplg_url?>node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script
	src="<?=ptplg_url?>node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=ptplg_url?>js/custom/data-tables.js"></script>

<!--Custom JQuery-->
<script src="<?=ptplg_url?>js/functions.js"></script>


<script type="text/javascript">
function deleteFilter (idFilter, valor) {
	$.ajax( {
		url: '<?=ptplg_url?>programs/ajax/ajaxChangeFilter.php?action=RMV&idFilter='+idFilter+'&valor='+valor,
		type: 'POST',
		data: new FormData(),
		success: function ( data ) {
			//console.log( data );
			location.href = './listPrograms/?selectFilter=ON';		
		},
		error: function ( data ) {
			//console.log( data );
		},
		cache: false,
		contentType: false,
		processData: false
	} );
	return false;
}
</script>
<?php $connect->close(); ?>