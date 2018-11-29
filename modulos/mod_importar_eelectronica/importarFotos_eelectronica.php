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
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEFotos.php';

EEFotos::setRuta($RutaServidor.$HostNombre.$RutaDatos);

$elementos = EEFotos::leerLista('/var/www/html/tpvfox/fotos');
echo 'Hay '.$elementos. ' ficheros de imagen para asociar.'.'<br>';
//echo EEFotos::getLista();
echo $elementos > 0 ? EEFotos::procesalista() :  'error';
echo '<br>';
$elementos = EEFotos::leerLista('/var/www/html/tpvfox/fotos');
echo 'De los cuales '.$elementos. ' No se han podido asociar.';
