<?php

$rutatpv = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/tpvfox';
if (!file_exists($rutatpv . '/inicial.php')) {
    $rutatpv = '/var/www/html/tpvfox';
}

file_exists($rutatpv . '/inicial.php') or die('ERROR: no existe fichero inicial.php');

include_once $rutatpv . '/inicial.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseMDBExport.php';

$variable = time();
if (file_exists('/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/index.php')) {
    $ruta = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/csv/';
    $rutapro = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/procesados';
} else {
    $ruta = '/var/www/html/tpvfox/BD/importar_eelectronica/csv';
    $rutapro = '/var/www/html/tpvfox/BD/importar_eelectronica/procesados';
}

$tablas = [
    'categorias' => 'Categorias',
//    'dtocliente' => 'DtoCliente',
//    'familiadto' => 'FamiliaDto',
    'articulos' => 'Articulos'
];

$ficheros = glob('/var/www/html/eelectronica/mdbs/*.mdb');
foreach($ficheros as $ficheromdb){
    $origen = $argv[1] . '/' . $argv[2];
    foreach ($tablas as $fichero => $tabla) {
        $destino = $ruta . '/' . $fichero . '_' . $variable . '.sql';
        exec('mdb-export -I mysql ' . $ficheromdb . ' ' . $tabla . ' > ' . $destino);
        mdbexport::crear([$origen,$tabla,$destino]);
    }
    $ficheros = mdbexport::leerNoProcesados();
    var_dump($ficheros);
//    rename($origen, $rutapro . '/' . $argv[2]);
}


	$ruta = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/tpvfox';
	if (!file_exists($ruta.'/inicial.php')){		
  	  $ruta = '/var/www/html/tpvfox';
        }

include_once $ruta.'/inicial.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEECategorias.php';

//
//'/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/csv/articulos_1539649567.sql'
$ficheros = glob('/var/www/html/tpvfox/BD/importar_eelectronica/csv/categoria*.sql');
foreach($ficheros as $fichero){
var_dump(ClaseEECategorias::importar($fichero,'/var/www/html/tpvfox'));
var_dump(ClaseEECategorias::fusionar());
}

$ficheros = glob('/var/www/html/tpvfox/BD/importar_eelectronica/csv/articulos*.sql');
foreach($ficheros as $fichero){
var_dump(ClaseEEArticulos::importar($fichero,'/var/www/html/tpvfox'));
var_dump(ClaseEEArticulos::fusionar());
}
