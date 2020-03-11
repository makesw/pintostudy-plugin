<?php
define( 'path_img_log_univ', 'https://pintostudy.com/wp-content/uploads/university-logos/');
/**Declaración de Querys**/
$queryUniversidades = "SELECT distinct u.* FROM university u WHERE 1 = 1 ";
/**Fin Declaración de Querys**/
/**Adición de Filtros Seleccionados a Querys**/
if(isset($_GET['selectFilter'])){
    foreach ($_SESSION['arrayFiltersUniv'] as &$valor) {
        $queryUniversidades .= $valor;
    }
}
$queryUniversidades .=' ORDER BY columna_2 asc';
/**Ejecución de Querys**/
$listUniversities = $connect->query($queryUniversidades);
$cantUniv = $listUniversities->num_rows;
/**Fin Ejecución de Querys**/

$selectFilter='';
if(isset($_GET['selectFilter'])){
    $selectFilter = '&selectFilter=On';
}


?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover dataTable-universities">
    <thead>
        <tr>
            <th><h2 class="font-weight-semibold"><?= $cantUniv.' '.$_UNIVERSITIES; ?></h2></th>
        </tr>
    </thead>
        <tbody>
                <?php
                while ($row = mysqli_fetch_array($listUniversities)) {
                ?>
                <tr
                class="user-list d-sm-flex">
                <td scope="col" class="flex-sm-row card"><div class="col-md-2 col-sm-6 col-12 mb-2">
                                    <img class="img-fluid rounded" src="<?=path_img_log_univ.$row['columna_34'].'.png';?>">
                                </div>
                    <div class="description pl-sm-3">
                        <h3><?php echo $row['columna_2']; ?></h3>
                        <h5><strong><?php echo $row['columna_3'].', '.$row['columna_4']; ?></strong></h5>
                        <p>
                                                <?php echo substr($row['columna_30'],0,200)."..."; ?>
                                            </p>
                        <p><h5><strong>
                            Application Fee: <?php echo is_numeric($row['columna_25']) ? '$ '.number_format($row['columna_25'],0).'$USD': ''; ?><br>
                            Tuition Fee: <?php echo is_numeric($row['columna_23']) ? '$ '.number_format($row['columna_23'],0).' - $ '.number_format(( ($row['columna_23']*0.1)+$row['columna_23']).'$USD',0): $row['columna_23']; ?>
                            </strong>
                            </h5>
                        </p>
                                            
                        <a href="../university-detail/?nombre=<?php echo $row['columna_2'].'&selectFilter='.$selectFilter; ?>"
						class="gx-btn gx-btn-light-green btnDetail"><?= $_BTN_DETAILS ?></a>          
                                
                    </div></td>
            </tr>
            <?php } ?>                                              
            </tbody>
    </table>
</div>
<!--Datatables JQuery-->
<script src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?=ptplg_url?>node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script
	src="<?=ptplg_url?>node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?=ptplg_url?>js/custom/data-tables.js"></script>

<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--Perfect Scrollbar JQuery-->
<script src="<?=ptplg_url?>node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<!--Big Slide JQuery-->
<script src="<?=ptplg_url?>node_modules/bigslide/dist/bigSlide.min.js"></script>
<script src="<?=ptplg_url?>js/functions.js"></script>
<script>
$(document).ready(function () {
	$('.dataTable-universities').DataTable({
		"searching": false,
		"bLengthChange": false,
		"bInfo": true,
		"ordering": false,
		"pageLength": 10,
		 "language": {
		    "search": "Search:",
		    "info": "Page _PAGE_ Of _PAGES_"
		  }
	});
});
</script>
    
