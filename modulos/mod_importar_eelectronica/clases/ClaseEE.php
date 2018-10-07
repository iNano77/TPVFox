<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

class ClaseEE extends ModeloP {

    protected static $tabla = false;
    protected static $tablaMdb = false;

    public static function limpia() {
        if (self::$tabla !== false) {
            $sql = 'DELETE FROM ' . self::$tabla;
            return self::_consultaDML($sql);
        } else {
            return false;
        }
    }

    public static function importar($ficherosql) {

        $class = get_called_class();
        
        if (($class::tablaMdb !== false) && ($class::$tabla !== false)){
            if (file_exists($ficherosql)) {
                $class::limpia();
                $errores = [];
                $fichero = fopen($ficherosql, 'r');
                while ($linea = fgets($fichero)) {
                    $lineanueva = str_replace($class::tablaMdb, $class::$tabla, $linea);
                    $result = $class::_consultaDML($lineanueva);
                    if(!$result){
                        $errores[] = $lineanueva;
                    }
                }
            }
            return $errores;
        } else {
            return false;
        }
    }

}

