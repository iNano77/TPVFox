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
class fusion extends ModeloP {

    use traitFormateaFechas;
    
    protected static $tabla = 'modulo_eelectronica_importar';

    /**
     * Crea un registro para monitorizar el progreso de las acciones
     * de importacion.
     * 
     * @param string $accion Accion que va a realizar
     * @param integer $totalRegistros
     * @return integer id registro creado o false en caso de error
     */
    public static function crear($accion, $totalRegistros,$mdborigen='') {
        $resultado = self::_insert(self::$tabla, [
            'fechaInicio'=>date(self::getFormatoFechaHoraSQL()),
            'origen'=>$mdborigen,
            'accion'=>$accion, 
            'totalRegistros'=>$totalRegistros,
            'numRegistro'=>0,
            'actualizado_en'=>date(self::getFormatoFechaHoraSQL())]);
        return $resultado;
    }

    /**
     * Actualiza el registro en la tabla de monitorizacion
     * 
     * @param integer $idProgreso indice clave del registro a actualizar
     * @param integer $numRegistros Contador del registro por el que va la accion
     * @return boolean true si el update terminado correctamente
     */
    public static function actualizar($idProgreso, $numRegistros) {
        $resultado = self::_update(self::$tabla, [            
            'numRegistro'=>$numRegistros,
            'actualizado_en'=>date(self::getFormatoFechaHoraSQL())],['id='.$idProgreso]);
        return $resultado;
    }
    
    public static function finalizar($idProgreso) {
        $resultado = self::_update(self::$tabla, [            
            'fechaFin'=>date(self::getFormatoFechaHoraSQL()),
            'actualizado_en'=>date(self::getFormatoFechaHoraSQL())],['id='.$idProgreso]);
        return $resultado;
    }
    
    public static function leer($idProgreso){
        return parent::_leer(self::$tabla,['id='.$idProgreso]);
    }
            
    public static function leerOrigen($origen,$accion=''){
        $condiciones = ['origen=\''.$origen.'\''];
        if($accion!= ''){
            $condiciones[]='accion=\''.$accion.'\'';
        }
        return parent::_leer(self::$tabla,$condiciones);
    }
}
