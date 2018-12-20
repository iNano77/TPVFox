<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 */



/* Fichero de tareas a realizar.
 * 
 * 
 * Con el switch al final y variable $pulsado
 * 
 *
 *   
 */
/* ===============  REALIZAMOS CONEXIONES  =============== */
include_once './../../inicial.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/tareas/claseTareasImportar.php';
$pulsado = $_POST['pulsado'];
switch ($pulsado) {
    case 'progresoImportar':
        $resultado = tareasImportar::EstadoProgreso('mdbexport');
    break;

    case 'IniciarImportacionFusion':
        // Iniciamos el proceso Importar y Fusion en segundo plano
        $resultado= array();
        exec("php -f fusionar_eelectronica.php > /dev/null &");
    breaK;    
}
echo json_encode($resultado);


