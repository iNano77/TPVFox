<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */
$camino = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/tpvfox';
if (!file_exists($camino . '/inicialCLI.php')) {
    $camino = '/var/www/html/tpvfox';
}


include_once $camino . '/inicialCLI.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseMDBExport.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/clasePasotestigo.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEECategorias.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEDtoCliente.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEFamiliaDto.php';

registroSistema::crear(basename(__FILE__), 'monitor', json_encode($argc), 'inicio');

if (isset($argc)) {
    $ruta = $argv[1];
    $fichero = $argv[2];
    if ($ruta && $fichero) {
        $ficherosql = $ruta . '/' . $fichero;
        if (strpos($fichero, 'categorias') !== FALSE) {
            registroSistema::crear(basename(__FILE__), 'importar categorias', basename($ficherosql), 'inicio');
            $resultado = ClaseEECategorias::importar($ficherosql);
            registroSistema::crear(basename(__FILE__), 'importar categorias', basename($ficherosql), 'fin');
            registroSistema::crear(basename(__FILE__), 'fusionar categorias', basename($ficherosql), 'inicio');
            ClaseEECategorias::fusionar();
            registroSistema::crear(basename(__FILE__), 'fusionar categorias', basename($ficherosql), 'fin');
        } elseif (strpos($fichero, 'articulos') !== FALSE) {
            registroSistema::crear(basename(__FILE__), 'importar articulos', basename($ficherosql), 'inicio');
            $resultado = ClaseEEArticulos::importar($ficherosql);
            registroSistema::crear(basename(__FILE__), 'importar articulos', basename($ficherosql), 'fin');
            registroSistema::crear(basename(__FILE__), 'fusionar articulos', basename($ficherosql), 'inicio');
            ClaseEEArticulos::fusionar();
            registroSistema::crear(basename(__FILE__), 'fusionar articulos', basename($ficherosql), 'inicio');
        } elseif (strpos($fichero, 'dtocliente') !== FALSE) {
            ClaseEEDtoCliente::importar($ficherosql, $ruta);
        } elseif (strpos($fichero, 'familiadto') !== FALSE) {
            ClaseEEFamiliaDto::importar($ficherosql, $ruta);
        } else {
            registroSistema::crear(basename(__FILE__), 'importar ee', $fichero, 'No es fichero válido');
        }
//        rename($ficherosql, $URLCom . '/BD/importar_eelectronica/procesados/csv/' . $fichero);        
    } else {
        registroSistema::crear(basename(__FILE__), 'importar ee', $ruta, '--No ha pasado--' . $fichero);
    }
    return $resultado;
}