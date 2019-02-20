<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */



include_once './../../inicial.php';
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
        // @ Objetivo:
        // Leer un directorior y obtener un array con las foto JPG o jpg haya.
        // @ Parametros:
        //  $ruta ->  (string) Ruta donde se encuentran las fotos originales.
        // @ Devuelve:
        // Array con los datos de las imagenes.
       
        if ($ruta == '') {
            // Valor por defecto.
            $ruta = self::$rutaDatos;
        }
        $ficherosjpg = glob($ruta . '/*.jpg');
        $ficherosJPG = glob($ruta . '/*.JPG');
        self::$ficheros = array_merge($ficherosjpg, $ficherosJPG);

        return count(self::$ficheros);
    }

    public static function procesalista($destino = '')
    {
        // @Objetivo
        // Buscar que imagen tiene asociada cada articulo
        // y remove a directorio de categoria (id) y cambiar el nombre
        // con el id.
        if ($destino == '') {
            $destino = self::$rutaDatos . '/fotos';
        }
        $nuevalista = [];
        foreach (self::$ficheros as $indice => $ficherojpg) {
            $jpg = strtolower($ficherojpg);
            echo basename($jpg, '.jpg'). '---- Movido --->';
            $articulo = self::leerArticulo(basename($jpg, '.jpg'));
            if ($articulo) {
                $nuevalista[] = ['indice' => $indice, 'nombre' => basename($jpg), $articulo[0]];
                $idfamila3Caracter=  str_pad($articulo[0]['idFamilia'], 3, "0", STR_PAD_LEFT);
                $nuevaruta = $destino . '/' . $idfamila3Caracter;
                if (!is_dir($nuevaruta)) {
                    mkdir($nuevaruta, 0777, true);
                }
                $nuevojpg = $nuevaruta . '/' . $articulo[0]['idArticulo'].'.jpg';
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
