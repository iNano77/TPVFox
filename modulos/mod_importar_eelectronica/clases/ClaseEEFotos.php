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

if (file_exists($rutatpv . '/configuracion.php') or die('ERROR: no existe fichero configuracion.php')) {
    include_once ($rutatpv . '/configuracion.php');
    if (file_exists($RutaServidor . $HostNombre)) {
        $URLCom = $RutaServidor . $HostNombre;
    }
}

include_once $URLCom . '/modulos/claseModeloP.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';

/**
 * Description of ClaseFamilias
 *
 * 
 * @author alagoro
 */
class EEFotos extends ModeloP
{

    private static $ficheros = [];
    private static $rutaDatos = '';

    private static function leerArticulo($nombrearticulo)
    {
        $sql = 'SELECT af.idArticulo, af.idFamilia, at.crefTienda'
                . ' FROM articulosTiendas as at '
                . ' LEFT OUTER JOIN articulosFamilias as af '
                . ' ON (at.idArticulo = af.idArticulo) '
                . ' WHERE at.idTienda=1 AND at.crefTienda = \'' . $nombrearticulo . '\'';
        $resultado = self::_consulta($sql);
        return $resultado;
    }

    public static function setRuta($rutaDatos)
    {
        self::$rutaDatos = $rutaDatos;
    }

    public static function leerLista($ruta = '')
    {
        if ($ruta == '') {
            $ruta = self::$rutaDatos . '/fotos';
        }
        $ficherosjpg = glob($ruta . '/*.jpg');
        $ficherosJPG = glob($ruta . '/*.JPG');
        self::$ficheros = array_merge($ficherosjpg, $ficherosJPG);

        return count(self::$ficheros);
    }

    public static function procesalista($destino = '')
    {
        if ($destino == '') {
            $destino = self::$rutaDatos . '/fotos';
        }
        echo 'Destino: '.$destino . '<br>';
        $nuevalista = [];
        foreach (self::$ficheros as $indice => $ficherojpg) {
            $jpg = strtolower($ficherojpg);
            echo $jpg . '--->';
            $articulo = self::leerArticulo(basename($jpg, '.jpg'));
            if ($articulo) {
                $nuevalista[] = ['indice' => $indice, 'nombre' => basename($jpg), $articulo[0]];
                $nuevaruta = $destino . '/' . $articulo[0]['idFamilia'];
                if (!is_dir($nuevaruta)) {
                    mkdir($nuevaruta, 0777, true);
                }
                $nuevojpg = $nuevaruta . '/' . basename($jpg);
                rename($ficherojpg, $nuevojpg);
                echo $nuevojpg . '--->';
            }
            echo '<br>';
        }
        self::$ficheros = $nuevalista;
        return count($nuevalista);
    }

    public static function getLista()
    {
        return implode('<br> ', self::$ficheros);
    }

}
