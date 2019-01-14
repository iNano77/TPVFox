<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción
 *  Este script se ejecuta tanto por icron como desde la web.
 *  Leer el fichero mdb /var/www/htmly conver/var/www/htmltir los datos de las tablas que indicamos en sql
 *  Tambien añadimos sql a las tablas del modulo eelectronica.
 *  Tambien añadimos o modificamos los productos y categorias.
 * 
 */


include_once './../../inicial.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseMDBExport.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEECategorias.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/clasePasotestigo.php';
include_once ($URLCom .'/controllers/parametros.php');

$ClasesParametros = new ClaseParametros('parametros.xml');
$parametros = $ClasesParametros->getRoot();

$variable = time();

// Obtenemos las rutas:
$rutas = $ClasesParametros->ArrayElementos('configuracion');
foreach ($rutas['ruta'] as $r ){
    switch ($r->nombre) {
        case 'sql':
          $ruta = $r->valor;
        break;

        case 'procesado':
           $rutapro = $r->valor;
        break;

        case 'origen':
           $origen = $r->valor;
        break;
    }
    if (is_dir($r->valor) === FALSE){
        // Algo salio mal , ya que no existe la ruta.
        error_log( 'Mal ruta Parametros.xml  '. $r->valor);
        exit;
    }
}

$tablas = [
    'categorias' => 'Categorias',
//    'dtocliente' => 'DtoCliente',
//    'familiadto' => 'FamiliaDto',
    'articulos' => 'Articulos'
];
// La funcion glob de php devuelve una matriz que contiene los ficheros/directorios coincidentes
// una matriz vacía si no hubo ficheros coincidentes o FALSE si se produjo un error. 
$ficherosmdb = glob($origen . '/*.mdb');

if (count($ficherosmdb) > 0) {
    foreach ($ficherosmdb as $ficheromdb) {
        $elmdb = basename($ficheromdb);
        $registroid = substr($elmdb, 3, 10); // Me quedo con el numero
        registroSistema::crear($registroid, 'mdbexport', $elmdb, 'inicio');
        $testigo = pasoTestigo::leerTestigo('mdbexport');
        registroSistema::crear($registroid, 'crear pasotestigo', pasoTestigo::getSQLConsulta(), pasoTestigo::getErrorConsulta());
        if ($testigo['estado'] == pasoTestigo::K_ESTADO_DESBLOQUEADO) {
            registroSistema::crear($registroid, 'fusionar', json_encode($testigo), 'está desbloqueado');            
            $idtestigo = $testigo['id'];
            pasoTestigo::bloquear($idtestigo, $registroid);
            registroSistema::crear($registroid, 'fusionar', 'pasotestigo:'.$idtestigo, 'bloqueando');            
            foreach ($tablas as $fichero => $tabla) {
                $destino = $ruta . '/' . $fichero . '_' . $variable . '.sql';
                exec('mdb-export -I mysql ' . $ficheromdb . ' ' . $tabla . ' > ' . $destino, $valor,$ok);
                if ($ok > 0){
                    // Hubo un error , este error debería marcarse en registro de la tabla modulo_eelectronica_registro
                    // ya que no se muestra resultado por pantalla. o Si.
                    echo ' No existe o no funciona libreria mdb-export';
                    echo '<pre>';
                    print_r($ok);
                    echo '</pre>';
                    registroSistema::crear(0, 'mdbexport', 'mdb-tools', 'No existe o no funciona mdb-export');
                    exit();
                } 
                $resultado = mdbexport::crear(['origen' => $ficheromdb, 'tabla' => $tabla, 'destino' => basename($destino)]);
                registroSistema::crear($registroid, 'mdbexport', $destino, 'exec-->'.$resultado);
                if ($resultado === false) {
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
                        $fichero = basename($destino);
                        $ficherosql = $ruta . '/' . $fichero;
                        if (strpos($fichero, 'categorias') !== FALSE) {
                            registroSistema::crear($registroid, 'importar categorias', basename($ficherosql), 'inicio:'.time());
                            $resultado = ClaseEECategorias::importar($ficherosql, $registroid);
                            registroSistema::crear($registroid, 'importar categorias', basename($ficherosql), 'fin:'.time());
                            registroSistema::crear($registroid, 'fusionar categorias', basename($ficherosql), 'inicio:'.time());
                            ClaseEECategorias::fusionar($registroid, basename($ficherosql));
                            registroSistema::crear($registroid, 'fusionar categorias', basename($ficherosql), 'fin:'.time());
                        } elseif (strpos($fichero, 'articulos') !== FALSE) {
                            registroSistema::crear($registroid, 'importar articulos', basename($ficherosql), 'inicio');
                            $resultado = ClaseEEArticulos::importar($ficherosql, $registroid);
                            registroSistema::crear($registroid, 'importar articulos', basename($ficherosql), 'fin');
                            registroSistema::crear($registroid, 'fusionar articulos', basename($ficherosql), 'inicio');
                            ClaseEEArticulos::fusionar($registroid);
                            registroSistema::crear($registroid, 'fusionar articulos', basename($ficherosql), 'fin');
                        } elseif (strpos($fichero, 'dtocliente') !== FALSE) {
                            ClaseEEDtoCliente::importar($ficherosql, $registroid);
                        } elseif (strpos($fichero, 'familiadto') !== FALSE) {
                            ClaseEEFamiliaDto::importar($ficherosql, $registroid);
                        } else {
                            registroSistema::crear($registroid, 'importar ee', $fichero, 'No es fichero válido');
                        }
                    }
                }
            }
            pasoTestigo::desbloquear($idtestigo);
            registroSistema::crear($registroid, 'fusionar', 'pasotestigo', 'desbloqueado');
        } else {
            echo 'Bloqueado';
            registroSistema::crear($registroid, 'mdbexport', 'Ya existe proceso mdb export', 'No se procesa mdb:' . $elmdb);
        }
        rename($ficheromdb, $rutapro . '/' . $elmdb);
        registroSistema::crear($registroid, 'mdbexport', $elmdb, 'fin');
    }
} else {
    registroSistema::crear(basename(__FILE__), 'ficherosmdb', $origen, 'No existen ficheros mdb');
}
echo 'Fin del todo ' . time();
