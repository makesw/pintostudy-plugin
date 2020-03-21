<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltCiudad = "SELECT DISTINCT (p.columna_3) ciudad, count(p.columna_3) total FROM program p JOIN university u 
    ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltCiudad .= $valor;
            }
        }
    } 
    $queryFltCiudad .=  ' group by ciudad order by ciudad asc';
    $listCiudades = $connect->query($queryFltCiudad);
    echo '<option value="-1">'.$CITY.'...'.'</option>';
    while ($row = mysqli_fetch_array($listCiudades)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['city']) && strpos($_SESSION['arrayApplyFiltersValues']['city'], $row['ciudad'])) {
            echo "<option selected value='" . $row['ciudad'] . "'>" . $row['ciudad'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['ciudad'] . "'>" . $row['ciudad'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>