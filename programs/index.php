<?php
session_start();
require_once(ptplg_path . '/conexion.php');
require_once(ptplg_path . '/lng/lang_en.php');
/**Inicializar Array de Filtros:**/
$_SESSION['arrayApplyFilters'] = $array = [
    "university" => "",
    "level" => "",
    "discipline" => "",
    "country" => "",
    "city" => "",
    "costLiving" => "",
    "durationProg" => "",
    "intake" => "",
    "tuitionfee" => "",
    "searchText" => ""
    
];
$_SESSION['arrayApplyFiltersValues'] = $array = [
    "university" => "",
    "level" => "",
    "discipline" => "",
    "country" => "",
    "city" => "",
    "costLiving" => "",
    "durationProg" => "",
    "intake" => "",
    "tuitionfee" => "",
    "searchText" => ""    
];
/**Fin Inicializar Array para Filtros**/
// Consultar Niveles:
$niveles = $connect->query("SELECT DISTINCT columna_6 from program");
// Consultar Diciplinas:
$diciplinas = $connect->query("SELECT DISTINCT columna_5 from program");
// Consultar Lugares:
$lugares = $connect->query("SELECT DISTINCT columna_1 from program");
//contar totalidad de programas:
$cantPrograms = mysqli_fetch_array($connect->query("SELECT COUNT(1) total from program"));
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
<!-- Main Content -->
<div class="gx-main-content">
     <div class="pt-3 text-center programs-title">
      	<h2><strong><?= $_SEARCH_TITTLE ?></strong></h2>
     </div>
     <form  id="formFilters" method="post" action="listprograms">
			<div class="row">					
					<div class="col-md-4 col-12">
						<div class="form-group">
							<label class="programs-title" for="fltNivel"><?= $_LEVEL ?></label>
							<div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="zmdi back-img-level"></i></div>
                                </div>															
							<select id="filtNiveles" class="form-control selectpicker" multiple name="filtNiveles[]" required
								data-live-search="false" data-iconBase="fa" data-tickIcon="fa-check" data-none-selected-text title="Please Select...">								
								<?php 
								   while ( $row = mysqli_fetch_array( $niveles ) ) {
									    echo "<option value='" . $row[ 'columna_6' ] . "'>" . $row[ 'columna_6' ] . "</option>";
									}
								?>								
							</select>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-12">
						<div class="form-group">
							<label class="programs-title" for="filtDiciplinas"><?= $_DISCIPLINE ?></label>
							<div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="zmdi back-img-discip"></i></div>
                                </div>								
							<select id="filtDiciplinas" class="form-control selectpicker" multiple name="filtDiciplinas[]" required
								data-live-search="false" title="Please Select...">
								<?php 
								   while ( $row = mysqli_fetch_array( $diciplinas ) ) {
									    echo "<option value='" . $row[ 'columna_5' ] . "'>" . $row[ 'columna_5' ] . "</option>";
									}
								?>								
							</select>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-12">
						<div class="form-group">
							<label class="programs-title" for="filtLugares"><?= $_LOCATION ?></label>							
							<div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="zmdi back-img-location"></i></div>
                                </div>	
							<select id="filtLugares" class="form-control selectpicker" multiple multiple name="filtLugares[]" required
								data-live-search="false" title="Please Select...">
								<?php 
								   while ( $row = mysqli_fetch_array( $lugares ) ) {
									    echo "<option value='" . $row[ 'columna_1' ] . "'>" . $row[ 'columna_1' ] . "</option>";
									}
								?>								
							</select>
							</div>
						</div>
					</div>
			</div>
			<div class="dropdown-box text-center">
			<button class="gx-btn gx-btn-light-green btn-round">
						<i class="zmdi zmdi-search zmdi-hc-fw"></i><span><?= $_BTN_SEARCH ?></span>
					</button>
			</div>
			<input type="hidden" id="hfiltNiv" name="hfiltNiv" value="" />
			</form>
</div>
<script src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<link rel="stylesheet" href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap-select.css" />
<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap-select.min.js"></script>
</html>
<?php $connect->close(); ?>
