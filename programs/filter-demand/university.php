<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltUniversidad = "SELECT DISTINCT (p.columna_2) universidad, count(p.columna_2) total FROM program p JOIN university u 
    ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltUniversidad .= $valor;
            }
        }
    } 
    $queryFltUniversidad .=  ' group by universidad order by universidad asc';
    $listUniversidades = $connect->query($queryFltUniversidad);
    echo '<option value="-1">'.$_UNIVERSITY.'...'.'</option>';
    while ($row = mysqli_fetch_array($listUniversidades)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['university']) && strpos($_SESSION['arrayApplyFiltersValues']['university'], $row['universidad'])) {
            echo "<option selected value='" . $row['universidad'] . "'>" . $row['universidad'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['universidad'] . "'>" . $row['universidad'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>