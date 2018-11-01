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
class mdbexport extends ModeloP {

    use traitFormateaFechas;
    
    protected static $tabla = 'modulo_eelectronica_mdbexport';

    /**
     * Crea un registro para monitorizar el progreso de las acciones
     * de importacion.
     * 
     * @param string $accion Accion que va a realizar
     * @param integer $totalRegistros
     * @return integer id registro creado o false en caso de error
     */
    public static function crear($datos) {        
        $resultado = self::_insert(self::$tabla, $datos);
        return $resultado;
    }

    /**
     * Actualiza el registro en la tabla de monitorizacion
     * 
     * @param integer $idProgreso indice clave del registro a actualizar
     * @param integer $numRegistros Contador del registro por el que va la accion
     * @return boolean true si el update terminado correctamente
     */
    public static function actualizar($id, $datos) {
        $datos['actualizado_en'] = date(self::getFormatoFechaHoraSQL());
        $resultado = self::_update(self::$tabla
                ,$datos
                ,['id='.$id]);
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

    public static function leerNoProcesados($tabla=''){
        $condiciones = ['procesado=false'];
        if($tabla){
            $condiciones[] = 'tabla=\''.$tabla.'\'';
        }
        return parent::_leer(self::$tabla,$condiciones);
    }
            
}
