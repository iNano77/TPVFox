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
include_once $URLCom . '/modulos/mod_traits/calculaMD5.php';

/**
 * Description of ClaseEEArticulos
 * Articulos importados de Electronica Enrique
 * 
 * @author alagoro
 */
class ClaseEEArticulos extends ModeloP
{

    use CalcularMD5;

    protected static $tabla = 'modulo_eelectronica_articulos';

    /**
     * 
     * @return array
     */
    public static function limpia()
    {
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    public static function importar($ficherosql, $ruta)
    {
        $contador = 0;
        if (file_exists($ficherosql)) {
            ClaseEEArticulos::limpia();
            $fichero = fopen($ficherosql, 'r');
            $linea = fgets($fichero);
            while ($linea) {
                $lineanueva = $linea;
                $linea = fgets($fichero);
                while ($linea && (strpos($linea, 'INSERT INTO') === false)) {
                    $lineanueva .= $linea;
                    $linea = fgets($fichero);
                }
                if ($lineanueva) {
                    $lineawrite = str_replace('Articulos', ClaseEEArticulos::$tabla, $lineanueva);
                    $error = ClaseEEArticulos::_consultaDML($lineawrite);
//                    if (ClaseEEArticulos::hayErrorConsulta()) {
//                        echo ClaseEEArticulos::getErrorConsulta();
//                        echo '<br>'. ClaseEEArticulos::getSQLConsulta();
//                        $contador++;
//                    }
                }
            }
            return ($contador);
        }
        return false;
    }

    public static function QuitaIva($coniva, $iva)
    {
        return $coniva / (1 + ($iva / 100));
    }

    public static function fusionar()
    {
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
                            'estado' => 'importado'
                        ])) {
                        $errores[] = ['insert artT', $articuloEE['Art'], alArticulosTienda::getErrorConsulta()];
                    }
                    alArticulosPrecios::insert([
                        'idArticulo' => $nuevoid,
                        'idTienda' => $idTienda,
                        'pvpCiva' => $articuloEE['pvp'],
                        'pvpSiva' => self::QuitaIva($articuloEE['pvp'], $articuloEE['iva'])
                    ]);
                    alArticulosStocks::actualizarStock($nuevoid, $idTienda, $articuloEE['Stock'], K_STOCKARTICULO_SUMA);
                } else {
                    $errores[] = ['existe cref', $articuloEE['Art'], alArticulos::getErrorConsulta()];
                }
            } else {

                $articulotpv = alArticulos::leerArticuloTienda($idArticuloTienda, $idTienda);
                if (count($articulotpv) > 0) {
                    $articulotpv = $articulotpv[0];
//                    $actualizar = false;

                    $md51 = self::calcularMD5([
                            $articulotpv['ivaArticulo'],
                            $articulotpv['descripcion']
                    ]);

                    $articuloEE['iva'] = number_format($articuloEE['iva'], 2);
                    $md52 = self::calcularMD5([
                            $articuloEE['iva'],
                            substr($articuloEE['Nom'], 0, 100)
                    ]);
                    $actualizar = ($md51 != $md52);

                    if ($articuloEE['Stock'] != $articulotpv['stocktpv']) {
                        $actualizar = true;
                        alArticulosStocks::actualizarStock($idArticuloTienda, $idTienda, $articuloEE['Stock'], K_STOCKARTICULO_SUMA);
                    }
                    if ($articuloEE['pvp'] != $articulotpv['pvptpv']) {
                        $actualizar = true;
                        alArticulosPrecios::update(
                            $idArticuloTienda, $idTienda, ['pvpCiva' => $articuloEE['pvp']]
                        );
                    }

                    if ($actualizar) {
                        $datos['estado'] = 'actualizado';
                        if (!alArticulos::actualizar($idArticuloTienda, $datos)) {
                            $errores[] = ['ac art', $idArticuloTienda, $articuloEE['Art']];
                        }
                    }
                }
            }
        }
        return $errores;
    }

    public static function leer()
    {
        return self::_leer(self::$tabla);
    }
}
