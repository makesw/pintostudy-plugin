<?php
session_start();
require_once('../../conexion.php');
define( 'path_img_log_univ', 'https://pintostudy.com/wp-content/uploads/university-logos/');
$queryPrograms = "SELECT p.columna_7, p.columna_16, u.columna_2 nombre_univ,u.columna_3 pais,u.columna_4 ciudad,
u.columna_34 logo_universidad, u.columna_24 costo_vida, u.columna_25 app_fee, p.columna_14 tuition_year, p.columna_15 tuition_prog
FROM program p JOIN university u WHERE p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";

/**Apply Filters to Query:**/
if( isset($_SESSION['arrayApplyFilters']) ){
    foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
        if( !empty($valor) ){
            $queryPrograms .= $valor;
        }
    }
}

$queryPrograms .=" LIMIT " . intval($_GET['start']) . ", " . intval($_GET['length']);

$listPrograms = $connect->query($queryPrograms);
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 0;
$response = '';
echo '{
  "draw": ' . $draw . ',
  "recordsTotal": '.$_GET['totalProg'].',
  "recordsFiltered": '.$_GET['totalProg'].',
  "data": ['; 
$data ='';
while ($row = mysqli_fetch_array($listPrograms)) {
    $tuitionFee = !empty($row['tuition_year']) ? $row['tuition_year']: $row['tuition_prog'];
    $search  = array("\n","•	");
    $data.='[[
        "'.path_img_log_univ.$row['logo_universidad'].'.png'.'",
        "'.str_replace("\n" , " " ,$row['columna_7']).'",   
        "'.str_replace("\n" , " " ,$row['nombre_univ']).'",
        "'.$row['ciudad'].'",
        "'.$row['pais'].'",
        "'.str_replace($search, '<br/>', substr($row['columna_16'],0,200)).'...'.'",
        "'.(is_numeric($row['app_fee']) ? '$ '.number_format($row['app_fee'],0) : 'ND').' USD",
        "'.(is_numeric($tuitionFee) ? '$ '.number_format($tuitionFee,0).' - $ '.number_format(( ($tuitionFee*0.1)+$tuitionFee),0): 'ND').' USD"
    ]],';
}
$data.= ']}';
$data = str_replace ( ',]}' , ']}' , $data );
echo $data;
?>