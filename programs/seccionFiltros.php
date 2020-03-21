<?php
session_start();
/**Declaración de Querys**/
$queryFltCostVida = "SELECT MIN(CAST(u.columna_24 AS UNSIGNED)) rngMinimo, MAX(CAST(u.columna_24 AS UNSIGNED)) rngMaximo
FROM program p JOIN university u ON p.columna_2 = u.columna_2  AND p.columna_3 = u.columna_4 ";
$queryRngPrecMin = "SELECT MIN(CAST(p.columna_14 AS UNSIGNED)) min14, MIN(CAST(p.columna_15 AS UNSIGNED)) min15 FROM program p JOIN university u ON p.columna_2 = u.columna_2
 AND p.columna_3 = u.columna_4 ";
$queryRngPrecMax = "SELECT MAX(CAST(p.columna_14 AS UNSIGNED)) max14, MAX(CAST(p.columna_15 AS UNSIGNED)) max15 FROM program p JOIN university u ON p.columna_2 = u.columna_2
AND p.columna_3 = u.columna_4 ";


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
            $queryRngPrecMin .= $valor;
            $queryRngPrecMax .= $valor;
            $queryFltCostVida .= $valor;
        }
    }
}

/**Excecute Querys:**/
$arrayRngs = calcRngMinMax($queryRngPrecMin, $queryRngPrecMax);
$arrayRngsCostLiving =  mysqli_fetch_array( $connect->query($queryFltCostVida));

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
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtNiveles"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$_LEVEL?>...</option>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtDisiplina"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$_DISCIPLINE?>...</option>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtPais"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$COUNTRY?>...</option>
 	</select>
</div>
<div class="btn-group dropdown no-border">
	<select id="filtCiudad"
		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
		onchange="javaScript:selectFilter(this);">
		<option value="-1"><?=$CITY?>...</option>
 	</select>
</div>

<div class="btn-group dropdown no-border">
<a class="jr-btn btn-white btn btn-default btn-filt-more" href="javascript:openModal();" type="button"><?=$MORE_FILTERS?></a>
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
                        				<select id="filtDuracion"
                        					class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
                        					onchange="javaScript:selectFilter(this);">
                        					<option value="-1"><?=$PROG_DURATION?>...</option>
                        				</select>
                        </div>
                        
                        <div class="padding-filtter">
                        	<select id="filtIntake"
                        		class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter"
                        		onchange="javaScript:selectFilter(this);">
                        		<option value="-1"><?=$INTAKE?>...</option>
                        </select>
                        </div>
                        
                        <div class="padding-filtter">
                        					<brange><?=$COSTLIVING?> ($USD):</brange>
                         <input id="ex1" type="text" class="span2" value="" 
                        	data-slider-min="<?=$arrayRngsCostLiving['rngMinimo'];?>" data-slider-max="<?=$arrayRngsCostLiving['rngMaximo'];?>" 
                        	data-slider-step="5000" data-slider-value="[<?=$arrayRngsCostLiving['rngMinimo'];?>,<?=$arrayRngsCostLiving['rngMaximo'];?>]"/>
                        	<br/><br/>
                            <a href="javaScript:selectFilterPrice('filtCostVida');" class="gx-btn-light-green btn-price"><?=$BTN_APPLY_PRICE_RANGE?></a>
                  	  		<a href="javaScript:deleteFilter('filtCostVida','');" class="gx-btn-light-green btn-price">Clean</a>
                  	  		
                        			</div>
                         
                         <brange><?=$RNG_PRICES?> ($USD):</brange>
                         <input id="ex2" type="text" class="span2" value="" 
                        	data-slider-min="<?=$arrayRngs[0];?>" data-slider-max="<?=$arrayRngs[1];?>" 
                        	data-slider-step="5000" data-slider-value="[<?=$arrayRngs[0];?>,<?=$arrayRngs[1];?>]"/>
                        	<br/><br/>
                            <a href="javaScript:selectFilterPrice('filtRngTuitionFee');" class="gx-btn-light-green btn-price"><?=$BTN_APPLY_PRICE_RANGE?></a>
                  	  		<a href="javaScript:deleteFilter('filtRngTuitionFee','');" class="gx-btn-light-green btn-price">Clean</a>
                        
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
jQuery(function($){
	$("#ex1").slider({});
});	
jQuery(function($){
	$("#ex2").slider({});
});	
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
    			location.href = './listprograms';			
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
function selectFilterPrice( filter ){
	if( filter != null && filter == 'filtCostVida'){
    	$.ajax( {
    		url: '<?=ptplg_url?>programs/ajax/ajaxChangeFilter.php?idFilter=filtRngCostLiving&value='+$("#ex1").val()+'&action=ADD',
    		type: 'GET',
    		data: new FormData(),
    		success: function ( data ) {
    			//console.log( data );
    			location.href = './listprograms';			
    		},
    		error: function ( data ) {
    			//console.log( data );
    		},
    		cache: false,
    		contentType: false,
    		processData: false
    	} );
	}else if(filter != null && filter == 'filtRngTuitionFee'){
		$.ajax( {
    		url: '<?=ptplg_url?>programs/ajax/ajaxChangeFilter.php?idFilter=filtRngTuitionFee&value='+$("#ex2").val()+'&action=ADD',
    		type: 'GET',
    		data: new FormData(),
    		success: function ( data ) {
    			//console.log( data );
    			location.href = './listprograms';			
    		},
    		error: function ( data ) {
    			//console.log( data );
    		},
    		cache: false,
    		contentType: false,
    		processData: false
    	} );
	}
	return false;
}
$(document).ready(function () {
	jQuery(function($){
        $.ajax( {
        	url: '<?=ptplg_url?>programs/filter-demand/university.php',
        	type: 'GET',
        	data: new FormData(),
        	success: function ( data ) {
        		//console.log( data );
        		$("#filtUniversidades").html(data);	
        	},
        	error: function ( data ) {
        		console.log( data );
        	},
        	cache: false,
        	contentType: false,
        	processData: false
        } );
        $.ajax( {
        	url: '<?=ptplg_url?>programs/filter-demand/level.php',
        	type: 'GET',
        	data: new FormData(),
        	success: function ( data ) {
        		//console.log( data );
        		$("#filtNiveles").html(data);	
        	},
        	error: function ( data ) {
        		console.log( data );
        	},
        	cache: false,
        	contentType: false,
        	processData: false
        } );
        $.ajax( {
        	url: '<?=ptplg_url?>programs/filter-demand/discipline.php',
        	type: 'GET',
        	data: new FormData(),
        	success: function ( data ) {
        		//console.log( data );
        		$("#filtDisiplina").html(data);	
        	},
        	error: function ( data ) {
        		console.log( data );
        	},
        	cache: false,
        	contentType: false,
        	processData: false
        } );
        $.ajax( {
        	url: '<?=ptplg_url?>programs/filter-demand/country.php',
        	type: 'GET',
        	data: new FormData(),
        	success: function ( data ) {
        		//console.log( data );
        		$("#filtPais").html(data);	
        	},
        	error: function ( data ) {
        		console.log( data );
        	},
        	cache: false,
        	contentType: false,
        	processData: false
        } );
        $.ajax( {
        	url: '<?=ptplg_url?>programs/filter-demand/city.php',
        	type: 'GET',
        	data: new FormData(),
        	success: function ( data ) {
        		//console.log( data );
        		$("#filtCiudad").html(data);	
        	},
        	error: function ( data ) {
        		console.log( data );
        	},
        	cache: false,
        	contentType: false,
        	processData: false
        } );
        return false;    
	});
});

function openModal(){
    $(document).ready(function () {
    	jQuery(function($){
            $.ajax( {
            	url: '<?=ptplg_url?>programs/filter-demand/costLiving.php',
            	type: 'GET',
            	data: new FormData(),
            	success: function ( data ) {
            		//console.log( data );
            		$("#filtCostVida").html(data);	
            	},
            	error: function ( data ) {
            		console.log( data );
            	},
            	cache: false,
            	contentType: false,
            	processData: false
            } );
            $.ajax( {
            	url: '<?=ptplg_url?>programs/filter-demand/durationProgram.php',
            	type: 'GET',
            	data: new FormData(),
            	success: function ( data ) {
            		//console.log( data );
            		$("#filtDuracion").html(data);	
            	},
            	error: function ( data ) {
            		console.log( data );
            	},
            	cache: false,
            	contentType: false,
            	processData: false
            } );
            $.ajax( {
            	url: '<?=ptplg_url?>programs/filter-demand/intake.php',
            	type: 'GET',
            	data: new FormData(),
            	success: function ( data ) {
            		//console.log( data );
            		$("#filtIntake").html(data);	
            	},
            	error: function ( data ) {
            		console.log( data );
            	},
            	cache: false,
            	contentType: false,
            	processData: false
            } );
            $('#exampleModalCenter4').modal('toggle');
    	});
    });
	
}
</script>