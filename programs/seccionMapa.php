<?php
require_once(ptplg_path . 'conexion.php');

/**Declaración de Query**/
$queryPrograms = "SELECT distinct trim(p.columna_7), p.columna_16, u.columna_2 nombre_univ,u.columna_3 pais,u.columna_4 ciudad,
u.columna_34 logo_universidad, u.columna_24 costo_vida, u.columna_25 app_fee, u.columna_23 tuition_fee, u.columna_6 coordenadas
, u.columna_14 cant_estu FROM program p JOIN university u WHERE p.columna_2 = u.columna_2 AND p.columna_3 = u.columna_4 ";

/**Apply Filters to Query:**/
if( isset($_SESSION['arrayApplyFilters']) ){
    foreach ($_SESSION['arrayApplyFilters'] as &$valor) {
        if( !empty($valor) ){
            $queryPrograms .= $valor;
        }
    }
}
$listPrograms = $connect->query($queryPrograms);
/**Fin Ejecución de Querys**/
$arrayPuntos = array();
while ($row = mysqli_fetch_array($listPrograms)) {
    $arrayPunto = array();
    $arrayPunto[0] = $row['columna_7']; //nombre programa
    $arrayPunto[1] = $row['nombre_univ']; //nombre universidad
    $arrayPunto[2] = $row['coordenadas']; //coordenadas    
    $tuitionFee = 'ND';
    if( is_numeric($row['tuition_fee']) ){
        $tuitionFee =  '$ '.number_format($row['tuition_fee'],0).' - $ '.number_format(( ($row['tuition_fee']*0.1)+$row['tuition_fee']),0);
    }
    $arrayPunto[3] = $tuitionFee; //tuition fee
    $arrayPunto[4] = $row['ciudad']; //ciudad
    $arrayPunto[5] = $row['cant_estu']; //ciudad
    array_push($arrayPuntos, $arrayPunto);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=ISO-8859-1">
<title>Map</title>
<style type="text/css">
body{
margin:0px;
}
</style>
</head>
<body>
<div id="map" style="width: 100%; height: calc(100vh - 20px) !important;touch-action: pan-x pan-y;"></div>
</body>
</html>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfnwHDFA1GHewcUq1bFFLtgKxJfkxe8-k"
type="text/javascript"></script>

<script>
//<![CDATA[
function initMap() {
	var bounds = new google.maps.LatLngBounds();
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 15, lng: -20},
      zoom: 2,
      mapTypeId: 'roadmap'
    });
    map.setTilt(50);
	  
    var image = new google.maps.MarkerImage(
        "<?=ptplg_url?>images/pintostudy.png",
        new google.maps.Size(30, 35),
        new google.maps.Point(0, 0),
        new google.maps.Point(17, 34),
        new google.maps.Size(30, 35)
    );	

 	// Multiple markers location, latitude, and longitude
    var markers = [
        <?php if($listPrograms->num_rows > 0){
            foreach ($arrayPuntos as $valorMaker){
                $latLng = explode(",", $valorMaker[2]);
                echo '["'.$valorMaker[0].'","'.trim($latLng[0]).'","'.trim($latLng[1]).'","'.trim($valorMaker[1]).'","'.trim($valorMaker[4]).'","'.trim($valorMaker[5]).'"],';
            }
        }
        ?>
	];

 	// Info window content
    var infoWindowContent = [
        <?php if($listPrograms->num_rows > 0){
            foreach ($arrayPuntos as $valorMaker){ ?>
                ['<div class="info_content">' +
                	'<h3><?php echo $valorMaker[1].' / '.$valorMaker[4]; ?></h3>' +
                	'<p style="text-align: left;"><strong>Students: </strong> <?=is_numeric($valorMaker[5]) ? number_format($valorMaker[5]) : $valorMaker[5] ;?></p>'+
                	'<p style="text-align: left;"><strong><?=$TIUTION_FEE?>:</strong> <?=is_numeric($valorMaker[3]) ? number_format(trim($valorMaker[3])) : trim($valorMaker[3]) ;?></p>'+
                 '</div>'],
        <?php }
        }
        ?>
    ];

 	// Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][3],
            icon: image,
            //animation: google.maps.Animation.DROP
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }
  
};
//]]>
window.onload=initMap
</script>