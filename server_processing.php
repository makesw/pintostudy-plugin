<?php
require_once ('conexion.php');
$queryPrograms = "SELECT p.columna_7, p.columna_16, u.columna_2 nombre_univ,u.columna_3 pais,u.columna_4 ciudad,
u.columna_34 logo_universidad, u.columna_24 costo_vida, u.columna_25 app_fee, p.columna_14 tuition_year, p.columna_15 tuition_prog
FROM program p JOIN university u WHERE p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 LIMIT " . intval($_GET['start']) . ", " . intval($_GET['length']);
$listPrograms = $connect->query($queryPrograms);
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
$response = '';
$recordsTotal = $listPrograms->num_rows;
echo '{
  "draw": ' . $draw . ',
  "recordsTotal": 2000,
  "recordsFiltered": 2000,
  "data": [';
$data ='';
while ($row = mysqli_fetch_array($listPrograms)) {
    $data.=' [
          "' . $row['pais'] . '",
          "Satou",
          "Accountant",
          "Tokyo",
          "28th Nov 08",
          "$162,700"
        ],';
}
$data.= ']}';
$data = str_replace ( ',]}' , ']}' , $data );
echo $data;
?>