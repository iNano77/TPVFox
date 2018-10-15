<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
include_once $URLCom . '/modulos/mod_familia/clases/ClaseFamilias.php';
include_once $URLCom . '/modulos/mod_familia/clases/ClaseFamiliasTienda.php';

/**
 * Description of ClaseFamilias
 *
 * 
 * @author alagoro
 */
class ClaseEECategorias extends ModeloP
{

    protected static $tabla = 'modulo_eelectronica_categorias';

    public static function limpia()
    {
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    public static function importar($ficherosql, $ruta)
    {
        if (file_exists($ficherosql)) {
            self::limpia();
            $errores = [];
            $fichero = fopen($ficherosql, 'r');
            while ($linea = fgets($fichero)) {
                $lineanueva = str_replace('Categorias', ClaseEECategorias::$tabla, $linea);
                if (!ClaseEECategorias::_consultaDML($lineanueva))
                    $errores[] = [ClaseEECategorias::getErrorConsulta(), ClaseEECategorias::getSQLConsulta()];
            }
            return json_encode($errores);
        }
        return false;
    }

    public static function fusionar()
    {
        $categorias = self::leer();
        $idTienda = 1;
        $errores = [];
        foreach ($categorias as $categoriaEE) {
            $datos = [
                'familiaNombre' => $categoriaEE['Cat'],
                'descripcion' => $categoriaEE['Des'],
                'familiaPadre' => 0,
                'beneficiomedio' => 0.0,
                'estado' => 'importado'
            ];
            $idfamiliasTienda = alFamiliasTienda::existeCRef($categoriaEE['Cat'], $idTienda);
            if (!$idfamiliasTienda) {
                $nuevoid = ClaseFamilias::insertar($datos);
                if ($nuevoid) {
                    $idfamiliasTienda = $nuevoid;
                    if (!alFamiliasTienda::insert([
                            'idFamilia' => $idfamiliasTienda,
                            'idTienda' => $idTienda,
                            'crefTienda' => $categoriaEE['Cat']                            
                        ])) {
                        $errores[] = ['insert CATT', $categoriaEE['Cat'], alFamiliasTienda::getErrorConsulta()];
                    }
                } else {
                    $errores[] = ['insert fam', $categoriaEE['Cat'], ClaseFamilias::getErrorConsulta()];
                }
            } else {

                $familiatpv = ClaseFamilias::read($idfamiliasTienda);
                if (count($familiatpv) > 0) {
                    $familiatpv = $familiatpv[0];
//                    $actualizar = false;

                    if ($familiatpv['descripcion'] != $categoriaEE['Des']) {
                        $datos = [];
                        $datos['familiaNombre'] = $categoriaEE['Cat'];
                        $datos['descripcion'] = $categoriaEE['Des'];
                        $datos['estado'] = 'actualizado';
                        if (!ClaseFamilias::actualizar($idfamiliasTienda, $datos)) {
                            $errores[] = ['ac art', $idfamiliasTienda, $categoriaEE['Cat']];
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
