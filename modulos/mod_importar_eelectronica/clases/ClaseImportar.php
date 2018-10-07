<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';

/**
 * Description of ClaseFamilias
 *
 * 
 * @author alagoro
 */
class ClaseEEImportar extends ModeloP {

    private static function importarArticulos() {
        $articulosEE = ClaseEEArticulos::leer();
        foreach ($articulosEE as $articuloEE) {
            Articulos::leer($articuloEE->id);
        }
        return self::_leer(self::$tabla);
    }

    public static function importarEEenTPV() {
        self::importarArticulos();

        return $errores;
    }
}
