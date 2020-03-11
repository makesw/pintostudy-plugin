<?php
/**Declaración de Querys**/
$queryFltPais = "SELECT DISTINCT (u.columna_3) pais FROM university u WHERE 1=1 ";
$queryFltCiudad = "SELECT DISTINCT (u.columna_4) ciudad FROM university u WHERE 1=1 ";
$queryPromMatric = "SELECT MIN(CAST(u.columna_23 AS UNSIGNED)) min, MAX(CAST(u.columna_23 AS UNSIGNED)) max FROM university u JOIN program p WHERE p.columna_2 = u.columna_2 ";
$queryCostVida = "SELECT MIN(CAST(u.columna_24 AS UNSIGNED)) min, MAX(CAST(u.columna_24 AS UNSIGNED)) max FROM university u JOIN program p WHERE p.columna_2 = u.columna_2 ";
$queryCantItem = "SELECT count(1) total FROM university u WHERE 1=1 ";
$arrayDisciplinas = array("Arts","Sciences","Computer Sciences","Social Sciences","Engineering","Law and Politic Sciences"
    ,"Business (Marketing, Management, Finance)","Health","Architecture and Design","Education","Sport","Media","Comunity Services"
    ,"Languages");
$queryCantItemDiscp = "SELECT count(1) total FROM university u JOIN program p WHERE p.columna_2 = u.columna_2 ";
/**Fin Declaración de Querys**/

/**Adición de Filtro iniciales a Querys**/
if(isset($_GET['selectFilter'])){
    //añadir a los querys los filtros seleccionados
    foreach ($_SESSION['arrayFiltersUniv'] as &$valor) {
        $queryFltPais.= $valor;
        $queryFltCiudad.= $valor;
        $queryPromMatric.= $valor;
        $queryCostVida.= $valor;
        $queryCantItem.= $valor;
        $queryCantItemDiscp.= $valor;
    }
}

/**Ejecución de Querys**/
$listPaises = $connect->query($queryFltPais);
$listCiudades = $connect->query($queryFltCiudad);

$arrayRngsTui = mysqli_fetch_array($connect->query($queryPromMatric));
$arrayCostLiv = mysqli_fetch_array($connect->query($queryCostVida));

/**Fin Ejecución de Querys**/
?>
<!-- Bootstrap stylesheet -->
	<link href="<?=ptplg_url?>css/mouldifi-bootstrap.css" rel="stylesheet">
<!-- /bootstrap stylesheet -->

<link href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap-slider.css" rel="stylesheet">
<link href="<?=ptplg_url?>node_modules/bootstrap/dist/css/bootstrap-slider.min.css" rel="stylesheet">

<link href="<?=ptplg_url?>css/pintostudy-plugin.css" rel="stylesheet">

<div class="btn-group dropdown no-border">
    <select id="filtPais" class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter" onchange="javaScript:selectFilter(this);">
        <option value="-1"><?=$COUNTRY ?>...</option>
        <?php
        while ($row = mysqli_fetch_array($listPaises)) {
            $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND u.columna_3 ='" . $row['pais'] . "'"));
            if( $countItem > 0 ){
                if(isset($_SESSION['arrayFiltersSelectedUniv'][0]) && strpos($_SESSION['arrayFiltersSelectedUniv'][0],$row[ 'pais' ])){
                    echo "<option selected value='" . $row[ 'pais' ] . "'>" . $row[ 'pais' ] . " (" . $countItem['total'] . ")" . "</option>";
                }else{
                    echo "<option value='" . $row[ 'pais' ] . "'>" . $row[ 'pais' ] . " (" . $countItem['total'] . ")" . "</option>";
                }
            }
        }
        ?>
     </select>
</div>
<div class="btn-group dropdown no-border">
    <select id="filtCiudad" class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter" onchange="javaScript:selectFilter(this);">
        <option value="-1"><?=$CITY?>...</option>
        <?php
        while ($row = mysqli_fetch_array($listCiudades)) {
            $countItem = mysqli_fetch_array($connect->query($queryCantItem . " AND u.columna_4 ='" . $row['ciudad'] . "'"));
            if( $countItem > 0 ){
                if(isset($_SESSION['arrayFiltersSelectedUniv'][1]) && strpos($_SESSION['arrayFiltersSelectedUniv'][1],$row[ 'ciudad' ])){
                    echo "<option selected value='" . $row[ 'ciudad' ] . "'>" . $row[ 'ciudad' ] . " (" . $countItem['total'] . ")" . "</option>";
                }else{
                    echo "<option value='" . $row[ 'ciudad' ] . "'>" . $row[ 'ciudad' ] . " (" . $countItem['total'] . ")" . "</option>";
                }
            }
        }
        ?>
     </select>
</div>
<div class="btn-group dropdown no-border">
    <select id="filtDisiplina" class="gx-btn gx-btn-sm  gx-btn-primary  dropdown-toggle btnFilter" onchange="javaScript:selectFilter(this);">
        <option value="-1"><?=$_DISCIPLINE?>...</option>
        <?php
        foreach ($arrayDisciplinas as &$valor) {
            $countItem = mysqli_fetch_array($connect->query($queryCantItemDiscp . " AND p.columna_5 like'%" . $valor . "%'"));
            if( $countItem > 0 ){
                if(isset($_SESSION['arrayFiltersSelectedUniv'][4]) && strpos($_SESSION['arrayFiltersSelectedUniv'][4],$valor)){
                    echo "<option selected value='" . $valor . "'>" .$valor . " (" . $countItem['total'] . ")" . "</option>";
                }else{
                    echo "<option value='" . $valor . "'>" . $valor . " (" . $countItem['total'] . ")" . "</option>";
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
                     <brange><?=$TIUTION_FEE?> ($USD):</brange>
                     <input id="ex2" type="text" class="span2" value="" 
                    	data-slider-min="<?=!empty($arrayRngsTui[0]) ? $arrayRngsTui[0] : 0;?>" data-slider-max="<?=!empty($arrayRngsTui[1]) ? $arrayRngsTui[1] : 5000;?>" 
                    	data-slider-step="5000" data-slider-value="[<?=!empty($arrayRngsTui[0]) ? $arrayRngsTui[0] : 0;?>,<?=!empty($arrayRngsTui[1]) ? $arrayRngsTui[1] : 5000;?>]"/>
                    	<br/><br/>
                        <a href="javaScript:applyTuitionFee();" class="gx-btn-light-green btn-price"><?=$BTN_APPLY_PRICE_RANGE?></a>
               </div> 
               
               <div class="gx-btn-group"> 
                     <brange><?=$COSTLIVING?> ($USD):</brange>
                     <input id="ex22" type="text" class="span2" value="" 
                    	data-slider-min="<?=!empty($arrayCostLiv[0]) ? $arrayCostLiv[0] :0;?>" data-slider-max="<?=!empty($arrayCostLiv[1]) ? $arrayCostLiv[1]: 5000;?>" 
                    	data-slider-step="5000" data-slider-value="[<?=!empty($arrayCostLiv[0]) ? $arrayCostLiv[0] : 0 ;?>,<?=!empty($arrayCostLiv[1]) ? $arrayCostLiv[1] : 5000 ;?>]"/>
                    	<br/><br/>
                        <a href="javaScript:applyCostLiv();" class="gx-btn-light-green btn-price"><?=$BTN_APPLY_PRICE_RANGE?></a>
               </div> 
               
            </div>
            </div>           
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
            url: '<?=ptplg_url?>universities/ajax/ajaxChangeFilter.php?idFilter='+id+'&value='+value+'&action=ADD',
            type: 'POST',
            data: new FormData(),
            success: function ( data ) {
                //console.log( data );
                location.href = './explore-universities/?selectFilter=On';
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
jQuery(function($){
	$("#ex2").slider({});
	$("#ex22").slider({});
});	
</script>