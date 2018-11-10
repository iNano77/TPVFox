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
class registroSistema extends ModeloP {

    use traitFormateaFechas;
    
    protected static $tabla = 'modulo_eelectronica_registro';

    public static function crear($fichero, $accion, $sentencia,$error) {
        $resultado = self::_insert(self::$tabla, [
            'fichero'=>$fichero, 
            'accion'=>$accion,
            'sentencia'=>$sentencia,
            'error'=>$error,
            'actualizado_en'=>date(self::getFormatoFechaHoraSQL())]);
        return $resultado;
    }

    
    public static function leer($idRegistro){
        return parent::_leer(self::$tabla,['id='.$idRegistro]);
    }
    public static function leerXFichero($fichero){
        return parent::_leer(self::$tabla,['fichero='.$fichero]);
    }
    
    
}
