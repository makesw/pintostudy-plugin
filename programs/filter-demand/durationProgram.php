<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltDuracion = "SELECT DISTINCT (p.columna_10) duracion , count(p.columna_10) total FROM program p JOIN university u ON p.columna_2 = u.columna_2
    AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltDuracion .= $valor;
            }
        }
    } 
    $queryFltDuracion .=  ' group by duracion order by duracion asc';
    $listDuracion = $connect->query($queryFltDuracion);
    echo '<option value="-1">'.$PROG_DURATION.'...'.'</option>';
    while ($row = mysqli_fetch_array($listDuracion)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['durationProg']) && strpos($_SESSION['arrayApplyFiltersValues']['durationProg'], $row['duracion'])) {
            echo "<option selected value='" . $row['duracion'] . "'>" . $row['duracion'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['duracion'] . "'>" . $row['duracion'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>