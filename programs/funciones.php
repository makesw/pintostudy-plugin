<?php 
function calcularListaRangoPrecios($queryRngPrecMin,$queryRngPrecMax){ //Cada rango se definió en 5mil USD
    include(ptplg_path . 'conexion.php');
        
    $rngMin = mysqli_fetch_array( $connect->query($queryRngPrecMin));
    $rngMax = mysqli_fetch_array( $connect->query($queryRngPrecMax));
    
    if($rngMin['min14']<$rngMin['min15']){$rngMin=$rngMin['min14'];}else{$rngMin=$rngMin['min15'];}
    if($rngMax['max14']>$rngMax['max15']){$rngMax=$rngMax['max14'];}else{$rngMax=$rngMax['max15'];}
    
    if(empty($rngMin)){
        $rngMin = 0;
    }
    if(empty($rngMax)){
        $rngMax = 0;
    }
    
    $arrListaRangos = array();
    $arrRango = array();
    $valorIzq  = 0;
    $valorDer = 0;
    $valorIzq = $rngMin;
    while ( $valorDer < $rngMax ) {
        $valorDer = $rngMin+5000;
        if($valorDer>$rngMax){
            $valorDer = $rngMax;
        }
        $arrRango[0]=$valorIzq;
        $arrRango[1]=$valorDer;
        array_push($arrListaRangos,$arrRango);
        $rngMin = $valorDer;
        $valorIzq = $rngMin+1;
    }
    $connect->close(); 
    return $arrListaRangos;
}
function calcRngMinMax($queryRngPrecMin,$queryRngPrecMax){ //Cada rango se definió en 5mil USD
    include(ptplg_path . 'conexion.php');
    $arrayResponse = Array();
    $rngMin = mysqli_fetch_array( $connect->query($queryRngPrecMin));
    $rngMax = mysqli_fetch_array( $connect->query($queryRngPrecMax));
    
    if($rngMin['min14']<$rngMin['min15']){$rngMin=$rngMin['min14'];}else{$rngMin=$rngMin['min15'];}
    if($rngMax['max14']>$rngMax['max15']){$rngMax=$rngMax['max14'];}else{$rngMax=$rngMax['max15'];}
    
    if(empty($rngMin)){
        $rngMin = 0;
    }
    if(empty($rngMax)){
        $rngMax = 0;
    }
    $arrayResponse[0] = $rngMin;
    $arrayResponse[1] = $rngMax;
    
    return $arrayResponse;
}
?>