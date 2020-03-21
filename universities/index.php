<?php
session_start();
require_once(ptplg_path . 'conexion.php');
require_once(ptplg_path . 'universities/funciones.php');
require_once(ptplg_path . 'lng/lang_en.php');
/**Inicializar Array para Filtros:**/
if(!isset($_GET['selectFilter'])){
    $_SESSION['arrayFiltersSelectedUniv'] = array();
    $_SESSION['arrayFiltersUniv'] = array();
}
/**Fin Inicializar Array para Filtros**/
?>

<!-- Bootstrap stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-bootstrap.css" rel="stylesheet">
<!-- /bootstrap stylesheet -->

<!-- Font Material stylesheet -->
<link rel="stylesheet" href="<?=ptplg_url?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
<!-- /font material stylesheet -->

<!-- Mouldifi-core stylesheet -->
<link href="<?=ptplg_url?>css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi-core stylesheet -->

<!-- Color-Theme stylesheet -->
<link id="override-css-id" href="<?=ptplg_url?>css/theme-indigo.min.css" rel="stylesheet">
<!-- Color-Theme stylesheet -->

<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">

<style type="text/css">::-webkit-scrollbar
    {
        width: 0px;
    }
    ::-webkit-scrollbar-track-piece
    {
        background-color: transparent;
        -webkit-border-radius: 6px;
    }
</style>
<div class="gx-card-body manage-margin-header text-center">
	 <h1><strong><?= $SEARCH_UNIVERSITY ?></strong></h1>
	 <?php include ptplg_path . 'universities/seccionFiltros.php';?>
    <div class="manage-margin-header">
    <div class="inline-div-left">			
    	<?php include ptplg_path . 'universities/seccionLista.php';?>
    </div>
    <div class="inline-div-right">			
    	<?php include ptplg_path . 'universities/seccionMapa.php';?>
    </div>
    </div>
</div>
<!-- Loader Backdrop -->
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

<!--Custom JQuery-->
<script src="<?=ptplg_url?>js/functions.js"></script>
<script type="text/javascript"
	src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=ptplg_url?>node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script
	src="<?=ptplg_url?>node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=ptplg_url?>js/custom/data-tables.js"></script>
<?php $connect->close(); ?>