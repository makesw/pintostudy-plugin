<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltPais = "SELECT DISTINCT (p.columna_1) pais, count(p.columna_1) total FROM program p JOIN university u 
    ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltPais .= $valor;
            }
        }
    } 
    $queryFltPais .=  ' group by pais order by pais asc';
    $listPaises = $connect->query($queryFltPais);
    echo '<option value="-1">'.$COUNTRY.'...'.'</option>';
    while ($row = mysqli_fetch_array($listPaises)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['country']) && strpos($_SESSION['arrayApplyFiltersValues']['country'], $row['pais'])) {
            echo "<option selected value='" . $row['pais'] . "'>" . $row['pais'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['pais'] . "'>" . $row['pais'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>