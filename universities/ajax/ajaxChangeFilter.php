<?php 
session_start();
/**ADD FILTERS**/
if( isset($_GET['action']) && $_GET['action']=="ADD" && $_GET['value']!= "-1"){
    if( isset($_GET['idFilter']) && $_GET['idFilter']=="filtPais" ){ // agregar filtro de pais POS 0:
        $_SESSION['arrayFiltersUniv'][0] = " AND u.columna_3='".trim($_GET['value'])."'";
        $_SESSION['arrayFiltersSelectedUniv'][0] =  $_GET['idFilter'].'='.$_GET['value'];
    }
    if( isset($_GET['idFilter']) && $_GET['idFilter']=="filtCiudad"){ // agregar filtro de ciudad POS 1:
        $_SESSION['arrayFiltersUniv'][1] = " AND u.columna_4='".trim($_GET['value'])."'";
        $_SESSION['arrayFiltersSelectedUniv'][1] =  $_GET['idFilter'].'='.$_GET['value'];
    }
    if( isset($_GET['idFilter']) && $_GET['idFilter']=="filtRngTuitionFee"){ // agregar filtro promedio matricula POS 2:
        $rango = explode(",", $_GET['value']);
        $_SESSION['arrayFiltersUniv'][2] = " AND u.columna_23 BETWEEN ".$rango[0]." AND ".$rango[1];
        $_SESSION['arrayFiltersSelectedUniv'][2] =  $_GET['idFilter'].'='.$_GET['value'];
    }
    if( isset($_GET['idFilter']) && $_GET['idFilter']=="filtRngCostLiving"){ // agregar filtro costo de vida POS 3:
        $rango = explode(",", $_GET['value']);
        $_SESSION['arrayFiltersUniv'][3] = " AND u.columna_24 BETWEEN ".$rango[0]." AND ".$rango[1];
        $_SESSION['arrayFiltersSelectedUniv'][3] =  $_GET['idFilter'].'='.$_GET['value'];
    }
    if( isset($_GET['idFilter']) && $_GET['idFilter']=="filtDisiplina"){ // agregar filtro disciplina POS 4:
        $_SESSION['arrayFiltersUniv'][4] = " AND p.columna_5 like'%".$_GET['value']."%'";
        $_SESSION['arrayFiltersSelectedUniv'][4] =  $_GET['idFilter'].'='.$_GET['value'];
    }
}
/**FIN ADD FILTERS**/

/**REMOVE FILTERS**/
if( $_GET['value']== "-1" ){ // borrar filtro respectivo:    
    if( isset( $_GET['idFilter']) && $_GET['idFilter']=="filtPais" ){ //Clear filter pais POS 0
        $_SESSION['arrayFiltersUniv'][0] = "";
        $_SESSION['arrayFiltersSelectedUniv'][0] = "";
    }
    if( isset( $_GET['idFilter']) && $_GET['idFilter']=="filtCiudad" ){ //Clear filter ciudad POS 1
        $_SESSION['arrayFiltersUniv'][1] = "";
        $_SESSION['arrayFiltersSelectedUniv'][1] = "";
    }    
    if( isset( $_GET['idFilter']) && $_GET['idFilter']=="filtRngTuitionFee" ){ //Clear filter Promedio matricula POS 2:
        $_SESSION['arrayFiltersUniv'][2] = "";
        $_SESSION['arrayFiltersSelectedUniv'][2] = "";
    }
    if( isset( $_GET['idFilter']) && $_GET['idFilter']=="filtRngCostLiving" ){ //Clear filter costo de vida POS 3:
        $_SESSION['arrayFiltersUniv'][3] = "";
        $_SESSION['arrayFiltersSelectedUniv'][3] = "";
    }
    if( isset( $_GET['idFilter']) && $_GET['idFilter']=="filtDisiplina" ){ //Clear filter  disciplina POS 4:
        $_SESSION['arrayFiltersUniv'][4] = "";
        $_SESSION['arrayFiltersSelectedUniv'][4] = "";
    }
}
/**FIN REMOVE FILTERS**/
?>