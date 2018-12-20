<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once './../../inicial.php';
include_once ($URLCom .'/controllers/parametros.php');

$ClasesParametros = new ClaseParametros('parametros.xml');
$parametros = $ClasesParametros->getRoot();
// Obtenemos las rutas:
$rutas = $ClasesParametros->ArrayElementos('configuracion');
foreach ($rutas['ruta'] as $r ){
    if ($r->nombre === 'origen_fotos'){
        $RutaDatos = $r->valor;
        echo 'Entro en if:'.$RutaDatos.'<br/>';
        break;
    }
}
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEFotos.php';

EEFotos::setRuta($RutaDatos);
$elementos = EEFotos::leerLista();
echo 'Hay '.$elementos. ' ficheros de imagen para asociar.'.'<br>';
//echo EEFotos::getLista();
echo $elementos > 0 ? EEFotos::procesalista() :  'error';
echo '<br>';
$elementos = EEFotos::leerLista($URLCom.'/fotos');
echo 'De los cuales '.$elementos. ' No se han podido asociar.';
