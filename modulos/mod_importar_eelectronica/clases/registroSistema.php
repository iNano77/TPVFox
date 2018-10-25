<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
require_once $URLCom . '/modulos/mod_traits/traitFormateaFechas.php';

/**
 * Guardar en BD el progreso de la fusion asincrona (incrontab)
 * 
 */
class ClaseRegistroSistema extends ModeloP {

    use traitFormateaFechas;
    
    protected static $tabla = 'modulo_eelectronica_registro';

    public static function crearRegistro($accion, $numRegistros) {
//        $resultado = self::_insert(self::$tabla, ['fechaInicio'=>date(self::getFormatoFecha_dmY()),
//            $fichero
//            $accion, $numRegistros]);
//        return $resultado;
    }
    public static function actualizarProgreso($idProgreso, $accion, $numRegistros) {
        $resultado = self::_update(self::$tabla, [
            $accion, $numRegistros],['id='.$idProgreso]);
        return $resultado;
    }
    
    
}
