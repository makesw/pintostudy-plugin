<?php
session_start();
/**Declaración de Querys**/
$queryPrograms = "SELECT p.columna_7, p.columna_16, u.columna_2 nombre_univ,u.columna_3 pais,u.columna_4 ciudad,
u.columna_34 logo_universidad, u.columna_24 costo_vida, u.columna_25 app_fee, p.columna_14 tuition_year, p.columna_15 tuition_prog  
FROM program p JOIN university u WHERE p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";

/**Set init filters:**/
if( isset($_POST['filtNiveles']) ){
    $_SESSION['arrayApplyFilters']['level'] = " AND p.columna_6 IN('".implode( "','", $_POST['filtNiveles'])."')";
}

if( isset($_POST['filtDiciplinas']) ){
    $_SESSION['arrayApplyFilters']['discipline'] = " AND p.columna_5 IN('".implode( "','", $_POST['filtDiciplinas'])."')";
}
if( isset($_POST['filtLugares']) ){
    $_SESSION['arrayApplyFilters']['country'] = " AND p.columna_1 IN('".implode( "','", $_POST['filtLugares'])."')";
}

/**Search from home text_box **/
if(isset($_POST['searchText'])){
    $arrayStrSearch = explode(" ", $_POST['searchText']);
    $filterSearch  = "";
    $filterSearch .= "AND (";
    for( $i = 0; $i < count($arrayStrSearch); $i++ ) {
        if($i==0){
            $filterSearch .= " UPPER(p.columna_1) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        }else{
            $filterSearch .= " OR UPPER(p.columna_1) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        }        
        $filterSearch .= " OR UPPER(p.columna_2) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        $filterSearch .= " OR UPPER(p.columna_3) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        $filterSearch .= " OR UPPER(p.columna_5) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        $filterSearch .= " OR UPPER(p.columna_6) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        $filterSearch .= " OR UPPER(p.columna_7) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        $filterSearch .= " OR UPPER(p.columna_16) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
        $filterSearch .= " OR UPPER(p.columna_17) like '%".strtoupper(trim($arrayStrSearch[$i]))."%'";
    }
    $filterSearch .= ") ";    
    $_SESSION['arrayApplyFilters']['searchText'] = $filterSearch;
    $_SESSION['arrayApplyFiltersValues']['searchText'] = implode(", ", $arrayStrSearch);
}

/**Apply Filters to Query:**/
if( isset($_SESSION['arrayApplyFilters']) ){
    foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
        if( !empty($valor) ){
            $queryPrograms .= $valor;
        }
    }
}

$queryPrograms .=' ORDER BY columna_7 asc';

//echo $queryPrograms;

/**Excecute Query**/
$listPrograms = $connect->query($queryPrograms);
$cantProg = $listPrograms->num_rows;
/**Fin Ejecución de Querys**/

?>
<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">
<div class="table-responsive">
	<table id="dataTable-programs" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th><h2><?=str_replace ( "?" , $cantProg , $SEARCH_RESULTS_PROG );?></h2></th>
        </tr>
    </thead>
</table>
</div>
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
<script type="text/javascript">
$(document).ready(function() {
    $('#dataTable-programs').DataTable( {
    	"searching": false,
		"bLengthChange": false,
		"bInfo": true,
		"ordering": false,
    	"processing": true,
        "serverSide": true,
        ajax: {
        	url: '<?=ptplg_url?>programs/ajax/program_processing.php?totalProg='+<?=$cantProg?>,
			error: function ( data ) {
				//console.log( data );
			}
        },
        columnDefs: [
            {
              targets: 0,
              render: function (data, type, row, meta) {                           	 
                  return '<div class="col-md-2 col-sm-6 col-12 mb-2">'+
                  '<img class="img-fluid rounded" src="'+data[0]+'">'+
                  '</div>'+
                  '<div class="description pl-sm-3">'+
                  	'<h3>'+data[1]+' / '+data[2]+'</h3>'+
                  	'<h5><strong>'+data[3]+', '+data[4]+'</strong></h5>'+
                  	'<p>'+data[5]+'</p>'+
                  	'<p><h5><strong> Application Fee: '+data[6]+
                  		'<br/>Tuition Fee: '+data[7]+
                  	'</strong><h5></p>'+
                  	'<a href="program-detail/?prog='+data[1]+'" class="gx-btn gx-btn-light-green btnDetail"><?=$_BTN_DETAILS;?></a>'+
                  '</div>'
                  ;                  
                }
            }
          ],          
          createdRow: function (row, data, index) {
        	  $(row).addClass('user-list');
        	  $('td', row).eq(0).addClass('flex-sm-row card');
          }
    } );
} );
</script>