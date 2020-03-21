<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltCostVida = "SELECT DISTINCT (u.columna_24) costo_vida, count(u.columna_24) total FROM program p JOIN university u ON p.columna_2 = u.columna_2
    AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltCostVida .= $valor;
            }
        }
    } 
    $queryFltCostVida .=  ' group by costo_vida order by costo_vida asc';
    $listCostVida = $connect->query($queryFltCostVida);
    echo '<option value="-1">'.$COSTLIVING.' ($ USD)...'.'</option>';
    while ($row = mysqli_fetch_array($listCostVida)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['costLiving']) && strpos($_SESSION['arrayApplyFiltersValues']['costLiving'], $row['costo_vida'])) {
            echo "<option selected value='" . $row['costo_vida'] . "'>" . $row['costo_vida'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['costo_vida'] . "'>" . $row['costo_vida'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>