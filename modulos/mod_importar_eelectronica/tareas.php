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
        echo json_encode($resultado);
        break;
}

