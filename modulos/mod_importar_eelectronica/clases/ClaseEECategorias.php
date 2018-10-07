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
class ClaseEECategorias extends ModeloP {

    protected static $tabla = 'modulo_eelectronica_categorias';

    public function cuentaProductos($padres) {
        $nuestros = $padres;
        $sql = 'SELECT count(idArticulo) AS contador '
                . 'FROM articulosFamilias where idFamilia=';
        foreach ($padres as $indice => $padre) {
            $resultado = $this->consulta($sql . $padre['idFamilia']);
            $nuestros[$indice]['productos'] = $resultado['datos'][0]['contador'];
        }

        return $nuestros;
    }

    public static function limpia() {
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    public static function importar($ficherosql) {
        if (file_exists($ficherosql)) {
            self::limpia();
            $fichero = fopen($ficherosql, 'r');
            while ($linea = fgets($fichero)) {
                $lineanueva = str_replace('Categorias', ClaseEECategorias::$tabla, $linea);
                ClaseEECategorias::_consultaDML($lineanueva);
            }
        }
    }

    public static function leer() {

        return self::_leer(self::$tabla);
    }

}
