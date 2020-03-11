<?php 
session_start();
/**Add Selected Filter:**/
if($_GET['action']=="ADD" && $_GET['value']!="-1" ){
    if( $_GET['idFilter']=="filtNiveles"){
        $_SESSION['arrayApplyFilters']['level'] = " AND p.columna_6='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['level'] = $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtDisiplina"){
        $_SESSION['arrayApplyFilters']['discipline'] = " AND p.columna_5='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['discipline'] =  $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtPais"){
        $_SESSION['arrayApplyFilters']['country'] = " AND p.columna_1='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['country'] =  $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtCiudad"){
        $_SESSION['arrayApplyFilters']['city'] = " AND p.columna_3='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['city'] =  $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtRngTuitionFee"){
        $rango = explode(",", $_GET['value']);
        $_SESSION['arrayApplyFilters']['tuitionfee'] = " AND ( (p.columna_14 > ".$rango[0]." AND p.columna_14 < ".$rango[1].") OR ( p.columna_15 > ".$rango[0]." AND p.columna_15 < ".$rango[1].") ) ";
        $_SESSION['arrayApplyFiltersValues']['tuitionfee'] =  $_GET['idFilter'].'=$ '.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtCostVida"){
        $_SESSION['arrayApplyFilters']['costLiving'] = " AND u.columna_24='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['costLiving'] =  $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtDuracion"){
        $_SESSION['arrayApplyFilters']['durationProg'] = " AND p.columna_10='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['durationProg'] = $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtIntake"){
        $_SESSION['arrayApplyFilters']['intake'] = " AND p.columna_12 like'%".$_GET['value']."%'";
        $_SESSION['arrayApplyFiltersValues']['intake'] = $_GET['idFilter'].'='.$_GET['value'];
        
    }else if( $_GET['idFilter']=="filtUniversidades"){
        $_SESSION['arrayApplyFilters']['university'] = " AND p.columna_2='".$_GET['value']."'";
        $_SESSION['arrayApplyFiltersValues']['university'] = $_GET['idFilter'].'='.$_GET['value'];
    }
    
}else if( $_GET['value']=="-1" ){
    
    if( $_GET['idFilter']=="filtNiveles"){
        $_SESSION['arrayApplyFilters']['level'] = "";
        $_SESSION['arrayApplyFiltersValues']['level'] ="";
        
    }else if( $_GET['idFilter']=="filtDisiplina"){
        $_SESSION['arrayApplyFilters']['discipline'] = "";
        $_SESSION['arrayApplyFiltersValues']['discipline'] ="";
        
    }else if( $_GET['idFilter']=="filtPais"){
        $_SESSION['arrayApplyFilters']['country'] ="";
        $_SESSION['arrayApplyFiltersValues']['country'] ="";
        
    }else if( $_GET['idFilter']=="filtCiudad"){
        $_SESSION['arrayApplyFilters']['city'] = "";
        $_SESSION['arrayApplyFiltersValues']['city'] ="";
        
    }else if( $_GET['idFilter']=="filtRngTuitionFee"){
        $rango = explode(",", $_GET['value']);
        $_SESSION['arrayApplyFilters']['tuitionfee'] ="";
        $_SESSION['arrayApplyFiltersValues']['tuitionfee'] ="";
        
    }else if( $_GET['idFilter']=="filtCostVida"){
        $_SESSION['arrayApplyFilters']['costLiving'] ="";
        $_SESSION['arrayApplyFiltersValues']['costLiving'] ="";
        
    }else if( $_GET['idFilter']=="filtDuracion"){
        $_SESSION['arrayApplyFilters']['durationProg'] = "";
        $_SESSION['arrayApplyFiltersValues']['durationProg'] ="";
        
    }else if( $_GET['idFilter']=="filtIntake"){
        $_SESSION['arrayApplyFilters']['intake'] = "";
        $_SESSION['arrayApplyFiltersValues']['intake'] ="";
        
    }else if( $_GET['idFilter']=="filtUniversidades"){
        $_SESSION['arrayApplyFilters']['university'] = "";
        $_SESSION['arrayApplyFiltersValues']['university'] ="";
        
    }else if( $_GET['idFilter']=="searchText"){
        $_SESSION['arrayApplyFilters']['searchText'] = "";
        $_SESSION['arrayApplyFiltersValues']['searchText'] ="";
    }
}
?>