<?php
session_start();
/**Declaración de Querys**/
$queryFltUniversidad = "SELECT DISTINCT (p.columna_2) universidad FROM program p WHERE 1=1 ";
$queryFltNivel = "SELECT DISTINCT (p.columna_6) nivel FROM program p WHERE 1=1 ";
$queryFltDiciplina = "SELECT DISTINCT (p.columna_5) disciplina FROM program p WHERE 1=1 ";
$queryFltPais = "SELECT DISTINCT (p.columna_1) pais FROM program p WHERE 1=1 ";
$queryFltCiudad = "SELECT DISTINCT (p.columna_3) ciudad FROM program p WHERE 1=1 ";
$queryFltCostVida = "SELECT DISTINCT (u.columna_24) costo_vida FROM program p JOIN university u ON p.columna_2 = u.columna_2
AND p.columna_3 = u.columna_4 ";
$queryCantItem = "SELECT COUNT(1) total FROM program p JOIN university u ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
$queryFltDuracion = "SELECT DISTINCT (p.columna_10) duracion FROM program p WHERE 1=1 ";
$queryRngPrecMin = "SELECT MIN(CAST(p.columna_14 AS UNSIGNED)) min14, MIN(CAST(p.columna_15 AS UNSIGNED)) min15 FROM program p WHERE 1=1 ";
$queryRngPrecMax = "SELECT MAX(CAST(p.columna_14 AS UNSIGNED)) max14, MAX(CAST(p.columna_15 AS UNSIGNED)) max15 FROM program p WHERE 1=1 ";


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

/**Apply Filters to Querys:**/
if( isset($_SESSION['arrayApplyFilters']) ){
    foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
        if( !empty($valor) ){
            $queryFltUniversidad .= $valor;
            $queryFltNivel .= $valor;
            $queryFltDiciplina .= $valor;
            $queryFltPais .= $valor;
            $queryFltCiudad .= $valor;
            $queryFltCostVida .= $valor;
            $queryFltDuracion .= $valor;
            $queryCantItem .= $valor;
            $queryRngPrecMin .= $valor;
            $queryRngPrecMax .= $valor;
        }
    }
}

/**Excecute Querys:**/
$listUniversidades = $connect->query($queryFltUniversidad);
$listNiveles = $connect->query($queryFltNivel);
$listDiciplinas = $connect->query($queryFltDiciplina);
$listPaises = $connect->query($queryFltPais);
$listCiudades = $connect->query($queryFltCiudad);
$listCostVida = $connect->query($queryFltCostVida);
$listDuracion = $connect->query($queryFltDuracion);

$arrayRngs = calcRngMinMax($queryRngPrecMin, $queryRngPrecMax);

$arrayMesesInatke = array(
    "JANUARY",
    "FEBRUARY",
    "MARCH",
    "APRIL",
    "MAY",
    "JUNE",
    "JULY",
    "AUGUST",
    "SEPTEMBER",
    "OCTOBER",
    "NOVEMBER",
    "DECEMBER"
);
?>
<!-- Bootstrap stylesheet -->
	<link href="<?=ptplg_url?>css/mouldifi-bootstrap.css" rel="stylesheet">
<!-- /bootstrap stylesheet -->

<link href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap-slider.css" rel="stylesheet">
<link href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap-slider.min.css" rel="stylesheet">

<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">

<div class="btn-group dropdown no-border">
	<select id="filtUniversidades"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$_UNIVERSITY?>...</option>
    	<?php
    while ($row = mysqli_fetch_array($listUniversidades)) {
        $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND p.columna_2 ='" . $row['universidad'] . "' "));
        if( $countItem > 0 ){
            if (!empty($_SESSION['arrayApplyFiltersValues']['university']) && strpos($_SESSION['arrayApplyFiltersValues']['university'], $row['universidad'])) {
                echo "<option selected value='" . $row['universidad'] . "'>" . $row['universidad'] . " (" . $countItem['total'] . ")" . "</option>";
            } else {
                echo "<option value='" . $row['universidad'] . "'>" . $row['universidad'] . " (" . $countItem['total'] . ")" . "</option>";
            }
        }
    }
    ?>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtNiveles"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$_LEVEL?>...</option>
    	<?php
    while ($row = mysqli_fetch_array($listNiveles)) {
        $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND p.columna_6 ='" . $row['nivel'] . "'"));
        if( $countItem > 0 ){
            if (!empty($_SESSION['arrayApplyFiltersValues']['level']) && strpos($_SESSION['arrayApplyFiltersValues']['level'], $row['nivel'])) {
                echo "<option selected value='" . $row['nivel'] . "'>" . $row['nivel'] . " (" . $countItem['total'] . ")" . "</option>";
            } else {
                echo "<option value='" . $row['nivel'] . "'>" . $row['nivel'] . " (" . $countItem['total'] . ")" . "</option>";
            }
        }
    }
    ?>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtDisiplina"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$_DISCIPLINE?>...</option>
    	<?php
    while ($row = mysqli_fetch_array($listDiciplinas)) {
        $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND p.columna_5 ='" . $row['disciplina'] . "'"));
        if( $countItem > 0 ){
            if (!empty($_SESSION['arrayApplyFiltersValues']['discipline']) && strpos($_SESSION['arrayApplyFiltersValues']['discipline'], $row['disciplina'])) {
                echo "<option selected value='" . $row['disciplina'] . "'>" . $row['disciplina'] . " (" . $countItem['total'] . ")" . "</option>";
            } else {
                echo "<option value='" . $row['disciplina'] . "'>" . $row['disciplina'] . " (" . $countItem['total'] . ")" . "</option>";
            }
        }
    }
    ?>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtPais"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$COUNTRY?>...</option>
    	<?php
    while ($row = mysqli_fetch_array($listPaises)) {
        $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND p.columna_1 ='" . $row['pais'] . "'"));
        if( $countItem > 0 ){
            if (!empty($_SESSION['arrayApplyFiltersValues']['country']) && strpos($_SESSION['arrayApplyFiltersValues']['country'], $row['pais'])) {
                echo "<option selected value='" . $row['pais'] . "'>" . $row['pais'] . " (" . $countItem['total'] . ")" . "</option>";
            } else {
                echo "<option value='" . $row['pais'] . "'>" . $row['pais'] . " (" . $countItem['total'] . ")" . "</option>";
            }
        }
    }
    ?>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtCiudad"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$CITY?>...</option>
    	<?php
    while ($row = mysqli_fetch_array($listCiudades)) {
        $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND p.columna_3 ='" . $row['ciudad'] . "'"));
        if( $countItem > 0 ){
            if (!empty($_SESSION['arrayApplyFiltersValues']['city']) && strpos($_SESSION['arrayApplyFiltersValues']['city'], $row['ciudad'])) {
                echo "<option selected value='" . $row['ciudad'] . "'>" . $row['ciudad'] . " (" . $countItem['total'] . ")" . "</option>";
            } else {
                echo "<option value='" . $row['ciudad'] . "'>" . $row['ciudad'] . " (" . $countItem['total'] . ")" . "</option>";
            }
        }
    }
    ?>
 	</select>
</div>

<div class="btn-group dropdown no-border">
<button class="jr-btn btn-white btn btn-default btn-filt-more" data-toggle="modal"
data-target="#exampleModalCenter4" type="button"><?=$MORE_FILTERS?></button>
</div>

<div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h2 class="modal-title" id="exampleModalCenterTitle"><?=$MORE_FILTERS?></h2>
                <a href="javascript:close_modal();" class="close" aria-label="Close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </a>
            </div>
            <div class="modal-body">
               <div class="gx-card-body manage-margin text-center padding-filtter">
               
               <div class="gx-btn-group"> 
                        <div class="padding-filtter">
                        					<select id="filtCostVida"
                        						class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
                        						onchange="javaScript:selectFilter(this);">
                        						<option value="-1"><?=$COSTLIVING?> ($ USD)...</option>
                        <?php
                        while ($row = mysqli_fetch_array($listCostVida)) {
                            $countItem = mysqli_fetch_array($connect->query($queryCantItem." AND u.columna_24 ='" . $row['costo_vida'] . "'"));
                            if( $countItem > 0 ){
                                if (!empty($_SESSION['arrayApplyFiltersValues']['costLiving']) && strpos($_SESSION['arrayApplyFiltersValues']['costLiving'], $row['costo_vida'])) {
                                    echo "<option selected value='" . $row['costo_vida'] . "'>" . $row['costo_vida'] . " (" . $countItem['total'] . ")" . "</option>";
                                } else {
                                    echo "<option value='" . $row['costo_vida'] . "'>" . $row['costo_vida'] . " (" . $countItem['total'] . ")" . "</option>";
                                }
                            }
                        }
                        ?>
                        </select>
                        			</div>
                        
                        
                        			<div class="padding-filtter">
                        				<select id="filtDuracion"
                        					class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
                        					onchange="javaScript:selectFilter(this);">
                        					<option value="-1"><?=$PROG_DURATION?>...</option>
                        <?php
                        while ($row = mysqli_fetch_array($listDuracion)) {
                            $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND p.columna_10 ='" . $row['duracion'] . "'"));
                            if( $countItem > 0 ){
                                if (!empty($_SESSION['arrayApplyFiltersValues']['durationProg']) && strpos($_SESSION['arrayApplyFiltersValues']['durationProg'], $row['duracion'])) {
                                    echo "<option selected value='" . $row['duracion'] . "'>" . $row['duracion'] . " (" . $countItem['total'] . ")" . "</option>";
                                } else {
                                    echo "<option value='" . $row['duracion'] . "'>" . $row['duracion'] . " (" . $countItem['total'] . ")" . "</option>";
                                }
                            }
                        }
                        ?>
                        </select>
                        </div>
                        
                        <div class="padding-filtter">
                        	<select id="filtIntake"
                        		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
                        		onchange="javaScript:selectFilter(this);">
                        		<option value="-1"><?=$INTAKE?>...</option>
                        <?php
                        for ($i = 0; $i < count($arrayMesesInatke); $i ++) {
                            $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND UPPER(p.columna_12) like'%" . trim($arrayMesesInatke[$i]) . "%'"));
                            if( $countItem > 0 ){
                                if (!empty($_SESSION['arrayApplyFiltersValues']['intake']) && strpos($_SESSION['arrayApplyFiltersValues']['intake'], $arrayMesesInatke[$i])) {
                                    echo "<option selected value='" . $arrayMesesInatke[$i] . "'>" . $arrayMesesInatke[$i] . " (" . $countItem['total'] . ")" . "</option>";
                                } else {
                                    echo "<option value='" . $arrayMesesInatke[$i] . "'>" . $arrayMesesInatke[$i] . " (" . $countItem['total'] . ")" . "</option>";
                                }
                            }
                        }
                        ?>
                        </select>
                        </div>
                         
                         <brange><?=$RNG_PRICES?> ($USD):</brange>
                         <input id="ex2" type="text" class="span2" value="" 
                        	data-slider-min="<?=$arrayRngs[0];?>" data-slider-max="<?=$arrayRngs[1];?>" 
                        	data-slider-step="5000" data-slider-value="[<?=$arrayRngs[0];?>,<?=$arrayRngs[1];?>]"/>
                        	<br/><br/>
                            <a href="javaScript:selectFilterPrice();" class="gx-btn-light-green btn-price"><?=$BTN_APPLY_PRICE_RANGE?></a>
                  	  
                        
                </div>
                
                 
            </div>
               
            </div>
            <!-- div class="modal-footer border-0">
                <a href="javascript:void(0)" class="gx-btn-light-green btnDetail btnBack"
                   data-dismiss="modal"><?=$CLOSE?></a>
            </div -->
        </div>
    </div>
</div>
		
<script src="<?=ptplg_url?>node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap-slider.js"></script>
<script src="<?=ptplg_url?>node_modules/bootstrap/dist/js/bootstrap-slider.min.js"></script>
<script type="text/javascript">
function selectFilter (selectObj) {
	id = selectObj.id;
	value = selectObj.value;
	 event.preventDefault();
    	$.ajax( {
    		url: '<?=ptplg_url?>programs/ajax/ajaxChangeFilter.php?idFilter='+id+'&value='+value+'&action=ADD',
    		type: 'GET',
    		data: new FormData(),
    		success: function ( data ) {
    			//console.log( data );
    			location.href = './';				
    		},
    		error: function ( data ) {
    			console.log( data );
    		},
    		cache: false,
    		contentType: false,
    		processData: false
    	} );
    	return false;
}
jQuery(function($){
	$("#ex2").slider({});
});	
function selectFilterPrice(){
	$.ajax( {
		url: '<?=ptplg_url?>programs/ajax/ajaxChangeFilter.php?idFilter=filtRngTuitionFee&value='+$("#ex2").val()+'&action=ADD',
		type: 'GET',
		data: new FormData(),
		success: function ( data ) {
			//console.log( data );
			location.href = './';				
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