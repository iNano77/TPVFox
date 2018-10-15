<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */
	$camino = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/tpvfox';
	if (!file_exists($camino.'/inicialCLI.php')){		
  	  $camino = '/var/www/html/tpvfox';
        }


include_once $camino.'/inicialCLI.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEECategorias.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEDtoCliente.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEFamiliaDto.php';

if (isset($argc)) {
    $ruta = $argv[1];
    $fichero = $argv[2];
    if ($ruta && $fichero) {
        $ficherosql = $ruta . '/' . $fichero;
        if (strpos($fichero, 'categorias') !== FALSE) {
            echo ' categorias ';
            $resultado = ClaseEECategorias::importar($ficherosql, $ruta);
            ClaseEECategorias::fusionar();
        }
         elseif (strpos($fichero, 'articulos') !== FALSE) {
            echo 'articulos';
            $resultado = ClaseEEArticulos::importar($ficherosql, $ruta);
            ClaseEEArticulos::fusionar();
            
        } elseif (strpos($fichero, 'dtocliente') !== FALSE) {
            ClaseEEDtoCliente::importar($ficherosql, $ruta);
        } elseif (strpos($fichero, 'familiadto') !== FALSE) {
            ClaseEEFamiliaDto::importar($ficherosql, $ruta);            
        } else {
            echo 'No ha funcionado';
        }
//        rename($ficherosql, $URLCom . '/BD/importar_eelectronica/procesados/csv/' . $fichero);
        
    } else {
        echo $ruta . '--No ha pasado--' . $fichero;
    }
    return $resultado;
}