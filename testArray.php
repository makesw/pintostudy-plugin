<?php 

$array = [
    "clave1" => "AND p.columna_6 IN('Arauca','Cali', 'Bogotá')",
    "clave2" => "foo",
];

echo $array['clave1'];

foreach ($array as &$valor) {
    echo $valor;
}


?>