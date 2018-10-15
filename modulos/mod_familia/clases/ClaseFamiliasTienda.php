<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $RutaServidor . $HostNombre . '/modulos/claseModeloP.php';

/**
 * Description of ClaseFamiliasTienda
 * 
 * Modelo de la tabla que recoge las familias por tienda
 * 
 * @author alagoro
 */
class alFamiliasTienda extends ModeloP
{

    protected static $tabla = 'familiasTienda';

/**
 * Leer la linea de familia de una tienda. Si el primer parámetro es nulo o 0
 * se leen todas las familias de una tienda
 * 
 * @param int $idFamilia default 0
 * @param int $idTienda default 1
 * @return array familiasTienda
 */
    public static function leer($idFamilia = 0, $idTienda = 1)
    {
        $condiciones = $idFamilia !== 0 ? ['idFamilia=' . $idFamilia, 'idTienda=' . $idTienda] : ['idTienda=' . $idTienda];
        return alFamiliasTienda::_leer(self::$tabla, $condiciones);
    }

    /**
     * Devuelve si existe una tupla con valores de idFamilia, idTienda
     * 
     * @param int $idFamilia
     * @param int $idTienda default 1
     * @return boolean
     */
    public static function existe($idFamilia, $idTienda = 1)
    {
        $resultado = self::leer($idFamilia, $idTienda);

        return count($resultado) > 0;
    }

    /**
     * Busca una referencia de tienda y devuelve el idFamilia si existe o false
     * 
     * @param string $cRefTienda
     * @param int $idTienda
     * @return int idFamilia o false si no existe
     */
    public static function existeCRef($cRefTienda, $idTienda = 1)
    {
        $familia = self::_leer(self::$tabla, ['crefTienda=\'' . $cRefTienda . '\'', 'idTienda=' . $idTienda]);
        if (!$familia) {
            $resultado = false;
        } else {
            $resultado = $familia[0]['idFamilia'];
        }
        return $resultado;
    }

    /**
     * Inserta los valores del array $datos en la tabla
     * 
     * @param array $datos Columnas a insertar de la forma 'nombreColumna'=>valor
     * @param boolean $soloSQL en vez de ejecutar la sentencia, sólo la crea
     * @return int con el id insertado, true si $soloSQL, o false si hubo error
     */
    public static function insert($datos, $soloSQL = false)
    {
        $idFamilia = $datos['idFamilia'];
        $idTienda = $datos['idTienda'];
        if (self::existe($idFamilia, $idTienda) && !$soloSQL) {
            $resultado = parent::_delete(self::$tabla, ['idFamilia=' . $idFamilia, 'idTienda=' . $idTienda]);
        }
        $resultado = parent::_insert(self::$tabla, $datos, $soloSQL);
        return $resultado;
    }

    /**
     * Actualiza la tabla con $datos para la tupla con clave $idFamilia, $idTienda
     * 
     * @param int $idFamilia
     * @param int $idTienda
     * @param array $datos
     * @param boolean $soloSQL
     * @return int 0 si es correcto y un código de error si hubo error
     */
    public static function update($idFamilia, $idTienda, $datos, $soloSQL = false)
    {
        $resultado = parent::_update(self::$tabla, $datos, [
                'idFamilia=' . $idFamilia,
                'idTienda=' . $idTienda
                ], $soloSQL);
        return $resultado;
    }
}
