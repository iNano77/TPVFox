<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $RutaServidor . $HostNombre . '/modulos/claseModeloP.php';

/**
 * Description of ClaseArticulos
 *
 * @author alagoro
 */
class alArticulosPrecios extends ModeloP {

    protected static $tabla = 'articulosPrecios';

    public static function leer($idArticulo = 0, $idTienda = 1) {
//    Si no se lee articulo por id, se leen múltiples articulos
        $condiciones = $idArticulo !== 0 ? ['idArticulo=' . $idArticulo, 'idTienda=' . $idTienda] : ['idTienda=' . $idTienda];
        return parent::_leer(self::$tabla, $condiciones);
    }

    public static function existe($idArticulo, $idTienda = 1) {
        $resultado = self::leer($idArticulo, $idTienda);

        return count($resultado) > 0;
    }

    public static function existePrecio($idArticulo, $idTienda = 1) {
        $articulo = self::_leer(self::$tabla, ['idArticulo=' . $idArticulo, 'idTienda=' . $idTienda]);
        if (!$articulo) {
            $resultado = false;
        } else {
            $resultado = $articulo[0]['idArticulo'];
        }
        return $resultado;
    }

    public static function insert($datos, $soloSQL = false) {
        $resultado = parent::_insert(self::$tabla, $datos, $soloSQL);
        return $resultado;
    }

    public static function update($idArticulo, $idTienda, $datos, $soloSQL = false) {
        $resultado = parent::_update(self::$tabla, $datos, [
                    'idArticulo=' . $idArticulo,
                    'idTienda=' . $idTienda
                        ], $soloSQL);
        return $resultado;
    }

}
