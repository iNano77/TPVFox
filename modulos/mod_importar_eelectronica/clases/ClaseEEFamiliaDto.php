<?php


/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';

/**
 * Description of ClaseFamilias
 *
 * 
 * @author alagoro
 */
class ClaseEEFamiliaDto extends ModeloP {

    protected static $tabla = 'modulo_eelectronica_familiadto';

    public static function limpia() {
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    public static function importar($ficherosql) {
        if (file_exists($ficherosql)) {
            self::limpia();
            $fichero = fopen($ficherosql, 'r');
            while ($linea = fgets($fichero)) {
                $lineanueva = str_replace('FamiliaDto', self::$tabla, $linea);
                self::_consultaDML($lineanueva);
            }
        }
    }

    public static function leer() {

        return self::_leer(self::$tabla);
    }

}
