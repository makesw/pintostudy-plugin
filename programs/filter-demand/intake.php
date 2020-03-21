<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryCantItem = "SELECT COUNT(1) total FROM program p JOIN university u ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
    /**Apply Filters to Querys:**/
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryCantItem .= $valor;
            }
        }
    }
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
    echo '<option value="-1">'.$INTAKE.'...'.'</option>';
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