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
class alArticulosTienda extends ModeloP {

    protected static $tabla = 'articulosTiendas';

    public static function leer($idArticulo = 0, $idTienda = 1) {
//    Si no se lee articulo por id, se leen múltiples articulos
        $condiciones = $idArticulo !== 0 ? ['idArticulo=' . $idArticulo, 'idTienda=' . $idTienda] : ['idTienda=' . $idTienda];
        return alArticulosTienda::_leer(self::$tabla, $condiciones);
    }

    public static function existe($idArticulo, $idTienda = 1) {
        $resultado = self::leer($idArticulo, $idTienda);

        return count($resultado) > 0;
    }

    public static function existeCRef($cRefTienda, $idTienda = 1) {
        $articulo = self::_leer(self::$tabla, ['crefTienda=\'' . $cRefTienda.'\'', 'idTienda=' . $idTienda]);
        if (!$articulo) {
            $resultado = false;
        } else {
            $resultado = $articulo[0]['idArticulo'];
        }
        return $resultado;
    }

    public function getStock($idArticulo, $idTienda = 1) {
        return alArticulosStocks::leer($idArticulo, $idTienda); //si no existe lo crea
    }

    public static function insert($datos, $soloSQL = false) {
        $idArticulo = $datos['idArticulo'];
        $idTienda = $datos['idTienda'];
        if(self::existe($idArticulo, $idTienda) && !$soloSQL){
            $resultado = parent::_delete(self::$tabla,['idArticulo='.$idArticulo, 'idTienda='.$idTienda]);
        }
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
