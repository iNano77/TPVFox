<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */
$rutatpv = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/tpvfox';
if (!file_exists($rutatpv . '/inicial.php')) {
    $rutatpv = '/var/www/html/tpvfox';
}

file_exists($rutatpv . '/inicial.php') or die('ERROR: no existe fichero inicial.php');

include_once $rutatpv . '/inicial.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseMDBExport.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEECategorias.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/clasePasotestigo.php';


$variable = time();
if (file_exists('/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/index.php')) {
    $ruta = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/csv/';
    $rutapro = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/procesados';
    $origen = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/mdbs';
} else {
    $ruta = '/var/www/html/tpvfox/BD/importar_eelectronica/csv';
    $rutapro = '/var/www/html/tpvfox/BD/importar_eelectronica/procesados';
    $origen = '/var/www/html/eelectronica/mdbs';
}

$tablas = [
    'categorias' => 'Categorias',
//    'dtocliente' => 'DtoCliente',
//    'familiadto' => 'FamiliaDto',
    'articulos' => 'Articulos'
];

$ficherosmdb = glob($origen . '/*.mdb');
if (count($ficherosmdb) > 0) {
    foreach ($ficherosmdb as $ficheromdb) {
        $elmdb = basename($ficheromdb);
        $registroid = substr($elmdb, 3, 10);
        registroSistema::crear($registroid, 'mdbexport', $elmdb, 'inicio');
        $testigo = pasoTestigo::leerTestigo('mdbexport');
        registroSistema::crear($registroid, 'crear pasotestigo', pasoTestigo::getSQLConsulta(), pasoTestigo::getErrorConsulta());
        if ($testigo['estado'] == pasoTestigo::K_ESTADO_DESBLOQUEADO) {
            registroSistema::crear($registroid, 'fusionar', json_encode($testigo), 'está desbloqueado');            
            $idtestigo = $testigo['id'];
            pasoTestigo::bloquear($idtestigo);
            registroSistema::crear($registroid, 'fusionar', 'pasotestigo:'.$idtestigo, 'bloqueando');
            foreach ($tablas as $fichero => $tabla) {
                $destino = $ruta . '/' . $fichero . '_' . $variable . '.sql';
                exec('mdb-export -I mysql ' . $ficheromdb . ' ' . $tabla . ' > ' . $destino);
                $resultado = mdbexport::crear(['origen' => $ficheromdb, 'tabla' => $tabla, 'destino' => basename($destino)]);
                if (!$resultado) {
                    registroSistema::crear(basename(__FILE__), 'mdbexport', mdbexport::getSQLConsulta(), mdbexport::getErrorConsulta());
                } else {
                    $contador = 0;
                    sleep(5);
                    while (!file_exists($destino) && $contador < 3) {
                        sleep(5);
                        $contador++;
                    }
                    if (!file_exists($destino)) {
                        registroSistema::crear($registroid, 'mdbexport', $destino, 'No existe fichero');
                    } else {
//                        exec('/usr/bin/php '.dirname(__FILE__).'/monitor_eelectronica.php '.$ruta.' '.basename($destino));
                        $fichero = basename($destino);
                        $ficherosql = $ruta . '/' . $fichero;
                        if (strpos($fichero, 'categorias') !== FALSE) {
                            registroSistema::crear($registroid, 'importar categorias', basename($ficherosql), 'inicio:'.time());
                            $resultado = ClaseEECategorias::importar($ficherosql, $registroid);
                            registroSistema::crear($registroid, 'importar categorias', basename($ficherosql), 'fin:'.time());
                            registroSistema::crear($registroid, 'fusionar categorias', basename($ficherosql), 'inicio:'.time());
                            ClaseEECategorias::fusionar();
                            registroSistema::crear($registroid, 'fusionar categorias', basename($ficherosql), 'fin:'.time());
                        } elseif (strpos($fichero, 'articulos') !== FALSE) {
                            registroSistema::crear($registroid, 'importar articulos', basename($ficherosql), 'inicio');
                            $resultado = ClaseEEArticulos::importar($ficherosql);
                            registroSistema::crear($registroid, 'importar articulos', basename($ficherosql), 'fin');
                            registroSistema::crear($registroid, 'fusionar articulos', basename($ficherosql), 'inicio');
                            ClaseEEArticulos::fusionar();
                            registroSistema::crear($registroid, 'fusionar articulos', basename($ficherosql), 'fin');
                        } elseif (strpos($fichero, 'dtocliente') !== FALSE) {
                            ClaseEEDtoCliente::importar($ficherosql, $ruta);
                        } elseif (strpos($fichero, 'familiadto') !== FALSE) {
                            ClaseEEFamiliaDto::importar($ficherosql, $ruta);
                        } else {
                            registroSistema::crear($registroid, 'importar ee', $fichero, 'No es fichero válido');
                        }
                    }
                }
            }
            pasoTestigo::desbloquear($idtestigo);
            registroSistema::crear($registroid, 'fusionar', 'pasotestigo', 'desbloqueado');
        } else {
            registroSistema::crear($registroid, 'mdbexport', 'Ya existe proceso mdb export', 'No se procesa mdb:' . $elmdb);
        }
        rename($ficheromdb, $rutapro . '/' . $elmdb);
        registroSistema::crear($registroid, 'mdbexport', $elmdb, 'fin');
    }
} else {
    registroSistema::crear(basename(__FILE__), 'ficherosmdb', $origen, 'No existen ficheros mdb');
}
echo 'Fin del todo ' . time();
//    $ficheros = mdbexport::leerNoProcesados();
//    return json_encode($ficheros);



//$ficherossql = mdbexport::leerNoProcesados('Categorias');
//if ($ficherossql) {
//    foreach ($ficherossql as $ficherosql) {
//        $idmdbexport = $ficherosql['id'];
//        $destino = $ficherosql['destino'];
//        $resactualizar = mdbexport::actualizar($idmdbexport, ['fechaInicio' => date(mdbexport::getFormatoFechaHoraSQL())]);
//        $resultado = ClaseEECategorias::importar($destino);
//        if ($resultado === false) {
//            registroSistema::crear(basename(__FILE__), 'importar categorias', $destino, 'No existe fichero sql');
//            mdbexport::actualizar($idmdbexport, ['fechaFin' => date(mdbexport::getFormatoFechaHoraSQL()), 'procesado' => -1]);
//        } else {
//            mdbexport::actualizar($idmdbexport, ['fechaFin' => date(mdbexport::getFormatoFechaHoraSQL()), 'procesado' => true]);
//            rename($destino, $rutapro . '/csv/' . basename($destino));
//        }
//    }
//} else {
//    $resultado = registroSistema::crear(basename(__FILE__), 'mdbexport', mdbexport::getSQLConsulta(), mdbexport::getErrorConsulta());
//}
//
//$ficherossql = mdbexport::leerNoProcesados('Articulos');
//if ($ficherossql) {
//    foreach ($ficherossql as $ficherosql) {
//        $idmdbexport = $ficherosql['id'];
//        $destino = $ficherosql['destino'];
//        $resactualizar = mdbexport::actualizar($idmdbexport, ['fechaInicio' => date(mdbexport::getFormatoFechaHoraSQL())]);
//        $resultado = ClaseEEArticulos::importar($destino);
//        if ($resultado === false) {
//            registroSistema::crear(basename(__FILE__), 'importar articulos', $destino, 'No existe fichero sql');
//            mdbexport::actualizar($idmdbexport, ['fechaFin' => date(mdbexport::getFormatoFechaHoraSQL()), 'procesado' => -1]);
//        } else {
//            mdbexport::actualizar($idmdbexport, ['fechaFin' => date(mdbexport::getFormatoFechaHoraSQL()), 'procesado' => true]);
//            rename($destino, $rutapro . '/csv/' . basename($destino));
//        }
//    }
//} else {
//    $resultado = registroSistema::crear(basename(__FILE__), 'mdbexport', mdbexport::getSQLConsulta(), mdbexport::getErrorConsulta());
//}

//var_dump(ClaseEECategorias::fusionar());
//var_dump(ClaseEEArticulos::fusionar());
