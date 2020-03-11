<?php
function calcularListaRangPromMatric( $query ){ //Cada rango se definió en 5mil USD
    include(ptplg_path . 'conexion.php');
    $arrayRangos = array();
    $rangos = mysqli_fetch_array($connect->query($query));
        
    if( $rangos!=null && !empty($rangos[ 'maxPromMatric' ]) ){   
        $arrRango = array();
        $valorDer = 0;
        $valorIzq = $rangos[ 'minPromMatric' ];
        while ( $valorDer < $rangos[ 'maxPromMatric' ] ) {
            $valorDer = $valorIzq+5000;
            if($valorDer>$rangos[ 'maxPromMatric' ]){
                $valorDer = $rangos[ 'maxPromMatric' ];
            }
            $arrRango[0]=$valorIzq;
            $arrRango[1]=$valorDer;
            array_push($arrayRangos,$arrRango);
            $rngMin = $valorDer;
            $valorIzq = $rngMin+1;
        }
    }
    $connect->close();
    return $arrayRangos;
}
function calcularListaRangCostVida( $query ){ //Cada rango se definió en 5mil USD
    include(ptplg_path . 'conexion.php');
    
    $arrayRangos = array();
    $rangos = mysqli_fetch_array($connect->query($query));
    
    if( $rangos!=null && !empty($rangos[ 'maxValcostV' ]) ){
        $arrRango = array();
        $valorDer = 0;
        $valorIzq = $rangos[ 'minValcostV' ];
        while ( $valorDer < $rangos[ 'maxValcostV' ] ) {
            $valorDer = $valorIzq+5000;
            if($valorDer>$rangos[ 'maxValcostV' ]){
                $valorDer = $rangos[ 'maxValcostV' ];
            }
            $arrRango[0]=$valorIzq;
            $arrRango[1]=$valorDer;
            array_push($arrayRangos,$arrRango);
            $rngMin = $valorDer;
            $valorIzq = $rngMin+1;
        }
    }
    $connect->close();
    return $arrayRangos;
}
?>