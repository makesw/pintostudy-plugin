<?php
require_once(ptplg_path . 'conexion.php');
/**Declaración de Querys**/
$queryUniversidades = "SELECT distinct u.* FROM university u WHERE 1 = 1 ";
/**Fin Declaración de Querys**/
/**Adición de Filtro iniciales a Querys**/
for ($i = 0; $i <= count($_SESSION['arrayFiltersUniv']); $i++) {
    $queryUniversidades .= $_SESSION['arrayFiltersUniv'][$i];
}
/**Fin Adición de Filtro iniciales a Querys**/
/**Ejecución de Querys**/
$listUniversities = $connect->query($queryUniversidades);
/**Fin Ejecución de Querys**/
$arrayPoints = array();
while ($row = mysqli_fetch_array($listUniversities)) {
    $arrayPoint = array();
    $arrayPoint[0] = $row['columna_6']; //coordenadas
    $arrayPoint[1] = $row['columna_14']; //cantidad de estudiantes
    $arrayPoint[2] = $row['columna_2']; //Nombre Universidad
    $arrayPoint[3] = $row['columna_4']; //Ciudad
    $arrayPoint[4] = $row['columna_3']; //Pais
    $arrayPoint[5] = $row['columna_23']; //Tuition Fee
    array_push($arrayPoints, $arrayPoint);
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
        <?php if($listUniversities->num_rows > 0){
            foreach ($arrayPoints as $valorMaker){
                $latLng = explode(",", $valorMaker[0]);
                echo '["'.$valorMaker[2].'","'.trim($latLng[0]).'","'.trim($latLng[1]).'","'.$valorMaker[1].'"],';
            }
        }
        ?>
	];

 	// Info window content
    var infoWindowContent = [
        <?php if($listUniversities->num_rows > 0){
            foreach ($arrayPoints as $valorMaker){ ?>
                ['<div class="info_content">' +
                '<h3><?php echo $valorMaker[2]; ?></h3>' +
                '<p style="text-align: left;><strong></strong> <?php echo $valorMaker[3].' / '.$valorMaker[4]; ?></p>' + 
                '<p style="text-align: left;><strong><?php echo  $valorMaker[3]." / ".$valorMaker[4]; ?></strong>'+
               	'<br/>Students: <?php echo  is_numeric($valorMaker[1]) ? number_format($valorMaker[1]) : $valorMaker[1]; ?>' +    
               	'<br/>Tuition Fee: <?php echo is_numeric($valorMaker[5]) ? ('$ '.number_format($valorMaker[5],0).' - $ '.number_format(( ($valorMaker[5]*0.1)+$valorMaker[5]),0)): $valorMaker[5] ; ?></p>' +
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
            title: markers[i][0],
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