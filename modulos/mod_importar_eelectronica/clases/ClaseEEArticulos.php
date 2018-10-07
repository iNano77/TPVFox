<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulosTienda.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulos.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulosStocks.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulosPrecios.php';

/**
 * Description of ClaseEEArticulos
 * Articulos importados de Electronica Enrique
 * 
 * @author alagoro
 */
class ClaseEEArticulos extends ModeloP {

    protected static $tabla = 'modulo_eelectronica_articulos';

    public static function limpia() {
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    public static function importar($ficherosql) {
        if (file_exists($ficherosql)) {
            ClaseEEArticulos::limpia();
            $fichero = fopen($ficherosql, 'r');
            while ($linea = fgets($fichero)) {
                $lineanueva = str_replace('Articulos', ClaseEEArticulos::$tabla, $linea);
                ClaseEEArticulos::_consultaDML($lineanueva);
            }
        }
    }

    public static function QuitaIva($coniva, $iva){
        return $coniva / (1+($iva/100));
    }

        public static function fusionar() {
        $articulos = self::leer();
        $idTienda = 1;
        $errores = [];
        foreach ($articulos as $articuloEE) {
            $datos = [
                'articulo_name' => substr($articuloEE['Nom'], 0, 100),
                'iva' => $articuloEE['iva'],
                'estado' => 'importado'
            ];
            $idArticuloTienda = alArticulosTienda::existeCRef($articuloEE['Art']);
            if (!$idArticuloTienda) {
                $nuevoid = alArticulos::insertar($datos);
                if ($nuevoid) {
                    $idArticuloTienda = $nuevoid;
                    if (!alArticulosTienda::insert([
                                'idArticulo' => $nuevoid,
                                'idTienda' => $idTienda,
                                'crefTienda' => $articuloEE['Art'],
                                'idVirtuemart' => '0',
                                'estado' => 'eeok'
                            ])) {
                        $errores[] = ['insert artT',$articuloEE['Art'], alArticulosTienda::getErrorConsulta()];
                    }
                    alArticulosPrecios::insert([
                        'idArticulo' => $nuevoid,
                        'idTienda' => $idTienda,
                        'pvpCiva' => $articuloEE['pvp'],
                        'pvpSiva' => self::QuitaIva($articuloEE['pvp'],$articuloEE['iva'])
                    ]);
                } else {
                    $errores[] = ['existe cref',$articuloEE['Art'], alArticulos::getErrorConsulta()];
                }
            } else {
                if (!alArticulos::actualizar($idArticuloTienda, $datos)) {
                    $errores[] = ['ac art',$idArticuloTienda, $articuloEE['Art']];
                } else {
                    alArticulosPrecios::update(
                            $idArticuloTienda, $idTienda, ['pvpCiva' => $articuloEE['pvp']]
                    );
                }
            }
            if ($idArticuloTienda) {
                alArticulosStocks::actualizarStock($idArticuloTienda, $idTienda, $articuloEE['Stock'], K_STOCKARTICULO_SUMA);
            }
        }
        return $errores;
    }

    public static function leer() {

        return self::_leer(self::$tabla);
    }

}
