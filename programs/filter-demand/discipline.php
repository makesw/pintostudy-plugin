<?php 
    session_start();
    require_once('../../conexion.php');
    require_once('../../lng/lang_en.php');
    $queryFltDiciplina = "SELECT DISTINCT (p.columna_5) disciplina, count(p.columna_5) total FROM program p JOIN university u 
    ON p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";
    if( isset($_SESSION['arrayApplyFilters']) ){
        foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
            if( !empty($valor) ){
                $queryFltDiciplina .= $valor;
            }
        }
    } 
    $queryFltDiciplina .=  ' group by disciplina order by disciplina asc';
    $listDiciplinas = $connect->query($queryFltDiciplina);
    echo '<option value="-1">'.$_DISCIPLINE.'...'.'</option>';
    while ($row = mysqli_fetch_array($listDiciplinas)) {
        if (!empty($_SESSION['arrayApplyFiltersValues']['discipline']) && strpos($_SESSION['arrayApplyFiltersValues']['discipline'], $row['disciplina'])) {
            echo "<option selected value='" . $row['disciplina'] . "'>" . $row['disciplina'] . " (" . $row['total'] . ")" . "</option>";
        } else {
            echo "<option value='" . $row['disciplina'] . "'>" . $row['disciplina'] . " (" . $row['total'] . ")" . "</option>";
        }
    }
?>