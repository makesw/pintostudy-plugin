<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltlevel = "SELECT DISTINCT (p.columna_6) nivel , count(p.columna_6) total FROM program p JOIN university u 
    ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltlevel .= $valor;
            }
        }
    } 
    $queryFltlevel .=  ' group by nivel order by nivel asc';
    $listNiveles = $connect->query($queryFltlevel);
    echo '<option value="-1">'.$_LEVEL.'...'.'</option>';
    while ($row = mysqli_fetch_array($listNiveles)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['level']) && strpos($_SESSION['arrayApplyFiltersValues']['level'], $row['nivel'])) {
            echo "<option selected value='" . $row['nivel'] . "'>" . $row['nivel'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['nivel'] . "'>" . $row['nivel'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>